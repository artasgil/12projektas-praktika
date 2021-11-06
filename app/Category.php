<?php

namespace App;

use App\Shop;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;
    protected $table="categories";
    protected $fillable = ["title", "description", "shop_id"];
    public $sortable = ["id", "title", "description", "shop_id" ];



    public function shopTitle() {
        return $this->belongsTo(Shop::class,'shop_id', 'id');
    }

    public function manyProducts() {
        return $this->hasMany(Product::class,'category_id', 'id');
    }
}
