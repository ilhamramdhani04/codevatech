<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait untuk mencatat aktivitas admin ke tabel activity_logs.
 * Gunakan di controller admin.
 *
 * Contoh penggunaan:
 *   $this->logActivity('created', $kerusakan, 'Kerusakan baru ditambahkan.');
 *   $this->logActivity('updated', $kerusakan, 'Kerusakan diperbarui.', $changes);
 *   $this->logActivity('deleted', $kerusakan, 'Kerusakan dihapus.');
 */
trait LogsActivity
{
    /**
     * Catat aktivitas ke activity_logs.
     *
     * @param  string      $action       created|updated|deleted
     * @param  Model       $model        Model yang terdampak
     * @param  string      $description  Pesan ringkas
     * @param  array|null  $changes      Data perubahan (opsional)
     */
    protected function logActivity(
        string $action,
        Model $model,
        string $description,
        ?array $changes = null,
    ): void {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'model_type' => get_class($model),
            'model_id'   => $model->getKey(),
            'description'=> $description,
            'ip_address' => request()->ip(),
            'changes'    => $changes,
        ]);
    }
}
