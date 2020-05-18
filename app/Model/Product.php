<?php

namespace App\Model;

class Product extends Model
{

    public function category() {
        return $this->belongsTo(Category::class, "category_id");
    }

}
