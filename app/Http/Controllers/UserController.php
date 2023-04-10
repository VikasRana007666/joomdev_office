<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->merge(['role' => 'user']);
            $user = User::where($request->only('email', 'role'))->first();

            session(['user' => $user]);

            // Email Check
            if (empty($user)) {
                return back()->with("error", "Email Not Found!");
            }

            // Password Check
            if (!Hash::check($request->password, $user->password)) {
                return back()->with("error", "Passowd Didn't Match!");
            }

            // Checking For 1 Month
            $instance = Carbon::createFromFormat('Y-m-d H:i:s', $user->last_password_change);
            $next_month = $instance->addMonths(1);
            if ($next_month < Carbon::now()) {
                $user->update(["password_change_status" => "not_changed"]);
            }

            // Password Change Status Check
            if ($user->password_change_status == "not_changed") {
                return redirect()->route("user.reset_password");
            }

            // $request->session()->regenerate();
            Auth::guard('web')->login($user);

            return redirect()->route('user.home');
        } else if ($request->isMethod('get')) {
            return view('user.login');
        } else {
            return "<h1>Not Found!</h1>";
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->regenerate();

        return redirect()->route('user.login');
    }

    public function reset_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = session("user");

            // Check Same Password
            if ($request->password != $request->password_confirmation) {
                return back()->with("error", "Password Not Match!");
            }

            $user->update([
                "password" => Hash::make($request->password),
                "password_change_status" => "changed",
                "last_password_change" => Carbon::now()
            ]);

            // $request->session()->regenerate();
            Auth::guard('web')->login($user);

            return redirect()->route('user.home');
        } else if ($request->isMethod('get')) {
            return view('user.reset_password');
        } else {
            return "<h1>Not Found!</h1>";
        }
    }

    public function home(Request $request)
    {
        return view('user.home');
    }

    public function add_task(Request $request)
    {
        if ($request->isMethod('post')) {
            Task::create($request->all());

            return redirect()->route('user.add_task');
        } else if ($request->isMethod('get')) {
            $user = auth('web')->user();

            $tasks = Task::latest()->where(["user_id" => $user->id])->get();
            return view('user.add_task', [
                "tasks" => $tasks
            ]);
        } else {
            return "<h1>Not Found!</h1>";
        }
    }
}
