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
            if (!Schema::hasColumn('rooms', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            if (!Schema::hasColumn('rooms', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2)->nullable()->after('slug');
            }
            if (!Schema::hasColumn('rooms', 'bed_count')) {
                $table->integer('bed_count')->default(1)->after('price_per_night');
            }
            if (!Schema::hasColumn('rooms', 'bath_count')) {
                $table->integer('bath_count')->default(1)->after('bed_count');
            }
            if (!Schema::hasColumn('rooms', 'person_count')) {
                $table->integer('person_count')->default(2)->after('bath_count');
            }
            if (!Schema::hasColumn('rooms', 'wifi')) {
                $table->boolean('wifi')->default(true)->after('person_count');
            }
            if (!Schema::hasColumn('rooms', 'air_conditioning')) {
                $table->boolean('air_conditioning')->default(true)->after('wifi');
            }
            if (!Schema::hasColumn('rooms', 'tv_cable')) {
                $table->boolean('tv_cable')->default(true)->after('air_conditioning');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
        });
    }
};
