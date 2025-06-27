<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('pseudo')->nullable()->default(Str::random(7));
            $table->string('email')->unique();
            $table->string('identifiant')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('auth_token')->nullable()->default(null);
            $table->string('password');
            $table->boolean('is_ame')->nullable()->default(false);
            $table->string('status')->nullable()->default(null);
            $table->string('contacts')->nullable()->default(null);
            $table->string('matricule')->nullable()->default(null);
            $table->string('FEDAPAY_ID')->nullable()->default(null);
            $table->string('years_experiences')->nullable()->default(null);
            $table->string('grade')->nullable()->default(null);
            $table->string('graduate_deliver')->nullable()->default(null);
            $table->string('graduate_year')->nullable()->default(null);
            $table->string('graduate_type')->nullable()->default(null);
            $table->string('graduate')->nullable()->default(null);
            $table->string('marital_status')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('teaching_since')->nullable()->default(null);
            $table->date('birth_date')->nullable()->default(null);
            $table->string('birth_city')->nullable()->default(null);
            $table->string('school')->nullable()->default(null);
            $table->string('job_city')->nullable()->default(null);
            $table->string('job_department')->nullable()->default(null);
            $table->string('gender')->nullable()->default(null);
            $table->string('firstname')->nullable()->default(null);
            $table->string('lastname')->nullable()->default(null);
            $table->string('profil_photo')->nullable()->default(null);
            $table->string('ability')->nullable()->default('default');
            $table->string('password_reset_key')->nullable()->default(null);
            $table->string('email_verify_key')->nullable()->default(null);
            $table->boolean('confirmed_by_admin')->default(false);
            $table->boolean('blocked')->default(false);
            $table->string('current_function')->default('Enseignant');
            $table->datetime('blocked_at')->nullable()->default(null);
            $table->string('blocked_because')->nullable()->default(null);
            $table->string('general_school')->nullable()->default(null);
            $table->unsignedBigInteger('wrong_password_tried')->nullable()->default(null);
            $table->boolean('from_general_school')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
