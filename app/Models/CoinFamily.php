<?php

namespace App\Models;

use App\Models\Traits\ValidatesModelBeforeSave;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoinFamily extends Model
{
    use HasFactory, ValidatesModelBeforeSave;

    protected $fillable = [
        'name',
    ];

    public function rules(): array
    {
        return [
            'name' => ['required', 'filled', 'string'],
            'monetary_pattern_id' => ['required', 'exists:monetary_patterns,id'],
        ];
    }

    public function monetaryPattern(): BelongsTo
    {
        return $this->belongsTo(MonetaryPattern::class);
    }
}
