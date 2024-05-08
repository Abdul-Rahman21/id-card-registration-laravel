<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisation_type',
        'organisation_name',
        'contact_no',
        'standard',
        'sections',
        'location',
        'link'
    ];

    public $timestamps = true;
}
