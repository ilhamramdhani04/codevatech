<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuleGejala extends Model
{
    protected $table = 'rule_gejala';

    protected $fillable = ['rule_id', 'gejala_id', 'is_negated'];

    protected $casts = [
        'is_negated' => 'boolean',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
}
