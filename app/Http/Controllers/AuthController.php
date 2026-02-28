<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    // =======================
    // FORM LOGIN
    // =======================
    public function login()
    {
        return view('auth.login');
    }

    // =======================
    // PROSES LOGIN
    // =======================
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        // Regenerate session (security)
        $request->session()->regenerate();

        // Simpan session
        Session::put('login', true);
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->nama);
        Session::put('role', strtolower(trim($user->role)));

        // Redirect berdasarkan role
        switch (Session::get('role')) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'petugas':
                return redirect()->route('petugas.dashboard');

            case 'siswa':
                return redirect()->route('siswa.dashboard');

            default:
                Session::flush();
                return redirect('/login')->with('error', 'Role tidak dikenali');
        }
    }

    // =======================
    // FORM REGISTER
    // =======================
    public function register()
    {
        return view('auth.register');
    }

    // =======================
    // PRO SES REGISTER
    // =======================
    public function registerProcess(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'nama'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa'
        ]);

        return redirect('/login')
            ->with('success', 'Register berhasil, silakan login');
    }

    // =======================
    // LOGOUT
    // =======================
    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
