<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StockItem;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class StockCategory extends Model
{
    use HasFactory, Loggable, SoftDeletes;
    protected $table = "stock_categories";

    protected $fillable = [
        'name',
    ];

    public function getItem()
    {
        return $this->hasMany(StockItem::class,'category_id');
    }
}
