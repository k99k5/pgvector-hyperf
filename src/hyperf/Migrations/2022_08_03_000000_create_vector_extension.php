<?php

use Hyperf\DbConnection\Db;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down(): void
    {
        DB::statement('DROP EXTENSION vector');
    }
};
