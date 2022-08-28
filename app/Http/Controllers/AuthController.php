<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required|string',
            'nik' => 'required|string',
            'level_id' => 'required'
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->nik = $request->input('nik');
            $user->level_id = $request->input('level_id');
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            return response()->json( [
                'message' => 'Pendaftaran Berhasil, Silahkan Login'
            ], 201);

        } 
        catch (\Exception $e) {
            return response()->json( [
                'message' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */	 
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $user = User::where("email", $email)->first();

        if (!$user) {
            $out = [
                "message" => "Email tidak terdaftar",
                "code"    => 401,
            ];
            return response()->json($out, $out['code']);
        }

        if (Hash::check($password, $user->password)) {
            $out = [
                "message" => "Login Berhasil",
                "code"    => 200,
            ];
        } else {
            $out = [
                "message" => "Password Salah",
                "code"    => 401,
            ];
        }

        return response()->json($out, $out['code']);
    }
	
    // public function logout()
    // {
    //     return response()->json([
    //         'message' =>'Berhasil logout'
    //     ], 200);
    // }

     /**
     * Get user details.
     *
     * @param  Request  $request
     * @return Response
     */	 	
    public function me()
    {
        return response()->json(auth()->user());
    }
}