<?php

namespace App\Http\Controllers;

use App\Models\LetterSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterSubmissionController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $LetterSubmission = LetterSubmission::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $LetterSubmission->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $LetterSubmission->offset($request->get('length'));
            }
            return $LetterSubmission->get();
        } else {
            $LetterSubmission = LetterSubmission::find($id);
            if ($LetterSubmission) {
                return $LetterSubmission;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Surat tidak ditemukan',
                ], 404);
            }
        }
    }

    public function store(Request $request)
    {
       $LetterSubmission = new LetterSubmission;
      
       $validator = Validator::make($request->all(), [
            'type_id'           =>  'required',
            'user_id'           =>  'required',
            'name'              =>  'required',
            'date_of_birth'     =>  'required',
            'place_of_birth'    =>  'required',
            'religion'          =>  'required',
            'gender'            =>  'required',
            'address'           =>  'required',
            'response'          =>  'required',
       ]);
       
       if ($validator->fails()) {
            return response()->json([
                'succcess'  =>  false,
                'message'   =>  'Semua Kolom wajib diisi',
                'data'      =>  $validator->errors()
            ], 401);
       } else {
            $LetterSubmission->type_id=$request->input('type_id');
            $LetterSubmission->user_id=$request->input('user_id');
            $LetterSubmission->name=$request->input('name');
            $LetterSubmission->date_of_birth=$request->input('date_of_birth');
            $LetterSubmission->place_of_birth=$request->input('place_of_birth');
            $LetterSubmission->religion=$request->input('religion');
            $LetterSubmission->gender=$request->input('gender');
            $LetterSubmission->address=$request->input('address');
            $LetterSubmission->response=$request->input('response');

            $LetterSubmission->save();

            if ($LetterSubmission) {
                return response()->json([
                    'succcess'  => true,
                    'message'   =>  'Surat berhasil disimpan',
                    'data'      => $LetterSubmission
                ], 201);
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Surat gagal disimpan',
                ], 400);
            }
       }
    }

    public function update(Request $request, $id)
    {
        
        $LetterSubmission = LetterSubmission::find($id);
        if ($LetterSubmission) {
            $validator = Validator::make($request->all(), [
                'type_id'           =>  'required',
                'user_id'           =>  'required',
                'name'              =>  'required',
                'date_of_birth'     =>  'required',
                'place_of_birth'    =>  'required',
                'religion'          =>  'required',
                'gender'            =>  'required',
                'address'           =>  'required',
                'response'          =>  'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'succcess'  =>  false,
                    'message'   =>  'Semua Kolom wajib diisi',
                    'data'      =>  $validator->errors()
                ], 401);
            } else {
                $LetterSubmission->type_id=$request->input('type_id');
                $LetterSubmission->user_id=$request->input('user_id');
                $LetterSubmission->name=$request->input('name');
                $LetterSubmission->date_of_birth=$request->input('date_of_birth');
                $LetterSubmission->place_of_birth=$request->input('place_of_birth');
                $LetterSubmission->religion=$request->input('religion');
                $LetterSubmission->gender=$request->input('gender');
                $LetterSubmission->address=$request->input('address');
                $LetterSubmission->response=$request->input('response');
    
                $LetterSubmission->update();
    
                if ($LetterSubmission) {
                    return response()->json([
                        'succcess'  => true,
                        'message'   =>  'Surat berhasil diperbaharui',
                        'data'      => $LetterSubmission
                    ], 201);
                } else {
                    return response()->json([
                        'succcess'  => false,
                        'message'   =>  'Surat gagal diperbaharui',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'succcess'  => false,
                'message'   =>  'Surat tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $LetterSubmission = LetterSubmission::find($id);
        $LetterSubmission->delete();
        if ($LetterSubmission) {
            return response()->json([
                'success' => true,
                'message' => 'Surat berhasil dihapus'
            ], 200);
        }
    }
}