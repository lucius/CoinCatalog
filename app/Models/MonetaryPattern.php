<?php

namespace App\Models;

use App\Models\Traits\ValidatesModelBeforeSave;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonetaryPattern extends Model
{
    use HasFactory, SoftDeletes, ValidatesModelBeforeSave;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $fillable = [
        'name',
        'symbol',
        'start_date',
        'end_date',
    ];

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'symbol' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ];
    }

    public function coinFamilies(): HasMany
    {
        return $this->hasMany(CoinFamily::class);
    }
}
