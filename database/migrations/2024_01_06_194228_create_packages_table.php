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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('service');
            $table->string('provider');
            $table->string('title');
            $table->text('description');
            $table->integer('price_type');
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->json('data')->nullable();
            $table->timestamps();
        });

        Schema::create('tenant_package', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_package');
        Schema::dropIfExists('packages');
    }
};
