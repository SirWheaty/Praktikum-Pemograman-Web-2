<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('projects') && ! Schema::hasColumn('projects', 'category_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            });
        }

        if (! Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('email', 100);
                $table->string('subject', 200)->nullable();
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');

        if (Schema::hasTable('projects') && Schema::hasColumn('projects', 'category_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropConstrainedForeignId('category_id');
            });
        }

        Schema::dropIfExists('categories');
    }
};
