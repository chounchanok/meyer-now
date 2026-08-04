<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportFileEmployee;
use App\Imports\ImportFileEmployeeEvt;
use App\Imports\ImportFileEmployeeAttendance;
use App\Imports\ImportFileEmployeeScorePA;
use App\Imports\ImportFileEmployeeSalary;
use App\Imports\ImportFileUser;
use App\Imports\ImportFilePercent;

use App\Imports\ImportEmployee;
use App\Models\EmployeeLogModel;
use App\Models\ImportEmployeeModel;
use App\Models\EmployeeModel;
use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;

class UploadFileController extends Controller
{
    public function employeesGroup($parameters)
    {
        $search = Arr::get($parameters, 'search');
        $paginate = Arr::get($parameters, 'total', 15);
        $query = new EmployeeLogModel;
        if ($search) {
            $query = $query->where('TH_TITLE', 'LIKE', '%' . trim($search) . '%');
        }
        $query = $query->orderBy('ORISOFT_NO', 'asc');
        $results = $query->paginate($paginate);

        //group
        // $get_section = EmployeeLogModel::select('SECTION_CODE', 'SECTION_DESCRIPTION')
        //         ->groupby('SECTION_CODE', 'SECTION_DESCRIPTION')
        //         ->get();
        //     $get_division = EmployeeLogModel::select('DIVISION_CODE', 'DIVISION_DESCRIPTION')
        //         ->groupby('DIVISION_CODE', 'DIVISION_DESCRIPTION')
        //         ->get();
        //     $get_department = EmployeeLogModel::select('DEPARTMENT_CODE', 'DEPARTMENT_DESCRIPTION')
        //         ->groupby('DEPARTMENT_CODE', 'DEPARTMENT_DESCRIPTION')
        //         ->get();
        //     $get_position = EmployeeLogModel::select('POSITION_CODE', 'POSITION_DESCRIPTION')
        //         ->groupby('POSITION_CODE', 'POSITION_DESCRIPTION')
        //         ->get();

        //     foreach ($get_section as $section) {
        //         $existingSection = Section::where('section_code', $section->SECTION_CODE)->first();
        //         if (!$existingSection) {
        //             $input_section = new Section();
        //             $input_section->section_code = $section->SECTION_CODE;
        //             $input_section->section_description = $section->SECTION_DESCRIPTION;
        //             $input_section->save();
        //         }
        //     }
        //     foreach ($get_division as $division) {
        //         $existingDivision = Division::where('division_code', $division->DIVISION_CODE)->first();
        //         if (!$existingDivision) {
        //             $input_division = new Division();
        //             $input_division->division_code = $division->DIVISION_CODE;
        //             $input_division->division_description = $division->DIVISION_DESCRIPTION;
        //             $input_division->save();
        //         }
        //     }
        //     foreach ($get_department as $department) {
        //         $existingDepartment = Department::where('department_code', $department->DEPARTMENT_CODE)->first();
        //         if (!$existingDepartment) {
        //             $input_deparment = new Department();
        //             $input_deparment->department_code = $department->DEPARTMENT_CODE;
        //             $input_deparment->department_description = $department->DEPARTMENT_DESCRIPTION;
        //             $input_deparment->save();
        //         }
        //     }
        //     foreach ($get_position as $position) {
        //         $existingPosition = Position::where('POSITION_CODE', $position->POSITION_CODE)->first();
        //         if (!$existingPosition) {
        //             $input_position = new Position();
        //             $input_position->position_code = $position->POSITION_CODE;
        //             $input_position->position_description = $position->POSITION_DESCRIPTION;
        //             $input_position->save();
        //         }
        //     }

        return $results;
    }
    public function filesGroup($parameters)
    {
        $search = Arr::get($parameters, 'search');
        $paginate = Arr::get($parameters, 'total');
        $query = new ImportEmployeeModel;
        if ($search) {
            $query = $query->where('name', 'LIKE', '%' . trim($search) . '%');
        }
        $query = $query->orderBy('id_file', 'asc');
        $results = $query->paginate($paginate);
        return $results;
    }
    public function index(Request $request)
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        $employees = $this->employeesGroup($request->all());

        // $files = $this->filesGroup($request->all());
        // $files->pages = new \stdClass();
        // $files->pages->start = ($files->perPage() * $files->currentPage()) - $files->perPage();

        $files = DB::table('tb_import_employee')
                    ->select('tb_import_employee.id_file',
                            'tb_import_employee.name',
                            'tb_import_employee.path',
                            'tb_import_employee.created_at'
                    );
        
        $files = $files->orderBy('tb_import_employee.id_file', 'DESC')->get();

        $files2 = DB::table('tb_import_employee_evt')
                    ->select('tb_import_employee_evt.id',
                            'tb_import_employee_evt.name',
                            'tb_import_employee_evt.path',
                            'tb_import_employee_evt.created_at'
                    );
        
        $files2 = $files2->orderBy('tb_import_employee_evt.id', 'DESC')->get();

        $files3 = DB::table('tb_import_employee_attendance')
                    ->select('tb_import_employee_attendance.id',
                            'tb_import_employee_attendance.name',
                            'tb_import_employee_attendance.path',
                            'tb_import_employee_attendance.created_at'
                    );
        
        $files3 = $files3->orderBy('tb_import_employee_attendance.id', 'DESC')->get();

        $files4 = DB::table('tb_import_employee_score_pa')
                    ->select('tb_import_employee_score_pa.id',
                            'tb_import_employee_score_pa.name',
                            'tb_import_employee_score_pa.path',
                            'tb_import_employee_score_pa.created_at'
                    );
        
        $files4 = $files4->orderBy('tb_import_employee_score_pa.id', 'DESC')->get();

        $files5 = DB::table('tb_import_employee_salary')
                    ->select('tb_import_employee_salary.id',
                            'tb_import_employee_salary.name',
                            'tb_import_employee_salary.path',
                            'tb_import_employee_salary.created_at'
                    );
        
        $files5 = $files5->orderBy('tb_import_employee_salary.id', 'DESC')->get();

        $userID = Auth::user()->id;
        $orisoft_code = DB::table('users')
        ->select('orisoft_code')
        ->where('id',$userID)->first();

        $checkYear = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->where('rec_year','like','%'.$checkYear.'%')
        ->where('status_pa','<=','1')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYear)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')->where('pa_timeline_id', $tb_pa_timeline->id)->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 0){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }
        
        return view('pages.setting.uploadFile.index', [
            "employees" => $employees,
            "files" => $files,
            "files2" => $files2,
            "files3" => $files3,
            "files4" => $files4,
            "files5" => $files5,
            "orisoft_code" => $orisoft_code->orisoft_code
        ]);
    }

    public function detail(Request $request, $test,$id){
        $datarow = DB::table('tb_employee_log')
                    ->select('tb_employee_log.ID_FILE',
                            'tb_employee_log.ORISOFT_NO',
                            'tb_employee_log.ENG_TITLE',
                            'tb_employee_log.TH_TITLE',
                            'tb_employee_log.EMPLOYEE_LOCAL_NAME',
                            'tb_employee_log.EMPLOYEE_NAME',
                            'tb_employee_log.GRADE_CODE',
                            'tb_employee_log.DIVISION_CODE',
                            'tb_employee_log.DEPARTMENT_CODE',
                            'tb_employee_log.SECTION_CODE',
                            'tb_employee_log.POSITION_DESCRIPTION',
                            'tb_employee_log.SECTION_DESCRIPTION',
                            'tb_employee_log.DEPARTMENT_DESCRIPTION',
                            'tb_employee_log.DIVISION_DESCRIPTION',
                            'tb_employee_log.GRADE_DESCRIPTION'
                    )
                    ->where('ID_FILE',$id);
        
        $datarow = $datarow->orderBy('tb_employee_log.ID_FILE', 'DESC')->get();
        // return view('pages.setting.uploadFile.detail')->with('id',$id);
        return view('pages.setting.uploadFile.detail', [
            "id" => $id,
            "datarow" => $datarow,
        ]);
    }

    public function detail2(Request $request, $test,$id){
        $datarow = DB::table('tb_employee_evaluator_log')
        ->select('tb_employee_evaluator_log.*','tb_employee.employee_local_name_en AS name1')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator_log.employee_no')
        ->where('tb_employee_evaluator_log.id_file',$id)
        ->orderBy('tb_employee_evaluator_log.id_file', 'DESC')->get();

        if(count($datarow)>0){
            foreach ($datarow as $key => $value) {
                $data2 = DB::table('tb_employee')
                ->select('tb_employee.employee_local_name_en')
                ->where('tb_employee.orisoft_no', $value->approve_pa_score_by)
                ->first();
                if($data2){
                    $datarow[$key]->name2 = $data2->employee_local_name_en;
                }else{
                    $datarow[$key]->name2 = '';
                }
            }
        }
        return view('pages.setting.uploadFile.detail2', [
            "id" => $id,
            "datarow" => $datarow,
        ]);
    }

    public function detail3(Request $request, $test,$id){
        $datarow = DB::table('tb_employee_attendance_log')
        ->select('tb_employee_attendance_log.*','tb_employee.employee_local_name_en AS name1')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_attendance_log.employee_no')
        ->where('tb_employee_attendance_log.id_file',$id)
        ->orderBy('tb_employee_attendance_log.id_file', 'DESC')->get();

        return view('pages.setting.uploadFile.detail3', [
            "id" => $id,
            "datarow" => $datarow,
        ]);
    }

    public function detail4(Request $request, $test,$id){
        $datarow = DB::table('tb_employee_final_score_log')
        ->select('tb_employee_final_score_log.*','tb_employee.employee_local_name_en AS name1')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score_log.employee_no')
        ->where('tb_employee_final_score_log.id_file',$id)
        ->orderBy('tb_employee_final_score_log.id_file', 'DESC')->get();

        return view('pages.setting.uploadFile.detail4', [
            "id" => $id,
            "form" => $id,
            "datarow" => $datarow,
        ]);
    }

    public function detail5(Request $request, $test,$id){
        $datarow = DB::table('tb_employee_salary_log')
        ->where('tb_employee_salary_log.id_file',$id)
        ->orderBy('tb_employee_salary_log.id_file', 'DESC')->get();

        return view('pages.setting.uploadFile.detail5', [
            "id" => $id,
            "form" => $id,
            "datarow" => $datarow,
        ]);
    }

    public function master_group(){
        $datarow = DB::table('tb_employee')->select('grade_code','grade_description')->groupBy('grade_code')->get();
        if($datarow){
            foreach ($datarow as $key => $value) {
                $tb_grade_code = DB::table('tb_grade_code')->insert([
                    "grade_code" => $value->grade_code,
                    "grade_description" => $value->grade_description,
                    "created_by" => Auth::user()->id,
                    "created" => date('Y-m-d H:i:s')
                ]);
            }
        }
        $result = [
            'status'            => 200
        ];
        echo json_encode($result); 
    }

    public function covert($code)
    {
        if ($code < 100) {
            $a = "0000$code";
        } else if ($code < 1000) {
            $a = "000$code";

        } else if ($code < 10000) {
            $a = "00$code";

        } else if ($code < 100000) {
            $a = "0$code";

        } else {
            $a = "$code";

        }
        return $a;
    }
    public function import_employee(Request $request)
    {
        DB::beginTransaction();
        $file = new Arr;
        $import = new ImportEmployeeModel();

        if ($request->hasFile('excelFile_employee')) {
            $request->validate([
                'excelFile_employee' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
            ]);
            $file = $request->file('excelFile_employee');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $fileSave = date('Ymd-His') . '-' . $originalName;
        }
        $import->name = $originalName;
        $import->path = '/upload/employee/' . $fileSave;
        $import->size = $size;
        $import->created_at = date('Y:m:d H:i:s');

        if ($import->save()) {
            Excel::import(new ImportFileEmployee($import->id_file), $file);
            $file->move(public_path('upload/employee/'), $fileSave);
            DB::commit();
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'Data imported successfully!');
        } else {
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'fail!');
        }

    }

    public function import_employee_evt(Request $request)
    {
        DB::beginTransaction();
        $file = new Arr;
        if ($request->hasFile('excelFile_employee_evt')) {
            $request->validate([
                'excelFile_employee_evt' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
            ]);
            $file = $request->file('excelFile_employee_evt');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $fileSave = date('Ymd-His') . '-' . $originalName;
        }
        $id = DB::table('tb_import_employee_evt')->insertGetId([
            'name' => $originalName,
            'path' => '/upload/employee/' . $fileSave,
            'size' => $size,
            'created_at' => date('Y:m:d H:i:s')
        ]);
        // dd($id);
        // exit;
        if ($id != "") {
            Excel::import(new ImportFileEmployeeEvt($id), $file);
            $file->move(public_path('upload/employee/'), $fileSave);
            DB::commit();
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'Data imported successfully!');
        } else {
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'fail!');
        }

    }

    public function import_employee_attendance(Request $request)
    {
        // 1. ตรวจสอบและจัดการไฟล์ให้อยู่นอก Transaction (ถ้าไม่มีไฟล์จะได้ไม่ต้องเริ่ม Transaction)
        if (!$request->hasFile('excelFile_employee_attendance')) {
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('error', 'No file selected.');
        }

        $request->validate([
            'excelFile_employee_attendance' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
        ]);
        
        $file = $request->file('excelFile_employee_attendance');
        $originalName = $file->getClientOriginalName();
        $size = $file->getSize();
        $fileSave = date('Ymd-His') . '-' . $originalName;

        // 2. เริ่มเปิด Transaction
        DB::beginTransaction();
        
        try {
            $id = DB::table('tb_import_employee_attendance')->insertGetId([
                'name' => $originalName,
                'path' => '/upload/employee/' . $fileSave,
                'size' => $size,
                'created_at' => date('Y-m-d H:i:s') // แก้ไข format วันที่ให้ถูกต้องสำหรับ Database
            ]);

            if ($id != "") {
                // คำสั่งนี้น่าจะใช้เวลาทำงานนาน จึงต้องอยู่ใน try...catch
                Excel::import(new ImportFileEmployeeAttendance($id), $file);
                
                $file->move(public_path('upload/employee/'), $fileSave);
                
                // 3. ทำงานจบสมบูรณ์ บันทึกข้อมูลและปลดล็อก
                DB::commit();
                return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'Data imported successfully!');
            } else {
                DB::rollBack();
                return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('error', 'Failed to generate ID.');
            }

        } catch (\Exception $e) {
            // 4. หากมี Error กลางทาง (เช่น ข้อมูล Excel ผิดรูปแบบ หรือคอลัมน์ไม่ตรง)
            // ให้ Rollback และปลดล็อก Database ทันที ป้องกันปัญหา Timeout
            DB::rollBack();
            
            // แจ้งเตือน Error กลับไปยังหน้าเว็บ
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('error', 'Import Failed: ' . $e->getMessage());
        }
    }

    public function import_employee_score_pa(Request $request)
    {
        DB::beginTransaction();
        $file = new Arr;
        if ($request->hasFile('excelFile_employee_score_pa')) {
            $request->validate([
                'excelFile_employee_score_pa' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
            ]);
            $file = $request->file('excelFile_employee_score_pa');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $fileSave = date('Ymd-His') . '-' . $originalName;
        }
        $id = DB::table('tb_import_employee_score_pa')->insertGetId([
            'name' => $originalName,
            'path' => '/upload/employee/' . $fileSave,
            'size' => $size,
            'created_at' => date('Y:m:d H:i:s')
        ]);
        // dd($id);
        // exit;
        if ($id != "") {
            Excel::import(new ImportFileEmployeeScorePA($id), $file);
            $file->move(public_path('upload/employee/'), $fileSave);
            DB::commit();
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'Data imported successfully!');
        } else {
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'fail!');
        }

    }

    public function import_employee_salary(Request $request)
    {
        DB::beginTransaction();
        $file = new Arr;
        if ($request->hasFile('excelFile_employee_salary')) {
            $request->validate([
                'excelFile_employee_salary' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
            ]);
            $file = $request->file('excelFile_employee_salary');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $fileSave = date('Ymd-His') . '-' . $originalName;
        }
        $id = DB::table('tb_import_employee_salary')->insertGetId([
            'name' => $originalName,
            'path' => '/upload/employee/' . $fileSave,
            'size' => $size,
            'created_at' => date('Y:m:d H:i:s')
        ]);
        // dd($id);
        // exit;
        if ($id != "") {
            Excel::import(new ImportFileEmployeeSalary($id), $file);
            $file->move(public_path('upload/employee/'), $fileSave);
            DB::commit();
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'Data imported successfully!');
        } else {
            return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'fail!');
        }

    }

    public function import_user(Request $request)
    {
        DB::beginTransaction();
        $file = new Arr;
        if ($request->hasFile('excelFile_user')) {
            $request->validate([
                'excelFile_user' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
            ]);
            $file = $request->file('excelFile_user');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $fileSave = date('Ymd-His') . '-' . $originalName;
        }
        Excel::import(new ImportFileUser, $file);
        $file->move(public_path('upload/employee/'), $fileSave);
        DB::commit();
        return redirect(trans(request()->segment(1)).'/setting/uploadFile')->with('success', 'Data imported successfully!');
    }

    public function eva_excel($test)
    {
        $data0 = [];
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id',
                'tb_employee_final_score.evaluator_no',
                'tb_employee_final_score.evaluator_name_en',
                'tb_employee_final_score.evaluator_name_th',
                'tb_employee_evaluator.grade_code',
                'tb_employee_evaluator.position_description',
                'tb_employee_evaluator.division_code',
                'tb_employee_evaluator.group_description'
        )
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.evaluator_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereNotNull('tb_employee_final_score.evaluator_no');

        $gatall = $gatall->orderBy('tb_employee_final_score.evaluator_no','ASC')->groupby('tb_employee_final_score.evaluator_no')->get();

        
        

        $excel = public_path('upload/eva/')."Evaluator_checklist.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);

        $sheet = $spreadsheet->getActiveSheet();

        $x = 2;
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                $sheet->setCellValue('A'.$x, $value->evaluator_no);
                $sheet->setCellValue('B'.$x, $value->evaluator_name_en);
                $sheet->setCellValue('C'.$x, $value->evaluator_name_th);
                $sheet->setCellValue('D'.$x, $value->grade_code);
                $sheet->setCellValue('E'.$x, $value->position_description);
                $sheet->setCellValue('F'.$x, $value->division_code);
                $sheet->setCellValue('G'.$x, $value->group_description);
                $x++;
            }
        }
        $output_file = $previousYear.'-Evaluator checklist';
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$output_file.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function import_increase_percent(Request $request)
    {
        DB::beginTransaction();
        $file = new Arr;
        if ($request->hasFile('excelFile_increase_percent')) {
            $request->validate([
                'excelFile_increase_percent' => 'required|mimes:xlsx,xls|max:5120', // 5MB max size
            ]);
            $file = $request->file('excelFile_increase_percent');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $fileSave = date('Ymd-His') . '-' . $originalName;
        }
        Excel::import(new ImportFilePercent, $file);
        $file->move(public_path('upload/employee/'), $fileSave);
        DB::commit();
        return redirect(trans(request()->segment(1)).'/setting/manageDepartment')->with('success', 'Data imported successfully!');
    }
}
