<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('certificate_template_id')
                  ->nullable()
                  ->constrained('certificate_templates')
                  ->onDelete('set null')
                  ->after('status');

            // Options: 'attendance' (scanned/present), 'all_registered', 'manual'
            $table->string('certificate_issuance_rule')
                  ->default('attendance')
                  ->after('certificate_template_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['certificate_template_id']);
            $table->dropColumn(['certificate_template_id', 'certificate_issuance_rule']);
        });
    }
};
