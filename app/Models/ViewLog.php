<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'content_id',
        'date',
    ];  

    protected $table = "si_view_log";
}
