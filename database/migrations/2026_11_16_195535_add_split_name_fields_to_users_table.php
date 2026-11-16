<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('id');
            $table->string('middle_initial', 5)->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_initial');
        });

        // Backfill existing users so old accounts aren't blank
        DB::table('users')->orderBy('id')->each(function ($user) {
            if (!empty($user->name)) {
                $parts = preg_split('/\s+/', trim($user->name));
                $firstName = $parts[0] ?? '';
                $lastName = count($parts) > 1 ? array_pop($parts) : '';
                $middleInitial = null;

                if (count($parts) > 1) {
                    $middleCandidate = trim($parts[count($parts) - 1], '.');
                    if (strlen($middleCandidate) <= 2) {
                        $middleInitial = strtoupper($middleCandidate);
                    }
                }

                DB::table('users')->where('id', $user->id)->update([
                    'first_name'     => $firstName,
                    'middle_initial' => $middleInitial,
                    'last_name'      => $lastName,
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'middle_initial', 'last_name']);
        });
    }
};
