<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TransferController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $params = request()->all();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $transfers = Transfer::filter($params)->paginate(10);
        } else {
            $transfers = Transfer::where('user_id', $user->id)->filter($params)->paginate(10);
        }
        return view('admin.transfer.index', compact('transfers'));
    }

    public function create(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        $accounts = Accounts::where('status', 'active')->where('user_id', '!=', $user->id)->get();
        $user_accounts = Accounts::where('user_id', $user->id)->where('status', 'active')->get();
        return view('admin.transfer.create', compact('users', 'accounts', 'user_accounts'));
    }


    public function store(Request $request)
    {

        $request->validate(Transfer::$rules);
        if ($request->from_account_id == $request->to_account_id) {
            session()->flash('danger', 'To Bank Other Bank Select');
            return back()->with('danger', 'To Bank Other Bank Select');
        } else {
            $input = $request->all();
            $user = Transfer::create($input);
            return redirect()->route('transfer.index')->with('success', Lang::get('langs.flash_suc'));
        }

    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $transfers = Transfer::find($id);
        $users = User::where('role','!=',config('constants.ROLE.ADMIN'))->get();
        $accounts = Accounts::where('status', 'active')->get();
        $user_accounts = Accounts::where('user_id', $user->id)->where('status', 'active')->get();
        return view('Admin.transfer.edit', compact('transfers', 'users', 'accounts', 'user_accounts'));

    }

    public function update(Request $request, $id)
    {
        $rules = Transfer::$rules;
        $request->validate($rules);
        if ($request->from_account_id == $request->to_account_id) {
            session()->flash('danger', 'To Bank Other Bank Select');
            return back()->with('danger', 'To Bank Other Bank Select');
        } else {
            $transfers = Transfer::find($id);
            $input = $request->all();
            $transfers->update($input);

            return redirect()->route('transfer.index')->with('info', Lang::get('langs.flash_up'));
        }
    }

    public function destroy(Request $request, $id)
    {
        $transfers = Transfer::find($id);
        if (empty($transfers)) {
            return redirect(route('transfer.index'))->with('danger', Lang::get('langs.flash_not_found'));
        }
        $transfers->delete($id);
        return redirect(route('transfer.index'))->with('danger', Lang::get('langs.flash_del'));
    }
}
