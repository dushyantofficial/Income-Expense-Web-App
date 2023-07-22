<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function index(Request $request)
    {


        if ($request->user_id || $request->bank_id) {
            if (Auth::user()->role == config('constants.ROLE.ADMIN')) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $accounts = Accounts::where('user_id', Auth::user()->id)->get();
                $banks = Accounts::where('status', 'active')->get();
                $user_account = Accounts::where('user_id', $request->user_id)->where('id', $request->bank_id)->first();
                if (!empty($user_account)) {
                    $income = Incomes::where('user_id', $request->user_id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->where('account_id', $user_account->id)->select('id', 'user_id', 'date', 'amount', 'category_id', 'account_id', 'remark', DB::raw("'incomes' AS `type`"))->with('account')->with('users')->get();
                    $expense = Expenses::where('user_id', $request->user_id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->where('account_id', $user_account->id)->select('id', 'user_id', 'date', 'amount', 'category_id', 'account_id', 'remark', DB::raw("'expenses' AS `type`"))->with('account')->with('users')->get();
                    $transfer = Transfer::where('user_id', $request->user_id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->where('from_account_id', $user_account->id)->orWhere('to_account_id', $user_account->id)->select('id', 'user_id', 'date', 'amount', 'remark', 'from_account_id', 'to_account_id', DB::raw("'transfer' AS `type`"))->with('users')->get();
                    $query = collect($income)->merge(collect($expense))->sortByDesc('date');
                    $querys = collect($query)->merge(collect($transfer))->sortByDesc('date');
                    $reports = $querys->groupBy('date');
//                    dd($reports);
                    // dd($this->paginate($reports)) ;
                    $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->where('status', 'active')->get();
                    return view('admin.report.index', compact('reports', 'users', 'accounts', 'user_account', 'banks'));
                }
            } else if (Auth::user()->role == config('constants.ROLE.USER')) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $accounts = Accounts::where('user_id', Auth::user()->id)->get();
                $banks = Accounts::where('status', 'active')->get();
                $user_account = Accounts::where('user_id', Auth::user()->id)->where('id', $request->bank_id)->first();
                if (!empty($user_account)) {
                    $income = Incomes::where('user_id', Auth::user()->id)->where('account_id', $user_account->id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->select('id', 'user_id', 'date', 'amount', 'category_id', 'account_id', 'remark', DB::raw("'incomes' AS `type`"))->with('account')->with('users')->get();
                    $expense = Expenses::where('user_id', Auth::user()->id)->where('account_id', $user_account->id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->select('id', 'user_id', 'date', 'amount', 'category_id', 'account_id', 'remark', DB::raw("'expenses' AS `type`"))->with('account')->with('users')->get();
                    $transfer = Transfer::where('user_id', Auth::user()->id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->where('from_account_id', $user_account->id)->orWhere('to_account_id', $user_account->id)->select('id', 'user_id', 'date', 'amount', 'remark', 'from_account_id', 'to_account_id', DB::raw("'transfer' AS `type`"))->with('users')->get();
                    // $transfer = Transfer::where('user_id', Auth::user()->id)->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->select('id', 'user_id', 'date', 'amount', 'remark', DB::raw("'transfer' AS `type`"))->with('users')->get();
                    $query = collect($income)->merge(collect($expense))->sortBy('date');
                    $querys = collect($query)->merge(collect($transfer))->sortBy('date');
                    $reports = $querys->groupBy('date');
                    $users = User::where('status', 'active')->get();
                    return view('admin.report.index', compact('reports', 'users', 'user_account', 'accounts', 'banks'));
                }
            }
        }
        $accounts = Accounts::where('user_id', Auth::user()->id)->get();
        $banks = Accounts::where('status', 'active')->get();
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->where('status', 'active')->get();
        return view('admin.report.index', compact('users', 'accounts', 'banks'));
    }

    public function get_user(Request $request)
    {
        $data = Accounts::where('user_id', $request->cat_id)->get();
        return response()->json(['data' => $data]);
    }

}
