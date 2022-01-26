<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_details';
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'email',
        'date_of_birth',
        'address',
        'nationality',
        'preferred_contact_mode'
    ];


    public function education_details()
    {
        return $this->hasMany('App\Models\EducationDetail', 'customer_detail_id');
    }
}
