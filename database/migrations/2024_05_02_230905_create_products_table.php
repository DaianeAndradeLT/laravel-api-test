<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        Schema::create('products', function (Blueprint $table) {
            $table->comment('Registra os produtos consumidos da API');
            $table->id();
            $table->string('title');
            $table->float('price');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->integer('external_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
