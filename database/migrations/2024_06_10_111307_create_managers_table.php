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
        if(!Schema::hasTable('managers')){
            Schema::create('managers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pengajuan_id')->constrained()->onDelete('cascade');
                $table->enum('manager', ['Approved', 'Rejected']);
                $table->text('alasan_manager')->nullable();
                $table->foreignId('action_by')->constrained('users')->onDelete('cascade');
                $table->timestamp('action_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
