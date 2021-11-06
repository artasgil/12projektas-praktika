<?php

namespace App;
use App\Category;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;
    protected $table="products";
    protected $fillable = ["title", "description", "excertpt", "price", "category_id"];
    public $sortable = ["id", "title", "description", "excertpt", "price", "category_id" ];



    public function productCategory() {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }
}
