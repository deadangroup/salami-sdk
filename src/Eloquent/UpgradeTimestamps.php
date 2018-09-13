<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

/**
 * Class UpgradeTimestamps
 * @package App\Console\Commands
 * Laravel Artisan command to upgrade timestamp columns for MySQL 5.7 strict mode.
 * If a timestamp column has a default of 0000-00-00 00:00:00, it now defaults to null.
 */
class UpgradeTimestamps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade-timestamps';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrades timestamp columns to be compatible with MySQL 5.7 strict mode.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sql = 'select table_name from information_schema.tables where table_schema=?;';
        $database = config('database.connections.mysql.database');
        $tables = DB::select($sql, [$database]);
        foreach ($tables as $table) {
            $this->upgradeTable($database, $table->table_name);
        }
    }

    protected function upgradeTable($database, $table)
    {
        $columns = DB::select('SHOW COLUMNS FROM `' . $database . '`.`' . $table . '`');
        foreach ($columns as $column) {
            if ($column->Type === 'timestamp' && $column->Default === '0000-00-00 00:00:00') {
                $this->upgradeColumn($database, $table, $column->Field);
            }
        }
    }

    protected function upgradeColumn($database, $table, $column)
    {
        $sql = "ALTER TABLE `$table` CHANGE `$column` `$column` TIMESTAMP NULL DEFAULT NULL;";
        echo $sql . PHP_EOL;
        DB::statement("SET sql_mode = '';");
        DB::statement($sql);
    }
}