<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('image_url')->change();
        });

        if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'image_url')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->text('image_url')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_url')->change();
        });
    }
};
