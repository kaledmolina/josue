<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_description',
        'education_title',
        'education_institution',
        'education_dates',
        'education_details',
        'experience_title',
        'experience_company',
        'experience_dates',
        'experience_details',
        'skills'
    ];

    protected $casts = [
        'skills' => 'array'
    ];
}
