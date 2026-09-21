<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained('proposal_campaigns')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('duration');
            $table->date('proposed_date');
            $table->dateTime('voting_deadline')->nullable();
            $table->decimal('estimated_budget', 10, 2)->nullable();
            $table->string('supporting_document_path')->nullable();
            $table->boolean('is_document_validated')->default(false);
            $table->enum('status', ['pending', 'needs_revision', 'active', 'approved_for_execution', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
