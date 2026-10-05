<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->nullable()->unique();
            $table->string('course')->nullable();
            $table->string('year_level')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('profile_picture')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'student_id',
                'course',
                'year_level',
                'contact_number',
                'profile_picture',
            ]);
        });
    }
};