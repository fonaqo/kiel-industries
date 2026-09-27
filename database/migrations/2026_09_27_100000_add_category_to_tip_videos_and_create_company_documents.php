<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tip_videos', function (Blueprint $table) {
            $table->string('category', 40)->default('filiere')->after('slug');
        });

        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 40)->default('certification');
            $table->text('summary')->nullable();
            $table->string('file_path', 500);
            $table->string('issuer')->nullable();
            $table->date('issued_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_documents');

        Schema::table('tip_videos', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
