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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Title of certification or achievement.');
            $table->string('issuer')->comment('The issuing organization or institution.');
            $table->string('date')->comment('Date of certification or achievement.');
            $table->string('image_url')->comment('URL of the certification or achievement.');
            $table->text('description')->comment('Description of the certification or achievement.');
            $table->text('credential_url')->nullable()->comment('URL to verify the certification or achievement.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
