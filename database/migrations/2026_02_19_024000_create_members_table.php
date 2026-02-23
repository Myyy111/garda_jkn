<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('password'); 
            $table->string('name');
            $table->string('phone');
            $table->enum('gender', ['L', 'P']);
            $table->enum('education', ['SD', 'SMP', 'SMA', 'Diploma', 'S1/D4', 'S2']);
            $table->string('occupation');
            $table->text('address_detail');
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('district_id')->constrained('districts');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
