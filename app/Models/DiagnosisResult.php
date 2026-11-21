<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosisResult extends Model
{
    protected $table = 'diagnosis_results';

    protected $fillable = ['diagnosis_history_id', 'kerusakan_id'];

    public function diagnosisHistory(): BelongsTo
    {
        return $this->belongsTo(DiagnosisHistory::class, 'diagnosis_history_id');
    }

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }
}
