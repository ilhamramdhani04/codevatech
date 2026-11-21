<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosisGejala extends Model
{
    protected $table = 'diagnosis_gejala';

    protected $fillable = ['diagnosis_history_id', 'gejala_id'];

    public function diagnosisHistory(): BelongsTo
    {
        return $this->belongsTo(DiagnosisHistory::class, 'diagnosis_history_id');
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
}
