<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LetterSubmission extends Model
{
    protected $fillable = ['type_id','user_id','name','date_of_birth','place_of_birth','religion','gender','address','response','created_at','updated_at'];

    protected $with = ['type_letter','user'];

    public function type_letter()
    {
        return $this->belongsTo(TypeLetter::class, 'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}