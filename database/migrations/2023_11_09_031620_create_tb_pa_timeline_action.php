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
        Schema::create('tb_pa_timeline_action', function (Blueprint $table) {
            $table->id();
            $table->string('pa_timeline_id');
            $table->string('action_name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('start_date_real')->nullable();
            $table->date('end_date_real')->nullable();
            $table->enum('hr',['active','inactive'])->default('inactive');
            $table->enum('manager',['active','inactive'])->default('inactive');
            $table->enum('dm',['active','inactive'])->default('inactive');
            $table->enum('gm',['active','inactive'])->default('inactive');
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pa_timeline_action');
    }
};
