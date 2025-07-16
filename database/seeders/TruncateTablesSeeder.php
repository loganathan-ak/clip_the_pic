<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruncateTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $tables = DB::select('SHOW TABLES');
        $databaseName = DB::connection()->getDatabaseName();

        foreach ($tables as $tableObject) {
            foreach ($tableObject as $tableName) {
                if ($tableName != 'users' && $tableName != 'plans') {
                    DB::table($tableName)->truncate();
                    echo "Table '$tableName' data cleared: $tableName\n";
                }
            }
        }

        Schema::enableForeignKeyConstraints();

        echo "All table data cleared except 'users' and 'plans'.\n";
    }
}