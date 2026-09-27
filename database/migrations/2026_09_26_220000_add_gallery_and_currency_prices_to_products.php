<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('image_url');
            $table->decimal('price_eur', 12, 2)->nullable()->after('price_fcfa');
            $table->decimal('price_usd', 12, 2)->nullable()->after('price_eur');
            $table->decimal('compare_price_eur', 12, 2)->nullable()->after('compare_price_fcfa');
            $table->decimal('compare_price_usd', 12, 2)->nullable()->after('compare_price_eur');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'gallery',
                'price_eur',
                'price_usd',
                'compare_price_eur',
                'compare_price_usd',
            ]);
        });
    }
};
