<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PatroliSchedule extends Model
{
    protected $fillable = ['start_date','context','created_at','updated_at'];
}