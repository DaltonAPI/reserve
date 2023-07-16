<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        'monday-checkbox',
        'monday-start',
        'monday-end',
        'tuesday-checkbox',
        'tuesday-start',
        'tuesday-end',
        'wednesday-checkbox',
        'wednesday-start',
        'wednesday-end',
        'thursday-checkbox',
        'thursday-start',
        'thursday-end',
        'friday-checkbox',
        'friday-start',
        'friday-end',
        'saturday-checkbox',
        'saturday-start',
        'saturday-end',
        'sunday-checkbox',
        'sunday-start',
        'sunday-end',
        'user_id'
    ];

    protected $rules = [
        'monday-start' => 'required_if:monday-checkbox,on',
        'monday-end' => 'required_if:monday-checkbox,on',
        'tuesday-start' => 'required_if:tuesday-checkbox,on',
        'tuesday-end' => 'required_if:tuesday-checkbox,on',
        'wednesday-start' => 'required_if:wednesday-checkbox,on',
        'wednesday-end' => 'required_if:wednesday-checkbox,on',
        'thursday-start' => 'required_if:thursday-checkbox,on',
        'thursday-end' => 'required_if:thursday-checkbox,on',
        'friday-start' => 'required_if:friday-checkbox,on',
        'friday-end' => 'required_if:friday-checkbox,on',
        'saturday-start' => 'required_if:saturday-checkbox,on',
        'saturday-end' => 'required_if:saturday-checkbox,on',
        'sunday-start' => 'required_if:sunday-checkbox,on',
        'sunday-end' => 'required_if:sunday-checkbox,on',
    ];

    public function validate($data)
    {
        return Validator::make($data, $this->rules);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

}
