<?php

namespace Tests\Feature\MonetaryPattern;

use App\Models\MonetaryPattern;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateMonetaryPatternTest extends TestCase
{
    public function test_create_with_full_data()
    {
        $model = MonetaryPattern::factory()->make();
        $model->save();
        $this->assertModelExists($model);
    }

    public function test_create_without_name()
    {
        $this->expectException(ValidationException::class);
        $model = MonetaryPattern::factory()->make();
        $model->fill(['name' => null]);
        $model->save();
        $this->assertModelMissing($model);
    }

    public function test_create_without_symbol()
    {
        $this->expectException(ValidationException::class);
        $model = MonetaryPattern::factory()->make();
        $model->fill(['symbol' => null]);
        $model->save();
        $this->assertModelExists($model);
        $this->assertModelMissing($model);
    }

    public function test_create_without_start_date()
    {
        $this->expectException(ValidationException::class);
        $model = MonetaryPattern::factory()->make();
        $model->fill(['start_date' => null]);
        $model->save();
        $this->assertModelMissing($model);
    }

    public function test_create_with_wrong_period()
    {
        $this->expectException(ValidationException::class);
        $model = MonetaryPattern::factory()->startBeforeEnds()->make();
        $model->save();
        $this->assertModelMissing($model);
    }

    public function test_create_without_end_date()
    {
        $model = MonetaryPattern::factory()->current()->make();
        $model->fill(['end_date' => null]);
        $model->save();
        $this->assertModelExists($model);
    }

    public function test_if_casts_are_dates()
    {
        MonetaryPattern::all()->each(function (MonetaryPattern $monetaryPattern) {
            $this->assertInstanceOf(\DateTimeInterface::class, $monetaryPattern->start_date);
            if (! empty($this->end_date)) {
                $this->assertInstanceOf(\DateTimeInterface::class, $monetaryPattern->end_date);
            }
        });
    }
}
