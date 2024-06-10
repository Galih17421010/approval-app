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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_finance_id')->constrained()->onDelete('cascade');
            $table->enum('finance', ['Approved', 'Rejected']);
            $table->text('alasan_finance')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->foreignId('action_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('action_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
