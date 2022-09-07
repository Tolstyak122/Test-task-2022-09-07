<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Good extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'published', 'price'];
    protected $casts = [
        'published' => 'boolean',
    ];

    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class, 'category_good_binds')->withTimestamps();
    }

    public function published()
    {
        return Attribute::make(
            set: fn ($value) => (bool)$value ?? 0,
        );
    }
    public function price()
    {
        return Attribute::make(
            set: fn ($value) => (float)$value ?? 0,
        );
    }
    public function scopePriceLimit($query, ?array $limits) {
        $min = $limits['min'] ?? 0;
        $max = $limits['max'] ?? 0;
        if($min) {
            $query = $query->where('price', '>=', $min);
        }
        if($max) {
            $query = $query->where('price', '<=', $max);
        }
        return $query;
    }
    public function scopeTitleSearch($query, ?string $title) {
        if($title) {
            return $query->where('title', 'like', "%$title%");
        }
        return $query;
    }
    public function scopeWithTrash($query, ?bool $trash) {
        if($trash) {
            return $query->withTrashed();
        }
        return $query;
    }
    public function scopePublishedOnly($query, ?bool $published) {
        if($published) {
            return $query->where('published', '=', 1);
        }
        return $query;
    }
    public function scopeCatNameSearch($query, ?string $title) {
        if($title) {
            return $query->whereHas('categories', function(Builder $query) use ($title) {
                $query->where('categories.title', 'like', "%$title%");
            });
        }
        return $query;
    }
    public function scopeCatIdSearch($query, ?int $cat_id) {
        if($cat_id) {
            return $query->whereHas('categories', function(Builder $query) use ($cat_id) {
                $query->where('categories.id', '=', $cat_id);
            });
        }
        return $query;
    }
}
