<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_photos', function (Blueprint $table) {
            // Only add caption if it doesn't exist yet
            if (!Schema::hasColumn('activity_photos', 'caption')) {
                $table->string('caption')->nullable()->after('photo_path');
            }

            // Add batch_id for multi-photo post grouping
            if (!Schema::hasColumn('activity_photos', 'batch_id')) {
                $table->string('batch_id')->nullable()->after('caption');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activity_photos', function (Blueprint $table) {
            if (Schema::hasColumn('activity_photos', 'batch_id')) {
                $table->dropColumn('batch_id');
            }
        });
    }
};
