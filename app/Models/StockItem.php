<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StockCategory;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class StockItem extends Model
{
    use HasFactory, Loggable, SoftDeletes;
    protected $table = "stock_items";

    protected $fillable = [
        'name',
        'category_id',
    ];

    public function getCategory()
    {        
        return $this->belongsTo(StockCategory::class, 'category_id');
    }
}
