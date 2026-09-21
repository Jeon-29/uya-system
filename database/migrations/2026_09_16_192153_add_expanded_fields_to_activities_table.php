<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('organizer_name')->nullable()->after('location');
            $table->decimal('budget', 10, 2)->default(0.00)->after('organizer_name');
            $table->string('duration')->nullable()->after('budget');
            $table->boolean('is_registration_open')->default(true)->after('status');
            $table->boolean('is_attendance_open')->default(false)->after('is_registration_open');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'organizer_name',
                'budget',
                'duration',
                'is_registration_open',
                'is_attendance_open',
            ]);
        });
    }
};
