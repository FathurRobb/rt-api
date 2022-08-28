<?php

namespace App\Http\Controllers;

use App\Models\PatroliSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatroliScheduleController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null) {
            $PatroliSchedule = PatroliSchedule::orderBy('id', $request->has('order') != null ? $request->get('order') : 'asc');
            if ($request->has('start')) {
                $PatroliSchedule->offset($request->get('start'));
            }
            if ($request->has('length')) {
                $PatroliSchedule->offset($request->get('length'));
            }
            return $PatroliSchedule->get();
        } else {
            $PatroliSchedule = PatroliSchedule::find($id);
            if ($PatroliSchedule) {
                return $PatroliSchedule;
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Jadwal Patroli tidak ditemukan',
                ], 404);
            }
        }
    }

    public function store(Request $request)
    {
       $PatroliSchedule = new PatroliSchedule;
      
       $validator = Validator::make($request->all(), [
            'start_date'  => 'required',
            'context'     => 'required'
       ]);
       
       if ($validator->fails()) {
            return response()->json([
                'succcess'  =>  false,
                'message'   =>  'Semua Kolom wajib diisi',
                'data'      =>  $validator->errors()
            ], 401);
       } else {
            $PatroliSchedule->start_date=$request->input('start_date');
            $PatroliSchedule->context=$request->input('context');

            $PatroliSchedule->save();

            if ($PatroliSchedule) {
                return response()->json([
                    'succcess'  => true,
                    'message'   =>  'Jadwal Patroli berhasil disimpan',
                    'data'      => $PatroliSchedule
                ], 201);
            } else {
                return response()->json([
                    'succcess'  => false,
                    'message'   =>  'Jadwal Patroli gagal disimpan',
                ], 400);
            }
       }
    }

    public function update(Request $request, $id)
    {
        
        $PatroliSchedule = PatroliSchedule::find($id);
        if ($PatroliSchedule) {
            $validator = Validator::make($request->all(), [
                'start_date'  => 'required',
                'context'     => 'required'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'succcess'  =>  false,
                    'message'   =>  'Semua Kolom wajib diisi',
                    'data'      =>  $validator->errors()
                ], 401);
            } else {
                $PatroliSchedule->start_date=$request->input('start_date');
                $PatroliSchedule->context=$request->input('context');
    
                $PatroliSchedule->update();
    
                if ($PatroliSchedule) {
                    return response()->json([
                        'succcess'  => true,
                        'message'   =>  'Jadwal Patroli berhasil diperbaharui',
                        'data'      => $PatroliSchedule
                    ], 201);
                } else {
                    return response()->json([
                        'succcess'  => false,
                        'message'   =>  'Jadwal Patroli gagal diperbaharui',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'succcess'  => false,
                'message'   =>  'Jadwal Patroli tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $PatroliSchedule = PatroliSchedule::find($id);
        $PatroliSchedule->delete();
        if ($PatroliSchedule) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal Patroli berhasil dihapus'
            ], 200);
        }
    }
}