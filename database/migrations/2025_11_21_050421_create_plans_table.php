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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('service_types')->onDelete('cascade');
            $table->string('domain_name');

            #make platform foreign key!
            $table->unsignedBigInteger('platform_id');
            $table->foreign('platform_id')
            ->references('id')
            ->on('platforms')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            #make website type foreign key!
            $table->unsignedBigInteger('website_type_id');
            $table->foreign('website_type_id')
            ->references('id')
            ->on('website_types')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            #make category foreign key!
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->timestamp('start_date')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->integer('duration')->default(0);
            $table->integer('price')->default(0);
            $table->integer('is_plan_active')->default(1);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
    
};
