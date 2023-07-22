<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    public $table = 'accounts';
    protected $appends = [
        'Total','ExpensesAmount','FromTransfer','ToTransfer','TotalBalance'
    ];
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'amount',
        'status',
    ];

    public static $rules = [
        'user_id' => 'required',
        'type' => 'required',
        'name' => 'required',
        'amount' => 'required|digits_between:1,99999999999999|min:0|not_in:0',
    ];



    public function users(){
      return  $this->belongsTo(User::class,'user_id');
    }


    public function incomes(){
        return  $this->hasMany(Incomes::class,'account_id');
    }

    public function expenses(){
        return  $this->hasMany(Expenses::class,'account_id');
    }

    public function from_transfers(){
        return  $this->hasMany(Transfer::class,'from_account_id');
    }

    public function to_transfers(){
        return  $this->hasMany(Transfer::class,'to_account_id');
    }

    public function getTotalAttribute()
    {
        return $this->incomes->sum('amount');
    }

    public function getExpensesAmountAttribute()
    {
        return $this->expenses->sum('amount');
    }

    public function getFromTransferAttribute()
    {
        return $this->from_transfers->sum('amount');
    }

    public function getToTransferAttribute()
    {
        return $this->to_transfers->sum('amount');
    }


    public function getTotalBalanceAttribute()
    {
        return $this->from_transfers->sum('amount') + $this->to_transfers->sum('amount');
    }


    public function scopeFilter($query, $params)
    {

        if (isset($params['search'])) {
            $query->where(function ($query) use ($params) {
                $keyword = $params['search'];
                $query->where('name', 'LIKE', '%' . $keyword . '%');
                $query->orWhereHas('users', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
                $or_fields = ['type', 'amount'];
                foreach ($or_fields as $or_field) {
                    $query->orWhere($or_field, 'LIKE', '%' . $keyword . '%');
                }
            });
        }
    }
}
