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
        'preferred_contact_mode',
        'guid'
    ];

    //relationships
    public function education_details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\EducationDetail', 'customer_detail_id');
    }

    //filters
    public function scopeFilterByName($query, $name = null)
    {
        if (!$name) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeFilterByEmail($query, $email = null)
    {
        if (!$email) {
            return $query;
        }
        return $query->where('email', 'like', '%' . $email . '%');
    }

    public function scopeFilterByPhone($query, $phone = null)
    {
        if (!$phone) {
            return $query;
        }
        return $query->where('email', 'like', '%' . $phone . '%');
    }

    public function scopeFilterByAddress($query, $address = null)
    {
        if (!$address) {
            return $query;
        }
        return $query->where('address', 'like', '%' . $address . '%');
    }

    public function scopeFilterByNationality($query, $nationality = null)
    {
        if (!$nationality) {
            return $query;
        }
        return $query->where('address', 'like', '%' . $nationality . '%');
    }

    public function scopeFilterByPreferredContactMode($query, $preferred_contact_mode = null)
    {
        if (!$preferred_contact_mode) {
            return $query;
        }
        return $query->where('preferred_contact_mode', 'like', '%' . $preferred_contact_mode . '%');
    }

    public function scopeCreatedAtDateBetween($query, $dates)
    {
        if (isset($dates['start_date'])) {
            return $query->where('created_at', '>=', getStartOfDate($dates['start_date']))
                ->where('created_at', '<=', getEndOfDate($dates['end_date']));
        }
    }

}

