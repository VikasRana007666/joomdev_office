<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adding_admin()
    {
        User::updateOrCreate([
            "email" => "admin@gmail.com",
            "phone" => "9999999999",
        ], [
            "role" => "admin",
            "first_name" => "Admin",
            "last_name" => "Admin",
            "password" => Hash::make("12345678")
        ]);
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->merge(['role' => 'admin']);
            $admin = User::where($request->only('email', 'role'))->first();
            // dd($admin);
            // Email Check
            if (empty($admin)) {
                return back()->with("error", "Email Not Found!");
            }

            // Password Check
            if (!Hash::check($request->password, $admin->password)) {
                return back()->with("error", "Passowd Didn't Match!");
            }

            // $request->session()->regenerate();
            Auth::guard('web')->login($admin);

            return redirect()->route('admin.home');
        } else if ($request->isMethod('get')) {

            return view('admin.login', []);
        } else {
            return "<h1>Not Found!</h1>";
        }
    }

    public function home(Request $request)
    {
        return view('admin.home');
    }

    public function add_user(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->merge(['role' => 'user']);
            // return $request->all();
            // Checking if the email exists
            $check = User::where($request->only('email', 'role'))->exists();
            if ($check) {
                return back()->with("error", "Email Already registered!");
            }

            // Checking if the phone exists
            $check = User::where($request->only('phone', 'role'))->exists();
            if ($check) {
                return back()->with("error", "Phone Already registered!");
            }

            // Creating the user
            $user = User::create($request->only(
                'first_name',
                'last_name',
                'email',
                'role',
                'phone'
            ));

            $user->update(["password" => Hash::make($request->password)]);

            return redirect()->route('admin.add_user');
        } else if ($request->isMethod('get')) {
            $users = User::latest()->where([
                "role" => "user"
            ])->get();

            return view('admin.add_user', [
                "users" => $users
            ]);
        } else {
            return "<h1>Not Found!</h1>";
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }

    public function all_tasks(Request $request)
    {
        if ($request->isMethod('post')) {
            return redirect()->route('admin.all_tasks');
        } else if ($request->isMethod('get')) {
            $tasks = Task::leftJoin('users', 'users.id', '=', 'tasks.user_id')
                ->select(
                    'tasks.*',
                    'users.first_name',
                    'users.last_name',
                    'users.email'
                )->latest()->get();

            return view('admin.all_tasks', [
                "tasks" => $tasks
            ]);
        } else {
            return "<h1>Not Found!</h1>";
        }
    }

    public function download_csv(Request $request)
    {
        if ($request->isMethod('get')) {
            $tasks = Task::leftJoin('users', 'users.id', '=', 'tasks.user_id')
                ->select(
                    'tasks.*',
                    'users.email as email'
                )->latest()->get();

            $filename = "download.csv";

            $handle = fopen($filename, 'w+');

            fputcsv($handle, array('email', 'start_time', 'end_time', 'notes', 'description'));

            foreach ($tasks as $item) {
                fputcsv($handle, array($item['email'], $item['start_time'], $item['end_time'], $item['notes'], $item['description']));
            }

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return response()->file($filename, $headers);
        } else {
            return redirect()->back();
        }
    }
}
