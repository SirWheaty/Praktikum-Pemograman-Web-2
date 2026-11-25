<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasColumn('projects', 'category_id')) {
            return;
        }

        $names = DB::table('projects')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        foreach ($names as $name) {
            $slug = Str::slug($name);
            if ($slug === '') {
                continue;
            }

            $categoryId = DB::table('categories')
                ->where('slug', $slug)
                ->value('id');

            if ($categoryId === null) {
                $categoryId = DB::table('categories')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('projects')
                ->where('category', $name)
                ->whereNull('category_id')
                ->update(['category_id' => $categoryId]);
        }
    }

    public function down(): void
    {
        //
    }
};
