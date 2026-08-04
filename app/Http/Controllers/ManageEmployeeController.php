<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeModel;
use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Grademaster;

use App\Models\manage\ManageEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManageEmployeeController extends Controller
{
    public function index()
    {
        return view('pages.setting.manageEmployee.index',[
            'manage' => ManageEmployee::orderby('created','asc')->get(),
        ]);
    }

    public function managepage_employee($test,$id)
    {
        return view('pages/setting/manageEmployee/managepage',[
            'manage' => ManageEmployee::where('year',$id)->first(),
            'department' => Department::get(),
            'division' => Division::get(),
            'position' => Position::get(),
            'section' => Section::get(),
            'grade' => Grademaster::get()
        ]);
    }

    public function table_allemployee_getdata(Request $request)
    {
        $like = $request->Like;
        $manage = ManageEmployee::when($like, function ($query) use ($like) {
            if (@$like['id'] != "") {
                $query->where('id', @$like['id']);
            }
        })->orderby('created', 'asc')->get();
        if (count($manage) > 0) {
            for ($i = 0; $i < count($manage); $i++) {
                $checkbox = '<input type="checkbox" value="'.$manage[$i]->id.'">';
                $button = '<a href="manageEmployee/managepage/'.$manage[$i]->year.'"   type="button">
                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="ki-solid ki-pencil fs-5"></i>
                                </button>
                            </a>';

                $data[] = array(
                    "checkbox" =>  $checkbox,
                    "no" =>  $i+1,
                    "title" =>  $manage[$i]->name,
                    "date" =>  date('Y-m-d',strtotime($manage[$i]->date)),
                    "button" =>  $button,
                );
            }

            $result = [
                'recordsTotal'    => 1,
                'recordsFiltered' => 1,
                'data'            => $data,
            ];
            echo json_encode($result);
        } else {
                $checkbox = '<input type="checkbox">';
                $data = [];


            $result = [
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => $data,
            ];
            echo json_encode($result);
        }
    }

    public function table_employee_getdata(Request $request,$test,$id)
    {
        // ****** ใช้ในกรณัี Query จาก Database ******
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee.id';

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }

        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        $lastimport = DB::table('tb_import_employee')->orderBy('id_file', 'desc')->first();

        $gatall = EmployeeModel::select('tb_employee.*',
            'tb_position.position_description',
            'tb_employee.employee_local_name_en',
            'tb_employee_final_score.status_evaluation'
        )
        ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->Where('tb_employee_final_score.rec_year','like','%'.$id.'%');

        $count_data = EmployeeModel::select('tb_employee.id')
        ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->Where('tb_employee_final_score.rec_year','like','%'.$id.'%');

        if(@$like['searchText'] != ""){
            $searchText = @$like['searchText'];
            $gatall->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
            });
            $count_data->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
            });
        }
        if($like['search_position'] != "all"){
            $gatall->where('tb_employee.position_code', 'like','%'.$like['search_position'].'%');
            $count_data->where('tb_employee.position_code', 'like','%'.$like['search_position'].'%');
        }
        if($like['search_division'] != "all"){
            $gatall->where('tb_employee.division_code', 'like','%'.$like['search_division'].'%');
            $count_data->where('tb_employee.division_code', 'like','%'.$like['search_division'].'%');
        }
        if($like['search_department'] != "all"){
            $gatall->where('tb_employee.department_code', 'like','%'.$like['search_department'].'%');
            $count_data->where('tb_employee.department_code', 'like','%'.$like['search_department'].'%');
        }
        if($like['search_section'] != "all"){
            $gatall->where('tb_employee.section_code', 'like','%'.$like['search_section'].'%');
            $count_data->where('tb_employee.section_code', 'like','%'.$like['search_section'].'%');
        }
        if($like['search_grade'] != "all"){
            $gatall->where('tb_employee.grade_code', 'like','%'.$like['search_grade'].'%');
            $count_data->where('tb_employee.grade_code', 'like','%'.$like['search_grade'].'%');
        }

        if(!empty($search)){
            $gatall->where(function ($query) use($search) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
                $query->orWhere('tb_position.position_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
                $query->orWhere('tb_position.position_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
            });
        }

        if(empty($field)){
            $fieldby = 'tb_employee.orisoft_no';
        }
        else{
            if($field == 2){
                $fieldby = 'tb_employee.orisoft_no';
            }else if($field == 3){
                $fieldby = 'tb_employee.employee_name';
            }else if($field == 4){
                $fieldby = 'tb_position.position_description';
            }else if($field == 5){
                $fieldby = 'tb_employee.division_code';
            }else if($field == 6){
                $fieldby = 'tb_employee.department_code';
            }
        }

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }
        $gatall->orderBy($fieldby,$order);
        $gatall = $gatall->skip($start)->take($length)->get();

        $count_data = $count_data->orderBy('tb_employee.created_at', 'DESC')->count();

        if(count($gatall)>0){
            foreach ($gatall as $value) {
                $employee_status_description = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->employee_status_description == 'Resigned'){
                    $employee_status_description = '<span class="set_status'.$value->id.' badge badge-light-danger">Resigned</span>';
                }else if($value->employee_status_description == 'Transferred'){
                    $employee_status_description = '<span class="set_status'.$value->id.' badge badge-light-warning">Transferred</span>';
                }else{
                    if($value->employee_status_description){
                        if($value->employee_status_description == 'Passed'){
                            $employee_status_description = '<span class="set_status'.$value->id.' badge badge-light-success">Passed</span>';
                        }
                    }
                }

                // if($value->employee_status_description == 'Active'){
                //     $employee_status_description = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$PercentDepartment[$i]->id.'" onchange="change_active(this,'.$PercentDepartment[$i]->id.');" value="'.$PercentDepartment[$i]->id.'" data-id="'.$PercentDepartment[$i]->id.'" checked>';
                // }else{
                //     $employee_status_description = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$PercentDepartment[$i]->id.'" onchange="change_active(this,'.$PercentDepartment[$i]->id.');" value="'.$PercentDepartment[$i]->id.'" data-id="'.$PercentDepartment[$i]->id.'">';
                // }
                $checkbox = '<input type="checkbox">';
                $data[] = array(
                    "checkbox" =>  $checkbox,
                    "no" =>  $pagestart,
                    "code" =>  $value->orisoft_no,
                    "name" =>  $value->employee_local_name_en,
                    "position" =>  $value->position_description,
                    "div" =>  $value->division_code,
                    "dept" =>  $value->department_code,
                    "sec" =>  $value->section_code,
                    "grade" =>  $value->grade_code,
                    "status" =>  $employee_status_description,
                    "edit" =>  $value->id,
                    "employee_status_description" =>  $value->employee_status_description,
                    "fieldby" =>  $fieldby,
                    "orderby" =>  $order,
                );
                $pagestart++;
            }
        }else{
            $data = [];
        }

        $totalRecords = $totalDisplay = $count_data;
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $data,
        ];
        echo json_encode($result);

        // ****** ใช้ในกรณัี Mockup data ******
        // $html = '<img src="logos/Meyer-Logo_web-full.png">';
        // $like = $request->Like;
        // $employee = EmployeeModel::
        // when($like, function ($query) use ($like) {
        //     if (@$like['position'] != "all") {
        //         $query->where('position_code', @$like['position']);
        //     }
        //     if (@$like['department'] != "all") {
        //         $query->where('department_code', @$like['department']);
        //     }
        //     if (@$like['division'] != "all") {
        //         $query->where('division_code', @$like['division']);
        //     }
        //     if (@$like['searchText'] != "") {
        //         $query->where('orisoft_no', 'like', '%' . @$like['searchText'] . '%');
        //     }
        // })->with('position','department','division','employeelog')->whereYear('created_at',$id)->orderby('created_at', 'asc')->get();

        // if (count($employee) > 0 ) {
        //     for ($i = 0 ; $i < count($employee); $i++) {
        //         $checkbox = '<input type="checkbox" >';
        //         $data[] = array(
        //             "checkbox" =>  $checkbox,
        //             "no" =>  $i+1,
        //             "code" =>  $employee[$i]->orisoft_no,
        //             "name" =>  $employee[$i]->employeelog->EMPLOYEE_LOCAL_NAME,
        //             "position" =>  $employee[$i]->position->position_description,
        //             "div" =>  $employee[$i]->division->division_code,
        //             "dept" =>  $employee[$i]->department->department_code,
        //             "sec" =>  'Sect01',
        //             "status" =>  '',
        //             "edit" =>  '<button onclick="fetchEmployee('.$employee[$i]->id.')"> แก้ไข </button>'
        //         );
        //     }

        //     $result = [
        //         'recordsTotal'    => 1,
        //         'recordsFiltered' => 1,
        //         'data'            => $data,
        //     ];
        //     echo json_encode($result);
        // }
        // else{

        //         $checkbox = '<input type="checkbox">';
        //         $data[] = array(
        //             "checkbox" =>  '-',
        //             "no" =>  '-',
        //             "code" =>  '-',
        //             "name" =>  '-',
        //             "position" =>  '-',
        //             "div" =>  '-',
        //             "dept" =>  '-',
        //             "sec" =>  '-',
        //             "status" =>  '',
        //             "edit" =>  '',
        //         );

        //     $result = [
        //         'recordsTotal'    => 1,
        //         'recordsFiltered' => 1,
        //         'data'            => $data,
        //     ];
        //     echo json_encode($result);
        // }

    }
    public function add_manage(Request $request)
    {
        try {
            // if(date('Y-m') <= (date('Y').'-2')){
            //     $year = date('Y', strtotime('-1 year'));
            // }else{
                $year = date('Y');
            // }
            $date = date('Y-m-d');
            // $year = date('Y');
            $timeline = ManageEmployee::where('year', $year)->get();
            if (count($timeline) > 0) {
                DB::rollback();
                $status = 409;
                $message = "ปีนี้มีรายชื่อพนักงานอยู่แล้ว";
            } else {
                $data = new ManageEmployee();
                $data->name = $request->name;
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
    function fetch_employee($test,$id){
        // $employee = EmployeeModel::find($id);
        $employee = EmployeeModel::where('id',$id)->first();

        $employee->division_code_transferred_description = '';
        $employee->department_code_transferred_description = '';
        $employee->section_code_transferred_description = '';
        if($employee->division_code_transferred){
            $get_division = Division::where('division_code', $employee->division_code_transferred)->first();
            $employee->division_code_transferred_description = $get_division->division_description;
        }
        if($employee->department_code_transferred){
            $get_department = Department::where('department_code', $employee->department_code_transferred)->first();
            $employee->department_code_transferred_description = $get_department->department_description;
        }
        if($employee->section_code_transferred){
            $get_section = Section::where('section_code', $employee->section_code_transferred)->first();
            $employee->section_code_transferred_description = $get_section->section_description;
        }
        return $employee;
    }
    function edit_employee(Request $request,$test,$id){
        try {

            $get_division = Division::where('division_code', $request->division)->first();
            $get_department = Department::where('department_code', $request->department)->first();
            $get_section = Section::where('section_code', $request->section)->first();

            DB::table('tb_employee')->where('id', $id)
            ->update([
                'employee_status_description' => 'Passed',
                "division_code_transferred" => NULL,
                "department_code_transferred" => NULL,
                "section_code_transferred" => NULL,
                "transferred_effective_date" => NULL
            ]);

            $data = EmployeeModel::find($id);
            $data->division_code = $request->division;
            $data->division_description = $get_division->division_description;
            $data->department_code = $request->department;
            $data->department_description = $get_department->department_description;
            $data->section_code = $request->section;
            $data->section_description = $get_section->section_description;
                if ($data->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
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

    public function resignEmployee(Request $request)
    {
        $id             = $request->input('id');

        DB::table('tb_employee')->where('id', $id )->update([
            'employee_status_description' => 'Resigned'
        ]);
        $result = [
            'id'                => $id
        ];
        echo json_encode($result);
    }
}
