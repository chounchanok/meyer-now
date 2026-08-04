<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\GradeAction;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ManageGradeController extends Controller
{
    public function index()
    {
        return view('pages.apps.setting.manageGrade.index');
    }
    
    public function show(Request $request, $test,$id)
    {
        
        return view('pages.apps.setting.manageGrade.show',[
            'id'=>$id,
        ]);
    }

    public function managepage_grade()
    {   
        return view('pages/setting/manageGrade/managepage');
    }

    public function table_allgrade_getdata(Request $request)
    {
        $Grade = Grade::select('id',
            'tb_grade.title',
            'tb_grade.date',
            'tb_grade.active'
        );
        if($request->search_name != 0){
            if(!empty($request->search_name)){
                $Grade->where('tb_grade.title', 'LIKE' ,'%'.$request->search_name.'%');
            }
        }  
        if($request->search_date != 0){
            if(!empty($request->search_date)){
                $Grade->where('tb_grade.date', $request->search_date);
            }
        }  
        $Grade = $Grade->orderby('created', 'asc')->get();
        if (count($Grade)>0) {
            for ($i = 0; $i < count($Grade); $i++) {
                $title = $Grade[$i]->title;
                $date = date('Y-m-d', strtotime($Grade[$i]->date));
                if (Auth::user()->can('edit set budget')) {
                $button = '<a href="manageGrade/'.$Grade[$i]->id.'/show">
                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="ki-solid ki-pencil fs-5"></i>
                                </button>
                            </a>';
                }
                // if($Grade[$i]->active == '1'){
                //     $status_active = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$Grade[$i]->id.'" onchange="change_active(this,'.$Grade[$i]->id.');" value="'.$Grade[$i]->id.'" data-id="'.$Grade[$i]->id.'" checked>';
                // }else{
                //     $status_active = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$Grade[$i]->id.'" onchange="change_active(this,'.$Grade[$i]->id.');" value="'.$Grade[$i]->id.'" data-id="'.$Grade[$i]->id.'">';
                // }
                // "status_active" => '<div class="form-check form-switch">'.$status_active.'</div>',
                $data[] = array(
                    "no" =>  $i + 1,
                    "title" => $title,
                    "year" => $date,
                    "button" =>  $button,
                );
            }
            $result = [
                'recordsTotal'    => count($Grade),
                'recordsFiltered' => count($Grade),
                'data'            => $data ,
            ];
            echo json_encode($result);
        }
        else{
            // "status_active" => '',
            $data[] = array(
                "no" =>  '-',
                "title" => 'ไม่พบข้อมูล',
                "year" => '-',
                "button" =>  '-',
            );
            $result = [
                'recordsTotal'    => count($Grade),
                'recordsFiltered' => count($Grade),
                'data'            => $data ,
            ];
            echo json_encode($result);
        }
    }

    public function table_grade_getdata(Request $request,$test,$id)
    {
        $action = GradeAction::where('grade_id',$id)->get();
        if(count($action) == 0){
            $data[] = array(
                "id" => '',
                "no" =>  '',
                "grade_name" => 'ไม่พบข้อมูล',
                "percent" => '',
                "status" => '',
                "button" =>  ''
            );
        }else{
            for ($i = 0; $i < count($action); $i++) {
                $grade_name = $action[$i]->grade_name;
                $percent = $action[$i]->percent;

                $check = '';
                $checkActive = 'InActive';
                $checkbgcolor = 'background-color: #FFF5F8;';
                $checkcolor = 'color: #F1416C;';
                if($action[$i]->status==1){
                    $check = 'checked="checked"';
                    $checkActive = 'Active';
                    $checkbgcolor = 'background-color: #E8FFF3;';
                    $checkcolor = 'color: #50CD89;';
                }

                $data[] = array(
                    "id" => $action[$i]->id,
                    "no" =>  $i+1,
                    "grade_name" => $grade_name,
                    "percent" => $percent,
                    "status" => '<div style="display: flex;align-items: center;justify-content: center;">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
                                        <input class="form-check-input h-30px w-50px" type="checkbox" value="1" id="flexSwitchDefault'.$action[$i]->id.'" '.$check.'  onchange="changeactive('.$action[$i]->id.');"/>
                                    </div>
                                    <div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;'.$checkbgcolor.'">
                                        <span style="'.$checkcolor.'">'.$checkActive.'</span>
                                    </div>
                                </div>',
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
            $grade = Grade::where('year',$year)->get();

            if (count($grade) > 0) {
                DB::rollback();
                $status = 409;
                $message = "มีข้อมูลของปีนี้แล้ว";
            } else {
                $data = new Grade();
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

    public function fetch_config($test,$id)
    {
        $action = GradeAction::find($id);
        return $action;
    }
    public function addedit_action(Request $request)
    {
        try {
            if($request->id_action > 0){
                $action = GradeAction::find($request->id_action);
                $action->grade_name = $request->grade_name;
                $action->percent = $request->percent;
                $action->save();
                if ($action->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }else{
                $action = new GradeAction();
                $action->grade_id = $request->edit_id_grade;
                $action->grade_name = $request->grade_name;
                $action->percent = $request->percent;
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
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    
    public function grade_change_active(Request $request)
    {
        $id             = $request->input('id');
        $status_active             = $request->input('status_active');
        DB::table('tb_grade')->where('id', $id )->update([
            'active' => $status_active
        ]);
        $result = [
            'status'                => 200
        ];
        echo json_encode($result); 
    }

    public function grade_changeactive(Request $request)
    {
        $id = DB::table('tb_grade_action')
        ->where('id', $request->input('id') )
        ->update(['status' => $request->input('status')]);

        // DB::table('evaluation_criteria')->where('id', $request->input('id'))->delete();
        // $id = DB::table('evaluation_criteria')->where('id', $request->input('id') )
        // ->update([
        //     'criteria_active' => '0'
        // ]);
        $data = array(
            "status" =>  200
        );
        echo json_encode($data); 
    }
}
