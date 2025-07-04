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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->integer("item_no");
            $table->string("description");
            $table->dateTime("doc_date");
            $table->integer("quantity_code");
            $table->string("index_code");
            $table->string("status");
            $table->integer("retention_period")->nullable();
            $table->dateTime("disposal_date")->nullable(); 
            $table->timestamps();

            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
