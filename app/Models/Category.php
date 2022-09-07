<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    protected $hidden = ['pivot'];

    protected static function booted() {
        static::deleting(function ($category) {
            $category->loadCount(['goods']);
            if($category->goods_count) {
                return false;
            }
        });
    }

    public function goods() {
        return $this->belongsToMany(\App\Models\Good::class, 'category_good_binds');
    }
}
