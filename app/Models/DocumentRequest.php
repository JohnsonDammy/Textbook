<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'document_request';

    public function requestFundsModel()
{
    return $this->belongsTo(RequestFundsModel::class, 'RequestType', 'RequestType')->whereColumn('School_Emis', 'fundsrequest.School_Emis');
}


}
