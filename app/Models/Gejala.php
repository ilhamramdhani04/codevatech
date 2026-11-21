<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gejala extends Model
{
    use SoftDeletes;

    public const DIAGNOSIS_GROUPS = [
        'power' => '⚡ Daya & Baterai',
        'display' => '🖥️ Layar & Tampilan',
        'performance' => '⚙️ Performa & Hardware',
        'input' => '⌨️ Input & Perangkat',
        'system' => '🔒 Sistem, Firmware & AI',
    ];

    protected $table = 'gejalas';

    protected $fillable = ['kode_gejala', 'nama_gejala', 'is_frequent', 'diagnosis_group'];

    protected $casts = [
        'is_frequent' => 'boolean',
    ];

    /**
     * Relasi many-to-many ke Rule melalui tabel pivot rule_gejala.
     */
    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'rule_gejala', 'gejala_id', 'rule_id')
                    ->withPivot('is_negated')
                    ->withTimestamps();
    }

    public function ruleGejala(): HasMany
    {
        return $this->hasMany(RuleGejala::class, 'gejala_id');
    }

    public function diagnosisGejala(): HasMany
    {
        return $this->hasMany(DiagnosisGejala::class, 'gejala_id');
    }
}
