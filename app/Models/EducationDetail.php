<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationDetail extends Model
{
    use HasFactory;

    protected $table = 'education_details';

    protected $fillable = [
        'customer_detail_id',
        'education_type',
        'institution_name',
        'institution_address',
        'grade',
        'start_date',
        'end_date',
        'current_status'
    ];

    public function customer_detail()
    {
        return $this->belongsTo('App\Models\CustomerDetail', 'customer_detail_id');
    }
}
