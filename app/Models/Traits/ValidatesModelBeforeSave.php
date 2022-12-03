<?php

namespace App\Models\Traits;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

trait ValidatesModelBeforeSave
{
    public static function bootValidatesModelBeforeSave(): void
    {
        static::saving(function (Model $model) {
            $model->performValidation();
        });
    }

    /**
     * @throws ValidationException
     */
    public function performValidation(): void
    {
        $instance = $this->getValidatorInstance();
        if ($instance->fails()) {
            $this->failedValidation($instance);
        }

        $this->passedValidation();
    }

    protected function getValidatorInstance()
    {
        $factory = App::make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            $validator = App::call([$this, 'validator'], compact('factory'));
        } else {
            $validator = $this->createDefaultValidator($factory);
        }

        if (method_exists($this, 'withValidator')) {
            $validator = $this->withValidator($validator);
        }

        return $validator;
    }

    public function createDefaultValidator(mixed $factory)
    {
        $rules = App::call([$this, 'rules']);

        return $factory->make(
            $this->validationData(),
            $rules,
            $this->messages(),
        );
    }

    public function validationData()
    {
        return $this->toArray();
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    /**
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag ?? 'default');
    }

    protected function passedValidation()
    {
        //
    }
}
