<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'title',
        'description',
        'image',
        'type',
        'subtype',
        'location',
        'urgency',
        'anonymous',
        'status',
        'evacuation_site',
        'dispatch_unit',
        'contact_person',
        'contact_number',
        'casualties',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
