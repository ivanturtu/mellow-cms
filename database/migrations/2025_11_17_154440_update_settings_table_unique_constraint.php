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
        Schema::table('settings', function (Blueprint $table) {
            // Remove the unique constraint on 'key' only
            $table->dropUnique(['key']);
            
            // Add a unique constraint on the combination of 'key' and 'group'
            // This allows the same key to exist in different groups
            $table->unique(['key', 'group'], 'settings_key_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Remove the composite unique constraint
            $table->dropUnique('settings_key_group_unique');
            
            // Restore the original unique constraint on 'key' only
            $table->unique('key');
        });
    }
};
