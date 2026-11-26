<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE users ALTER COLUMN avatar_url TYPE TEXT');
            DB::statement('ALTER TABLE teknisi ALTER COLUMN foto TYPE TEXT');
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->text('avatar_url')->nullable()->change();
        });

        if (Schema::hasColumn('teknisi', 'foto')) {
            Schema::table('teknisi', function (Blueprint $table) {
                $table->text('foto')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Keep TEXT columns safely
    }
};
