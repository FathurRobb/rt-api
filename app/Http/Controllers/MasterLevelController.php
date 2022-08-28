<?php

namespace App\Http\Controllers;

use App\Models\MasterLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterLevelController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $Level = MasterLevel::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $Level->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $Level->offset($request->get('length'));
            }
            return $Level->get();
        } else {
            $Level = MasterLevel::find($id);
            if ($Level) {
                return $Level;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Level tidak ditemukan',
                ], 404);
            }
        }
    }

    public function store(Request $request)
    {
       $Level = new MasterLevel;
      
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
            $Level->name =$request->input('name');

            $Level->save();

            if ($Level) {
                return response()->json([
                    'succcess'  => true,
                    'message'   =>  'Level berhasil disimpan',
                    'data'      => $Level
                ], 201);
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Level gagal disimpan',
                ], 400);
            }
       }
    }

    public function update(Request $request, $id)
    {
        
        $Level = MasterLevel::find($id);
        if ($Level) {
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
                $Level->name =$request->input('name');
    
                $Level->update();
    
                if ($Level) {
                    return response()->json([
                        'succcess'  => true,
                        'message'   =>  'Level berhasil diperbaharui',
                        'data'      => $Level
                    ], 201);
                } else {
                    return response()->json([
                        'succcess'  => false,
                        'message'   =>  'Level gagal diperbaharui',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'succcess'  => false,
                'message'   =>  'Level tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $Level = MasterLevel::find($id);
        $Level->delete();
        if ($Level) {
            return response()->json([
                'success' => true,
                'message' => 'Level berhasil dihapus'
            ], 200);
        }
    }
}