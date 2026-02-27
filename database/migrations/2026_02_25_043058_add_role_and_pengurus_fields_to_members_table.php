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
        Schema::table('members', function (Blueprint $table) {
            $table->string('role')->default('anggota')->after('name');
            $table->string('status_pengurus')->default('tidak_mendaftar')->after('role');
            
            // Pengurus Registration Data
            $table->boolean('is_interested_pengurus')->default(false);
            $table->boolean('has_org_experience')->default(false);
            $table->string('org_name')->nullable();
            $table->string('org_position')->nullable();
            $table->integer('org_duration_months')->nullable();
            $table->text('org_description')->nullable();
            $table->string('org_certificate_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'role', 
                'status_pengurus', 
                'is_interested_pengurus', 
                'has_org_experience',
                'org_name',
                'org_position',
                'org_duration_months',
                'org_description',
                'org_certificate_path'
            ]);
        });
    }
};
