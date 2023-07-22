<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_pic',
        'gender',
        'mobile',
        'status',
        'role',
        'lang',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'gender' => 'required',
        'mobile' => 'required|digits:10',
    ];

    public function account(){
        return  $this->hasMany(Transfer::class,'to_account_id');
    }


    public function scopeFilter($query, $params)
    {
        if (isset($params['search'])) {
            $query->where(function ($query) use ($params) {
                $keyword = $params['search'];
                $query->where('name', 'LIKE', '%' . $keyword . '%');
                $or_fields = ['email','mobile'];
                foreach ($or_fields as $or_field) {
                    $query->orWhere($or_field, 'LIKE', '%' . $keyword . '%');
                }
            });
        }
        return $query;
    }
}
