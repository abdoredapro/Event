<?php

use App\Models\Category;
use App\Models\Provider;
use App\Models\SubCategory;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->nullable()->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(SubCategory::class)->nullable()->constrained()
            ->nullOnDelete();
            $table->foreignIdFor(Provider::class)->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('image');
            $table->float('price');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
