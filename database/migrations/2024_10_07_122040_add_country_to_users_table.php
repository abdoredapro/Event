<?php

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Country::class)->after('birthdate')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(City::class)->after('country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Area::class)->after('city_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor(Country::class);
            $table->dropForeignIdFor(City::class);
            $table->dropForeignIdFor(Area::class);
        });
    }
};
