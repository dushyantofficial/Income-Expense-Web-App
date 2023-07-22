<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Categories;
use App\Models\Expenses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ExpensesController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $params = request()->all();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $expenses = Expenses::filter($params)->paginate(10);
        } else {
            $expenses = Expenses::where('user_id', $user->id)->filter($params)->paginate(10);
        }
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        $categories = Categories::where('status', 'active')->get();
        $accounts = Accounts::where('status', 'active')->get();
        $user_accounts = Accounts::where('user_id', $user->id)->where('status', 'active')->get();
        return view('admin.expenses.create', compact('users', 'categories', 'accounts', 'user_accounts'));
    }


    public function store(Request $request)
    {

        $request->validate(Expenses::$rules);
        $input = $request->all();
        $user = Expenses::create($input);
        return redirect()->route('expenses.index')->with('success', Lang::get('langs.flash_suc'));
    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $expenses = Expenses::find($id);
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        $accounts = Accounts::where('status', 'active')->get();
        $categories = Categories::where('status', 'active')->get();
        $user_accounts = Accounts::where('user_id', $user->id)->where('status', 'active')->get();
        return view('Admin.expenses.edit', compact('expenses', 'users', 'categories', 'accounts', 'user_accounts'));

    }

    public function update(Request $request, $id)
    {
        $rules = Expenses::$rules;
        $request->validate($rules);
        $expenses = Expenses::find($id);
        $input = $request->all();
        $expenses->update($input);

        return redirect()->route('expenses.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $expenses = Expenses::find($id);
        if (empty($expenses)) {
            return redirect(route('expenses.index'))->with('danger', Lang::get('langs.flash_not_found'));
        }
        $expenses->delete($id);
        return redirect(route('expenses.index'))->with('danger', Lang::get('langs.flash_del'));
    }
}
