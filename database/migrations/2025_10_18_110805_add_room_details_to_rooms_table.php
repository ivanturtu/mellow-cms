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
        Schema::table('rooms', function (Blueprint $table) {
            // Aggiungi solo le colonne che non esistono già
            if (!Schema::hasColumn('rooms', 'features')) {
                $table->json('features')->nullable()->after('description');
            }
            if (!Schema::hasColumn('rooms', 'amenities')) {
                $table->json('amenities')->nullable()->after('features');
            }
            if (!Schema::hasColumn('rooms', 'location_address')) {
                $table->string('location_address')->nullable()->after('amenities');
            }
            if (!Schema::hasColumn('rooms', 'location_city')) {
                $table->string('location_city')->nullable()->after('location_address');
            }
            if (!Schema::hasColumn('rooms', 'location_state')) {
                $table->string('location_state')->nullable()->after('location_city');
            }
            if (!Schema::hasColumn('rooms', 'location_zip')) {
                $table->string('location_zip')->nullable()->after('location_state');
            }
            if (!Schema::hasColumn('rooms', 'location_country')) {
                $table->string('location_country')->nullable()->after('location_zip');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'price_per_night', 'bed_count', 'bath_count', 'person_count',
                'wifi', 'air_conditioning', 'tv_cable', 'description', 'features',
                'amenities', 'location_address', 'location_city', 'location_state',
                'location_zip', 'location_country'
            ]);
        });
    }
};
