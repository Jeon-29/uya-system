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
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('background_image_path');

            // Layout JSON structure for coordinates, fonts, alignments, colors, etc.
            // Example: {"recipient_name": {"x": 100, "y": 200, "font_size": 28, "color": "#224d5b"}}
            $table->json('layout_settings')->nullable();

            $table->string('signatory_name')->nullable();
            $table->string('signatory_title')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
