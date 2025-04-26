<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken;



class Student extends Authenticatable
{
       /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,HasApiTokens, Notifiable;

   /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // Protect against mass-assignment vulnerabilities
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'alt_phone', 'whatsapp',
        'dob', 'birth_place', 'region', 'caste', 'blood_group', 'identity_details',
        'current_address', 'permanent_address',
        'qualification', 'passing_year', 'percentage', 'institution', 'status'
    ];
    protected $hidden = [
        
        'remember_token',
    ];
    
}
