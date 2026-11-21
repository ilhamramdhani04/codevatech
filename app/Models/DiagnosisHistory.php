<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnosisHistory extends Model
{
    use SoftDeletes;

    protected $table = 'diagnosis_histories';

    protected $fillable = [
        'user_id', 'nama_pengguna', 'tanggal_diagnosis',
        'brand_id', 'laptop_model_id', 'laptop_info_manual',
    ];

    protected $casts = [
        'tanggal_diagnosis' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function laptopModel(): BelongsTo
    {
        return $this->belongsTo(LaptopModel::class, 'laptop_model_id');
    }

    /**
     * Helper: info laptop dalam format display-friendly.
     */
    public function getLaptopDisplayAttribute(): ?string
    {
        if ($this->brand && $this->laptopModel) {
            return $this->brand->nama_brand . ' ' . $this->laptopModel->full_name;
        }
        if ($this->brand) {
            return $this->brand->nama_brand;
        }
        return $this->laptop_info_manual;
    }

    public function diagnosisGejala(): HasMany
    {
        return $this->hasMany(DiagnosisGejala::class, 'diagnosis_history_id');
    }

    public function diagnosisResults(): HasMany
    {
        return $this->hasMany(DiagnosisResult::class, 'diagnosis_history_id');
    }

    /**
     * Shortcut untuk mendapat daftar gejala yang dipilih.
     */
    public function gejalas()
    {
        return $this->hasManyThrough(
            Gejala::class,
            DiagnosisGejala::class,
            'diagnosis_history_id',
            'id',
            'id',
            'gejala_id'
        );
    }

    /**
     * Shortcut untuk mendapat daftar kerusakan hasil.
     */
    public function kerusakans()
    {
        return $this->hasManyThrough(
            Kerusakan::class,
            DiagnosisResult::class,
            'diagnosis_history_id',
            'id',
            'id',
            'kerusakan_id'
        );
    }
}
