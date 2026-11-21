<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penyebab extends Model
{
    protected $table = 'penyebabs';

    protected $fillable = ['kerusakan_id', 'deskripsi'];

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(Kerusakan::class, 'kerusakan_id');
    }
}
