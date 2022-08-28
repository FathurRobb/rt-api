<?php

namespace App\Http\Controllers;

use App\Models\TypeLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeLetterController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $TypeLetter = TypeLetter::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $TypeLetter->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $TypeLetter->offset($request->get('length'));
            }
            return $TypeLetter->get();
        } else {
            $TypeLetter = TypeLetter::find($id);
            if ($TypeLetter) {
                return $TypeLetter;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Tipe Surat tidak ditemukan',
                ], 404);
            }
        }
    }

    public function store(Request $request)
    {
       $TypeLetter = new TypeLetter;
      
       $validator = Validator::make($request->all(), [
            'name'  => 'required',
       ]);
       
       if ($validator->fails()) {
            return response()->json([
                'succcess'  =>  false,
                'message'   =>  'Semua Kolom wajib diisi',
                'data'      =>  $validator->errors()
            ], 401);
       } else {
            $TypeLetter->name =$request->input('name');

            $TypeLetter->save();

            if ($TypeLetter) {
                return response()->json([
                    'succcess'  => true,
                    'message'   =>  'Tipe Surat berhasil disimpan',
                    'data'      => $TypeLetter
                ], 201);
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Tipe Surat gagal disimpan',
                ], 400);
            }
       }
    }

    public function update(Request $request, $id)
    {
        
        $TypeLetter = TypeLetter::find($id);
        if ($TypeLetter) {
            $validator = Validator::make($request->all(), [
                'name'  => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'succcess'  =>  false,
                    'message'   =>  'Semua Kolom wajib diisi',
                    'data'      =>  $validator->errors()
                ], 401);
            } else {
                $TypeLetter->name =$request->input('name');
    
                $TypeLetter->update();
    
                if ($TypeLetter) {
                    return response()->json([
                        'succcess'  => true,
                        'message'   =>  'Tipe Surat berhasil diperbaharui',
                        'data'      => $TypeLetter
                    ], 201);
                } else {
                    return response()->json([
                        'succcess'  => false,
                        'message'   =>  'Tipe Surat gagal diperbaharui',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'succcess'  => false,
                'message'   =>  'Tipe Surat tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $TypeLetter = TypeLetter::find($id);
        $TypeLetter->delete();
        if ($TypeLetter) {
            return response()->json([
                'success' => true,
                'message' => 'Tipe Surat berhasil dihapus'
            ], 200);
        }
    }
}