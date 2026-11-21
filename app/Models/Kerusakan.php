<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kerusakan extends Model
{
    use SoftDeletes;

    protected $table = 'kerusakans';

    protected $fillable = ['kategori_id', 'kode_kerusakan', 'nama_kerusakan'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class, 'kerusakan_id');
    }

    public function penyebabs(): HasMany
    {
        return $this->hasMany(Penyebab::class, 'kerusakan_id');
    }

    public function solusis(): HasMany
    {
        return $this->hasMany(Solusi::class, 'kerusakan_id')->orderBy('urutan');
    }

    public function diagnosisResults(): HasMany
    {
        return $this->hasMany(DiagnosisResult::class, 'kerusakan_id');
    }
}
