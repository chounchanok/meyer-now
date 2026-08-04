<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\EmployeeModel;
use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Grademaster;

use App\Models\Maintain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Users;

use Illuminate\Support\Facades\Mail;

class MaintainController extends Controller
{
    public function index()
    {
        $previousYear = date('Y');

        // ✅ กำหนดค่าตัวแปรตามเงื่อนไข `request()->segment(1)`
        if (trans(request()->segment(1)) == 'manager') {
            $arr = ['101', '114'];
            $arroffice = ['101', '114'];
            $arrasst = ['105'];
            $arr2 = ['101', '114'];
            $arrtop = ['101', '100'];
        } elseif (trans(request()->segment(1)) == 'mtl') {
            $arr = ['101', '114'];
            $arroffice = ['101', '114', '103', '104', '105', '108'];
            $arrasst = ['103', '104', '105', '108'];
            $arr2 = ['101', '114'];
            $arrtop = ['101', '100'];
        } else {
            $arr = ['105', '103', '114'];
            $arroffice = ['105', '106', '103', '114'];
            $arrasst = ['106'];
            $arr2 = ['114'];
            $arrtop = ['101', '100'];
        }

        // ✅ ดึงข้อมูลหลักที่ต้องการ
        $topmanagement2 = DB::table('tb_percent_department_action')
            ->select(
                'tb_percent_department_action.*',
                'tb_percent_department.year',
                'tb_division.division_description',
                'tb_department.department_description',
                'tb_section.section_description',
                'users.name AS top_name'
            )
            ->leftJoin('tb_percent_department', 'tb_percent_department.id', '=', 'tb_percent_department_action.percent_department_id')
            ->leftJoin('tb_division', 'tb_division.division_code', '=', 'tb_percent_department_action.division_code')
            ->leftJoin('tb_department', 'tb_department.department_code', '=', 'tb_percent_department_action.department_code')
            ->leftJoin('tb_section', 'tb_section.section_code', '=', 'tb_percent_department_action.section_code')
            ->leftJoin('users', 'users.orisoft_code', '=', 'tb_percent_department_action.approve_by2')
            ->where('tb_percent_department.year', $previousYear)
            ->orderBy('tb_percent_department_action.id', 'ASC')
            ->get();

        $topmanagement = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->whereIn('tb_employee_evaluator.position_code',$arr2)
        ;

        $topmanagement = $topmanagement->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        // **สร้างโครงสร้าง JSON**
        $groupedData = [];
        $evaluatorx = [];

        foreach ($topmanagement2 as $row) {
            $divisionCode = $row->division_code;
            $departmentCode = $row->department_code;
            $sectionCode = $row->section_code;

            $departmentdescription = $row->department_description;
            $sectiondescription = $row->section_description;

            // ✅ ตรวจสอบว่ามี Division หรือยัง
            if (!isset($groupedData[$divisionCode])) {
                $sub1 = substr($divisionCode, 0, 1);

                // ✅ ดึงข้อมูล evaluator เพียงครั้งเดียว
                $evaluatorx = DB::table('tb_employee_evaluator')
                    ->select('employee_no', 'employee_name_th', 'employee_name_en', 'division_code')
                    ->where('rec_year', $previousYear)
                    ->where('evaluator_active', '1')
                    ->whereIn('position_code', $arr)
                    ->where('division_code', 'like', '%' . $sub1 . '%')
                    ->groupBy('employee_no')
                    ->orderBy('employee_no', 'ASC')
                    ->get();

                $groupedData[$divisionCode] = [
                    'id' => $row->percent_department_id,
                    'division_code' => $divisionCode,
                    'division_description' => $row->division_description,
                    'top' => $row->approve_by2,
                    'tb_department' => [],
                    'set_department' => [],
                    'set_employee_no' => [],
                ];
            }

            // ✅ ตรวจสอบว่ามี Department หรือยัง
            if (!isset($groupedData[$divisionCode]['tb_department'][$departmentCode])) {
                $sub11 = substr($departmentCode, 0, 2);
                $groupedData[$divisionCode]['tb_department'][$departmentCode] = [
                    'id' => $row->percent_department_id,
                    'department_code' => $departmentCode,
                    'department_description' => $departmentdescription,
                    'dept' => $row->approve_by1,
                    'subil' => $sub11,
                    'tb_section' => [],
                    'evaluator' => [],
                ];

                // ✅ เพิ่ม Department ลงใน set_department
                if (!in_array($departmentCode, $groupedData[$divisionCode]['set_department'])) {
                    $groupedData[$divisionCode]['set_department'][] = $departmentCode;
                }
            }

            if(trans(request()->segment(1)) == 'manager'){
                $evaluatorG3AC = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th',
                        'tb_employee_evaluator.employee_name_en',
                        'tb_employee_evaluator.division_code')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->where('tb_employee_evaluator.evaluator_active','1')
                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                ->where('section_code','like','G3AC%')
                ->orwhere('employee_no','000002')
                ;
            }else{
                $evaluatorG3AC = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th',
                        'tb_employee_evaluator.employee_name_en',
                        'tb_employee_evaluator.division_code')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->where('tb_employee_evaluator.evaluator_active','1')
                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                ->where('section_code','like','G3AC%')
                ->orwhere('employee_no','000026')
                ;
            }

            if($sub11 == "G3"){
                $tb_employee_evaluator11 = DB::table('tb_employee_evaluator')
                // ->where('department_code',$value2->department_code)
                // ->where('department_code','like',''.$sub11.'%')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->whereIn('tb_employee_evaluator.position_code',$arr)
                ->where('section_code','like','G3AC%')
                ->first();
                // dd($tb_employee_evaluator);
                // exit;
                if($tb_employee_evaluator11){
                    $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3AC'] = $tb_employee_evaluator11->employee_no;
                }else{
                    if(trans(request()->segment(1)) == 'manager'){
                        $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3AC'] = '000002';
                    }else{
                        $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3AC'] = '000026';
                    }
                }
                $tb_employee_evaluator22 = DB::table('tb_employee_evaluator')
                // ->where('department_code',$value2->department_code)
                // ->where('department_code','like',''.$sub11.'%')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->whereIn('tb_employee_evaluator.position_code',$arr)
                ->where('section_code','like','G3TC%')
                ->first();
                // dd($tb_employee_evaluator);
                // exit;
                if($tb_employee_evaluator22){
                    $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3TC'] = $tb_employee_evaluator22->employee_no;
                }else{
                    $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3TC'] = '000023';
                }
            }
            $evaluatorG3AC = $evaluatorG3AC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
            if(count($evaluatorG3AC) == 0){
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3AC'] = $topmanagement;
            }else{
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3AC'] = $evaluatorG3AC;
            }
            $evaluatorG3TC = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee_evaluator.employee_name_th',
                    'tb_employee_evaluator.employee_name_en',
                    'tb_employee_evaluator.division_code')
            ->where('tb_employee_evaluator.rec_year',$previousYear)
            ->where('tb_employee_evaluator.evaluator_active','1')
            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
            ->where('section_code','like','G3TC%')
            ;

            $evaluatorG3TC = $evaluatorG3TC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
            if(count($evaluatorG3TC) == 0){
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3TC'] = [];
            }else{
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3TC'] = $evaluatorG3TC;
            }
            // ✅ ตรวจสอบว่ามี Section หรือยัง
            if (!isset($groupedData[$divisionCode]['tb_department'][$departmentCode]['tb_section'][$sectionCode])) {
                $tb_section = DB::table('tb_section')
                    ->select('id')
                    ->where('section_code', $sectionCode)
                    ->orderBy('section_code', 'ASC')
                    ->first();

                $groupedData[$divisionCode]['tb_department'][$departmentCode]['tb_section'][$sectionCode] = [
                    'id' => $tb_section->id ?? null,
                    'section_code' => $sectionCode,
                    'section_description' => $sectiondescription,
                ];
            }

            // ✅ เพิ่ม Evaluator (group ซ้ำ)
            if (!empty($row->approve_by1)) {
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                    ->where('rec_year', $previousYear)
                    ->where('employee_no', $row->approve_by1)
                    ->first();

                if ($tb_employee_evaluator) {
                    $evaluatorEntry = [
                        'employee_no' => $row->approve_by1,
                        'employee_name_th' => $tb_employee_evaluator->employee_name_th,
                        'employee_name_en' => $tb_employee_evaluator->employee_name_en,
                        'division_code' => $divisionCode,
                    ];

                    if (!in_array($evaluatorEntry, $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluator'])) {
                        $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluator'][] = $evaluatorEntry;
                    }
                }
            }
        }

        // ✅ แปลง `set_department` ให้เป็น String
        foreach ($groupedData as &$division) {
            if (!empty($division['set_department'])) {
                $division['set_department'] = implode(',', $division['set_department']);
            } else {
                $division['set_department'] = '';
            }
        }

        // ✅ แปลง `tb_department` และ `tb_section` เป็น Array
        $finalData = array_values($groupedData);
        foreach ($finalData as &$division) {
            $division['tb_department'] = array_values($division['tb_department']);
            foreach ($division['tb_department'] as &$department) {
                $department['tb_section'] = array_values($department['tb_section']);
            }
        }

        // ✅ ดึงข้อมูลปีสำหรับ `year`
        $year = DB::table('tb_employee_final_score')
            ->select('rec_year')
            ->groupBy('rec_year')
            ->orderBy('rec_year', 'DESC')
            ->get();
        // return response()->json($finalData);
        // dd($division);
        // exit;
        // ✅ ส่งข้อมูลไปยัง View
        // $division = collect($division);
        return view('pages.setting.maintain.index', [
            "year" => $year,
            "evaluator" => $evaluatorx,
            "division" => $finalData,
            "topmanagement2" => $topmanagement2,
        ]);
    }

    public function index_bk()
    {
        $previousYear = date('Y');
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year',$previousYear)
        ->where('employee_no',$orisoft_code)->first();

        if(trans(request()->segment(1)) == 'manager'){
            $arr = ['101','114'];
            $arroffice = ['101','114'];
            $arrasst = ['105'];
            $arr2 = ['101','114'];
            $arrtop = ['101','100'];
        }else if(trans(request()->segment(1)) == 'mtl'){
            $arr = ['101','114'];
            $arroffice = ['101','114','103','104','105','108'];
            $arrasst = ['103','104','105','108'];
            $arr2 = ['101','114'];
            $arrtop = ['101','100'];
        }else{
            $arr = ['105','103','114'];
            $arroffice = ['105','106','103','114'];
            $arrasst = ['106'];
            $arr2 = ['114'];
            $arrtop = ['101','100'];
        }



        $topmanagement2 = DB::table('tb_percent_department_action')
        ->select('tb_percent_department_action.*')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year',$previousYear)
        ->orderBy('tb_percent_department_action.id', 'ASC')->get();

        $topmanagement = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->whereIn('tb_employee_evaluator.position_code',$arr2)
        ;



        $topmanagement = $topmanagement->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $tb_division = DB::table('tb_division')
        ->select(
            'id',
            'division_code',
            'division_description',
        )
        ->orderBy('division_code','ASC')
        ->get();

        $evaluatorx = [];
        if(trans(request()->segment(1)) == 'mtl'){
            if(count($tb_division)>0){
                foreach ($tb_division as $key => $value) {
                    $sub1 = substr($value->division_code,0,1);

                    $tb_evaluator_division = DB::table('tb_employee_evaluator')
                    ->where('division_code','like','%'.$value->division_code.'%')
                    ->whereIn('tb_employee_evaluator.position_code',$arrtop)
                    ->first();
                    $tb_division[$key]->top = '000002';

                    $tb_department = DB::table('tb_department')
                    ->select(
                        'id',
                        'department_code',
                        'department_description',
                    )
                    ->where('department_code','like',''.$sub1.'%')
                    ->orderBy('department_code','ASC')->get();


                    if(count($tb_department)>0){
                        $tb_division[$key]->tb_department = $tb_department;
                        $set_department = '';
                        if(!empty($tb_department)){
                            foreach($tb_department AS $valxx1){
                                $set_department .= $valxx1->department_code.',';
                            }
                        }
                        $sub_set_department = substr($set_department,0,-1);
                        $tb_division[$key]->set_department = $sub_set_department;
                        if(count($tb_division[$key]->tb_department)>0){
                            foreach ($tb_division[$key]->tb_department as $key2 => $value2) {

                                $sub11 = substr($value2->department_code,0,2);
                                $sub_1 = substr($value2->department_code,0,1);

                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                ->select('employee_no')
                                ->where('department_code','like','%'.$sub11.'%')
                                ->where('section_code','like','%'.$sub11.'%')
                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                ->first();

                                if($tb_employee_evaluator){
                                    $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                    $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                }else{
                                    $tb_employee_evaluatorzx = DB::table('tb_percent_department_action')
                                    ->select('approve_by1 AS employee_no')
                                    ->where('department_code','like','%'.$sub11.'%')
                                    ->where('section_code','like','%'.$sub11.'%')
                                    ->first();
                                    if($tb_employee_evaluatorzx){
                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorzx->employee_no;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                    }
                                }


                                $sub2 = substr($value2->department_code,0,2);
                                $tb_section = DB::table('tb_section')
                                ->select(
                                    'id',
                                    'section_code',
                                    'section_description',
                                )
                                ->where('section_code','like',''.$sub2.'%')
                                ->orderBy('section_code','ASC')
                                ->get();
                                if(count($tb_division[$key]->tb_department)>0){
                                    $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                }
                                $evaluator = DB::table('tb_employee_evaluator')
                                ->select('tb_employee_evaluator.employee_no',
                                        'tb_employee_evaluator.employee_name_th',
                                        'tb_employee_evaluator.employee_name_en',
                                        'tb_employee_evaluator.division_code')
                                ->where('tb_employee_evaluator.evaluator_active','1')
                                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                ;

                                $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                if(count($evaluator) == 0){
                                    if($sub11 == "B2" || $sub11 == "B3" || $sub11 == "L2"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','000023')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else if($sub11 == "B6"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','990331')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                    }
                                }else{
                                    if($sub11 == "B2" || $sub11 == "B3" || $sub11 == "L2"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','000023')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else if($sub11 == "B6"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','990331')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                    }
                                }


                            }
                        }

                    }


                    // $evaluatorx[] = $evaluator;
                }
            }
        }else{
            if(count($tb_division)>0){
                foreach ($tb_division as $key => $value) {
                    $sub1 = substr($value->division_code,0,1);

                    $tb_evaluator_division = DB::table('tb_employee_evaluator')
                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                    ->where('division_code','like','%'.$value->division_code.'%')
                    ->whereIn('tb_employee_evaluator.position_code',$arrtop)
                    ->first();
                    if($tb_evaluator_division){
                        $tb_division[$key]->top = $tb_evaluator_division->employee_no;
                    }else{
                        $tb_division[$key]->top = '000002';
                    }
                    $tb_department = DB::table('tb_department')
                    ->select(
                        'id',
                        'department_code',
                        'department_description',
                    )
                    ->where('department_code','like',''.$sub1.'%')
                    ->orderBy('department_code','ASC')->get();


                    // echo "<pre>";
                    // print_r($tb_department);
                    // dd($tb_department);
                    // exit;
                    if(count($tb_department)>0){
                        $tb_division[$key]->tb_department = $tb_department;
                        $set_department = '';
                        if(!empty($tb_department)){
                            foreach($tb_department AS $valxx1){
                                $set_department .= $valxx1->department_code.',';
                            }
                        }
                        $sub_set_department = substr($set_department,0,-1);
                        $tb_division[$key]->set_department = $sub_set_department;
                        if(count($tb_division[$key]->tb_department)>0){
                            foreach ($tb_division[$key]->tb_department as $key2 => $value2) {
                                // dd($value2->department_code);
                                // exit;
                                $sub11 = substr($value2->department_code,0,2);
                                $sub_1 = substr($value2->department_code,0,1);
                                if($sub11 == "G3"){
                                    $tb_employee_evaluator11 = DB::table('tb_employee_evaluator')
                                    // ->where('department_code',$value2->department_code)
                                    // ->where('department_code','like',''.$sub11.'%')
                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('section_code','like','G3AC%')
                                    ->first();
                                    // dd($tb_employee_evaluator);
                                    // exit;
                                    if($tb_employee_evaluator11){
                                        $tb_division[$key]->tb_department[$key2]->G3AC = $tb_employee_evaluator11->employee_no;
                                    }else{
                                        if(trans(request()->segment(1)) == 'manager'){
                                            $tb_division[$key]->tb_department[$key2]->G3AC = '000002';
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->G3AC = '000026';
                                        }
                                    }
                                    $tb_employee_evaluator22 = DB::table('tb_employee_evaluator')
                                    // ->where('department_code',$value2->department_code)
                                    // ->where('department_code','like',''.$sub11.'%')
                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('section_code','like','G3TC%')
                                    ->first();
                                    // dd($tb_employee_evaluator);
                                    // exit;
                                    if($tb_employee_evaluator22){
                                        $tb_division[$key]->tb_department[$key2]->G3TC = $tb_employee_evaluator22->employee_no;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->G3TC = '000023';
                                    }
                                }else{
                                    if($sub_1 == '1' || $sub_1 == '2' || $sub_1 == '6' || $sub_1 == '7' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Y' || $sub_1 == 'Z'){
                                        $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.rec_year',$previousYear)
                                        ->where('department_code','like','%'.$value2->department_code.'%')
                                        ->whereIn('tb_employee_evaluator.position_code',$arr)
                                        ->first();
                                        // dd($tb_employee_evaluator);
                                        // exit;
                                        if($tb_employee_evaluator){
                                            $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                        }else{
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub_1 == '1' || $sub_1 == '6' || $sub_1 == '9' || $sub_1 == 'Z'){
                                                    $tb_employee_evaluatorsss = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('department_code','like',''.$sub1.'%')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                    ->first();
                                                    if($tb_employee_evaluatorsss){
                                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->set_employee_no = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                        $tb_division[$key]->set_employee_no = '000026';
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }
                                                }else if($sub_1 == '8'){
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    $tb_division[$key]->set_employee_no = '000002';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    $tb_division[$key]->set_employee_no = '000026';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }
                                            }else{
                                                if($sub_1 == '1' || $sub_1 == '6' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Z'){
                                                    $tb_employee_evaluatorsss = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('department_code','like',''.$sub1.'%')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                    ->first();
                                                    if($tb_employee_evaluatorsss){
                                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->set_employee_no = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                        $tb_division[$key]->set_employee_no = '000026';
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    $tb_division[$key]->set_employee_no = '000026';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }
                                            }
                                        }
                                    }else{
                                        if(trans(request()->segment(1)) == 'manager'){
                                            if($sub11 == "P3" || $sub11 == "P4"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000026')
                                                ->first();
                                            }else if($sub11 == "PD"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000002')
                                                ->first();
                                            }else if($sub11 == "PA"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000002')
                                                ->first();
                                            }else{
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                // ->where('department_code',$value2->department_code)
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->where('section_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->first();
                                            }
                                        }else{
                                            if($sub11 == "P3" || $sub11 == "PD"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','013591')
                                                ->first();
                                            }else if($sub11 == "P1" || $sub11 == "P4"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000003')
                                                ->first();
                                            }else{
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                // ->where('department_code',$value2->department_code)
                                                ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->where('section_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->first();
                                            }
                                        }



                                        // print_r($tb_employee_evaluator);
                                        // echo "<br>";
                                        // dd($sub11);
                                        // exit;
                                        if($tb_employee_evaluator){
                                            $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                        }else{
                                            $tb_employee_evaluatorzx = DB::table('tb_percent_department_action')
                                            ->select('approve_by1 AS employee_no')
                                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')

                                            // ->where('department_code',$value2->department_code)
                                            ->where('tb_percent_department.year',$previousYear)
                                            ->where('department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','%'.$sub11.'%')
                                            // ->whereIn('tb_percent_department_action.position_code',$arrasst)
                                            ->first();

                                            // print_r($tb_employee_evaluatorzx);
                                            // echo "<br>";
                                            // dd($sub11);
                                            // exit;
                                            if($tb_employee_evaluatorzx){
                                                $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorzx->employee_no;
                                            }else{
                                                if(trans(request()->segment(1)) == 'manager'){
                                                    if($sub11 == "PA"){
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    }
                                                }else if(trans(request()->segment(1)) == 'mtl'){
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                }
                                            }
                                        }
                                    }

                                }


                                if($sub_1 == '1' || $sub_1 == '2' || $sub_1 == '6' || $sub_1 == '7' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Y' || $sub_1 == 'Z'){
                                    $sub2 = substr($value2->department_code,0,2);
                                    $tb_section = DB::table('tb_section')
                                    ->select(
                                        'id',
                                        'section_code',
                                        'section_description',
                                    )
                                    ->where('section_code','like',''.$sub2.'%')->get();
                                    if(count($tb_division[$key]->tb_department)>0){
                                        $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                    }

                                    $evaluator = DB::table('tb_employee_evaluator')
                                    ->select('tb_employee_evaluator.employee_no',
                                            'tb_employee_evaluator.employee_name_th',
                                            'tb_employee_evaluator.employee_name_en',
                                            'tb_employee_evaluator.division_code')
                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                    ;

                                    $evaluatorx = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                                    if(count($evaluatorx) == 0){
                                        $evaluator111 = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.rec_year',$previousYear)
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arrasst)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ;

                                        $evaluator111 = $evaluator111->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                                        if(count($evaluator111) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator111;
                                        }
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $evaluatorx;
                                    }
                                }else{
                                    if($sub11 == "G3"){
                                        $sub2 = substr($value2->department_code,0,2);
                                        $tb_section = DB::table('tb_section')
                                        ->select(
                                            'id',
                                            'section_code',
                                            'section_description',
                                        )
                                        ->where('section_code','like',''.$sub2.'%')
                                        ->orderBy('section_code','ASC')
                                        ->get();
                                        if(count($tb_division[$key]->tb_department)>0){
                                            $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                        }
                                        if(trans(request()->segment(1)) == 'manager'){
                                            $evaluatorG3AC = DB::table('tb_employee_evaluator')
                                            ->select('tb_employee_evaluator.employee_no',
                                                    'tb_employee_evaluator.employee_name_th',
                                                    'tb_employee_evaluator.employee_name_en',
                                                    'tb_employee_evaluator.division_code')
                                            ->where('tb_employee_evaluator.rec_year',$previousYear)
                                            ->where('tb_employee_evaluator.evaluator_active','1')
                                            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','G3AC%')
                                            ->orwhere('employee_no','000002')
                                            ;
                                        }else{
                                            $evaluatorG3AC = DB::table('tb_employee_evaluator')
                                            ->select('tb_employee_evaluator.employee_no',
                                                    'tb_employee_evaluator.employee_name_th',
                                                    'tb_employee_evaluator.employee_name_en',
                                                    'tb_employee_evaluator.division_code')
                                            ->where('tb_employee_evaluator.rec_year',$previousYear)
                                            ->where('tb_employee_evaluator.evaluator_active','1')
                                            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','G3AC%')
                                            ->orwhere('employee_no','000026')
                                            ;
                                        }


                                        $evaluatorG3AC = $evaluatorG3AC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluatorG3AC) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3AC = $topmanagement;
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3AC = $evaluatorG3AC;
                                        }
                                        $evaluatorG3TC = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.rec_year',$previousYear)
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                        ->where('section_code','like','G3TC%')
                                        ;

                                        $evaluatorG3TC = $evaluatorG3TC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluatorG3TC) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3TC = [];
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3TC = $evaluatorG3TC;
                                        }
                                    }else{
                                        $sub2 = substr($value2->department_code,0,2);
                                        $tb_section = DB::table('tb_section')
                                        ->select(
                                            'id',
                                            'section_code',
                                            'section_description',
                                        )
                                        ->where('section_code','like',''.$sub2.'%')
                                        ->orderBy('section_code','ASC')
                                        ->get();
                                        if(count($tb_division[$key]->tb_department)>0){
                                            $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                        }
                                        // echo $sub11."<br>";
                                        $evaluator = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.rec_year',$previousYear)
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                        ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                        ;

                                        $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluator) == 0){
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000002')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else if($sub11 == "P3" || $sub11 == "P4"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000026')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                                }
                                            }else{
                                                if($sub11 == "P3" || $sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','013591')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else if($sub11 == "P1" || $sub11 == "P4"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000003')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                                }
                                            }
                                        }else{
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub11 == "PD" || $sub11 == "PA"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000002')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                                }
                                            }else{
                                                if($sub11 == "P3" || $sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.rec_year',$previousYear)
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','013591')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                    }


                    // $evaluatorx[] = $evaluator;
                }
            }
        }


        // dd($tb_division);
        // exit;


        /////////////////////////////////// code ได้รายชื่อ Manager พร้อม Department //////////////////////////////
        // $allcheck = [];
        // if(!empty($tb_division)){
        //     foreach($tb_division as $key => $value){
        //         if(!empty($tb_division[$key]->tb_department)){
        //             foreach($tb_division[$key]->tb_department as $key2 => $value2){
        //                 $sub1 = substr($value->division_code,0,1);
        //                 $sub11 = substr($value2->department_code,0,2);
        //                 if($sub11 == "G3"){
        //                     $allcheck[$value2->G3AC] = [];
        //                     $allcheck[$value2->G3TC] = [];
        //                 }else{
        //                     if($sub1 == '1' || $sub1 == '2' || $sub1 == '6' || $sub1 == '7' || $sub1 == '8' || $sub1 == '9' || $sub1 == 'Y' || $sub1 == 'Z'){
        //                         $allcheck[$value2->dept] = [];
        //                     }else{
        //                         $allcheck[$value2->dept] = [];
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        // if(!empty($tb_division)){
        //     foreach($tb_division as $key => $value){
        //         if(!empty($tb_division[$key]->tb_department)){
        //             foreach($tb_division[$key]->tb_department as $key2 => $value2){
        //                 $sub1 = substr($value->division_code,0,1);
        //                 $sub11 = substr($value2->department_code,0,2);
        //                 if($sub11 == "G3"){
        //                     array_push($allcheck[$value2->G3AC],$value2->department_code);
        //                     array_push($allcheck[$value2->G3TC],$value2->department_code);
        //                 }else{
        //                     if($sub1 == '1' || $sub1 == '2' || $sub1 == '6' || $sub1 == '7' || $sub1 == '8' || $sub1 == '9' || $sub1 == 'Y' || $sub1 == 'Z'){
        //                         array_push($allcheck[$value2->dept],$value2->department_code);
        //                     }else{
        //                         array_push($allcheck[$value2->dept],$value2->department_code);
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        // dd($tb_division);
        // exit;
        /////////////////////////////////// code ได้รายชื่อ Manager พร้อม Department //////////////////////////////





        // $tb_department = DB::table('tb_department')->get();
        // $tb_section = DB::table('tb_section')->get();


        $year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();

        echo json_encode($tb_division);
        exit;
        return view('pages.setting.maintain.index', [
            "year" => $year,
            "topmanagement" => $topmanagement,
            "evaluator" => $evaluatorx,
            "division" => $tb_division,
            "topmanagement2" => $topmanagement2,
            // "tb_department" => $tb_department,
            // "tb_section" => $tb_section,
        ]);
    }

    public function show(Request $request, $test ,$id)
    {
        $previousYear = $id;
        // return response()->json($previousYear);
        // dd($division);
        // exit;
        // ✅ กำหนดค่าตัวแปรตามเงื่อนไข `request()->segment(1)`
        if (trans(request()->segment(1)) == 'manager') {
            $arr = ['101', '114'];
            $arroffice = ['101', '114'];
            $arrasst = ['105'];
            $arr2 = ['101', '114'];
            $arrtop = ['101', '100'];
        } elseif (trans(request()->segment(1)) == 'mtl') {
            $arr = ['101', '114'];
            $arroffice = ['101', '114', '103', '104', '105', '108'];
            $arrasst = ['103', '104', '105', '108'];
            $arr2 = ['101', '114'];
            $arrtop = ['101', '100'];
        } else {
            $arr = ['105', '103', '114'];
            $arroffice = ['105', '106', '103', '114'];
            $arrasst = ['106'];
            $arr2 = ['114'];
            $arrtop = ['101', '100'];
        }

        // ✅ ดึงข้อมูลหลักที่ต้องการ
        $topmanagement2 = DB::table('tb_percent_department_action')
            ->select(
                'tb_percent_department_action.*',
                'tb_percent_department.year',
                'tb_division.division_description',
                'tb_department.department_description',
                'tb_section.section_description',
                'users.name AS top_name'
            )
            ->leftJoin('tb_percent_department', 'tb_percent_department.id', '=', 'tb_percent_department_action.percent_department_id')
            ->leftJoin('tb_division', 'tb_division.division_code', '=', 'tb_percent_department_action.division_code')
            ->leftJoin('tb_department', 'tb_department.department_code', '=', 'tb_percent_department_action.department_code')
            ->leftJoin('tb_section', 'tb_section.section_code', '=', 'tb_percent_department_action.section_code')
            ->leftJoin('users', 'users.orisoft_code', '=', 'tb_percent_department_action.approve_by2')
            ->where('tb_percent_department.year', $previousYear)
            ->orderBy('tb_percent_department_action.id', 'ASC')
            ->get();

        $topmanagement = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->whereIn('tb_employee_evaluator.position_code',$arr2)
        ;



        $topmanagement = $topmanagement->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        // **สร้างโครงสร้าง JSON**
        $groupedData = [];
        $evaluatorx = [];

        foreach ($topmanagement2 as $row) {
            $divisionCode = $row->division_code;
            $departmentCode = $row->department_code;
            $sectionCode = $row->section_code;

            $departmentdescription = $row->department_description;
            $sectiondescription = $row->section_description;

            // ✅ ตรวจสอบว่ามี Division หรือยัง
            if (!isset($groupedData[$divisionCode])) {
                $sub1 = substr($divisionCode, 0, 1);

                // ✅ ดึงข้อมูล evaluator เพียงครั้งเดียว
                $evaluatorx = DB::table('tb_employee_evaluator')
                    ->select('employee_no', 'employee_name_th', 'employee_name_en', 'division_code')
                    ->where('rec_year', $previousYear)
                    ->where('evaluator_active', '1')
                    ->whereIn('position_code', $arr)
                    ->where('division_code', 'like', '%' . $sub1 . '%')
                    ->groupBy('employee_no')
                    ->orderBy('employee_no', 'ASC')
                    ->get();

                $groupedData[$divisionCode] = [
                    'id' => $row->percent_department_id,
                    'division_code' => $divisionCode,
                    'division_description' => $row->division_description,
                    'top' => $row->approve_by2,
                    'tb_department' => [],
                    'set_department' => [],
                    'set_employee_no' => [],
                ];
            }

            // ✅ ตรวจสอบว่ามี Department หรือยัง
            if (!isset($groupedData[$divisionCode]['tb_department'][$departmentCode])) {
                $sub11 = substr($departmentCode, 0, 2);
                $groupedData[$divisionCode]['tb_department'][$departmentCode] = [
                    'id' => $row->percent_department_id,
                    'department_code' => $departmentCode,
                    'department_description' => $departmentdescription,
                    'dept' => $row->approve_by1,
                    'subil' => $sub11,
                    'tb_section' => [],
                    'evaluator' => [],
                ];

                // ✅ เพิ่ม Department ลงใน set_department
                if (!in_array($departmentCode, $groupedData[$divisionCode]['set_department'])) {
                    $groupedData[$divisionCode]['set_department'][] = $departmentCode;
                }
            }

            if(trans(request()->segment(1)) == 'manager'){
                $evaluatorG3AC = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th',
                        'tb_employee_evaluator.employee_name_en',
                        'tb_employee_evaluator.division_code')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->where('tb_employee_evaluator.evaluator_active','1')
                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                ->where('section_code','like','G3AC%')
                ->orwhere('employee_no','000002')
                ;
            }else{
                $evaluatorG3AC = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th',
                        'tb_employee_evaluator.employee_name_en',
                        'tb_employee_evaluator.division_code')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->where('tb_employee_evaluator.evaluator_active','1')
                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                ->where('section_code','like','G3AC%')
                ->orwhere('employee_no','000026')
                ;
            }

            if($sub11 == "G3"){
                $tb_employee_evaluator11 = DB::table('tb_employee_evaluator')
                // ->where('department_code',$value2->department_code)
                // ->where('department_code','like',''.$sub11.'%')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->whereIn('tb_employee_evaluator.position_code',$arr)
                ->where('section_code','like','G3AC%')
                ->first();
                // dd($tb_employee_evaluator);
                // exit;
                if($tb_employee_evaluator11){
                    $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3AC'] = $tb_employee_evaluator11->employee_no;
                }else{
                    if(trans(request()->segment(1)) == 'manager'){
                        $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3AC'] = '000002';
                    }else{
                        $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3AC'] = '000026';
                    }
                }
                $tb_employee_evaluator22 = DB::table('tb_employee_evaluator')
                // ->where('department_code',$value2->department_code)
                // ->where('department_code','like',''.$sub11.'%')
                ->where('tb_employee_evaluator.rec_year',$previousYear)
                ->whereIn('tb_employee_evaluator.position_code',$arr)
                ->where('section_code','like','G3TC%')
                ->first();
                // dd($tb_employee_evaluator);
                // exit;
                if($tb_employee_evaluator22){
                    $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3TC'] = $tb_employee_evaluator22->employee_no;
                }else{
                    $groupedData[$divisionCode]['tb_department'][$departmentCode]['G3TC'] = '000023';
                }
            }
            $evaluatorG3AC = $evaluatorG3AC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
            if(count($evaluatorG3AC) == 0){
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3AC'] = $topmanagement;
            }else{
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3AC'] = $evaluatorG3AC;
            }
            $evaluatorG3TC = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee_evaluator.employee_name_th',
                    'tb_employee_evaluator.employee_name_en',
                    'tb_employee_evaluator.division_code')
            ->where('tb_employee_evaluator.rec_year',$previousYear)
            ->where('tb_employee_evaluator.evaluator_active','1')
            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
            ->where('section_code','like','G3TC%')
            ;

            $evaluatorG3TC = $evaluatorG3TC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
            if(count($evaluatorG3TC) == 0){
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3TC'] = [];
            }else{
                $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluatorG3TC'] = $evaluatorG3TC;
            }
            // ✅ ตรวจสอบว่ามี Section หรือยัง
            if (!isset($groupedData[$divisionCode]['tb_department'][$departmentCode]['tb_section'][$sectionCode])) {
                $tb_section = DB::table('tb_section')
                    ->select('id')
                    ->where('section_code', $sectionCode)
                    ->orderBy('section_code', 'ASC')
                    ->first();

                $groupedData[$divisionCode]['tb_department'][$departmentCode]['tb_section'][$sectionCode] = [
                    'id' => $tb_section->id ?? null,
                    'section_code' => $sectionCode,
                    'section_description' => $sectiondescription,
                ];
            }

            // ✅ เพิ่ม Evaluator (group ซ้ำ)
            if (!empty($row->approve_by1)) {
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                    ->where('rec_year', $previousYear)
                    ->where('employee_no', $row->approve_by1)
                    ->first();

                if ($tb_employee_evaluator) {
                    $evaluatorEntry = [
                        'employee_no' => $row->approve_by1,
                        'employee_name_th' => $tb_employee_evaluator->employee_name_th,
                        'employee_name_en' => $tb_employee_evaluator->employee_name_en,
                        'division_code' => $divisionCode,
                    ];

                    if (!in_array($evaluatorEntry, $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluator'])) {
                        $groupedData[$divisionCode]['tb_department'][$departmentCode]['evaluator'][] = $evaluatorEntry;
                    }
                }
            }
        }

        // ✅ แปลง `set_department` ให้เป็น String
        foreach ($groupedData as &$division) {
            if (!empty($division['set_department'])) {
                $division['set_department'] = implode(',', $division['set_department']);
            } else {
                $division['set_department'] = '';
            }
        }

        // ✅ แปลง `tb_department` และ `tb_section` เป็น Array
        $finalData = array_values($groupedData);
        foreach ($finalData as &$division) {
            $division['tb_department'] = array_values($division['tb_department']);
            foreach ($division['tb_department'] as &$department) {
                $department['tb_section'] = array_values($department['tb_section']);
            }
        }

        // ✅ ดึงข้อมูลปีสำหรับ `year`
        $year = DB::table('tb_employee_final_score')
            ->select('rec_year')
            ->groupBy('rec_year')
            ->orderBy('rec_year', 'DESC')
            ->get();
        // return response()->json($finalData);
        // dd($division);
        // exit;
        // ✅ ส่งข้อมูลไปยัง View
        // $division = collect($division);
        return view('pages.setting.maintain.show', [
            "id" => $previousYear,
            "year" => $year,
            "evaluator" => $evaluatorx,
            "division" => $finalData,
            "topmanagement2" => $topmanagement2,
        ]);
    }

    public function showbk(Request $request, $test ,$id)
    {
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')->where('employee_no',$orisoft_code)->first();

        if(trans(request()->segment(1)) == 'manager'){
            $arr = ['101','114'];
            $arroffice = ['101','114'];
            $arrasst = ['105'];
            $arr2 = ['101','114'];
            $arrtop = ['101','100'];
        }else if(trans(request()->segment(1)) == 'mtl'){
            $arr = ['101','114'];
            $arroffice = ['101','114','103','104','105','108'];
            $arrasst = ['103','104','105','108'];
            $arr2 = ['101','114'];
            $arrtop = ['101','100'];
        }else{
            $arr = ['105','103','114'];
            $arroffice = ['105','106','103','114'];
            $arrasst = ['106'];
            $arr2 = ['114'];
            $arrtop = ['101','100'];
        }

        $previousYear = date('Y');

        $topmanagement2 = DB::table('tb_percent_department_action')
        ->select('tb_percent_department_action.*')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year',$previousYear)
        ->orderBy('tb_percent_department_action.id', 'ASC')->get();

        $topmanagement = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->whereIn('tb_employee_evaluator.position_code',$arr2)
        ;



        $topmanagement = $topmanagement->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $tb_division = DB::table('tb_division')
        ->select(
            'id',
            'division_code',
            'division_description',
        )
        ->orderBy('division_code','ASC')
        ->get();

        $evaluatorx = [];
        if(trans(request()->segment(1)) == 'mtl'){
            if(count($tb_division)>0){
                foreach ($tb_division as $key => $value) {
                    $sub1 = substr($value->division_code,0,1);

                    $tb_evaluator_division = DB::table('tb_employee_evaluator')
                    ->where('division_code','like','%'.$value->division_code.'%')
                    ->whereIn('tb_employee_evaluator.position_code',$arrtop)
                    ->first();
                    $tb_division[$key]->top = '000002';

                    $tb_department = DB::table('tb_department')
                    ->select(
                        'id',
                        'department_code',
                        'department_description',
                    )
                    ->where('department_code','like',''.$sub1.'%')
                    ->orderBy('department_code','ASC')->get();


                    if(count($tb_department)>0){
                        $tb_division[$key]->tb_department = $tb_department;
                        $set_department = '';
                        if(!empty($tb_department)){
                            foreach($tb_department AS $valxx1){
                                $set_department .= $valxx1->department_code.',';
                            }
                        }
                        $sub_set_department = substr($set_department,0,-1);
                        $tb_division[$key]->set_department = $sub_set_department;
                        if(count($tb_division[$key]->tb_department)>0){
                            foreach ($tb_division[$key]->tb_department as $key2 => $value2) {

                                $sub11 = substr($value2->department_code,0,2);
                                $sub_1 = substr($value2->department_code,0,1);

                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                ->select('employee_no')
                                ->where('department_code','like','%'.$sub11.'%')
                                ->where('section_code','like','%'.$sub11.'%')
                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                ->first();

                                if($tb_employee_evaluator){
                                    $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                    $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                }else{
                                    $tb_employee_evaluatorzx = DB::table('tb_percent_department_action')
                                    ->select('approve_by1 AS employee_no')
                                    ->where('department_code','like','%'.$sub11.'%')
                                    ->where('section_code','like','%'.$sub11.'%')
                                    ->first();
                                    if($tb_employee_evaluatorzx){
                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorzx->employee_no;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                    }
                                }


                                $sub2 = substr($value2->department_code,0,2);
                                $tb_section = DB::table('tb_section')
                                ->select(
                                    'id',
                                    'section_code',
                                    'section_description',
                                )
                                ->where('section_code','like',''.$sub2.'%')
                                ->orderBy('section_code','ASC')
                                ->get();
                                if(count($tb_division[$key]->tb_department)>0){
                                    $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                }
                                $evaluator = DB::table('tb_employee_evaluator')
                                ->select('tb_employee_evaluator.employee_no',
                                        'tb_employee_evaluator.employee_name_th',
                                        'tb_employee_evaluator.employee_name_en',
                                        'tb_employee_evaluator.division_code')
                                ->where('tb_employee_evaluator.evaluator_active','1')
                                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                ;

                                $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                if(count($evaluator) == 0){
                                    if($sub11 == "B2" || $sub11 == "B3" || $sub11 == "L2"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','000023')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else if($sub11 == "B6"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','990331')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                    }
                                }else{
                                    if($sub11 == "B2" || $sub11 == "B3" || $sub11 == "L2"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','000023')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else if($sub11 == "B6"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','990331')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                    }
                                }


                            }
                        }

                    }


                    // $evaluatorx[] = $evaluator;
                }
            }
        }else{
            if(count($tb_division)>0){
                foreach ($tb_division as $key => $value) {
                    $sub1 = substr($value->division_code,0,1);

                    $tb_evaluator_division = DB::table('tb_employee_evaluator')
                    ->where('division_code','like','%'.$value->division_code.'%')
                    ->whereIn('tb_employee_evaluator.position_code',$arrtop)
                    ->first();
                    if($tb_evaluator_division){
                        $tb_division[$key]->top = $tb_evaluator_division->employee_no;
                    }else{
                        $tb_division[$key]->top = '000002';
                    }
                    $tb_department = DB::table('tb_department')
                    ->select(
                        'id',
                        'department_code',
                        'department_description',
                    )
                    ->where('department_code','like',''.$sub1.'%')
                    ->orderBy('department_code','ASC')->get();


                    // echo "<pre>";
                    // print_r($tb_department);
                    // dd($tb_department);
                    // exit;
                    if(count($tb_department)>0){
                        $tb_division[$key]->tb_department = $tb_department;
                        $set_department = '';
                        if(!empty($tb_department)){
                            foreach($tb_department AS $valxx1){
                                $set_department .= $valxx1->department_code.',';
                            }
                        }
                        $sub_set_department = substr($set_department,0,-1);
                        $tb_division[$key]->set_department = $sub_set_department;
                        if(count($tb_division[$key]->tb_department)>0){
                            foreach ($tb_division[$key]->tb_department as $key2 => $value2) {
                                // dd($value2->department_code);
                                // exit;
                                $sub11 = substr($value2->department_code,0,2);
                                $sub_1 = substr($value2->department_code,0,1);
                                if($sub11 == "G3"){
                                    $tb_employee_evaluator11 = DB::table('tb_employee_evaluator')
                                    // ->where('department_code',$value2->department_code)
                                    // ->where('department_code','like',''.$sub11.'%')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('section_code','like','G3AC%')
                                    ->first();
                                    // dd($tb_employee_evaluator);
                                    // exit;
                                    if($tb_employee_evaluator11){
                                        $tb_division[$key]->tb_department[$key2]->G3AC = $tb_employee_evaluator11->employee_no;
                                    }else{
                                        if(trans(request()->segment(1)) == 'manager'){
                                            $tb_division[$key]->tb_department[$key2]->G3AC = '000002';
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->G3AC = '000026';
                                        }
                                    }
                                    $tb_employee_evaluator22 = DB::table('tb_employee_evaluator')
                                    // ->where('department_code',$value2->department_code)
                                    // ->where('department_code','like',''.$sub11.'%')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('section_code','like','G3TC%')
                                    ->first();
                                    // dd($tb_employee_evaluator);
                                    // exit;
                                    if($tb_employee_evaluator22){
                                        $tb_division[$key]->tb_department[$key2]->G3TC = $tb_employee_evaluator22->employee_no;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->G3TC = '000023';
                                    }
                                }else{
                                    if($sub_1 == '1' || $sub_1 == '2' || $sub_1 == '6' || $sub_1 == '7' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Y' || $sub_1 == 'Z'){
                                        $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                        ->where('department_code','like','%'.$value2->department_code.'%')
                                        ->whereIn('tb_employee_evaluator.position_code',$arr)
                                        ->first();
                                        // dd($tb_employee_evaluator);
                                        // exit;
                                        if($tb_employee_evaluator){
                                            $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                        }else{
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub_1 == '1' || $sub_1 == '6' || $sub_1 == '9' || $sub_1 == 'Z'){
                                                    $tb_employee_evaluatorsss = DB::table('tb_employee_evaluator')
                                                    ->where('department_code','like',''.$sub1.'%')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                    ->first();
                                                    if($tb_employee_evaluatorsss){
                                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->set_employee_no = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                        $tb_division[$key]->set_employee_no = '000026';
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }
                                                }else if($sub_1 == '8'){
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    $tb_division[$key]->set_employee_no = '000002';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    $tb_division[$key]->set_employee_no = '000026';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }
                                            }else{
                                                if($sub_1 == '1' || $sub_1 == '6' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Z'){
                                                    $tb_employee_evaluatorsss = DB::table('tb_employee_evaluator')
                                                    ->where('department_code','like',''.$sub1.'%')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                    ->first();
                                                    if($tb_employee_evaluatorsss){
                                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->set_employee_no = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                        $tb_division[$key]->set_employee_no = '000026';
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    $tb_division[$key]->set_employee_no = '000026';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }
                                            }
                                        }
                                    }else{
                                        if(trans(request()->segment(1)) == 'manager'){
                                            if($sub11 == "P3" || $sub11 == "P4"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000026')
                                                ->first();
                                            }else if($sub11 == "PD"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000002')
                                                ->first();
                                            }else if($sub11 == "PA"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000002')
                                                ->first();
                                            }else{
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                // ->where('department_code',$value2->department_code)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->where('section_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->first();
                                            }
                                        }else{
                                            if($sub11 == "P3" || $sub11 == "PD"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','013591')
                                                ->first();
                                            }else if($sub11 == "P1" || $sub11 == "P4"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000003')
                                                ->first();
                                            }else{
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                // ->where('department_code',$value2->department_code)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->where('section_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->first();
                                            }
                                        }



                                        // print_r($tb_employee_evaluator);
                                        // echo "<br>";
                                        // dd($sub11);
                                        // exit;
                                        if($tb_employee_evaluator){
                                            $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                        }else{
                                            $tb_employee_evaluatorzx = DB::table('tb_percent_department_action')
                                            ->select('approve_by1 AS employee_no')
                                            // ->where('department_code',$value2->department_code)
                                            ->where('department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','%'.$sub11.'%')
                                            // ->whereIn('tb_percent_department_action.position_code',$arrasst)
                                            ->first();

                                            // print_r($tb_employee_evaluatorzx);
                                            // echo "<br>";
                                            // dd($sub11);
                                            // exit;
                                            if($tb_employee_evaluatorzx){
                                                $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorzx->employee_no;
                                            }else{
                                                if(trans(request()->segment(1)) == 'manager'){
                                                    if($sub11 == "PA"){
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    }
                                                }else if(trans(request()->segment(1)) == 'mtl'){
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                }
                                            }
                                        }
                                    }

                                }


                                if($sub_1 == '1' || $sub_1 == '2' || $sub_1 == '6' || $sub_1 == '7' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Y' || $sub_1 == 'Z'){
                                    $sub2 = substr($value2->department_code,0,2);
                                    $tb_section = DB::table('tb_section')
                                    ->select(
                                        'id',
                                        'section_code',
                                        'section_description',
                                    )
                                    ->where('section_code','like',''.$sub2.'%')->get();
                                    if(count($tb_division[$key]->tb_department)>0){
                                        $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                    }

                                    $evaluator = DB::table('tb_employee_evaluator')
                                    ->select('tb_employee_evaluator.employee_no',
                                            'tb_employee_evaluator.employee_name_th',
                                            'tb_employee_evaluator.employee_name_en',
                                            'tb_employee_evaluator.division_code')
                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                    ;

                                    $evaluatorx = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                                    if(count($evaluatorx) == 0){
                                        $evaluator111 = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arrasst)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ;

                                        $evaluator111 = $evaluator111->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                                        if(count($evaluator111) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator111;
                                        }
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $evaluatorx;
                                    }
                                }else{
                                    if($sub11 == "G3"){
                                        $sub2 = substr($value2->department_code,0,2);
                                        $tb_section = DB::table('tb_section')
                                        ->select(
                                            'id',
                                            'section_code',
                                            'section_description',
                                        )
                                        ->where('section_code','like',''.$sub2.'%')
                                        ->orderBy('section_code','ASC')
                                        ->get();
                                        if(count($tb_division[$key]->tb_department)>0){
                                            $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                        }
                                        if(trans(request()->segment(1)) == 'manager'){
                                            $evaluatorG3AC = DB::table('tb_employee_evaluator')
                                            ->select('tb_employee_evaluator.employee_no',
                                                    'tb_employee_evaluator.employee_name_th',
                                                    'tb_employee_evaluator.employee_name_en',
                                                    'tb_employee_evaluator.division_code')
                                            ->where('tb_employee_evaluator.evaluator_active','1')
                                            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','G3AC%')
                                            ->orwhere('employee_no','000002')
                                            ;
                                        }else{
                                            $evaluatorG3AC = DB::table('tb_employee_evaluator')
                                            ->select('tb_employee_evaluator.employee_no',
                                                    'tb_employee_evaluator.employee_name_th',
                                                    'tb_employee_evaluator.employee_name_en',
                                                    'tb_employee_evaluator.division_code')
                                            ->where('tb_employee_evaluator.evaluator_active','1')
                                            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','G3AC%')
                                            ->orwhere('employee_no','000026')
                                            ;
                                        }


                                        $evaluatorG3AC = $evaluatorG3AC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluatorG3AC) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3AC = $topmanagement;
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3AC = $evaluatorG3AC;
                                        }
                                        $evaluatorG3TC = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                        ->where('section_code','like','G3TC%')
                                        ;

                                        $evaluatorG3TC = $evaluatorG3TC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluatorG3TC) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3TC = [];
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3TC = $evaluatorG3TC;
                                        }
                                    }else{
                                        $sub2 = substr($value2->department_code,0,2);
                                        $tb_section = DB::table('tb_section')
                                        ->select(
                                            'id',
                                            'section_code',
                                            'section_description',
                                        )
                                        ->where('section_code','like',''.$sub2.'%')
                                        ->orderBy('section_code','ASC')
                                        ->get();
                                        if(count($tb_division[$key]->tb_department)>0){
                                            $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                        }
                                        // echo $sub11."<br>";
                                        $evaluator = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                        ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                        ;

                                        $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluator) == 0){
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000002')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else if($sub11 == "P3" || $sub11 == "P4"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000026')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                                }
                                            }else{
                                                if($sub11 == "P3" || $sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','013591')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else if($sub11 == "P1" || $sub11 == "P4"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000003')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                                }
                                            }
                                        }else{
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub11 == "PD" || $sub11 == "PA"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000002')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                                }
                                            }else{
                                                if($sub11 == "P3" || $sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','013591')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                    }


                    // $evaluatorx[] = $evaluator;
                }
            }
        }
        $year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();

        return view('pages.setting.maintain.show',[
            "year" => $year,
            "topmanagement" => $topmanagement,
            "evaluator" => $evaluatorx,
            "division" => $tb_division,
            "topmanagement2" => $topmanagement2,
        ]);
    }

    public function setmanager(Request $request)
    {
        $code      = $request->input('code');
        $department_code      = $request->input('department_code');
        $section_code      = $request->input('section_code');
        $arr = ['105','106','103','114'];

        if($section_code == "G3AC"){
            $division_code = "G000";
            $department_code = "G300";
            $infonew = DB::table('tb_employee_evaluator')->where('tb_employee_evaluator.employee_no',$code)->first();
            DB::table('tb_employee_evaluator')->where('id', $infonew->id )
            ->update([
                "division_code" => $division_code,
                "department_code" => $department_code,
                "section_code" => $section_code,
            ]);
        }else if($section_code == "G3TC"){
            $division_code = "G000";
            $department_code = "G300";
            $infonew = DB::table('tb_employee_evaluator')->where('tb_employee_evaluator.employee_no',$code)->first();
            DB::table('tb_employee_evaluator')->where('id', $infonew->id )
            ->update([
                "division_code" => $division_code,
                "department_code" => $department_code,
                "section_code" => $section_code,
            ]);
        }else{
            $sub_dept = substr($department_code,0,1);
            if($sub_dept == '1' || $sub_dept == '2' || $sub_dept == '6' || $sub_dept == '7' || $sub_dept == '8' || $sub_dept == '9' || $sub_dept == 'Y' || $sub_dept == 'Z'){
                $tb_divi_ = DB::table('tb_division')->where('division_code','like',''.$sub_dept.'%')->first();
                $tb_section_ = DB::table('tb_section')->where('section_code','like',''.$sub_dept.'%')->get();
                $section_code_comma = '';
                if(!empty($tb_section_)){
                    foreach($tb_section_ AS $valxx){
                        $section_code_comma .= $valxx->section_code.',';
                    }
                }
                $infonew = DB::table('tb_employee_evaluator')->where('tb_employee_evaluator.employee_no',$code)->first();
                DB::table('tb_employee_evaluator')->where('id', $infonew->id )
                ->update([
                    "division_code" => $tb_divi_->division_code,
                    "department_code" => $department_code,
                    "section_code" => $section_code_comma
                ]);
            }else{

            }
            // $infoold = DB::table('tb_employee_evaluator')
            // ->where('tb_employee_evaluator.department_code','like','%'.$department_code.'%')
            // ->where('tb_employee_evaluator.section_code','like','%'.$section_code.'%')
            // ->where('tb_employee_evaluator.employee_no',$code)
            // ->first();
            // $infonew = DB::table('tb_employee_evaluator')->where('tb_employee_evaluator.employee_no',$code)->first();
            // DB::table('tb_employee_evaluator')->where('id', $infonew->id )
            // ->update([
            //     "division_code" => $division_code,
            //     "department_code" => $department_code,
            //     "section_code" => $section_code,
            // ]);
        }
        // $info = DB::table('tb_employee')
        // ->select('tb_employee.position_code',
        //         'tb_employee.position_description',
        //         'tb_employee.change_position_remark'
        // )
        // ->where('tb_employee.id',$id)
        // ->first();
        $result = [
            'code'                => $code,
            'department_code'                => $department_code,
            'section_code'=> $section_code
        ];
        echo json_encode($result);

    }

    public function update_manager(Request $request)
    {
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();


        if(trans(request()->segment(1)) == 'manager'){
            $arr = ['101','114'];
            $arroffice = ['101','114'];
            $arrasst = ['105'];
            $arr2 = ['101','114'];
            $arrtop = ['101','100'];
        }else if(trans(request()->segment(1)) == 'mtl'){
            $arr = ['101','114'];
            $arroffice = ['101','114','103','104','105','108'];
            $arrasst = ['103','104','105','108'];
            $arr2 = ['101','114'];
            $arrtop = ['101','100'];
        }else{
            $arr = ['105','103','114'];
            $arroffice = ['105','106','103','114'];
            $arrasst = ['106'];
            $arr2 = ['114'];
            $arrtop = ['101','100'];
        }

        $previousYear = date('Y');

        $topmanagement2 = DB::table('tb_percent_department_action')
        ->select('tb_percent_department_action.*')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year',$previousYear)
        ->orderBy('tb_percent_department_action.id', 'ASC')->get();

        $topmanagement = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->whereIn('tb_employee_evaluator.position_code',$arr2)
        ;



        $topmanagement = $topmanagement->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $tb_division = DB::table('tb_division')
        ->select(
            'id',
            'division_code',
            'division_description',
        )
        ->orderBy('division_code','ASC')
        ->get();

        $evaluatorx = [];
        if(trans(request()->segment(1)) == 'mtl'){
            if(count($tb_division)>0){
                foreach ($tb_division as $key => $value) {
                    $sub1 = substr($value->division_code,0,1);

                    $tb_evaluator_division = DB::table('tb_employee_evaluator')
                    ->where('division_code','like','%'.$value->division_code.'%')
                    ->whereIn('tb_employee_evaluator.position_code',$arrtop)
                    ->first();
                    $tb_division[$key]->top = '000002';

                    $tb_department = DB::table('tb_department')
                    ->select(
                        'id',
                        'department_code',
                        'department_description',
                    )
                    ->where('department_code','like',''.$sub1.'%')
                    ->orderBy('department_code','ASC')->get();


                    if(count($tb_department)>0){
                        $tb_division[$key]->tb_department = $tb_department;
                        $set_department = '';
                        if(!empty($tb_department)){
                            foreach($tb_department AS $valxx1){
                                $set_department .= $valxx1->department_code.',';
                            }
                        }
                        $sub_set_department = substr($set_department,0,-1);
                        $tb_division[$key]->set_department = $sub_set_department;
                        if(count($tb_division[$key]->tb_department)>0){
                            foreach ($tb_division[$key]->tb_department as $key2 => $value2) {

                                $sub11 = substr($value2->department_code,0,2);
                                $sub_1 = substr($value2->department_code,0,1);

                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                ->select('employee_no')
                                ->where('department_code','like','%'.$sub11.'%')
                                ->where('section_code','like','%'.$sub11.'%')
                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                ->first();

                                if($tb_employee_evaluator){
                                    $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                    $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                }else{
                                    $tb_employee_evaluatorzx = DB::table('tb_percent_department_action')
                                    ->select('approve_by1 AS employee_no')
                                    ->where('department_code','like','%'.$sub11.'%')
                                    ->where('section_code','like','%'.$sub11.'%')
                                    ->first();
                                    if($tb_employee_evaluatorzx){
                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorzx->employee_no;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                    }
                                }


                                $sub2 = substr($value2->department_code,0,2);
                                $tb_section = DB::table('tb_section')
                                ->select(
                                    'id',
                                    'section_code',
                                    'section_description',
                                )
                                ->where('section_code','like',''.$sub2.'%')
                                ->orderBy('section_code','ASC')
                                ->get();
                                if(count($tb_division[$key]->tb_department)>0){
                                    $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                }
                                $evaluator = DB::table('tb_employee_evaluator')
                                ->select('tb_employee_evaluator.employee_no',
                                        'tb_employee_evaluator.employee_name_th',
                                        'tb_employee_evaluator.employee_name_en',
                                        'tb_employee_evaluator.division_code')
                                ->where('tb_employee_evaluator.evaluator_active','1')
                                ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                ;

                                $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                if(count($evaluator) == 0){
                                    if($sub11 == "B2" || $sub11 == "B3" || $sub11 == "L2"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','000023')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else if($sub11 == "B6"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','990331')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                    }
                                }else{
                                    if($sub11 == "B2" || $sub11 == "B3" || $sub11 == "L2"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','000023')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else if($sub11 == "B6"){
                                        $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('employee_no','990331')
                                        ->orderBy('position_code','ASC')
                                        ->get();
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                    }
                                }


                            }
                        }

                    }


                    // $evaluatorx[] = $evaluator;
                }
            }
        }else{
            if(count($tb_division)>0){
                foreach ($tb_division as $key => $value) {
                    $sub1 = substr($value->division_code,0,1);

                    $tb_evaluator_division = DB::table('tb_employee_evaluator')
                    ->where('division_code','like','%'.$value->division_code.'%')
                    ->whereIn('tb_employee_evaluator.position_code',$arrtop)
                    ->first();
                    if($tb_evaluator_division){
                        $tb_division[$key]->top = $tb_evaluator_division->employee_no;
                    }else{
                        $tb_division[$key]->top = '000002';
                    }
                    $tb_department = DB::table('tb_department')
                    ->select(
                        'id',
                        'department_code',
                        'department_description',
                    )
                    ->where('department_code','like',''.$sub1.'%')
                    ->orderBy('department_code','ASC')->get();


                    // echo "<pre>";
                    // print_r($tb_department);
                    // dd($tb_department);
                    // exit;
                    if(count($tb_department)>0){
                        $tb_division[$key]->tb_department = $tb_department;
                        $set_department = '';
                        if(!empty($tb_department)){
                            foreach($tb_department AS $valxx1){
                                $set_department .= $valxx1->department_code.',';
                            }
                        }
                        $sub_set_department = substr($set_department,0,-1);
                        $tb_division[$key]->set_department = $sub_set_department;
                        if(count($tb_division[$key]->tb_department)>0){
                            foreach ($tb_division[$key]->tb_department as $key2 => $value2) {
                                // dd($value2->department_code);
                                // exit;
                                $sub11 = substr($value2->department_code,0,2);
                                $sub_1 = substr($value2->department_code,0,1);
                                if($sub11 == "G3"){
                                    $tb_employee_evaluator11 = DB::table('tb_employee_evaluator')
                                    // ->where('department_code',$value2->department_code)
                                    // ->where('department_code','like',''.$sub11.'%')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('section_code','like','G3AC%')
                                    ->first();
                                    // dd($tb_employee_evaluator);
                                    // exit;
                                    if($tb_employee_evaluator11){
                                        $tb_division[$key]->tb_department[$key2]->G3AC = $tb_employee_evaluator11->employee_no;
                                    }else{
                                        if(trans(request()->segment(1)) == 'manager'){
                                            $tb_division[$key]->tb_department[$key2]->G3AC = '000002';
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->G3AC = '000026';
                                        }
                                    }
                                    $tb_employee_evaluator22 = DB::table('tb_employee_evaluator')
                                    // ->where('department_code',$value2->department_code)
                                    // ->where('department_code','like',''.$sub11.'%')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('section_code','like','G3TC%')
                                    ->first();
                                    // dd($tb_employee_evaluator);
                                    // exit;
                                    if($tb_employee_evaluator22){
                                        $tb_division[$key]->tb_department[$key2]->G3TC = $tb_employee_evaluator22->employee_no;
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->G3TC = '000023';
                                    }
                                }else{
                                    if($sub_1 == '1' || $sub_1 == '2' || $sub_1 == '6' || $sub_1 == '7' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Y' || $sub_1 == 'Z'){
                                        $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                        ->where('department_code','like','%'.$value2->department_code.'%')
                                        ->whereIn('tb_employee_evaluator.position_code',$arr)
                                        ->first();
                                        // dd($tb_employee_evaluator);
                                        // exit;
                                        if($tb_employee_evaluator){
                                            // $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                        }else{
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub_1 == '1' || $sub_1 == '6' || $sub_1 == '9' || $sub_1 == 'Z'){
                                                    $tb_employee_evaluatorsss = DB::table('tb_employee_evaluator')
                                                    ->where('department_code','like',''.$sub1.'%')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                    ->first();
                                                    if($tb_employee_evaluatorsss){
                                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->set_employee_no = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                        $tb_division[$key]->set_employee_no = '000026';
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }
                                                }else if($sub_1 == '8'){
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    $tb_division[$key]->set_employee_no = '000002';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    $tb_division[$key]->set_employee_no = '000026';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }
                                            }else{
                                                if($sub_1 == '1' || $sub_1 == '6' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Z'){
                                                    $tb_employee_evaluatorsss = DB::table('tb_employee_evaluator')
                                                    ->where('department_code','like',''.$sub1.'%')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                    ->first();
                                                    if($tb_employee_evaluatorsss){
                                                        $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->set_employee_no = $tb_employee_evaluatorsss->employee_no;
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                        $tb_division[$key]->set_employee_no = '000026';
                                                        $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                    }
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    $tb_division[$key]->set_employee_no = '000026';
                                                    $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                                }
                                            }
                                        }
                                    }else{
                                        if(trans(request()->segment(1)) == 'manager'){
                                            if($sub11 == "P3" || $sub11 == "P4"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000026')
                                                ->first();
                                            }else if($sub11 == "PD"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000002')
                                                ->first();
                                            }else if($sub11 == "PA"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000002')
                                                ->first();
                                            }else{
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                // ->where('department_code',$value2->department_code)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->where('section_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->first();
                                            }
                                        }else{
                                            if($sub11 == "P3" || $sub11 == "PD"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','013591')
                                                ->first();
                                            }else if($sub11 == "P1" || $sub11 == "P4"){
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->orwhere('employee_no','000003')
                                                ->first();
                                            }else{
                                                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                                                ->select('employee_no')
                                                // ->where('department_code',$value2->department_code)
                                                ->where('department_code','like','%'.$sub11.'%')
                                                ->where('section_code','like','%'.$sub11.'%')
                                                ->whereIn('tb_employee_evaluator.position_code',$arr)
                                                ->first();
                                            }
                                        }



                                        // print_r($tb_employee_evaluator);
                                        // echo "<br>";
                                        // dd($sub11);
                                        // exit;
                                        if($tb_employee_evaluator){
                                            $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->set_employee_no = $tb_employee_evaluator->employee_no;
                                            $tb_division[$key]->tb_department[$key2]->sub11 = $sub11;
                                        }else{
                                            $tb_employee_evaluatorzx = DB::table('tb_percent_department_action')
                                            ->select('approve_by1 AS employee_no')
                                            // ->where('department_code',$value2->department_code)
                                            ->where('department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','%'.$sub11.'%')
                                            // ->whereIn('tb_percent_department_action.position_code',$arrasst)
                                            ->first();

                                            // print_r($tb_employee_evaluatorzx);
                                            // echo "<br>";
                                            // dd($sub11);
                                            // exit;
                                            if($tb_employee_evaluatorzx){
                                                $tb_division[$key]->tb_department[$key2]->dept = $tb_employee_evaluatorzx->employee_no;
                                            }else{
                                                if(trans(request()->segment(1)) == 'manager'){
                                                    if($sub11 == "PA"){
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    }
                                                }if(trans(request()->segment(1)) == 'manager'){
                                                    if($sub11 == "PA"){
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000002';
                                                    }else{
                                                        $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                    }
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->dept = '000026';
                                                }
                                            }
                                        }
                                    }

                                }


                                if($sub_1 == '1' || $sub_1 == '2' || $sub_1 == '6' || $sub_1 == '7' || $sub_1 == '8' || $sub_1 == '9' || $sub_1 == 'Y' || $sub_1 == 'Z'){
                                    $sub2 = substr($value2->department_code,0,2);
                                    $tb_section = DB::table('tb_section')
                                    ->select(
                                        'id',
                                        'section_code',
                                        'section_description',
                                    )
                                    ->where('section_code','like',''.$sub2.'%')->get();
                                    if(count($tb_division[$key]->tb_department)>0){
                                        $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                    }

                                    $evaluator = DB::table('tb_employee_evaluator')
                                    ->select('tb_employee_evaluator.employee_no',
                                            'tb_employee_evaluator.employee_name_th',
                                            'tb_employee_evaluator.employee_name_en',
                                            'tb_employee_evaluator.division_code')
                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                    ->whereIn('tb_employee_evaluator.position_code',$arr)
                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                    ;

                                    $evaluatorx = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                                    if(count($evaluatorx) == 0){
                                        $evaluator111 = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arrasst)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ;

                                        $evaluator111 = $evaluator111->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                                        if(count($evaluator111) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator111;
                                        }
                                    }else{
                                        $tb_division[$key]->tb_department[$key2]->evaluator = $evaluatorx;
                                    }
                                }else{
                                    if($sub11 == "G3"){
                                        $sub2 = substr($value2->department_code,0,2);
                                        $tb_section = DB::table('tb_section')
                                        ->select(
                                            'id',
                                            'section_code',
                                            'section_description',
                                        )
                                        ->where('section_code','like',''.$sub2.'%')
                                        ->orderBy('section_code','ASC')
                                        ->get();
                                        if(count($tb_division[$key]->tb_department)>0){
                                            $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                        }
                                        if(trans(request()->segment(1)) == 'manager'){
                                            $evaluatorG3AC = DB::table('tb_employee_evaluator')
                                            ->select('tb_employee_evaluator.employee_no',
                                                    'tb_employee_evaluator.employee_name_th',
                                                    'tb_employee_evaluator.employee_name_en',
                                                    'tb_employee_evaluator.division_code')
                                            ->where('tb_employee_evaluator.evaluator_active','1')
                                            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','G3AC%')
                                            ->orwhere('employee_no','000002')
                                            ;
                                        }else{
                                            $evaluatorG3AC = DB::table('tb_employee_evaluator')
                                            ->select('tb_employee_evaluator.employee_no',
                                                    'tb_employee_evaluator.employee_name_th',
                                                    'tb_employee_evaluator.employee_name_en',
                                                    'tb_employee_evaluator.division_code')
                                            ->where('tb_employee_evaluator.evaluator_active','1')
                                            ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                            ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                            ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                            ->where('section_code','like','G3AC%')
                                            ->orwhere('employee_no','000026')
                                            ;
                                        }


                                        $evaluatorG3AC = $evaluatorG3AC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluatorG3AC) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3AC = $topmanagement;
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3AC = $evaluatorG3AC;
                                        }
                                        $evaluatorG3TC = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                        ->where('section_code','like','G3TC%')
                                        ;

                                        $evaluatorG3TC = $evaluatorG3TC->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluatorG3TC) == 0){
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3TC = [];
                                        }else{
                                            $tb_division[$key]->tb_department[$key2]->evaluatorG3TC = $evaluatorG3TC;
                                        }
                                    }else{
                                        $sub2 = substr($value2->department_code,0,2);
                                        $tb_section = DB::table('tb_section')
                                        ->select(
                                            'id',
                                            'section_code',
                                            'section_description',
                                        )
                                        ->where('section_code','like',''.$sub2.'%')
                                        ->orderBy('section_code','ASC')
                                        ->get();
                                        if(count($tb_division[$key]->tb_department)>0){
                                            $tb_division[$key]->tb_department[$key2]->tb_section = $tb_section;
                                        }
                                        // echo $sub11."<br>";
                                        $evaluator = DB::table('tb_employee_evaluator')
                                        ->select('tb_employee_evaluator.employee_no',
                                                'tb_employee_evaluator.employee_name_th',
                                                'tb_employee_evaluator.employee_name_en',
                                                'tb_employee_evaluator.division_code')
                                        ->where('tb_employee_evaluator.evaluator_active','1')
                                        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                        ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                        ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                        ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                        ;

                                        $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('tb_employee_evaluator.position_code', 'ASC')->get();
                                        if(count($evaluator) == 0){
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000002')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else if($sub11 == "P3" || $sub11 == "P4"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000026')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                                }
                                            }else{
                                                if($sub11 == "P3" || $sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','013591')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else if($sub11 == "P1" || $sub11 == "P4"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000003')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $topmanagement;
                                                }
                                            }
                                        }else{
                                            if(trans(request()->segment(1)) == 'manager'){
                                                if($sub11 == "PD" || $sub11 == "PA"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','000002')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                                }
                                            }else{
                                                if($sub11 == "P3" || $sub11 == "PD"){
                                                    $tb_employee_evaluator11x = DB::table('tb_employee_evaluator')
                                                    ->where('tb_employee_evaluator.evaluator_active','1')
                                                    ->whereIn('tb_employee_evaluator.position_code',$arroffice)
                                                    ->where('tb_employee_evaluator.division_code','like','%'.$sub1.'%')
                                                    ->where('tb_employee_evaluator.department_code','like','%'.$sub11.'%')
                                                    ->where('tb_employee_evaluator.section_code','like','%'.$sub11.'%')
                                                    ->orwhere('employee_no','013591')
                                                    ->orderBy('position_code','ASC')
                                                    ->get();
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $tb_employee_evaluator11x;
                                                }else{
                                                    $tb_division[$key]->tb_department[$key2]->evaluator = $evaluator;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                    }


                    // $evaluatorx[] = $evaluator;
                }
            }
        }

        // dd($tb_division);
        // exit;


        /////////////////////////////////// code ได้รายชื่อ Manager พร้อม Department //////////////////////////////
        $allcheck = [];
        if(!empty($tb_division)){
            foreach($tb_division as $key => $value){
                if(!empty($tb_division[$key]->tb_department)){
                    foreach($tb_division[$key]->tb_department as $key2 => $value2){
                        $sub1 = substr($value->division_code,0,1);
                        $sub11 = substr($value2->department_code,0,2);
                        if($sub11 == "G3"){
                            $allcheck[$value2->G3AC] = [
                                "division_code"=>[],
                                "department_code"=>[],
                                "section_code"=>[],
                            ];
                            $allcheck[$value2->G3TC] = [
                                "division_code"=>[],
                                "department_code"=>[],
                                "section_code"=>[],
                            ];
                        }else{
                            if($sub1 == '1' || $sub1 == '2' || $sub1 == '6' || $sub1 == '7' || $sub1 == '8' || $sub1 == '9' || $sub1 == 'Y' || $sub1 == 'Z'){
                                $allcheck[$value2->dept] = [
                                "division_code"=>[],
                                "department_code"=>[],
                                "section_code"=>[],
                            ];
                            }else{
                                $allcheck[$value2->dept] = [
                                "division_code"=>[],
                                "department_code"=>[],
                                "section_code"=>[],
                            ];
                            }
                        }
                    }
                }
            }
        }
        if(!empty($tb_division)){
            foreach($tb_division as $key => $value){
                if(!empty($tb_division[$key]->tb_department)){
                    foreach($tb_division[$key]->tb_department as $key2 => $value2){
                        $sub1 = substr($value->division_code,0,1);
                        $sub11 = substr($value2->department_code,0,2);
                        if($sub11 == "G3"){
                            array_push($allcheck[$value2->G3AC]['department_code'],$value2->department_code);
                            array_push($allcheck[$value2->G3TC]['department_code'],$value2->department_code);
                            array_push($allcheck[$value2->G3AC]['section_code'],'G3AC');
                            array_push($allcheck[$value2->G3TC]['section_code'],'G3TC');
                        }else{
                            if($sub1 == '1' || $sub1 == '2' || $sub1 == '6' || $sub1 == '7' || $sub1 == '8' || $sub1 == '9' || $sub1 == 'Y' || $sub1 == 'Z'){
                                array_push($allcheck[$value2->dept]['department_code'],$value2->department_code);
                                $xxxtb_section = DB::table('tb_section')->where('section_code','like',''.$sub11.'%')->get();
                                if(count($xxxtb_section) > 0){
                                    foreach($xxxtb_section as $key3 => $value3){
                                        array_push($allcheck[$value2->dept]['section_code'],$value3->section_code);
                                    }
                                }
                            }else{
                                array_push($allcheck[$value2->dept]['department_code'],$value2->department_code);
                                $xxxtb_section = DB::table('tb_section')->where('section_code','like',''.$sub11.'%')->get();
                                if(count($xxxtb_section) > 0){
                                    foreach($xxxtb_section as $key3 => $value3){
                                        array_push($allcheck[$value2->dept]['section_code'],$value3->section_code);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if(!empty($allcheck)){
            foreach($allcheck as $key => $value){
                // dd($allcheck[$key]['department_code']);
                // if(!empty($value->department_code)){
                    foreach($allcheck[$key]['department_code'] as $key2 => $value2){
                        $sub1 = substr($value2,0,1);

                        $xxxtb_division = DB::table('tb_division')
                        ->where('tb_division.division_code','like',''.$sub1.'%')->first();
                        // dd($xxxtb_division);
                        array_push($allcheck[$key]['division_code'],$xxxtb_division->division_code);
                        // $tre = implode(",", $sub1);
                        // $caewf = explode(',',$tre);

                        // $tre = implode(",", $result3);
                    }
                // }
            }
        }
        if(!empty($allcheck)){
            foreach($allcheck as $key => $value){
                // dd($allcheck[$key]['department_code']);
                // if(!empty($value->department_code)){
                    $array_unique = array_unique( $value['division_code'] );
                    $allcheck[$key]['division_code'] = $array_unique;
                // }
            }
        }
        if(!empty($allcheck)){
            foreach($allcheck as $key => $value){
                $division_code_no_comma = implode(",", $allcheck[$key]['division_code']);
                $department_code_no_comma = implode(",", $allcheck[$key]['department_code']);
                $section_code_no_comma = implode(",", $allcheck[$key]['section_code']);
                $allcheck[$key]['division_code_no_comma'] = $division_code_no_comma;
                $allcheck[$key]['department_code_no_comma'] = $department_code_no_comma;
                $allcheck[$key]['section_code_no_comma'] = $section_code_no_comma;
            }
        }
        // dd($allcheck);
        // exit;





        /////////////////////////////////// code ได้รายชื่อ Manager พร้อม Department //////////////////////////////
        // $asd = [];
        // $checkmail = 0;
        if(!empty($allcheck)){
            foreach($allcheck as $key => $value){
                if(trans(request()->segment(1)) == 'manager'){
                    if($key != '000023'){
                        DB::table('tb_employee_evaluator')->where('employee_no', $key )
                        ->update([
                            "division_code" => $allcheck[$key]['division_code_no_comma'],
                            "department_code" => $allcheck[$key]['department_code_no_comma'],
                            "section_code" => $allcheck[$key]['section_code_no_comma']
                        ]);
                    }
                }else{
                    DB::table('tb_employee_evaluator')->where('employee_no', $key )
                    ->update([
                        "division_code" => $allcheck[$key]['division_code_no_comma'],
                        "department_code" => $allcheck[$key]['department_code_no_comma'],
                        "section_code" => $allcheck[$key]['section_code_no_comma']
                    ]);
                }

            }
        }


        //////////////////////////////////////////// Send mail to Manager & Asst.Manager ////////////////////////////////////////////
        // $checkmail = 0;
        // $rowusers = DB::table('users')
        // ->whereNotNull('email')->get();
        // if(!empty($rowusers)){
        //     foreach($rowusers as $key => $value){
        //         if($value->email){
        //             $six_digit_random_number = random_int(100000, 999999);
        //             DB::table('users')
        //             ->where('users.id', $value->id)
        //             ->update([
        //                 "password" => Hash::make(sprintf("%06d", $six_digit_random_number)),
        //             ]);
        //             $view_mail = '<html>
        //                                 <body>
        //                                 <p>Production Link for EPA (ฐานข้อมูลจริงที่ใช้ประเมินผล)</p>
        //                                 <a href="http://milepa" target="_blank"><p>http://milepa</p></a>
        //                                 <p>Username : '.$value->orisoft_code.'</p>
        //                                 <p>Password : '.$six_digit_random_number.'</p>
        //                                 <p>After you login to EPA, please change your password to new password immediately. </p>
        //                                 </body>
        //                             </html>';
        //             $arr = [$value->email];
        //             $arr = ['koranatsoi17@gmail.com'];
        //             $arr = array_unique( $arr );
        //             $save = Mail::send([], ['EPA Link for access EPA Production Database (MILEPA)'], function ($message) use ($view_mail,$arr) {
        //                 $message
        //                 ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
        //                 ->to($arr)
        //                 ->subject('EPA Link for access EPA Production Database (MILEPA)');
        //                 $message->html($view_mail);
        //             });
        //             if($save){
        //                 $checkmail = $checkmail;
        //             }
        //             else{
        //                 $checkmail++;
        //             }
        //         }
        //     }
        // }
        //////////////////////////////////////////// Send mail to Manager & Asst.Manager ////////////////////////////////////////////

        $result = [
            // "topmanagement" => $topmanagement,
            // "evaluator" => $evaluatorx,
            // "division" => $tb_division,
            "allcheck" => $allcheck,
            // "rowusers" => $rowusers,
            // "checkmail" => $checkmail,
        ];
        echo json_encode($result);

    }
    public function sendmail_manager(Request $request)
    {
        $search_year      = $request->input('search_year');
         //////////////////////////////////////////// Send mail to Manager & Asst.Manager ////////////////////////////////////////////
        $checkmail = 0;
        $rowusers = DB::table('tb_employee_evaluator')
        ->leftJoin('users','users.orisoft_code','=','tb_employee_evaluator.employee_no')
        ->where('tb_employee_evaluator.rec_year',$search_year)
        ->whereNotNull('users.email')->get();
        if(!empty($rowusers)){
            foreach($rowusers as $key => $value){
                if($value->email){
                    // $six_digit_random_number = random_int(100000, 999999);
                    // DB::table('users')
                    // ->where('users.id', $value->id)
                    // ->update([
                    //     "password" => Hash::make(sprintf("%06d", $six_digit_random_number)),
                    // ]);
                    if(trans(request()->segment(1)) == 'manager'){
                        $dbsegment = 'Manager';
                    }else if(trans(request()->segment(1)) == 'mtl'){
                        $dbsegment = 'MTL';
                    }else{
                        $dbsegment = 'MIL';
                    }
                    $view_mail = '<html>
                                        <body>
                                        <p>Production Link for EPA (ฐานข้อมูลจริงที่ใช้ประเมินผล) </p>
                                        <a href="http://milepa" target="_blank"><p>http://milepa</p></a>
                                        <p>Username : '.$value->orisoft_code.'</p>
                                        <p>After you login to EPA '.$dbsegment.' , please change your password to new password immediately. </p>
                                        </body>
                                    </html>';
                    $arr = [$value->email];
                    // $arr = ['koranatsoi17@gmail.com'];
                    $arr = array_unique( $arr );
                    $save = Mail::send([], ['EPA Link for access EPA Production Database (MILEPA)'], function ($message) use ($view_mail,$arr) {
                        $message
                        // ->from($address = 'koranatsoi17@gmail.com', $name = 'swadmin')
                        ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                        ->to($arr)
                        ->subject('EPA Link for access EPA Production Database (MILEPA)');
                        $message->html($view_mail);
                    });
                    if($save){
                        $checkmail = $checkmail;
                    }
                    else{
                        $checkmail++;
                    }
                }
            }
        }
        //////////////////////////////////////////// Send mail to Manager & Asst.Manager ////////////////////////////////////////////

        $result = [
            // "topmanagement" => $topmanagement,
            // "evaluator" => $evaluatorx,
            // "division" => $tb_division,
            // "allcheck" => $allcheck,
            "rowusers" => $rowusers,
            // "checkmail" => $checkmail,
        ];
        echo json_encode($result);

    }
    public function set_top(Request $request)
    {
        $code      = $request->input('code');
        $section_code      = $request->input('section_code');
        $previousYear = date('Y');

        DB::table('tb_percent_department_action')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year',$previousYear)
        ->where('tb_percent_department_action.section_code', $section_code )
        ->update([
            "approve_by2" => $code
        ]);

        // $topmanagement2 = DB::table('tb_percent_department_action')
        // ->select('tb_percent_department_action.*')
        // ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        // ->where('tb_percent_department.year',$previousYear)
        // ->where('tb_percent_department_action.section_code', $section_code )
        // ->get();

        $result = [
            'code'                => $code,
            'section_code'=> $section_code,
            // 'topmanagement2'=> $topmanagement2
        ];
        echo json_encode($result);

    }


}
