<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('current_phase', ['submission', 'review', 'voting', 'closed'])->default('submission');
            $table->dateTime('submission_deadline');
            $table->date('proposed_date_start');
            $table->date('proposed_date_end');
            $table->integer('required_yes_votes')->default(28);
            $table->integer('total_voters_target')->default(35);
            $table->decimal('required_approval_rate', 5, 2)->default(60.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_campaigns');
    }
};
