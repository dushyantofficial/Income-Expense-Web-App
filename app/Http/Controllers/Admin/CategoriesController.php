<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CategoriesImport;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $params = request()->all();
        if ($user->role == config('constants.ROLE.ADMIN')) {

            $key = 'categories_' . request('page') . '_' . (implode('_', $params));
            $categories = cache()->remember($key, 60 * 60 * 1, function () use ($params) {
                return Categories::filter($params)->paginate(10);
            });

            return view('admin.categories.index', compact('categories'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }

    public function create(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == 'admin') {
            return view('admin.categories.create');
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }


    public function store(Request $request)
    {
        $request->validate(Categories::$rules);
        $input = $request->all();
        $input['status'] = 'active';
        $user = Categories::create($input);
        return redirect()->route('categories.index')->with('success', Lang::get('langs.flash_suc'));
    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $categories = Categories::find($id);
            return view('Admin.categories.edit', compact('categories'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }

    }

    public function update(Request $request, $id)
    {
        $rules = Categories::$rules;
        $request->validate($rules);
        $categories = Categories::find($id);
        $input = $request->all();
        $categories->update($input);

        return redirect()->route('categories.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $categories = Categories::find($id);
            if (empty($categories)) {
                return redirect(route('categories.index'));
            }
            $categories->delete($id);
            return redirect(route('categories.index'))->with('danger', Lang::get('langs.flash_del'));
        } else {
            return redirect()->route('home')->with('danger', Lang::get('langs.flash_route'));

        }
    }


    public function categoriesStatus(Request $request)
    {
//        dd($request);
        $categories = Categories::find($request->user_id);
        $categories->status = $request->status;
        $categories->save();

        return redirect(route('categories.index'))->with('success', 'Status change successfully.');
    }


    public function import()
    {
        $this->validate(request(), [
           'file' => 'required|mimes:xls,csv,xlsx,txt',
        ]);

        Excel::import(new CategoriesImport(), request()->file('file'));

        return redirect()->back()->with('success', 'Import file SuccessFully!...');
    }

    public function demo_excel(Request $request)
    {
        $path = public_path('admin\images\categories1.xlsx');
        return response()->download($path);
    }


}
