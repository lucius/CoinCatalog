<?php

namespace Tests\Feature\CoinFamilies;

use App\Models\CoinFamily;
use App\Models\MonetaryPattern;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateCoinFamilyTest extends TestCase
{
    public function test_create_with_full_data()
    {
        $model = CoinFamily::factory()->for(MonetaryPattern::factory()->create())->create();
        $this->assertModelExists($model);
    }

    public function test_create_without_monetary_pattern()
    {
        $this->expectException(ValidationException::class);
        $model = CoinFamily::factory()->make();
        $model->fill(['name' => null]);
        $model->save();
        $this->assertModelMissing($model);
    }

    public function test_create_without_name()
    {
        $this->expectException(ValidationException::class);
        $model = CoinFamily::factory()->for(MonetaryPattern::factory()->create())->make();
        $model->fill(['name' => null]);
        $model->save();
        $this->assertModelMissing($model);
    }
}
