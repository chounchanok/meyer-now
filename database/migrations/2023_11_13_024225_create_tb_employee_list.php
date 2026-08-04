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
        Schema::create('tb_employee', function (Blueprint $table) {

            $table->integer('id')->primary();
            $table->integer('employee_import_id')->nullable();
            $table->string('orisoft_no',6)->nullable();
            $table->string('title_en',20)->nullable();
            $table->string('title_th',20)->nullable();
            $table->string('employee_local_name_th')->nullable();
            $table->string('employee_local_name_en')->nullable();
            $table->string('grade_code',4)->nullable();
            $table->string('division_code',4)->nullable();
            $table->string('department_code',4)->nullable();
            $table->string('section_code',4)->nullable();
            $table->string('position_description')->nullable();
            $table->string('section_description')->nullable();
            $table->string('division_description')->nullable();
            $table->string('grade_description')->nullable();
            $table->string('ID')->nullable();
            $table->datetime('birth_date')->nullable();
            $table->datetime('date_joined')->nullable();
            $table->string('employee_type',1)->nullable();
            $table->string('employee_type_description',20)->nullable();
            $table->string('home_contact_1',20)->nullable();
            $table->text('mail_address_1')->nullable();
            $table->string('position_code',3)->nullable();
            $table->datetime('date_resigned')->nullable();
            $table->datetime('date_retirement')->nullable();
            $table->datetime('date_confirmed')->nullable();
            $table->string('employee_status',1)->nullable();
            $table->string('employee_status_description',20)->nullable();
            $table->integer('sort')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_employee');
    }
};
