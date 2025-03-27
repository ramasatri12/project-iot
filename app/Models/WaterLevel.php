<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterLevel extends Model
{
    protected $fillable = ['height', 'status'];
}
