<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $Information = Information::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $Information->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $Information->offset($request->get('length'));
            }
            return $Information->get();
        } else {
            $Information = Information::find($id);
            if ($Information) {
                return $Information;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Information tidak ditemukan',
                ], 404);
            }
        }
    }

    public function store(Request $request)
    {
       $Information = new Information;
      
       $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'description'   => 'required',
            'file'          => 'required',
            'type'          => 'required'
       ]);
       
       if ($validator->fails()) {
            return response()->json([
                'succcess'  =>  false,
                'message'   =>  'Semua Kolom wajib diisi',
                'data'      =>  $validator->errors()
            ], 401);
       } else {
            $Information->name=$request->input('name');
            $Information->description=$request->input('description');
            if ($request->hasFile('file')) {
                $allowedfileExtension=['jpg','png','gif','pdf'];
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                $host = $request->getHttpHost();
    
                if ($check) {
                    $name = time() . $file->getClientOriginalName();
                    $file->move(storage_path('upload/Information', $name));
                    $link_name = "$host/upload/Information/$name";
                    $Information->file = $link_name;
                }
            }
            $Information->type=$request->input('type');

            $Information->save();

            if ($Information) {
                return response()->json([
                    'succcess'  => true,
                    'message'   =>  'Information berhasil disimpan',
                    'data'      => $Information
                ], 201);
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Information gagal disimpan',
                ], 400);
            }
       }
    }

    public function update(Request $request, $id)
    {
        
        $Information = Information::find($id);
        if ($Information) {
            $validator = Validator::make($request->all(), [
                'name'          => 'required',
                'description'   => 'required',
                'file'          => 'required',
                'type'          => 'required'
           ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'succcess'  =>  false,
                    'message'   =>  'Semua Kolom wajib diisi',
                    'data'      =>  $validator->errors()
                ], 401);
            } else {
                $Information->name=$request->input('name');
                $Information->description=$request->input('description');
                if ($request->hasFile('file')) {
                    $allowedfileExtension=['jpg','png','gif','pdf'];
                    $file = $request->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    $host = $request->getHttpHost();
        
                    if ($check) {
                        $name = time() . $file->getClientOriginalName();
                        $file->move(storage_path('upload/Information', $name));
                        $link_name = "$host/upload/Information/$name";
                        $Information->file = $link_name;
                    }
                }
                $Information->type=$request->input('type');
    
                $Information->update();
    
                if ($Information) {
                    return response()->json([
                        'succcess'  => true,
                        'message'   =>  'Information berhasil diperbaharui',
                        'data'      => $Information
                    ], 201);
                } else {
                    return response()->json([
                        'succcess'  => false,
                        'message'   =>  'Information gagal diperbaharui',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'succcess'  => false,
                'message'   =>  'Information tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $Information = Information::find($id);
        $Information->delete();
        if ($Information) {
            return response()->json([
                'success' => true,
                'message' => 'Information berhasil dihapus'
            ], 200);
        }
    }
}