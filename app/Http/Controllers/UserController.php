<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\User;
 use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Registration Request
     *
     * @param  Request  $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        Log::error('print_r($requestall,true)');
        Log::error(print_r($request->all(),true));

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('bagisto')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Login Request
     *
     * @param  Request  $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        Log::error('in login print_r($requestall,true)');
        Log::error(print_r($request->all(),true));

        $user = [
            'email' => $request->email,
            'password' => $request->password
        ];
        Log::error(print_r($user,true));
 
        if (auth()->attempt($user)) {
            $token = auth()->user()->createToken('bagisto')->accessToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
 
    /**
     * Returns Authenticated User Record
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userRecord()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
} 