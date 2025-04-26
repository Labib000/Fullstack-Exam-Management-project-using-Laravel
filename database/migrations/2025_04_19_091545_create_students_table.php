<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('alt_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->date('dob')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('region')->nullable();
            $table->string('caste')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('identity_details')->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('passing_year')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('institution')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
