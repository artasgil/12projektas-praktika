<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Shop extends Model
{
    use Sortable;
    protected $table="shops";
    protected $fillable = ["title", "description", "email", "phone", "country"];
    public $sortable = ["id", "title", "description", "email", "phone", "country"];
}
