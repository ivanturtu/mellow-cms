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
        Schema::table('about_sections', function (Blueprint $table) {
            $table->json('image_1_sizes')->nullable()->after('image_1');
            $table->json('image_2_sizes')->nullable()->after('image_2');
            $table->json('image_3_sizes')->nullable()->after('image_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->dropColumn(['image_1_sizes', 'image_2_sizes', 'image_3_sizes']);
        });
    }
};