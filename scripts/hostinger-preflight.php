<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

try {
    if (! app()->environment('production') || config('app.debug') || ! config('app.key')) {
        throw new RuntimeException('Set APP_ENV=production, APP_DEBUG=false, and a stable APP_KEY before deploying.');
    }

    if (! str_starts_with(config('app.url'), 'https://')) {
        throw new RuntimeException('APP_URL must use the production HTTPS domain.');
    }

    if (! in_array(config('database.default'), ['mysql', 'mariadb'], true)) {
        throw new RuntimeException('Configure the imported Hostinger MySQL/MariaDB database first.');
    }

    DB::connection()->getPdo();

    foreach (['users', 'kategoris', 'gejalas', 'kerusakans', 'penyebabs', 'solusis', 'rules', 'rule_gejala', 'brands', 'laptop_models', 'diagnosis_histories', 'diagnosis_gejala', 'diagnosis_results', 'activity_logs'] as $table) {
        if (! Schema::hasTable($table)) {
            throw new RuntimeException("Imported database is missing the required table: {$table}.");
        }
    }

    if (! Schema::hasColumn('gejalas', 'is_frequent')) {
        throw new RuntimeException('Imported database is missing gejalas.is_frequent; inspect migrations before updating its schema.');
    }

    if (config('session.driver') === 'database' && ! Schema::hasTable('sessions')) {
        throw new RuntimeException('Database sessions require the sessions table.');
    }

    if (config('cache.default') === 'database' && (! Schema::hasTable('cache') || ! Schema::hasTable('cache_locks'))) {
        throw new RuntimeException('Database caching requires cache and cache_locks tables.');
    }

    echo "Production environment and imported database checks passed.\n";
} catch (Throwable $exception) {
    // Connection errors may include credentials or SQL. Keep them out of CI logs.
    fwrite(STDERR, $exception instanceof RuntimeException && ! $exception instanceof PDOException && ! $exception instanceof \Illuminate\Database\QueryException
        ? $exception->getMessage()."\n"
        : "Production preflight failed. Check PHP extensions and database access privately on the server.\n");
    exit(1);
}
