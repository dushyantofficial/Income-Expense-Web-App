<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    public $table = 'expenses';

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'category_id',
        'account_id',
        'remark',
    ];

    public static $rules = [
        'date' => 'required',
        'amount' => 'required|digits_between:1,99999999999999|min:0|not_in:0',
        'user_id' => 'required',
        'category_id' => 'required',
        'account_id' => 'required',
    ];


    public function users(){
        return  $this->belongsTo(User::class,'user_id');
    }

    public function account(){
        return  $this->belongsTo(Accounts::class,'account_id');
    }

    public function category(){
        return  $this->belongsTo(Categories::class,'category_id');
    }

    public function scopeFilter($query, $params)
    {

        if (isset($params['search'])) {
            $query->where(function ($query) use ($params) {
                $keyword = $params['search'];
                $query->where('date', 'LIKE', '%' . $keyword . '%');
                $query->orWhereHas('users', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
                $query->orWhereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
                $query->orWhereHas('account', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
                $or_fields = ['remark', 'amount'];
                foreach ($or_fields as $or_field) {
                    $query->orWhere($or_field, 'LIKE', '%' . $keyword . '%');
                }
            });
        }
    }
}
