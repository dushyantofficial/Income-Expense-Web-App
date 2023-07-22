<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendMail;
use App\Rule\CurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Notification;

class UserController extends Controller
{


    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $params = request()->all();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $users = User::where('role', config('constants.ROLE.USER'))->filter($params)->paginate(10);
            return view('admin.user.index', compact('users'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }

    public function create(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            return view('admin.user.create');
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }

    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $request->validate(User::$rules);
            $validatedData = $request->validate([
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email'
            ]);
            $input = $request->all();
            $input['password'] = Hash::make(\request('password'));
            $input['status'] = 'active';
            $input['lang'] = 'en';
            $input['role'] = config('constants.ROLE.USER');
            if ($request->hasFile("profile_pic")) {
                $img = $request->file("profile_pic");
                $img->store('public/images');
                $input['profile_pic'] = $img->hashName();

            }

            $details = [
                'name' => 'Welcome' . $request->name,
                'body' => 'User Register SuccessFully!...',
                'thanks' => 'Thank you for new register!',
                'text' => 'View My Site',
                'url' => url('/'),

            ];

            $user = User::create($input);
            Notification::send($user, new SendMail($details));
            return redirect()->route('user.index')->with('success', Lang::get('langs.flash_suc'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }

    public function show($id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $users = User::find($id);

            if (empty($users)) {

                return redirect()->back()->with('dander', Lang::get('langs.flash_not_found'));
            }

            return view('Admin.user.show', compact('users'));

        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }

    public function edit(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $users = User::find($id);
            return view('Admin.user.edit', compact('users'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }

    public function update(Request $request, $id)
    {
        $rules = User::$rules;
        $rules['profile_pic'] = 'nullable';
        $rules['password'] = 'nullable';
        $request->validate($rules);
        $users = User::find($id);
        $validatedData = $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,' . $users->id,
        ]);
        $input = $request->all();
        if ($request->hasFile("profile_pic")) {
            $img = $request->file("profile_pic");
            if (Storage::exists('public/images' . $users->profile_pic)) {
                Storage::delete('public/images' . $users->profile_pic);
            }
            $img->store('public/images');
            $input['profile_pic'] = $img->hashName();
            $users->update($input);

        }

        $users->update($input);

        return redirect()->route('user.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $users = User::find($id);
            if (empty($users)) {
                return redirect(route('user.index'));
            }
            $users->delete($id);
            return redirect(route('user.index'))->with('danger', Lang::get('langs.flash_del'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }


    public function userStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return redirect(route('user.index'))->with('success', Lang::get('langs.flash_suc'));
    }

    public function profile()
    {

        return view('auth.profile');
    }

    public function profile_update(Request $request)
    {
        $rules = User::$rules;
        $rules['profile_pic'] = 'nullable';
        $rules['password'] = 'nullable';
        $request->validate($rules);
        $user = Auth::user();
        $validatedData = $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,' . $user->id,
        ]);
        $input = $request->all();
        if ($request->hasFile("profile_pic")) {
            $img = $request->file("profile_pic");
            if (Storage::exists('public/images' . $user->profile_pic)) {
                Storage::delete('public/images' . $user->profile_pic);
            }
            $img->store('public/images');
            $input['profile_pic'] = $img->hashName();
            $user->update($input);

        }

        $user->update($input);

        return redirect()->back()->with('info', Lang::get('langs.flash_up'));
    }

    public function change_password(Request $request)
    {
        $input = $request->all();
        $user = User::whereId(Auth::id())->first();
        $request->validate([
            'current_password' => [new CurrentPassword($user->password)],

            'new_password' => 'required|min:8',
            'conform_password' => 'required|same:new_password'
        ]);

        $new_pass['password'] = Hash::make($request->input('new_password'));
        $user->update($new_pass);
        $user->update($input);
        return redirect()->back()->with('info', Lang::get('langs.flash_change_pass'));
    }


}
