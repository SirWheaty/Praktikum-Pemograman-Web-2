<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'category_id',
        'image',
        'project_url',
        'github_url',
        'short_description',
        'status',
        'project_date',
        'is_featured',
        'repository_url',
        'thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'project_date' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}