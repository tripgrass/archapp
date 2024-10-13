<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request['password']       = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $response = ['token' => $token];

        return response($response, 200);
    }

    public function login()
    {
        return view('login');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard()->attempt($credentials)) {
            return redirect()->intended();
        }

        return redirect()->route('login')
            ->withInput($credentials)
            ->withErrors([
                'email' => 'Invalid credentials. Please check your email and password.',
            ])
            ->with('error', 'Invalid credentials. Please check your email and password.');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'message' => 'User information retrieved successfully',
                'user' => $user,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->to('login');
    }
}
?>