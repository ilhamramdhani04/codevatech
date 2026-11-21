<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gejala extends Model
{
    use SoftDeletes;

    protected $table = 'gejalas';

    protected $fillable = ['kode_gejala', 'nama_gejala', 'is_frequent'];

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
