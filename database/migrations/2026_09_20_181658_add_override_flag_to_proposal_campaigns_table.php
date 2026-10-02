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
        Schema::table('proposal_campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('proposal_campaigns', 'is_submission_override')) {
                $table->boolean('is_submission_override')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_campaigns', function (Blueprint $table) {
            $table->dropColumn('is_submission_override');
        });
    }
};
