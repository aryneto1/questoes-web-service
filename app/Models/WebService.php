<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebService extends Model
{
    protected $table = 'web_service';
    protected $guarded = ['_token'];
    protected $primaryKey = 'id';

    use HasFactory;
}
