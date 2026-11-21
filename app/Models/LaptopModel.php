<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaptopModel extends Model
{
    protected $table = 'laptop_models';

    protected $fillable = ['brand_id', 'nama_model', 'seri', 'kategori_laptop', 'tahun_rilis'];

    protected $casts = [
        'tahun_rilis' => 'integer',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function diagnosisHistories(): HasMany
    {
        return $this->hasMany(DiagnosisHistory::class, 'laptop_model_id');
    }

    /**
     * Helper: tampilkan nama lengkap "Model (Seri)"
     */
    public function getFullNameAttribute(): string
    {
        return $this->seri
            ? "{$this->nama_model} ({$this->seri})"
            : $this->nama_model;
    }
}
