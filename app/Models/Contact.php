<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'contact_name',
        'email',
        'phone_number',
        'contact_group',
        'assigned_to',
        'address',
    ];

    public function contactGroup()
    {
        return $this->belongsTo(ContactGroup::class, 'contact_group');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
