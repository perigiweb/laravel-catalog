<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait SlugTrait
{
    //
    public function createSlug($title)
    {
        $slugField = $this->slugField ?? 'slug';
        $slug  = $tmp = Str::slug($title);
        $where = [];
        if ($this->exists){
            $where[] = [$this->getKeyName(), '!=', $this->getKey()];
        }
        $i = 1;
        do {
            $where[] = [$slugField, '=', $tmp];
            $obj = static::where($where)->first();
            $found = ($obj and $obj->exists);
            if (!$found) {
                $slug = $tmp;
            } else {
                $tmp = $slug . '-' . $i;
                $i++;
            }
        } while ($found);

        return $slug;
    }
}
