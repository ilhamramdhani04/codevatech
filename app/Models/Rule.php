<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use SoftDeletes;

    protected $table = 'rules';

    protected $fillable = ['kerusakan_id', 'kode_rule', 'keterangan'];

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }

    public function ruleGejala(): HasMany
    {
        return $this->hasMany(RuleGejala::class, 'rule_id');
    }

    /**
     * Relasi many-to-many ke Gejala melalui pivot rule_gejala.
     */
    public function gejalas(): BelongsToMany
    {
        return $this->belongsToMany(Gejala::class, 'rule_gejala', 'rule_id', 'gejala_id')
                    ->withPivot('is_negated')
                    ->withTimestamps();
    }
}
