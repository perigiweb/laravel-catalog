<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;

class Product extends Model
{
  protected $fillable = [
    'brand_id',
    'name',
    'code',
    'price',
    'image',
    'description',
    'category_id'
  ];

  public static function booted()
  {
    static::deleting(function($product){
      if ($product->image){
        File::delete($product->image_path);
      }
    });
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(Brand::class);
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function getImageUrlAttribute(){
    return $this->image ? asset('storage/'.$this->image):null;
  }

  public function getImagePathAttribute(){
    return $this->image ? storage_path('app/public/' . $this->image):null;
  }
}
