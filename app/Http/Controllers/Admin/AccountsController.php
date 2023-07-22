<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class AccountsController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $params = request()->all();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $accounts = Accounts::filter($params)->paginate(10);
        } else {
            $accounts = Accounts::where('user_id', $user->id)->filter($params)->paginate(10);
        }
        return view('admin.account.index', compact('accounts'));
    }

    public function create(Request $request)
    {
//        $users = User::where('status', 'active')->get();
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        return view('admin.account.create', compact('users'));
    }


    public function store(Request $request)
    {
        $users = Accounts::where('user_id', $request->user_id)->where('name', $request->name)->first();

        if (empty($users)) {
            $request->validate(Accounts::$rules);
            $input = $request->all();
            $input['status'] = 'active';
            $user = Accounts::create($input);
            return redirect()->route('account.index')->with('success', Lang::get('langs.flash_suc'));
        } else {
            return redirect()->route('account.index')->with('danger', Lang::get('langs.flash_record_exit'));
        }
    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {

        $accounts = Accounts::find($id);
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        return view('Admin.account.edit', compact('accounts', 'users'));

    }

    public function update(Request $request, $id)
    {
        $rules = Accounts::$rules;
        $request->validate($rules);
        $categories = Accounts::find($id);
        $input = $request->all();
        $categories->update($input);

        return redirect()->route('account.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {

        $accounts = Accounts::find($id);
        if (empty($accounts)) {
            return redirect(route('account.index'))->with('danger', Lang::get('langs.flash_not_found'));;
        }
        $accounts->delete($id);
        return redirect(route('account.index'))->with('danger', Lang::get('langs.flash_del'));
    }


    public function accountStatus(Request $request)
    {
        $categories = Accounts::find($request->user_id);
        $categories->status = $request->status;
        $categories->save();

        return redirect(route('categories.index'))->with('success', 'Status change successfully.');
    }

    public function my_table(Request $request)
    {
        $ids = $request->input('ids');
        foreach ($ids as $index => $id) {
            DB::table('my_table')->where('id', $id)->update(['order' => $index]);
        }
        return response()->json(['success' => true]);
    }

}
