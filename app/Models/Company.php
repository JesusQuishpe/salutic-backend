<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table="companies";
    protected $fillable=[
        'long_name',
        'short_name',
        'address',
        'phone',
        'email',
        'logo_path',
        'start_hour',
        'end_hour'
    ];
}
