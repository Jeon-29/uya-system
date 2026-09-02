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
        Schema::table('users', function (Blueprint $table) {
            // Profile fields collected on the register form
            $table->unsignedTinyInteger('age')->nullable()->after('name');
            $table->string('gender')->nullable()->after('email');
            $table->string('contact_number')->nullable()->after('gender');
            $table->string('address')->nullable()->after('contact_number');

            // OTP fields shared by email-verification (register) and
            // password-reset flows. Only one OTP is "live" per user at a time.
            $table->string('otp_code')->nullable()->after('remember_token');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'gender',
                'contact_number',
                'address',
                'otp_code',
                'otp_expires_at',
            ]);
        });
    }
};
