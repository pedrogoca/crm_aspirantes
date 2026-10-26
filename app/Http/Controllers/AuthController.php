<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
    public function loginForm(){return view('auth.login');}
    public function registerForm(){return view('auth.register');}
    public function login(Request $r){
        $data=$r->validate(['email'=>'required|email','password'=>'required|string']);
        if(!Auth::attempt($data))return back()->withErrors(['email'=>'Credenciales incorrectas.'])->onlyInput('email');
        $r->session()->regenerate();return redirect()->intended(route('dashboard'));
    }
    public function register(Request $r){
        $data=$r->validate(['name'=>'required|string|max:150','email'=>'required|email|max:150|unique:users,email','password'=>'required|string|min:10|confirmed']);
        $user=User::create([...$data,'rol'=>'ASPIRANTE']);Auth::login($user);$r->session()->regenerate();return redirect()->route('dashboard');
    }
    public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('login');}
}
