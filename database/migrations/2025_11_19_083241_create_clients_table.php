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
    Schema::create('clients', function (Blueprint $table) {
      $table->id();
      $table->string('name',50);
      $table->string('email',50)->nullable();
      $table->string('phone',15)->nullable();
      $table->unsignedBigInteger('country_id');
      $table->foreign('country_id')
      ->references('id')
      ->on('countries')->nullable();
      $table->string('status',10)->default('active');
      $table->timestamps();
    });
  }
////add separator table for notes;

  /**
   * Reverse the migrations.
   */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
