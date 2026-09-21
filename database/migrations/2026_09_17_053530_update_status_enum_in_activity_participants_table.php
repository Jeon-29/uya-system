<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the enum column to include 'late'
        DB::statement("ALTER TABLE activity_participants MODIFY COLUMN status ENUM('registered', 'cancelled', 'attended', 'late', 'absent') DEFAULT 'registered'");
    }

    public function down(): void
    {
        // Revert back to original enum definition
        DB::statement("ALTER TABLE activity_participants MODIFY COLUMN status ENUM('registered', 'cancelled', 'attended', 'absent') DEFAULT 'registered'");
    }
};
