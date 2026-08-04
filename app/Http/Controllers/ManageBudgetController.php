<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\budget\Action;
use App\Models\budget\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManageBudgetController extends Controller
{
    public function index()
    {
        return view('pages.apps.setting.manageBudget.index');
    }

    public function show($test, $id)
    {

        return view('pages.apps.setting.manageBudget.show', [
            'id' => $id,
        ]);
    }

    public function managepage()
    {

        return view('pages/setting/manageBudget/managepage');
    }

    public function table_budget_getdata(Request $request)
    {
        $Budget = Budget::select(
            'id',
            'tb_budget.title',
            'tb_budget.date',
        );
        if ($request->search_name != 0) {
            if (!empty($request->search_name)) {
                $Budget->where('tb_budget.title', 'LIKE', '%' . $request->search_name . '%');
            }
        }
        if ($request->search_date != 0) {
            if (!empty($request->search_date)) {
                $Budget->where('tb_budget.date', $request->search_date);
            }
        }
        $Budget = $Budget->orderby('created', 'asc')->get();
        if (count($Budget) > 0) {
            for ($i = 0; $i < count($Budget); $i++) {
                $title = $Budget[$i]->title;
                $date = date('Y-m-d', strtotime($Budget[$i]->date));
                $button = '';
                if (Auth::user()->can('edit set budget')) {
                    $button = '<a href="manageBudget/' . $Budget[$i]->id . '"  type="button">
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>
                                </a>';
                }

                $data[] = array(
                    "no" =>  $i + 1,
                    "title" => $title,
                    "year" => $date,
                    "button" =>  $button,
                );
            }
            $result = [
                'recordsTotal'    => count($Budget),
                'recordsFiltered' => count($Budget),
                'data' => $data,
            ];
            echo json_encode($result);
        } else {
            $data[] = array(
                "no" =>  '-',
                "title" => 'ไม่พบข้อมูล',
                "year" => '-',
                "button" =>  '-',
            );
            $result = [
                'recordsTotal'    => count($Budget),
                'recordsFiltered' => count($Budget),
                'data'            => $data,
            ];
            echo json_encode($result);
        }
    }

    public function table_budget_rate_getdata(Request $request, $test, $id)
    {
        $action = Action::where('budget_id', $id)->get();
        if (count($action) == 0) {
            $data[] = array(
                "id" => '',
                "no" =>  '',
                "grade_name" => 'ไม่พบข้อมูล',
                "budget_range_start" => '',
                "budget_range_end" => '',
                "std" => '',
                "button" =>  ''
            );
        } else {
            for ($i = 0; $i < count($action); $i++) {
                $grade_name = $action[$i]->grade_name;
                $budget_range_start = $action[$i]->budget_range_start;
                $budget_range_end = $action[$i]->budget_range_end;
                $std = $action[$i]->std;
                $data[] = array(
                    "id" => $action[$i]->id,
                    "no" =>  $i + 1,
                    "grade_name" => $grade_name,
                    "budget_range_start" => $budget_range_start.' - '.$budget_range_end,
                    "budget_range_end" => $budget_range_end,
                    "std" => $std,
                    "button" =>  ''
                );
            }
        }

        $result = [
            'recordsTotal'    => count($action),
            'recordsFiltered' => count($action),
            'data'            => $data,
        ];
        echo json_encode($result);
    }

    public function add_action(Request $request)
    {
        try {

            $date = date('Y-m-d');
            $year = date('Y');
            $Budget = Budget::where('year', $year)->get();

            if (count($Budget) > 0) {
                DB::rollback();
                $status = 409;
                $message = "มีข้อมูลของปีนี้แล้ว";
            } else {
                $data = new Budget();
                $data->title = $request->title;
                $data->date = $date;
                $data->year = $year;
                $data->save();
                if ($data->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }
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

    public function fetch_config($test, $id)
    {
        $action = Action::find($id);
        return $action;
    }
    public function addedit_action(Request $request)
    {
        try {
            if ($request->id_action > 0) {
                $action = Action::find($request->id_action);
                $action->grade_name = $request->grade_name;
                $action->budget_range_start = $request->budget_range_start;
                $action->budget_range_end = $request->budget_range_end;
                $action->std = $request->std;
                $action->save();
                if ($action->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            } else {
                $action = new Action();
                $action->budget_id = $request->edit_id_budget;
                $action->grade_name = $request->grade_name;
                $action->budget_range_start = $request->budget_range_start;
                $action->budget_range_end = $request->budget_range_end;
                $action->std = $request->std;
                $action->save();
                if ($action->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }

        // if (date('Y-m') <= (date('Y') . '-2')) {
        //     $previousYear = date('Y', strtotime('-1 year'));
        // } else {
            $previousYear = date('Y');
        // }
        DB::table('tb_employee_final_score')
            ->where('tb_employee_final_score.rec_year', 'like', '%' . $previousYear . '%')
            ->where('tb_employee_final_score.status_pa', '5')
            ->update([
                "status_pa" => '6'
            ]);
       
        $checkYearABC = date('Y');
        $countABC = DB::table('tb_budget_action')
        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
        ->where('tb_budget.year','like','%'.$checkYearABC.'%')
        ->whereNull('tb_budget_action.std')
        ->where('tb_budget_action.grade_name','!=','U')
        ->where('tb_budget_action.grade_name','!=','CD')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 5 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
