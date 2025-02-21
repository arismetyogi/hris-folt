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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('unit_bisnis');
            // Personal Info
            $table->string('nik', length: 16)->unique();
            $table->string('name', 50);
            $table->date('date_of_birth');
            $table->string('phone', 16);
            $table->string('sex', 6);
            $table->string('religion', length: 10);
            $table->string('blood_type', length: 2);
            $table->string('address', 200);
            $table->unsignedBigInteger('zip_id')->nullable();
            // Professional Info
            $table->foreignId('employee_status_id')
                ->constrained('employee_statuses');
            $table->foreignId('jabatan_id')
                ->constrained('jabatans');
            $table->foreignId('subjabatan_id')
                ->constrained('subjabatans');
            $table->foreignId('band_id')
                ->constrained('bands');
            $table->foreignId('apotek_id')
                ->constrained('apoteks');
            $table->string('npp', length: 10);
            $table->string('sap_id')->unique()->nullable();
            $table->foreignId('grade_eselon_id')
                ->constrained('grade_eselons');
            $table->foreignId('area_id')
            ->constrained('areas');
            $table->foreignId('employee_level_id')
            ->constrained('employee_levels');
            $table->string('saptitle_id', 50)->unique();
            $table->string('saptitle_name', 100);
            $table->date('date_hired');
            $table->date('date_promoted');
            $table->date('date_last_mutated');
            $table->foreignId('status_desc_id')
            ->constrained('status_descs');
            // Insurance Details
            $table->string('bpjs_id', 13)->unique();
            $table->integer('insured_member_count');
            $table->integer('bpjs_class');
            $table->string('bpjstk_id', 16)->unique();
            // Contract Details
            $table->string('contract_document_id', 100)->nullable();
            $table->integer('contract_sequence_no')->nullable();
            $table->integer('contract_term')->nullable();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            // Tax Details
            $table->string('npwp', length: 16);
            $table->string('status_pasangan', 3); // TK, K-0, K-1, K-2, K-3
            $table->integer('jumlah_tanggungan'); // (0-3)
            $table->boolean('pasangan_ditanggung_pajak'); // (ya/tidak)
            // Banking Details
            $table->string('account_no', 16)->unique();
            $table->string('account_name', 50);
            $table->foreignId('bank_id')->constrained('banks');
            // Recruitment Status
            $table->unsignedBigInteger('recruitment_id')
                ->nullable();
            // Uniform Details
            $table->string('pants_size', 7);
            $table->string('shirt_size', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
