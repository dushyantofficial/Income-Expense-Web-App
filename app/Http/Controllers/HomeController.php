<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Categories;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\Tasks\Backup\BackupJob;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {



        $user = Auth::user();

        if ($user->email_verified_at == null){
            return view('auth.verify')->with('success','Send Email Verify Your Email');
        }
//        Admin Manage
        if ($user->role == 'admin') {

            $users = User::where('role', 'user')->count();
            $categories = Categories::count();
            $accounts = Accounts::count();
            $amounts = Accounts::sum('amount');
            $incomes_amounts = Incomes::sum('amount');
            $expenses_amounts = Expenses::sum('amount');
            $transfer_amounts = Transfer::sum('amount');

            $amountss = Accounts::get();
            $total_amount = 0;
            foreach ($amountss as $key => $amou) {
                $amount = $amou->amount + $amou->Total - $amou->ExpensesAmount - $amou->FromTransfer + $amou->ToTransfer;
                $total_amount += $amount;
            }

            //            Category Wise Income Graph

            $categoriess = Categories::with('incomes')->where('status', 'active')->has('incomes')->get();
            $color = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
//               dd('#' . $color);
            $income_categories_data = null;
            foreach ($categoriess as $key => $cat) {
                $income_categories_data[$key]['label'] = $cat->name;
                $income_categories_data[$key]['value'] = $cat->incomes->sum('amount');
                $income_categories_data[$key]['color'] = "#28a745";
                $income_categories_data[$key]['highlight'] = "#006400";

            }

            //            Category Wise Expenses Graph
            $expeses_categories = Categories::with('expenses')->where('status', 'active')->has('expenses')->get();

            $expenses_categories_data = null;
            foreach ($expeses_categories as $key => $cat) {
                $expenses_categories_data[$key]['label'] = $cat->name;
                $expenses_categories_data[$key]['value'] = $cat->expenses->sum('amount');
                $expenses_categories_data[$key]['color'] = "#a7151b";
                $expenses_categories_data[$key]['highlight'] = "#8b0000";

            }


        } else {
//        User Manage

            $users = User::where('role', 'user')->count();
            $categories = Categories::count();
            $accounts = Accounts::where('user_id', $user->id)->count();
            $amounts = Accounts::where('user_id', $user->id)->sum('amount');
            $incomes_amounts = Incomes::where('user_id', $user->id)->sum('amount');
            $expenses_amounts = Expenses::where('user_id', $user->id)->sum('amount');
            $transfer_amounts = Transfer::where('user_id', $user->id)->sum('amount');
            $from_transfer_amounts = Transfer::where('user_id', $user->id)->sum('amount');
            $amountss = Accounts::where('user_id', $user->id)->get();
            $total_amount = 0;
            foreach ($amountss as $key => $amou) {
                $amount = $amou->amount + $amou->Total - $amou->ExpensesAmount - $amou->FromTransfer + $amou->ToTransfer;
                $total_amount += $amount;
            }

            //            Category Wise Income Graph


            $categoriess = Incomes::where('user_id', Auth::user()->id)
                ->select('categories.name')
                ->selectRaw('SUM(incomes.amount) as amount')
                ->leftJoin('categories', 'categories.id', '=', 'incomes.category_id')
                ->groupBy('categories.name')->get();

            $color = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
            //   dd('#' . $rand);
            $income_categories_data = null;
            foreach ($categoriess as $key => $cat) {
                $income_categories_data[$key]['label'] = $cat->name;
                $income_categories_data[$key]['value'] = $cat->amount;
                $income_categories_data[$key]['color'] = "#28a745";
                $income_categories_data[$key]['highlight'] = "#006400";

            }

            //            Category Wise Expenses Graph
            $expeses_categories = Expenses::where('user_id', Auth::user()->id)
                ->select('categories.name')
                ->selectRaw('SUM(expenses.amount) as amount')
                ->leftJoin('categories', 'categories.id', '=', 'expenses.category_id')
                ->groupBy('categories.name')->get();

            $expenses_categories_data = null;
            foreach ($expeses_categories as $key => $cat) {
                $expenses_categories_data[$key]['label'] = $cat->name;
                $expenses_categories_data[$key]['value'] = $cat->amount;
                $expenses_categories_data[$key]['color'] = "#a7151b";
                $expenses_categories_data[$key]['highlight'] = "#8b0000";

            }
        }

        return view('home', compact('users', 'categories',
            'accounts', 'amounts', 'categoriess',
            'incomes_amounts', 'expenses_amounts',
            'transfer_amounts', 'total_amount', 'income_categories_data', 'expenses_categories_data'));
    }

    public function english()
    {
        $user = Auth::user();
        $input['lang'] = 'en';
        $user->update($input);
        return redirect()->back()->with('success', Lang::get('langs.lang'));
    }

    public function gujarati()
    {
        $user = Auth::user();
        $input['lang'] = 'guj';
        $user->update($input);
        return redirect()->back()->with('success', Lang::get('langs.lang'));
    }

    public function get_category(Request $request)
    {

        $income_categories_datas = Incomes::where('category_id', $request->cat_id)->select(
            DB::raw("(sum(amount)) as count"),
            DB::raw("MONTH(date) as month_name")
        )->whereYear('date', date('Y'))
            ->groupBy('month_name')
            ->get();

        $income_categories_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $m = $income_categories_datas->where('month_name', $i)->first();
            if (!empty($m)) {
                $amount = $m->count;
            } else {
                $amount = 0;
            }
            $income_categories_data[] = $amount;
        }
        return response()->json(['data' => $income_categories_data]);
    }


    public function backup_download(){
        // Create a new backup
        $backupJob = new BackupJob(config('backup.backup'));

        try {
            $backupJob->run();

            // Get all the backups
            $backups = Backup::get();
dd($backups);
            // Get the most recent backup
            $backup = $backups->last();

            if ($backup) {
                $filePath = $backup->path(); // Get the file path of the backup
                $fileName = $backup->filename(); // Get the file name of the backup

                // Check if the backup file exists
                if (Storage::disk('your-disk')->exists($filePath)) {
                    return Storage::disk('your-disk')->download($filePath, $fileName);
                } else {
                    // Backup file not found, handle the error
                    return redirect()->back()->with('error', 'Backup file not found.');
                }
            } else {
                // No backup found, handle the error
                return redirect()->back()->with('error', 'No backup available.');
            }
        } catch (\Exception $e) {
            // Backup creation failed, handle the error
            return redirect()->back()->with('danger', 'Backup creation failed: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'SuccessFully Download BackUp!...');
    }

    public function calendar(Request $request){

        if (\request()->birth_year || \request()->current_year){
            $request->validate([
                'current_year' => "required|date_format:Y|gt:$request->birth_year",
            ]);
            $age = \request()->current_year - \request()->birth_year;
            return view('Admin.calendar',compact('age'));
        }
        return view('Admin.calendar');
}



}
