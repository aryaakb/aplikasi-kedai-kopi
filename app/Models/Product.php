<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'description', 'price', 'stock', 'image', 'image_url'];
    
    public function getImageUrlAttribute()
    {
        // Prioritas: image_url dari database, lalu image upload, lalu default
        if ($this->attributes['image_url']) {
            return $this->attributes['image_url'];
        }
        return $this->image ? asset('storage/'.$this->image) : 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400';
    }
}