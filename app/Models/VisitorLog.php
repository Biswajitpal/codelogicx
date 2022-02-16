<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorLog extends Model
{
    use HasFactory;

    use SoftDeletes;
    
    protected $table = "visitor_log";

    protected $guarded = [];

}
