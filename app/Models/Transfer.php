<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    use HasFactory;

    public $table = 'transfers';

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'from_account_id',
        'to_account_id',
        'remark',
    ];

    public static $rules = [
        'date' => 'required',
        'amount' => 'required|digits_between:1,99999999999999|min:0|not_in:0',
        'user_id' => 'required',
        'from_account_id' => 'required',
        'to_account_id' => 'required',
    ];


    public function users(){
        return  $this->belongsTo(User::class,'user_id');
    }

    public function from_user(){
        return  $this->belongsTo(Accounts::class,'from_account_id');
    }

    public function to_user(){
        return  $this->belongsTo(Accounts::class,'to_account_id');
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
                $query->orWhereHas('from_user', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
                $query->orWhereHas('to_user', function ($q) use ($keyword) {
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
