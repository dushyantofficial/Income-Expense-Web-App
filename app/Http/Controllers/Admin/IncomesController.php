<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Categories;
use App\Models\Incomes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class IncomesController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $params = request()->all();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $incomes = Incomes::filter($params)->paginate(10);
        } else {
            $incomes = Incomes::where('user_id', $user->id)->filter($params)->paginate(10);
        }
        return view('admin.incomes.index', compact('incomes'));
    }

    public function create(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        $categories = Categories::where('status', 'active')->get();
        $accounts = Accounts::where('status', 'active')->get();
        $user_accounts = Accounts::where('user_id', $user->id)->where('status', 'active')->get();
        return view('admin.incomes.create', compact('users', 'categories', 'accounts', 'user_accounts'));
    }


    public function store(Request $request)
    {

        $request->validate(Incomes::$rules);
        $input = $request->all();
        $input['status'] = 'active';
        $user = Incomes::create($input);
        return redirect()->route('incomes.index')->with('success', Lang::get('langs.flash_suc'));
    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $incomes = Incomes::find($id);
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        $accounts = Accounts::where('status', 'active')->get();
        $categories = Categories::where('status', 'active')->get();
        $user_accounts = Accounts::where('user_id', $user->id)->where('status', 'active')->get();
        return view('Admin.incomes.edit', compact('incomes', 'users', 'categories', 'accounts', 'user_accounts'));

    }

    public function update(Request $request, $id)
    {
        $rules = Incomes::$rules;
        $request->validate($rules);
        $incomes = Incomes::find($id);
        $input = $request->all();
        $incomes->update($input);

        return redirect()->route('incomes.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $incomes = Incomes::find($id);
        if (empty($incomes)) {
            return redirect(route('incomes.index'))->with('danger', Lang::get('langs.flash_not_found'));
        }
        $incomes->delete($id);
        return redirect(route('incomes.index'))->with('danger', Lang::get('langs.flash_del'));
    }

}
