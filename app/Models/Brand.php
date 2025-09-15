<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Brand extends Model
{
  protected $fillable = [
    'name',
    'code',
    'logo',
  ];

  public static function booted()
  {
    static::deleting(function($brand){
      if ($brand->logo){
        File::delete($brand->logo_path);
      }
    });
  }

  public function getLogoUrlAttribute(){
    return $this->logo ? asset('storage/'.$this->logo):null;
  }

  public function getLogoPathAttribute(){
    return $this->logo ? storage_path('app/public/' . $this->logo):null;
  }
}
