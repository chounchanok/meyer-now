<?php

namespace App\Http\Controllers;

use App\Models\pa\Action;
use App\Models\pa\Patimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.formEvaluate.criteria.index');
    }
    public function add_list(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = new Patimeline;
            $data->title = $request->name;
            $data->date = $request->nick_name;
            $data->save();
            if (!$data->save()) {
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'message' => "บันทึกไม่สำเร็จ",
                ]);
            }
            DB::commit();
            $status = 200;
            $message = "บันทึกสำเร็จ";
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function edit_action(Request $request,$test,$id){
        try {
            DB::beginTransaction();
            $data = new Action();
            $data->title = $request->name;
            $data->date = $request->nick_name;
            $data->save();
            if (!$data->save()) {
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'message' => "บันทึกไม่สำเร็จ",
                ]);
            }
            DB::commit();
            $status = 200;
            $message = "บันทึกสำเร็จ";
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}

