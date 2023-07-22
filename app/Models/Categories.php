<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Categories extends Model
{
    use HasFactory;

    public $table = 'categories';

    protected $appends = [
        'UserIncome',
    ];

    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    public static $rules = [
        'name' => 'required',
        'icon' => 'required',
    ];

    public function scopeFilter($query, $params)
    {
        if (isset($params['search'])) {
            $query->where(function ($query) use ($params) {
                $keyword = $params['search'];
                $query->where('name', 'LIKE', '%' . $keyword . '%');
                $or_fields = ['icon'];
                foreach ($or_fields as $or_field) {
                    $query->orWhere($or_field, 'LIKE', '%' . $keyword . '%');
                }
            });
        }
        return $query;
    }

    public function incomes(){
        return $this->hasMany(Incomes::class,'category_id','id');
    }

    public function expenses(){
        return $this->hasMany(Expenses::class,'category_id','id');
    }

    public function getUserIncomeAttribute()
    {
        $user = Auth::user()->id;
        return $this->whereHas('incomes', function($q) use($user){
            return $q->where('user_id', $user);
        })->sum('amount');

        //

    }
}
