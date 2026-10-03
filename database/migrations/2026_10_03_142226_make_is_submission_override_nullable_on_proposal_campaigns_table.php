<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE proposal_campaigns MODIFY is_submission_override TINYINT(1) NULL DEFAULT NULL');
    }

    public function down(): void
    {
        // Intentionally left empty: restoring NOT NULL would fail if "auto" (null) rows exist.
    }
};
