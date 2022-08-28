<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $User = User::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $User->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $User->offset($request->get('length'));
            }
            return $User->get();
        } else {
            $User = User::find($id);
            if ($User) {
                return $User;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'User tidak ditemukan',
                ], 404);
            }
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $User = User::find($id);
    //     if ($User) {
    //         $validator = Validator::make($request->all(), [
    //             'name'  => 'required',
    //             'email' => 'required|email',
    //             'password' => 'required',
    //             'phone' => 'required|string',
    //             'nik' => 'required|string',
    //             'level_id' => 'required'
    //         ]);
                   
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'succcess'  =>  false,
    //                 'message'   =>  'Semua Kolom wajib diisi',
    //                 'data'      =>  $validator->errors()
    //             ], 401);
    //         } else {
    //             $User->name =$request->input('name');
    //             $user->email = $request->input('email');
    //             $user->phone = $request->input('phone');
    //             $user->nik = $request->input('nik');
    //             $user->level_id = $request->input('level_id');
    //             $user->password = app('hash')->make($request->input('password'));
    
    //             $User->update();
    
    //             if ($User) {
    //                 return response()->json([
    //                     'succcess'  => true,
    //                     'message'   =>  'User berhasil diperbaharui',
    //                     'data'      => $User
    //                 ], 201);
    //             } else {
    //                 return response()->json([
    //                     'succcess'  => false,
    //                     'message'   =>  'User gagal diperbaharui',
    //                 ], 400);
    //             }
    //         }
    //     } else {
    //         return response()->json([
    //             'succcess'  => false,
    //             'message'   =>  'User tidak ditemukan',
    //         ], 404);
    //     }
    // }

    public function destroy($id)
    {
        $User = User::find($id);
        $User->delete();
        if ($User) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ], 200);
        }
    }
}