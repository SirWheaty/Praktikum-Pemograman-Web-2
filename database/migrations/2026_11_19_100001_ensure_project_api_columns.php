<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('projects')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'short_description')) {
                $table->string('short_description')->nullable();
            }
            if (! Schema::hasColumn('projects', 'status')) {
                $table->string('status')->default('published');
            }
            if (! Schema::hasColumn('projects', 'project_date')) {
                $table->date('project_date')->nullable();
            }
            if (! Schema::hasColumn('projects', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (! Schema::hasColumn('projects', 'repository_url')) {
                $table->string('repository_url')->nullable();
            }
            if (! Schema::hasColumn('projects', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }
        });

        if (Schema::hasColumn('projects', 'status')) {
            \Illuminate\Support\Facades\DB::table('projects')
                ->whereNull('status')
                ->update(['status' => 'published']);
        }
    }

    public function down(): void
    {
        //
    }
};
