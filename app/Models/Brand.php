<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = ['nama_brand', 'logo_url'];

    public function laptopModels(): HasMany
    {
        return $this->hasMany(LaptopModel::class, 'brand_id');
    }

    public function diagnosisHistories(): HasMany
    {
        return $this->hasMany(DiagnosisHistory::class, 'brand_id');
    }
}
