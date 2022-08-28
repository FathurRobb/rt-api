<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $Faq = Faq::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $Faq->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $Faq->offset($request->get('length'));
            }
            return $Faq->get();
        } else {
            $Faq = Faq::find($id);
            if ($Faq) {
                return $Faq;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'FAQ tidak ditemukan',
                ], 404);
            }
        }
    }

    public function store(Request $request)
    {
       $Faq = new Faq;
      
       $validator = Validator::make($request->all(), [
            'name'            => 'required',
            'description'     => 'required'
       ]);
       
       if ($validator->fails()) {
            return response()->json([
                'succcess'  =>  false,
                'message'   =>  'Semua Kolom wajib diisi',
                'data'      =>  $validator->errors()
            ], 401);
       } else {
            $Faq->name=$request->input('name');
            $Faq->description=$request->input('description');

            $Faq->save();

            if ($Faq) {
                return response()->json([
                    'succcess'  => true,
                    'message'   =>  'FAQ berhasil disimpan',
                    'data'      => $Faq
                ], 201);
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'FAQ gagal disimpan',
                ], 400);
            }
       }
    }

    public function update(Request $request, $id)
    {
        
        $Faq = Faq::find($id);
        if ($Faq) {
            $validator = Validator::make($request->all(), [
                'name'            => 'required',
                'description'     => 'required'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'succcess'  =>  false,
                    'message'   =>  'Semua Kolom wajib diisi',
                    'data'      =>  $validator->errors()
                ], 401);
            } else {
                $Faq->name=$request->input('name');
                $Faq->description=$request->input('description');
    
                $Faq->update();
    
                if ($Faq) {
                    return response()->json([
                        'succcess'  => true,
                        'message'   =>  'FAQ berhasil diperbaharui',
                        'data'      => $Faq
                    ], 201);
                } else {
                    return response()->json([
                        'succcess'  => false,
                        'message'   =>  'FAQ gagal diperbaharui',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'succcess'  => false,
                'message'   =>  'FAQ tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $Faq = Faq::find($id);
        $Faq->delete();
        if ($Faq) {
            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil dihapus'
            ], 200);
        }
    }
}