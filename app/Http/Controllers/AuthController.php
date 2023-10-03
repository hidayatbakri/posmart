<?php

namespace App\Http\Controllers;

use App\Mail\AuthEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $requestValidate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $checkActivate = User::where('email', $requestValidate['email'])->first();
        if ($checkActivate) {
            if ($checkActivate['email_verified_at'] != null) {
                if (Auth::attempt($requestValidate)) {
                    $path = Auth::user()->level == 'admin' ? 'admin' : 'user';
                    return redirect('/' . $path);
                }
                return redirect()->back()->with('error', 'Username atau password salah');
            } else {
                return redirect()->back()->with('error', 'Akun belum di verifikasi');
            }
        }
        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'shop_name' => 'required',
            'phone_number' => 'required|min:11',
            'address' => 'required',
        ]);
        $tokenActive = Hash::make($request->email . $request->shop_name);
        $tokenActive2 = Hash::make($request->email . $request->shop_name);
        $requestValidate['password'] = Hash::make($request->password);
        $requestValidate['level'] = 'user';
        $requestValidate['token_activate'] = $tokenActive;

        $requestValidate['photo'] = $request->photo != null ? $request->file('photo')->store('avatar') : '';

        $data_email = [
            'subject' => 'no-reply | Activate your account',
            'name' => $request->name,
            'link' => env('APP_URL') . '/activate?token=' . $tokenActive
        ];
        Mail::to($request->email)->send(new AuthEmail($data_email));
        User::create($requestValidate);
        return redirect('/login')->with('success', 'Berhasil membuat akun baru');
    }

    public function activate(Request $request)
    {
        $user = User::where('token_activate', $request->get('token'))->first();
        if ($user != null) {
            User::find($user->id)->update(['email_verified_at' => Carbon::now()]);
            return redirect('/login')->with('success', 'Berhasil mengaktifkan akun anda');
        }
        return redirect('/login')->with('error', 'Gagal mengaktifkan akun');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function checkLevel()
    {
        if (Auth::user()->level == 'admin') {
            return redirect('/admin');
        }
        return redirect('/user');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Berhasil keluar');
    }
}
