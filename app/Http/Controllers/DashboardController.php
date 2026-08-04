<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users;
use App\Models\EmployeeEvaluator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\pa\Patimeline;
use App\Models\manage\ManageEmployee;
use Illuminate\Support\Facades\Hash;
class DashboardController extends Controller
{
    public function index(UsersDataTable $dataTable,Request $request)
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }

        $user_id = Auth::user()->id;
        $data1 = DB::table('users_model_has_roles')
        ->where('users_model_has_roles.model_id',$user_id);
        $data1 = $data1->first();

        $data2 = DB::table('users_role_has_permissions')
        ->where('users_role_has_permissions.role_id',$data1->role_id);
        $data2 = $data2->orderBy('permission_id','ASC')->first();

        $data3 = DB::table('users_permissions')
        ->where('users_permissions.id',$data2->permission_id)
        ->where('users_permissions.name','like','%view%');
        $data3 = $data3->orderBy('id','ASC')->first();

        $data4 = DB::table('users_roles')->where('users_roles.id',$data1->role_id)->first();
        if(!$data3){
            if($data4->name == "Admin"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view users%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "HR Manager"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view dashboards%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "HR Assistant"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view dashboards%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "Dept-Manager"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view review evaluate employees%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "Top Management"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view review salary%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "Evaluator"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view evaluate employees%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
        }

        if($data3->name == "view users"){
            addJavascriptFile('assets/js/custom/apps/user-management/users/list/add.js');
            // return $dataTable->render('pages.apps.user-management.users.list');
            return redirect()->route('meyer.user-management/users');
        }else if($data3->name == "view pa timeline history"){
            addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
            return redirect()->route('meyer.pa/timeline', [
                'year' => Patimeline::orderby('created', 'asc')->get(),
            ]);
        }else if($data3->name == "view task status tracking"){
            $department = DB::table('tb_department')->select('id','department_code','department_description')->get();
            return redirect()->route('meyer.pa/follow', [
                "department" => $department,
            ]);
        }else if($data3->name == "view evaluation criteria"){
            $datarow = DB::table('evaluation_criteria');
            $datarow = $datarow->orderBy('id', 'ASC')->get();
            return redirect()->route('meyer.formEvaluate/criteria', [
                "datarow" => $datarow,
            ]);
        }else if($data3->name == "view pa form groups"){
            $group_form = DB::table('group_form');
            $group_form = $group_form->orderBy('id', 'ASC')->get();
            return redirect()->route('meyer.formEvaluate/groupForm', [
                "datarow" => $group_form
            ]);
        }else if($data3->name == "view upload evaluators"){
            addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
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

            return redirect()->route('meyer.setting.uploadFile.index', [
                "files" => $files,
                "files2" => $files2,
                "files3" => $files3,
                "files4" => $files4,
                "files5" => $files5,
            ]);
        }else if($data3->name == "view employee"){
            return redirect()->route('meyer.setting.manageEmployee.index', [
                'manage' => ManageEmployee::orderby('created','asc')->get(),
            ]);
        }else if($data3->name == "view evaluate employees"){
            $section = DB::table('tb_section');
            $section = $section->orderBy('id', 'ASC')->get();
            return redirect()->route('meyer.evaluate', [
                "section" => $section
            ]);
            // return view('pages.evaluate.index', [
            //     "section" => $section
            // ]);
        }else if($data3->name == "view review pa results"){
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee.employee_local_name_th',
                    'tb_employee.employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

            $section = DB::table('tb_section');
            $section = $section->orderBy('id', 'ASC')->get();
            return redirect()->route('meyer.evaluateReview', [
                "division" => $division,
                "department" => $department,
                "evaluator" => $evaluator,
                "section" => $section
            ]);
            // return view('pages.evaluate.index', [
            //     "section" => $section
            // ]);
        }else if($data3->name == "view salary increase"){
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $section = DB::table('tb_section')->orderBy('id', 'ASC')->get();

            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->orderBy('tb_grade_action.id', 'ASC')->get();

            $budget = DB::table('tb_budget_action')
            ->select('tb_budget_action.*')
            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
            ->where('tb_budget.year',$previousYear)
            ->orderBy('tb_budget_action.id', 'ASC')->get();

            $percent_department = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->orderBy('tb_percent_department_action.id', 'ASC')->get();
            
            // if(date('Y-m') <= (date('Y').'-2')){
            //     $previousYear = date('Y', strtotime('-1 year'));
            // }else{
                $previousYear = date('Y');
            // }
            $data_all = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_in = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '0')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_reject = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '1')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_finish = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '2')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();
            
            return redirect()->route('meyer.salary', [
                "division" => $division,
                "department" => $department,
                "section" => $section,
                "bell_curve" => $bell_curve,
                "budget" => $budget,
                "percent_department" => $percent_department,
                "data_all" => $data_all,
                "data_in" => $data_in,
                "data_reject" => $data_reject,
                "data_finish" => $data_finish,
            ]);
        }else if($data3->name == "view review salary"){
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $section = DB::table('tb_section')->orderBy('id', 'ASC')->get();

            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->orderBy('tb_grade_action.id', 'ASC')->get();

            $budget = DB::table('tb_budget_action')
            ->select('tb_budget_action.*')
            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
            ->where('tb_budget.year',$previousYear)
            ->orderBy('tb_budget_action.id', 'ASC')->get();

            $percent_department = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->orderBy('tb_percent_department_action.id', 'ASC')->get();
            
            // if(date('Y-m') <= (date('Y').'-2')){
            //     $previousYear = date('Y', strtotime('-1 year'));
            // }else{
                $previousYear = date('Y');
            // }
            $data_all = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_in = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '0')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_reject = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '1')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_finish = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '2')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();
            return redirect()->route('meyer.salaryReview', [
                "division" => $division,
                "department" => $department,
                "section" => $section,
                "bell_curve" => $bell_curve,
                "budget" => $budget,
                "percent_department" => $percent_department,
                "data_all" => $data_all,
                "data_in" => $data_in,
                "data_reject" => $data_reject,
                "data_finish" => $data_finish,
            ]);
            // return view('pages.salaryReview.index', [
            //     "division" => $division,
            //     "department" => $department,
            //     "section" => $section,
            //     "bell_curve" => $bell_curve,
            //     "budget" => $budget,
            //     "percent_department" => $percent_department,
            //     "data_all" => $data_all,
            //     "data_in" => $data_in,
            //     "data_reject" => $data_reject,
            //     "data_finish" => $data_finish,
            // ]);
        }else if($data3->name == "view pa grading"){
            $position = DB::table('tb_position')->orderBy('id', 'ASC')->get();
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee.employee_local_name_th',
                    'tb_employee.employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

            $section = DB::table('tb_section');
            $section = $section->orderBy('id', 'ASC')->get();

            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->where('tb_grade_action.grade_name','!=','AR')
            ->where('tb_grade_action.grade_name','!=','P')
            ->where('tb_grade_action.grade_name','!=','U')
            ->where('tb_grade_action.grade_name','!=','CD')
            ->orderBy('tb_grade_action.id', 'ASC')->get();
            
            return redirect()->route('meyer.paGrading', [
                "position" => $position,
                "division" => $division,
                "department" => $department,
                "evaluator" => $evaluator,
                "section" => $section,
                "bell_curve" => $bell_curve,
            ]);
        }else if($data3->name == "view approve salary"){
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $section = DB::table('tb_section')->orderBy('id', 'ASC')->get();

            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->orderBy('tb_grade_action.id', 'ASC')->get();

            $budget = DB::table('tb_budget_action')
            ->select('tb_budget_action.*')
            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
            ->where('tb_budget.year',$previousYear)
            ->orderBy('tb_budget_action.id', 'ASC')->get();

            $percent_department = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->orderBy('tb_percent_department_action.id', 'ASC')->get();
            
            // if(date('Y-m') <= (date('Y').'-2')){
            //     $previousYear = date('Y', strtotime('-1 year'));
            // }else{
                $previousYear = date('Y');
            // }
            $data_all = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_in = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '0')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_reject = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '1')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();

            $data_finish = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->where('tb_employee_final_score.status_salary', '2')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->count();
            return redirect()->route('meyer.approveSalary', [
                "division" => $division,
                "department" => $department,
                "section" => $section,
                "bell_curve" => $bell_curve,
                "budget" => $budget,
                "percent_department" => $percent_department,
                "data_all" => $data_all,
                "data_in" => $data_in,
                "data_reject" => $data_reject,
                "data_finish" => $data_finish,
            ]);
        }else if($data3->name == "view review evaluate employees"){
            $year = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.rec_year')
            ->groupBy('tb_employee_final_score.rec_year')->get();

            $position = DB::table('tb_position')->orderBy('id', 'ASC')->get();
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee.employee_local_name_th',
                    'tb_employee.employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

            $section = DB::table('tb_section');
            $section = $section->orderBy('id', 'ASC')->get();
            return redirect()->route('meyer.ListEvaluator', [
                "year" => $year,
                "position" => $position,
                "division" => $division,
                "department" => $department,
                "evaluator" => $evaluator,
                "section" => $section
            ]);
            // return view('pages.ListEvaluator.index', [
            //     "year" => $year,
            //     "position" => $position,
            //     "division" => $division,
            //     "department" => $department,
            //     "evaluator" => $evaluator,
            //     "section" => $section
            // ]);
        }else if($data3->name == "view set evaluators pa form"){
            $position = DB::table('tb_position')->orderBy('id', 'ASC')->get();
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee.employee_local_name_th',
                    'tb_employee.employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

            $section = DB::table('tb_section');
            $section = $section->orderBy('id', 'ASC')->get();
            return redirect()->route('meyer.setEvaluator', [
                "position" => $position,
                "division" => $division,
                "department" => $department,
                "evaluator" => $evaluator,
                "section" => $section
            ]);
        }else{
            $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
            $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
            $section = DB::table('tb_section')->orderBy('id', 'ASC')->get();
            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->orderBy('tb_grade_action.id', 'ASC')->get();

            $search_year = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.rec_year')
            ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
            return view('pages.dashboards.index', [
                "division" => $division,
                "department" => $department,
                "section" => $section,
                "bell_curve" => $bell_curve,
                "search_year" => $search_year
            ]);
        }
        
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.dashboards.index');
    }
    
    public function get_dashboard1(Request $request)
    {
        $data[] = array(
            "div"=> 'div01',
            "dept"=> '1000',
            "sect"=> '875',
            "total1"=> 'xxxxx',
            "total2"=> 'xxxxx',
            "total3"=> 'xxxxx',
            "total4"=> '3.29%'
        );  
        $result = [
            'recordsTotal'    => 1,
            'recordsFiltered' => 1,
            'data'            => $data,
        ];
        echo json_encode($result); 
    }

    public function get_salary_adjust_old(Request $request)
    {
        $department_code      = $request->input('department_code');
        $section_code      = $request->input('section_code');
        // $search     = $request->input('search')['value'];
        // $start      = $request->input('start');
        // $pagestart  = $request->input('start')+1;
        // $length     = $request->input('length');
        // $field      = $request->input('order')[0]['column'];
        // $order      = $request->input('order')[0]['dir'];
        // $fieldby    = 'tb_employee_final_score.id';

        // $like = $request->Like;

        // if(empty($start)){
        //     $start = 0;
        // }

        // if(empty($length)){
        //     $length = 10;
        // }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $division_array = [];
        $alldata = [];
        $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        if(count($division)>0){
            foreach ($division as $key => $value) {
                $rowAR = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'AR');
                $rowAR = $rowAR->count();

                $rowP = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'P');
                $rowP = $rowP->count();

                $rowA = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'A');
                $rowA = $rowA->count();

                $rowB = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'B');
                $rowB = $rowB->count();

                $rowC = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'C');
                $rowC = $rowC->count();

                $rowD = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'D');
                $rowD = $rowD->count();

                $rowE = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'E');
                $rowE = $rowE->count();

                $rowU = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'U');
                $rowU = $rowU->count();

                $rowCD = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.division_code', $value->division_code)
                ->where('tb_employee_final_score.grade_proposed', 'CD');
                $rowCD = $rowCD->count();

                $alldata[] = array(
                    "division_code"=> $value->division_code,
                    "department_code"=> '',
                    "section_code"=> '',
                    "P"=> $rowP,
                    "AR"=> $rowAR,
                    "A"=> $rowA,
                    "B"=> $rowB,
                    "C"=> $rowC,
                    "D"=> $rowD,
                    "E"=> $rowE,
                    "U"=> $rowU,
                    "CD"=> $rowCD,
                    "Total"=> $rowP+$rowAR+$rowA+$rowB+$rowC+$rowD+$rowE+$rowU+$rowCD
                );
                // if($gatall>0){
                //     $alldata[$value->division_code] = $gatall;
                // }
            }
        }
        
        // $count_data = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        // if(!empty($search)){
        //     $gatall->where(function ($query) use($search) {
        //         $query->orWhere('tb_employee_final_score.employee_no','like','%'.$search.'%');
        //         $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
        //         $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
        //     });

        //     $count_data->where(function ($query) use($search) {
        //         $query->orWhere('tb_employee_final_score.employee_no','like','%'.$search.'%');
        //         $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
        //         $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
        //     });
        // }

        // if(empty($field)){
        //     $fieldby = 'tb_employee_final_score.employee_no';
        // }
        // else{
        //     if($field == 1){
        //         $fieldby = 'tb_employee_final_score.employee_no';
        //     }else if($field == 2){
        //         $fieldby = 'tb_employee.employee_local_name_en';
        //     }else if($field == 3){
        //         $fieldby = 'tb_employee.position_description';
        //     }else if($field == 4){
        //         $fieldby = 'tb_employee.division_description';
        //     }else if($field == 5){
        //         $fieldby = 'tb_employee.department_description';
        //     }else if($field == 6){
        //         $fieldby = 'tb_employee.section_description';
        //     }
        // }

        // if($order){
        //     $order = $order;
        // }
        // else{
        //     $order = 'asc';
        // }
        // $gatall = $gatall->orderBy($fieldby,$order)->get();

        // $count_data = $count_data->orderBy('tb_employee_final_score.id', 'ASC')->count();

        // if(count($gatall)>0){
        //     foreach ($gatall as $key => $value) {
        //         $data[] = array(
        //             "name"=> $value->employee_local_name_en,
        //             "position"=> $value->position_description,
        //             "group"=> "",
        //             "joindate"=> change_date($value->date_joined),
        //             "serviced"=> $value->service_days,
        //             "sl"=> $value->attendance_sl,
        //             "pl"=> $value->attendance_pl,
        //             "latet"=> '0',
        //             "lated"=> $value->attendance_late,
        //             "abst"=> $value->attendance_abt,
        //             "absd"=> $value->attendance_abs,"fieldby" =>  $fieldby,
        //             "orderby" =>  $order,
        //         ); 
        //         $pagestart++;
        //     }
        // }else{
        //     $data = [];
        // }

        // $totalRecords = $totalDisplay = $count_data;
        $result = [
            'recordsTotal'    => count($alldata),
            'recordsFiltered' => count($alldata),
            'data'            => $alldata
        ];
        echo json_encode($result);
    }

    public function get_salary_adjust(Request $request)
    {
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee_final_score.id';

        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_year       = $request->input('search_year');

        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
        // }

        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $data1 = DB::table('users_model_has_roles')
        // ->where('users_model_has_roles.model_id',$userID);
        // $data1->where(function ($query) {
        //     $query->orWhere('users_model_has_roles.role_id','3');
        //     $query->orWhere('users_model_has_roles.role_id','4');
        //     $query->orWhere('users_model_has_roles.role_id','7');
        // });
        // $data1 = $data1->count();
        
        // if($data1 == 0){
            // $division_code = DB::table('tb_employee_final_score')
            // ->select(
            // 'tb_employee.division_code'
            // )
            // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
            // $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
            // $new_division_code = [];
            // if(count($division_code)>0){
            //     foreach ($division_code as $value) {
            //         array_push($new_division_code,$value->division_code);
            //     }
            // }

            $section = DB::table('tb_employee_final_score')
            ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // ->whereIn('tb_employee.division_code',$new_division_code)
            ;
            $count_data = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // ->whereIn('tb_employee.division_code',$new_division_code)
            ;
            $orisoft_code = Auth::user()->orisoft_code;
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $section = $section->whereIn('tb_employee.division_code',$arr_division_code);
                $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);

                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $section = $section->whereIn('tb_employee.department_code',$arr_department_code);
                $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
            }
            if($orisoft_code == "000023"){
                if(trans(request()->segment(1)) != 'mtl'){
                    $section = $section->where('tb_employee.section_code','G3TC');
                    $count_data = $count_data->where('tb_employee.section_code','G3TC');
                }
            }
            if($orisoft_code == "000047"){
                $section = $section->where('tb_employee.section_code','G3AC');
                $count_data = $count_data->where('tb_employee.section_code','G3AC');
            }
        // }else{
        //     $section = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        //     $count_data = DB::table('tb_employee_final_score')
        //     ->select('tb_employee_final_score.id')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        //     $orisoft_code = Auth::user()->orisoft_code;
        //     $orisoft_all_code = DB::table('tb_employee_evaluator')
        // ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        // ->where('employee_no',$orisoft_code)->first();

        //     if($orisoft_code != "019492" && $orisoft_code != "000060"){
        //         $checka = strpos($orisoft_all_code->division_code,',');
        //         $arr_division_code = [];
        //         if($checka >= 0){
        //             $ex = explode(',',$orisoft_all_code->division_code);
        //             if(count($ex)>0){
        //                 foreach ($ex as $value) {
        //                     array_push($arr_division_code,$value);
        //                 }
        //             }
        //         }else{
        //             array_push($arr_division_code,$orisoft_all_code->division_code);
        //         }
        //         $section = $section->whereIn('tb_employee.division_code',$arr_division_code);
        //         $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);

        //         $arr_department_code = [];
        //         $checka = strpos($orisoft_all_code->department_code,',');
        //         if($checka >= 0){
        //             $ex = explode(',',$orisoft_all_code->department_code);
        //             if(count($ex)>0){
        //                 foreach ($ex as $value) {
        //                     array_push($arr_department_code,$value);
        //                 }
        //             }
        //         }else{
        //             array_push($arr_department_code,$orisoft_all_code->department_code);
        //         }
        //         $section = $section->whereIn('tb_employee.department_code',$arr_department_code);
        //         $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
        //     }
        // }
        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $section->whereIn('tb_employee.division_code', $search_division);
                $count_data->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $section->whereIn('tb_employee.department_code', $search_department);
                $count_data->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $section->whereIn('tb_employee.section_code', $search_section);
                $count_data->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search)){
            $section->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });
        }

        $fieldby = 'tb_employee.section_code';

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }
        $section = $section->groupBy('tb_employee.section_code');
        $section->orderBy($fieldby,$order);
        $section = $section->skip($start)->take($length)->get();

        $count_data = $count_data->groupBy('tb_employee.section_code')->get();
        // $count_data = $count_data->groupBy('tb_employee.section_code')->orderBy('tb_employee_final_score.id', 'ASC')->count();
        
        $division_array = [];
        $alldata = [];
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        if(count($section)>0){
            foreach ($section as $key => $value) {
                $rowAR = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'AR');
                $rowAR = $rowAR->count();

                $rowP = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'P');
                $rowP = $rowP->count();

                $rowA = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'A');
                $rowA = $rowA->count();

                $rowB = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'B');
                $rowB = $rowB->count();

                $rowC = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'C');
                $rowC = $rowC->count();

                $rowD = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'D');
                $rowD = $rowD->count();

                $rowE = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'E');
                $rowE = $rowE->count();

                $rowU = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'U');
                $rowU = $rowU->count();

                $rowCD = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'CD');
                $rowCD = $rowCD->count();

                $alldata[] = array(
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "P"=> '<div style="padding:16px;background: rgba(0, 158, 247, 0.10);">'.$rowP.'</div>',
                    "AR"=> '<div style="padding:16px;background: rgba(0, 158, 247, 0.10);">'.$rowAR.'</div>',
                    "A"=> '<div style="padding:16px;">'.$rowA.'</div>',
                    "B"=> '<div style="padding:16px;">'.$rowB.'</div>',
                    "C"=> '<div style="padding:16px;">'.$rowC.'</div>',
                    "D"=> '<div style="padding:16px;">'.$rowD.'</div>',
                    "E"=> '<div style="padding:16px;">'.$rowE.'</div>',
                    "U"=> '<div style="padding:16px;">'.$rowU.'</div>',
                    "CD"=> '<div style="padding:16px;">'.$rowCD.'</div>',
                    "Total"=> '<div style="padding:16px;background: rgba(114, 57, 234, 0.10);">'.$rowP+$rowAR+$rowA+$rowB+$rowC+$rowD+$rowE+$rowU+$rowCD.'</div>',
                );
            }
        }
        $totalRecords = $totalDisplay = count($count_data);
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $alldata
        ];
        echo json_encode($result);
    }

    public function get_salary_adjust_split(Request $request)
    {
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee_final_score.id';

        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_year       = $request->input('search_year');

        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
        // }

        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $data1 = DB::table('users_model_has_roles')
        // ->where('users_model_has_roles.model_id',$userID);
        // $data1->where(function ($query) {
        //     $query->orWhere('users_model_has_roles.role_id','3');
        //     $query->orWhere('users_model_has_roles.role_id','4');
        //     $query->orWhere('users_model_has_roles.role_id','7');
        // });
        // $data1 = $data1->count();
        
        // if($data1 == 0){
        //     $division_code = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.division_code'
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        //     $new_division_code = [];
        //     if(count($division_code)>0){
        //         foreach ($division_code as $value) {
        //             array_push($new_division_code,$value->division_code);
        //         }
        //     }

            $section = DB::table('tb_employee_final_score')
            ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // ->whereIn('tb_employee.division_code',$new_division_code)
            ;

            $count_data = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // ->whereIn('tb_employee.division_code',$new_division_code)
            ;

            $orisoft_code = Auth::user()->orisoft_code;
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            if(trans(request()->segment(1)) == 'manager'){

            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code != "000002" && $orisoft_code != "990002"){
                    $section->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                    $count_data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{
    
            }

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $section = $section->whereIn('tb_employee.division_code',$arr_division_code);
                $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);

                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $section = $section->whereIn('tb_employee.department_code',$arr_department_code);
                $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
            }
            if($orisoft_code == "000023"){
                if(trans(request()->segment(1)) != 'mtl'){
                    $section = $section->where('tb_employee.section_code','G3TC');
                    $count_data = $count_data->where('tb_employee.section_code','G3TC');
                }
            }
            if($orisoft_code == "000047"){
                $section = $section->where('tb_employee.section_code','G3AC');
                $count_data = $count_data->where('tb_employee.section_code','G3AC');
            }
        // }else{
        //     $section = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        //     $count_data = DB::table('tb_employee_final_score')
        //     ->select('tb_employee_final_score.id')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
        // }
        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $section->whereIn('tb_employee.division_code', $search_division);
                $count_data->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $section->whereIn('tb_employee.department_code', $search_department);
                $count_data->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $section->whereIn('tb_employee.section_code', $search_section);
                $count_data->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search)){
            $section->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });
        }

        $fieldby = 'tb_employee.section_code';

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }
        $section = $section->groupBy('tb_employee.section_code');
        $section->orderBy($fieldby,$order);
        $section = $section->skip($start)->take($length)->get();

        $count_data = $count_data->groupBy('tb_employee.section_code')->get();
        
        $division_array = [];
        $alldata = [];
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        if(count($section)>0){
            foreach ($section as $key => $value) {
                $rowAll = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code);
                $rowAll = $rowAll->count();

                $rowAR = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'AR');
                $rowAR = $rowAR->count();

                $rowP = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'P');
                $rowP = $rowP->count();

                $rowA = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'A');
                $rowA = $rowA->count();

                $rowB = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'B');
                $rowB = $rowB->count();

                $rowC = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'C');
                $rowC = $rowC->count();

                $rowD = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'D');
                $rowD = $rowD->count();

                $rowE = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'E');
                $rowE = $rowE->count();

                $rowU = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'U');
                $rowU = $rowU->count();

                $rowCD = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id','tb_employee_final_score.department_code','tb_employee_final_score.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.section_code', $value->section_code)
                ->where('tb_employee_final_score.grade_proposed', 'U');
                $rowCD = $rowCD->count();

                $countNoNull = $rowP+$rowAR+$rowA+$rowB+$rowC+$rowD+$rowE+$rowU+$rowCD;
                $sumP = 0;
                $sumAR = 0;
                $sumA = 0;
                $sumB = 0;
                $sumC = 0;
                $sumD = 0;
                $sumE = 0;
                $sumU = 0;
                $sumCD = 0;
                if($countNoNull > 0){
                    $sumP = (($rowP?$rowP:0)/$countNoNull)*100;
                    $sumAR = (($rowAR?$rowAR:0)/$countNoNull)*100;
                    $sumA = (($rowA?$rowA:0)/$countNoNull)*100;
                    $sumB = (($rowB?$rowB:0)/$countNoNull)*100;
                    $sumC = (($rowC?$rowC:0)/$countNoNull)*100;
                    $sumD = (($rowD?$rowD:0)/$countNoNull)*100;
                    $sumE = (($rowE?$rowE:0)/$countNoNull)*100;
                    $sumU = (($rowU?$rowU:0)/$countNoNull)*100;
                    $sumCD = (($rowCD?$rowCD:0)/$countNoNull)*100;
                }
                

                $alldata[] = array(
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "P"=> '<div style="padding:16px;background: rgba(0, 158, 247, 0.10);">'.number_format($sumP,1).'%</div>',
                    "AR"=> '<div style="padding:16px;background: rgba(0, 158, 247, 0.10);">'.number_format($sumAR,1).'%</div>',
                    "A"=> '<div style="padding:16px;">'.number_format($sumA,1).'%</div>',
                    "B"=> '<div style="padding:16px;">'.number_format($sumB,1).'%</div>',
                    "C"=> '<div style="padding:16px;">'.number_format($sumC,1).'%</div>',
                    "D"=> '<div style="padding:16px;">'.number_format($sumD,1).'%</div>',
                    "E"=> '<div style="padding:16px;">'.number_format($sumE,1).'%</div>',
                    "U"=> '<div style="padding:16px;">'.number_format($sumU,1).'%</div>',
                    "CD"=> '<div style="padding:16px;">'.number_format($sumCD,1).'%</div>',
                    "Total"=> '<div style="padding:16px;background: rgba(114, 57, 234, 0.10);">'.$sumP+$sumAR+$sumA+$sumB+$sumC+$sumD+$sumE+$sumU+$sumCD.'%</div>',
                );
            }
        }

        $totalRecords = $totalDisplay = count($count_data);
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $alldata
        ];
        echo json_encode($result);
    }

    public function get_summary_by_division_old(Request $request)
    {
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee_final_score.id';

        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }

        $division = DB::table('tb_employee_final_score')
        ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        $count_data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
            $checka = strpos($orisoft_all_code->division_code,',');
            $arr_division_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->division_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_division_code,$value);
                    }
                }
            }else{
                array_push($arr_division_code,$orisoft_all_code->division_code);
            }
            $division = $division->whereIn('tb_employee.division_code',$arr_division_code);
            $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);

            $arr_department_code = [];
            $checka = strpos($orisoft_all_code->department_code,',');
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->department_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_department_code,$value);
                    }
                }
            }else{
                array_push($arr_department_code,$orisoft_all_code->department_code);
            }
            $division = $division->whereIn('tb_employee.department_code',$arr_department_code);
            $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
        }
        if($orisoft_code == "000023"){
            if(trans(request()->segment(1)) != 'mtl'){
                $division = $division->where('tb_employee.section_code','G3TC');
                $count_data = $count_data->where('tb_employee.section_code','G3TC');
            }
        }
        if($orisoft_code == "000047"){
            $division = $division->where('tb_employee.section_code','G3AC');
            $count_data = $count_data->where('tb_employee.section_code','G3AC');
        }
        
        if(!empty($search)){
            $division->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });
        }

        $fieldby = 'tb_employee.division_code';

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }
        $division = $division->groupBy('tb_employee.division_code');
        $division->orderBy($fieldby,$order);
        $division = $division->skip($start)->take($length)->get();

        $count_data = $count_data->groupBy('tb_employee.division_code')->get();
        
        $division_array = [];
        $alldata = [];
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        if(count($division)>0){
            foreach ($division as $key => $value) {
                
                $total_count = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')                         
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no') 
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                $total_count->where('tb_employee.division_code',$value->division_code);
                $total_count = $total_count->count();

                $total_Daily_filter = DB::table('tb_employee_final_score')
                ->select( 
                    DB::raw('SUM(salary_old) AS current_salary_wage'),
                    DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                    DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                    DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                    DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                    DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                    DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                    DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                    DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                    DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                    DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                )                         
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                                 
                // ->where('tb_employee_final_score.salary_type','Daily')
                // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                ->where('tb_employee_final_score.salary_type','Daily')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.employee_status_description','Passed')
                ->where('tb_employee_final_score.freeze','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                
                ->whereNotNull('tb_employee_final_score.salary_old')
                ->whereNotNull('tb_employee_final_score.adjust_grade')
                ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                ;
                $total_Daily_filter->where('tb_employee.division_code',$value->division_code);
                $total_Daily_filter = $total_Daily_filter->first();

                if($total_Daily_filter->current_salary_wage > 0){
                    $cal = ((($total_Daily_filter->company_suggested_new_basic?$total_Daily_filter->company_suggested_new_basic:0)/($total_Daily_filter->current_salary_wage?$total_Daily_filter->current_salary_wage:0))-1)*100;
                    $total_Daily_filter->company_suggested_percent = $cal;
                }

                $total_Monthly_filter = DB::table('tb_employee_final_score')
                ->select( 
                    DB::raw('SUM(salary_old) AS current_salary_wage'),
                    DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                    DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                    DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                    DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                    DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                    DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                    DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                    DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                    DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                    DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                )                              
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                            
                // ->where('tb_employee_final_score.salary_type','Monthly')
                // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                
                ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                ->where('tb_employee_final_score.salary_type','Monthly')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.employee_status_description','Passed')
                ->where('tb_employee_final_score.freeze','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                
                ->whereNotNull('tb_employee_final_score.salary_old')
                ->whereNotNull('tb_employee_final_score.adjust_grade')
                ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                ;
                $total_Monthly_filter->where('tb_employee.division_code',$value->division_code);
                $total_Monthly_filter = $total_Monthly_filter->first();

                if($total_Monthly_filter->current_salary_wage_month > 0){
                    $cal = ((($total_Monthly_filter->company_suggested_new_basic?$total_Monthly_filter->company_suggested_new_basic:0)/($total_Monthly_filter->current_salary_wage_month?$total_Monthly_filter->current_salary_wage_month:0))-1)*100;
                    $total_Monthly_filter->company_suggested_percent = $cal;
                }
                
                $current_salary_wage = $total_Daily_filter->current_salary_wage+$total_Monthly_filter->current_salary_wage;
                $company_suggested_new_basic = $total_Daily_filter->company_suggested_new_basic+$total_Monthly_filter->company_suggested_new_basic;
                $company_suggested_percent = (($company_suggested_new_basic/$current_salary_wage)-1)*100;

                $current_salary_wage_month = $total_Daily_filter->current_salary_wage_month+$total_Monthly_filter->current_salary_wage_month;
                $new_salary_wage_month = $total_Daily_filter->new_salary_wage_month+$total_Monthly_filter->new_salary_wage_month;
                $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;

                $alldata[] = array(
                    "division_code"=> $value->division_code,
                    "Total1"=> ($total_count>0?number_format($total_count):''),
                    "Total2"=> ($current_salary_wage_month>0?number_format($current_salary_wage_month,2):''),
                    "Total3"=> ($new_salary_wage_month>0?number_format($new_salary_wage_month,2):''),
                    "Total4"=> ($inc_percent_proposed>0?number_format($inc_percent_proposed,2):'').'%'
                );
            }
        }

        

        $totalRecords = $totalDisplay = count($count_data);
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $alldata
        ];
        echo json_encode($result);
    }

    public function get_summary_by_division(Request $request)
    {
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee_final_score.id';

        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_year       = $request->input('search_year');

        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
        // }

        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $data1 = DB::table('users_model_has_roles')
        // ->where('users_model_has_roles.model_id',$userID);
        // $data1->where(function ($query) {
        //     $query->orWhere('users_model_has_roles.role_id','3');
        //     $query->orWhere('users_model_has_roles.role_id','4');
        //     $query->orWhere('users_model_has_roles.role_id','7');
        // });
        // $data1 = $data1->count();
        
        // if($data1 == 0){
            // $division_code = DB::table('tb_employee_final_score')
            // ->select(
            // 'tb_employee.division_code'
            // )
            // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
            // $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
            // $new_division_code = [];
            // if(count($division_code)>0){
            //     foreach ($division_code as $value) {
            //         array_push($new_division_code,$value->division_code);
            //     }
            // }
            $orisoft_code = Auth::user()->orisoft_code;
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            if($orisoft_code == "000026"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $alldata = [];
                foreach ($arr_division_code as $valuezzz) {
                    $division = DB::table('tb_employee_final_score')
                    ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee.division_code',$valuezzz)
                    ;

                    $count_data = DB::table('tb_employee_final_score')
                    ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee.division_code',$valuezzz)
                    ;

                    
                    if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                        
                        $arr_department_code = [];
                        $checka = strpos($orisoft_all_code->department_code,',');
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_all_code->department_code);
                        }
                        $division = $division->whereIn('tb_employee.department_code',$arr_department_code);
                        $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                    }
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $division->whereIn('tb_employee.division_code', $search_division);
                            $count_data->whereIn('tb_employee.division_code', $search_division);
                        }
                    }
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $division->whereIn('tb_employee.department_code', $search_department);
                            $count_data->whereIn('tb_employee.department_code', $search_department);
                        }
                    }
                    if(isset($search_section)){
                        if(count($search_section) > 0){
                            $division->whereIn('tb_employee.section_code', $search_section);
                            $count_data->whereIn('tb_employee.section_code', $search_section);
                        }
                    }
                    if(!empty($search)){
                        $division->where(function ($query) use($search) {
                            $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                            $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                            $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
                        });
                    }
            
                    $fieldby = 'tb_employee.division_code';
            
                    if($order){
                        $order = $order;
                    }
                    else{
                        $order = 'asc';
                    }
                    $division = $division->groupBy('tb_employee.division_code');
                    $division->orderBy($fieldby,$order);
                    $division = $division->skip($start)->take($length)->get();
                    
                    $count_data = $count_data->groupBy('tb_employee.division_code')->get();
                    // $count_data = $count_data->groupBy('tb_employee.section_code')->orderBy('tb_employee_final_score.id', 'ASC')->count();
                    
                    $division_array = [];
                    
                    // dd($division);
                    // exit;
                    $orisoft_code = Auth::user()->orisoft_code;
                    $orisoft_all_code = DB::table('tb_employee_evaluator')
                    ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                    ->where('employee_no',$orisoft_code)->first();
            
                    // dd($division);
                    // exit;
                    // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
                    if(count($division)>0){
                        foreach ($division as $key => $value) {
                            $divi = $value->division_code;
                            // dd($value->division_code);
                            // exit;
                            $total_count = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.id')                         
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no') 
                            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            ->where('tb_employee_final_score.status_evaluation', '3')   
                            ->where('tb_employee.employee_status_description','Passed')
                            ->where('tb_employee_final_score.freeze','1')
                            ->whereNot('tb_employee.grade_code','L810')
                            ->whereNot('tb_employee.grade_code','L820')
                            
                            ->whereNotNull('tb_employee_final_score.salary_old')
                            ->whereNotNull('tb_employee_final_score.adjust_grade')
                            ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                            ->where('tb_employee.division_code',$valuezzz)
                            ;
            
                            
            
                            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
            
                                $arr_department_code = [];
                                $checka = strpos($orisoft_all_code->department_code,',');
                                if($checka >= 0){
                                    $ex = explode(',',$orisoft_all_code->department_code);
                                    if(count($ex)>0){
                                        foreach ($ex as $value) {
                                            array_push($arr_department_code,$value);
                                        }
                                    }
                                }else{
                                    array_push($arr_department_code,$orisoft_all_code->department_code);
                                }
                                $total_count = $total_count->whereIn('tb_employee.department_code',$arr_department_code);
                            }else{
                                $total_count->where('tb_employee.division_code',$value->division_code);
                            }
                            if($orisoft_code == "000023"){
                                if(trans(request()->segment(1)) != 'mtl'){
                                    $total_count = $total_count->where('tb_employee.section_code','G3TC');
                                }
                            }
                            if($orisoft_code == "000047"){
                                $total_count = $total_count->where('tb_employee.section_code','G3AC');
                            }
                            if(isset($search_division)){
                                if(count($search_division) > 0){
                                    $total_count->whereIn('tb_employee.division_code', $search_division);
                                }
                            }
                            if(isset($search_department)){
                                if(count($search_department) > 0){
                                    $total_count->whereIn('tb_employee.department_code', $search_department);
                                }
                            }
                            if(isset($search_section)){
                                if(count($search_section) > 0){
                                    $total_count->whereIn('tb_employee.section_code', $search_section);
                                }
                            }
                            $total_count = $total_count->count();
            
                            $total_Daily_filter = DB::table('tb_employee_final_score')
                            ->select( 
                                DB::raw('SUM(salary_old) AS current_salary_wage'),
                                DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                                DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                                DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                                DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                                DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                                DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                                DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                                DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                                DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                                DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                            )                         
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                                 
                            // ->where('tb_employee_final_score.salary_type','Daily')
                            // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                            
                            ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                            ->where('tb_employee_final_score.salary_type','Daily')
                            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            ->where('tb_employee.employee_status_description','Passed')
                            ->where('tb_employee_final_score.freeze','1')
                            ->whereNot('tb_employee.grade_code','L810')
                            ->whereNot('tb_employee.grade_code','L820')
                            
                            ->whereNotNull('tb_employee_final_score.salary_old')
                            ->whereNotNull('tb_employee_final_score.adjust_grade')
                            ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                            ->where('tb_employee.division_code',$valuezzz)
                            ;
                            // $total_Daily_filter->where('tb_employee.division_code',$value->division_code);
            
                            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
            
                                $arr_department_code = [];
                                $checka = strpos($orisoft_all_code->department_code,',');
                                if($checka >= 0){
                                    $ex = explode(',',$orisoft_all_code->department_code);
                                    if(count($ex)>0){
                                        foreach ($ex as $value) {
                                            array_push($arr_department_code,$value);
                                        }
                                    }
                                }else{
                                    array_push($arr_department_code,$orisoft_all_code->department_code);
                                }
                                $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_code);
                            }else{
                                $total_Daily_filter->where('tb_employee.division_code',$value->division_code);
                            }
                            if($orisoft_code == "000023"){
                                if(trans(request()->segment(1)) != 'mtl'){
                                    $total_Daily_filter = $total_Daily_filter->where('tb_employee.section_code','G3TC');
                                }
                            }
                            if($orisoft_code == "000047"){
                                $total_Daily_filter = $total_Daily_filter->where('tb_employee.section_code','G3AC');
                            }
                            if(isset($search_division)){
                                if(count($search_division) > 0){
                                    $total_Daily_filter->whereIn('tb_employee.division_code', $search_division);
                                }
                            }
                            if(isset($search_department)){
                                if(count($search_department) > 0){
                                    $total_Daily_filter->whereIn('tb_employee.department_code', $search_department);
                                }
                            }
                            if(isset($search_section)){
                                if(count($search_section) > 0){
                                    $total_Daily_filter->whereIn('tb_employee.section_code', $search_section);
                                }
                            }
                            $total_Daily_filter = $total_Daily_filter->first();
            
                            if($total_Daily_filter->current_salary_wage > 0){
                                $cal = ((($total_Daily_filter->company_suggested_new_basic?$total_Daily_filter->company_suggested_new_basic:0)/($total_Daily_filter->current_salary_wage?$total_Daily_filter->current_salary_wage:0))-1)*100;
                                $total_Daily_filter->company_suggested_percent = $cal;
                            }
            
                            $total_Monthly_filter = DB::table('tb_employee_final_score')
                            ->select( 
                                DB::raw('SUM(salary_old) AS current_salary_wage'),
                                DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                                DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                                DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                                DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                                DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                                DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                                DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                                DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                                DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                                DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                            )                              
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                            
                            // ->where('tb_employee_final_score.salary_type','Monthly')
                            // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                            
                            ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                            ->where('tb_employee_final_score.salary_type','Monthly')
                            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            ->where('tb_employee.employee_status_description','Passed')
                            ->where('tb_employee_final_score.freeze','1')
                            ->whereNot('tb_employee.grade_code','L810')
                            ->whereNot('tb_employee.grade_code','L820')
                            
                            ->whereNotNull('tb_employee_final_score.salary_old')
                            ->whereNotNull('tb_employee_final_score.adjust_grade')
                            ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                            ->where('tb_employee.division_code',$valuezzz)
                            ;
                            
            
                            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002" ){
            
                                $arr_department_code = [];
                                $checka = strpos($orisoft_all_code->department_code,',');
                                if($checka >= 0){
                                    $ex = explode(',',$orisoft_all_code->department_code);
                                    if(count($ex)>0){
                                        foreach ($ex as $value) {
                                            array_push($arr_department_code,$value);
                                        }
                                    }
                                }else{
                                    array_push($arr_department_code,$orisoft_all_code->department_code);
                                }
                                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                            }else{
                                $total_Monthly_filter->where('tb_employee.division_code',$value->division_code);
                            }
                            if($orisoft_code == "000023"){
                                if(trans(request()->segment(1)) != 'mtl'){
                                    $total_Monthly_filter = $total_Monthly_filter->where('tb_employee.section_code','G3TC');
                                }
                            }
                            if($orisoft_code == "000047"){
                                $total_Monthly_filter = $total_Monthly_filter->where('tb_employee.section_code','G3AC');
                            }
                            if(isset($search_division)){
                                if(count($search_division) > 0){
                                    $total_Monthly_filter->whereIn('tb_employee.division_code', $search_division);
                                }
                            }
                            if(isset($search_department)){
                                if(count($search_department) > 0){
                                    $total_Monthly_filter->whereIn('tb_employee.department_code', $search_department);
                                }
                            }
                            if(isset($search_section)){
                                if(count($search_section) > 0){
                                    $total_Monthly_filter->whereIn('tb_employee.section_code', $search_section);
                                }
                            }
                            $total_Monthly_filter = $total_Monthly_filter->first();
            
                            if($total_Monthly_filter->current_salary_wage_month > 0){
                                $cal = ((($total_Monthly_filter->company_suggested_new_basic?$total_Monthly_filter->company_suggested_new_basic:0)/($total_Monthly_filter->current_salary_wage_month?$total_Monthly_filter->current_salary_wage_month:0))-1)*100;
                                $total_Monthly_filter->company_suggested_percent = $cal;
                            }
                            $current_salary_wage_month = 0;
                            $new_salary_wage_month = 0;
                            $inc_percent_proposed = 0;
                            if($total_Daily_filter->current_salary_wage_month >= 0 && $total_Monthly_filter->current_salary_wage_month >= 0){
                                $current_salary_wage_month = ($total_Daily_filter->current_salary_wage_month?$total_Daily_filter->current_salary_wage_month:0)+($total_Monthly_filter->current_salary_wage_month?$total_Monthly_filter->current_salary_wage_month:0);
                                $new_salary_wage_month = ($total_Daily_filter->new_salary_wage_month?$total_Daily_filter->new_salary_wage_month:0)+($total_Monthly_filter->new_salary_wage_month?$total_Monthly_filter->new_salary_wage_month:0);
                                if($current_salary_wage_month > 0){
                                    $inc_percent_proposed = ((($new_salary_wage_month!=0?$new_salary_wage_month:0)/($current_salary_wage_month!=0?$current_salary_wage_month:0))-1)*100;
                                }else{
                                    $inc_percent_proposed = 0;
                                }
                            }
                            
            
                            $alldata[] = array(
                                "total_Daily_filter"=> $total_Daily_filter,
                                "total_Monthly_filter"=> $total_Monthly_filter,
                                "division_code"=> $divi,
                                "Total1"=> ($total_count>0?number_format($total_count):''),
                                "Total2"=> ($current_salary_wage_month>0?number_format($current_salary_wage_month,2):''),
                                "Total3"=> ($new_salary_wage_month>0?number_format($new_salary_wage_month,2):''),
                                "Total4"=> ($inc_percent_proposed>0?number_format($inc_percent_proposed,2):'').'%'
                            );
                        }
                    }else{
                        $alldata[] = array(
                            "total_Daily_filter"=> '',
                            "total_Monthly_filter"=> '',
                            "division_code"=> $valuezzz,
                            "Total1"=> '',
                            "Total2"=> '',
                            "Total3"=> '',
                            "Total4"=> '%'
                        );
                    }
                }
                
            }else{
                $division = DB::table('tb_employee_final_score')
                ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->whereIn('tb_employee.division_code',$new_division_code)
                ;

                $count_data = DB::table('tb_employee_final_score')
                ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->whereIn('tb_employee.division_code',$new_division_code)
                ;

                
                if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                    $checka = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_all_code->division_code);
                    }
                    $division = $division->whereIn('tb_employee.division_code',$arr_division_code);
                    $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);

                    $arr_department_code = [];
                    $checka = strpos($orisoft_all_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_all_code->department_code);
                    }
                    $division = $division->whereIn('tb_employee.department_code',$arr_department_code);
                    $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                }
                if($orisoft_code == "000023"){
                    if(trans(request()->segment(1)) != 'mtl'){
                        $division = $division->where('tb_employee.section_code','G3TC');
                        $count_data = $count_data->where('tb_employee.section_code','G3TC');
                    }
                }
                if($orisoft_code == "000047"){
                    $division = $division->where('tb_employee.section_code','G3AC');
                    $count_data = $count_data->where('tb_employee.section_code','G3AC');
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $division->whereIn('tb_employee.division_code', $search_division);
                        $count_data->whereIn('tb_employee.division_code', $search_division);
                    }
                }
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $division->whereIn('tb_employee.department_code', $search_department);
                        $count_data->whereIn('tb_employee.department_code', $search_department);
                    }
                }
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $division->whereIn('tb_employee.section_code', $search_section);
                        $count_data->whereIn('tb_employee.section_code', $search_section);
                    }
                }
                if(!empty($search)){
                    $division->where(function ($query) use($search) {
                        $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                        $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                        $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
                    });
                }
        
                $fieldby = 'tb_employee.division_code';
        
                if($order){
                    $order = $order;
                }
                else{
                    $order = 'asc';
                }
                $division = $division->groupBy('tb_employee.division_code');
                $division->orderBy($fieldby,$order);
                $division = $division->skip($start)->take($length)->get();
                
                $count_data = $count_data->groupBy('tb_employee.division_code')->get();
                // $count_data = $count_data->groupBy('tb_employee.section_code')->orderBy('tb_employee_final_score.id', 'ASC')->count();
                
                $division_array = [];
                $alldata = [];
                // dd($division);
                // exit;
                $orisoft_code = Auth::user()->orisoft_code;
                $orisoft_all_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();
        
                // dd($division);
                // exit;
                // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
                if(count($division)>0){
                    foreach ($division as $key => $value) {
                        $divi = $value->division_code;
                        // dd($value->division_code);
                        // exit;
                        $total_count = DB::table('tb_employee_final_score')
                        ->select('tb_employee_final_score.id')                         
                        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no') 
                        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                        ->where('tb_employee_final_score.status_evaluation', '3')   
                        ->where('tb_employee.employee_status_description','Passed')
                        ->where('tb_employee_final_score.freeze','1')
                        ->whereNot('tb_employee.grade_code','L810')
                        ->whereNot('tb_employee.grade_code','L820')
                        
                        ->whereNotNull('tb_employee_final_score.salary_old')
                        ->whereNotNull('tb_employee_final_score.adjust_grade')
                        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                        ;
        
                        
        
                        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                            $checka = strpos($orisoft_all_code->division_code,',');
                            $arr_division_code = [];
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->division_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_division_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_division_code,$orisoft_all_code->division_code);
                            }
                            $total_count = $total_count->whereIn('tb_employee.division_code',$arr_division_code);
        
                            $arr_department_code = [];
                            $checka = strpos($orisoft_all_code->department_code,',');
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_all_code->department_code);
                            }
                            $total_count = $total_count->whereIn('tb_employee.department_code',$arr_department_code);
                        }else{
                            $total_count->where('tb_employee.division_code',$value->division_code);
                        }
                        if($orisoft_code == "000023"){
                            if(trans(request()->segment(1)) != 'mtl'){
                                $total_count = $total_count->where('tb_employee.section_code','G3TC');
                            }
                        }
                        if($orisoft_code == "000047"){
                            $total_count = $total_count->where('tb_employee.section_code','G3AC');
                        }
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $total_count->whereIn('tb_employee.division_code', $search_division);
                            }
                        }
                        if(isset($search_department)){
                            if(count($search_department) > 0){
                                $total_count->whereIn('tb_employee.department_code', $search_department);
                            }
                        }
                        if(isset($search_section)){
                            if(count($search_section) > 0){
                                $total_count->whereIn('tb_employee.section_code', $search_section);
                            }
                        }
                        $total_count = $total_count->count();
        
                        $total_Daily_filter = DB::table('tb_employee_final_score')
                        ->select( 
                            DB::raw('SUM(salary_old) AS current_salary_wage'),
                            DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                            DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                            DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                            DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                            DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                            DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                            DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                            DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                            DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                            DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                        )                         
                        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                                 
                        // ->where('tb_employee_final_score.salary_type','Daily')
                        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                        // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                        
                        ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                        ->where('tb_employee_final_score.salary_type','Daily')
                        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                        ->where('tb_employee.employee_status_description','Passed')
                        ->where('tb_employee_final_score.freeze','1')
                        ->whereNot('tb_employee.grade_code','L810')
                        ->whereNot('tb_employee.grade_code','L820')
                        
                        ->whereNotNull('tb_employee_final_score.salary_old')
                        ->whereNotNull('tb_employee_final_score.adjust_grade')
                        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                        ;
                        // $total_Daily_filter->where('tb_employee.division_code',$value->division_code);
        
                        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                            $checka = strpos($orisoft_all_code->division_code,',');
                            $arr_division_code = [];
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->division_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_division_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_division_code,$orisoft_all_code->division_code);
                            }
                            $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_division_code);
        
                            $arr_department_code = [];
                            $checka = strpos($orisoft_all_code->department_code,',');
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_all_code->department_code);
                            }
                            $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_code);
                        }else{
                            $total_Daily_filter->where('tb_employee.division_code',$value->division_code);
                        }
                        if($orisoft_code == "000023"){
                            if(trans(request()->segment(1)) != 'mtl'){
                                $total_Daily_filter = $total_Daily_filter->where('tb_employee.section_code','G3TC');
                            }
                        }
                        if($orisoft_code == "000047"){
                            $total_Daily_filter = $total_Daily_filter->where('tb_employee.section_code','G3AC');
                        }
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $total_Daily_filter->whereIn('tb_employee.division_code', $search_division);
                            }
                        }
                        if(isset($search_department)){
                            if(count($search_department) > 0){
                                $total_Daily_filter->whereIn('tb_employee.department_code', $search_department);
                            }
                        }
                        if(isset($search_section)){
                            if(count($search_section) > 0){
                                $total_Daily_filter->whereIn('tb_employee.section_code', $search_section);
                            }
                        }
                        $total_Daily_filter = $total_Daily_filter->first();
        
                        if($total_Daily_filter->current_salary_wage > 0){
                            $cal = ((($total_Daily_filter->company_suggested_new_basic?$total_Daily_filter->company_suggested_new_basic:0)/($total_Daily_filter->current_salary_wage?$total_Daily_filter->current_salary_wage:0))-1)*100;
                            $total_Daily_filter->company_suggested_percent = $cal;
                        }
        
                        $total_Monthly_filter = DB::table('tb_employee_final_score')
                        ->select( 
                            DB::raw('SUM(salary_old) AS current_salary_wage'),
                            DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                            DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                            DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                            DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                            DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                            DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                            DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                            DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                            DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                            DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                        )                              
                        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                            
                        // ->where('tb_employee_final_score.salary_type','Monthly')
                        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                        // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                        
                        ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                        ->where('tb_employee_final_score.salary_type','Monthly')
                        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                        ->where('tb_employee.employee_status_description','Passed')
                        ->where('tb_employee_final_score.freeze','1')
                        ->whereNot('tb_employee.grade_code','L810')
                        ->whereNot('tb_employee.grade_code','L820')
                        
                        ->whereNotNull('tb_employee_final_score.salary_old')
                        ->whereNotNull('tb_employee_final_score.adjust_grade')
                        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                        ;
                        
        
                        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                            $checka = strpos($orisoft_all_code->division_code,',');
                            $arr_division_code = [];
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->division_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_division_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_division_code,$orisoft_all_code->division_code);
                            }
                            $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
        
                            $arr_department_code = [];
                            $checka = strpos($orisoft_all_code->department_code,',');
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_all_code->department_code);
                            }
                            $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                        }else{
                            $total_Monthly_filter->where('tb_employee.division_code',$value->division_code);
                        }
                        if($orisoft_code == "000023"){
                            if(trans(request()->segment(1)) != 'mtl'){
                                $total_Monthly_filter = $total_Monthly_filter->where('tb_employee.section_code','G3TC');
                            }
                        }
                        if($orisoft_code == "000047"){
                            $total_Monthly_filter = $total_Monthly_filter->where('tb_employee.section_code','G3AC');
                        }
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $total_Monthly_filter->whereIn('tb_employee.division_code', $search_division);
                            }
                        }
                        if(isset($search_department)){
                            if(count($search_department) > 0){
                                $total_Monthly_filter->whereIn('tb_employee.department_code', $search_department);
                            }
                        }
                        if(isset($search_section)){
                            if(count($search_section) > 0){
                                $total_Monthly_filter->whereIn('tb_employee.section_code', $search_section);
                            }
                        }
                        $total_Monthly_filter = $total_Monthly_filter->first();
        
                        if($total_Monthly_filter->current_salary_wage_month > 0){
                            $cal = ((($total_Monthly_filter->company_suggested_new_basic?$total_Monthly_filter->company_suggested_new_basic:0)/($total_Monthly_filter->current_salary_wage_month?$total_Monthly_filter->current_salary_wage_month:0))-1)*100;
                            $total_Monthly_filter->company_suggested_percent = $cal;
                        }
                        $current_salary_wage_month = 0;
                        $new_salary_wage_month = 0;
                        $inc_percent_proposed = 0;
                        if($total_Daily_filter->current_salary_wage_month > 0){
                            $current_salary_wage_month = ($total_Daily_filter->current_salary_wage_month?$total_Daily_filter->current_salary_wage_month:0)+($total_Monthly_filter->current_salary_wage_month?$total_Monthly_filter->current_salary_wage_month:0);
                            $new_salary_wage_month = ($total_Daily_filter->new_salary_wage_month?$total_Daily_filter->new_salary_wage_month:0)+($total_Monthly_filter->new_salary_wage_month?$total_Monthly_filter->new_salary_wage_month:0);
                            $inc_percent_proposed = ((($new_salary_wage_month!=0?$new_salary_wage_month:0)/($current_salary_wage_month!=0?$current_salary_wage_month:0))-1)*100;
                        }
                        
        
                        $alldata[] = array(
                            "total_Daily_filter"=> $total_Daily_filter,
                            "total_Monthly_filter"=> $total_Monthly_filter,
                            "division_code"=> $divi,
                            "Total1"=> ($total_count>0?number_format($total_count):''),
                            "Total2"=> ($current_salary_wage_month>0?number_format($current_salary_wage_month,2):''),
                            "Total3"=> ($new_salary_wage_month>0?number_format($new_salary_wage_month,2):''),
                            "Total4"=> ($inc_percent_proposed>0?number_format($inc_percent_proposed,2):'').'%'
                        );
                    }
                }
            }
            
        // }else{
        //     $division = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        //     $count_data = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
        // }
        

        
        
        $totalRecords = $totalDisplay = count($count_data);
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $alldata
        ];
        echo json_encode($result);
    }
    
    public function get_approved_budget(Request $request)
    {
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee_final_score.id';

        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_year       = $request->input('search_year');
        
        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
        // }

        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        
        
        // $data1 = DB::table('users_model_has_roles')
        // ->where('users_model_has_roles.model_id',$userID);
        // $data1->where(function ($query) {
        //     $query->orWhere('users_model_has_roles.role_id','3');
        //     $query->orWhere('users_model_has_roles.role_id','4');
        //     $query->orWhere('users_model_has_roles.role_id','7');
        // });
        // $data1 = $data1->count();
        
        // if($data1 == 0){
        //     $division_code = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.division_code'
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        //     $new_division_code = [];
        //     if(count($division_code)>0){
        //         foreach ($division_code as $value) {
        //             array_push($new_division_code,$value->division_code);
        //         }
        //     }
            $section = DB::table('tb_employee_final_score')
            ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // ->whereIn('tb_employee.division_code',$new_division_code)
            ;

            $count_data = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // ->whereIn('tb_employee.division_code',$new_division_code)
            ;

            $orisoft_code = Auth::user()->orisoft_code;
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $section = $section->whereIn('tb_employee.division_code',$arr_division_code);
                $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);

                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $section = $section->whereIn('tb_employee.department_code',$arr_department_code);
                $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
            }
            if($orisoft_code == "000023"){
                if(trans(request()->segment(1)) != 'mtl'){
                    $section = $section->where('tb_employee.section_code','G3TC');
                    $count_data = $count_data->where('tb_employee.section_code','G3TC');
                }
            }
            if($orisoft_code == "000047"){
                $section = $section->where('tb_employee.section_code','G3AC');
                $count_data = $count_data->where('tb_employee.section_code','G3AC');
            }
        // }else{
        //     $section = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.division_code','tb_employee.department_code','tb_employee.section_code')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        //     ;

        //     $count_data = DB::table('tb_employee_final_score')
        //     ->select('tb_employee_final_score.id')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        //     ;
        // }

        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $section->whereIn('tb_employee.division_code', $search_division);
                $count_data->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $section->whereIn('tb_employee.department_code', $search_department);
                $count_data->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $section->whereIn('tb_employee.section_code', $search_section);
                $count_data->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search)){
            $section->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee.division_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_code','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_code','like','%'.$search.'%');
            });
        }

        $fieldby = 'tb_employee.section_code';

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }
        $section = $section->groupBy('tb_employee.section_code');
        $section->orderBy($fieldby,$order);
        $section = $section->skip($start)->take($length)->get();

        $count_data = $count_data->groupBy('tb_employee.section_code')->get();
        
        $division_array = [];
        $alldata = [];
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        if(count($section)>0){
            foreach ($section as $key => $value) {
                $section_total = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')       
                ->where('tb_percent_department_action.section_code',$value->section_code)
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->first();
                $total_Daily_filter = DB::table('tb_employee_final_score')
                ->select( 
                    DB::raw('SUM(salary_old) AS current_salary_wage'),
                    DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                    DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                    DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                    DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                    DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                    DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                    DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                    DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                    DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                    DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                )                         
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                                 
                // ->where('tb_employee_final_score.salary_type','Daily')
                // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                
                ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                ->where('tb_employee_final_score.salary_type','Daily')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.employee_status_description','Passed')
                ->where('tb_employee_final_score.freeze','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                
                ->whereNotNull('tb_employee_final_score.salary_old')
                ->whereNotNull('tb_employee_final_score.adjust_grade')
                ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                ;
                $total_Daily_filter->where('tb_employee.section_code',$value->section_code);
                $total_Daily_filter = $total_Daily_filter->first();

                $total_Monthly_filter = DB::table('tb_employee_final_score')
                ->select( 
                    DB::raw('SUM(salary_old) AS current_salary_wage'),
                    DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                    DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                    DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                    DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                    DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                    DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                    DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                    DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                    DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                    DB::raw('SUM(salary_month_new) AS new_salary_wage_month')
                )                              
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                            
                // ->where('tb_employee_final_score.salary_type','Monthly')
                // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                
                ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
                ->where('tb_employee_final_score.salary_type','Monthly')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee.employee_status_description','Passed')
                ->where('tb_employee_final_score.freeze','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                
                ->whereNotNull('tb_employee_final_score.salary_old')
                ->whereNotNull('tb_employee_final_score.adjust_grade')
                ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                ;

                $total_Monthly_filter->where('tb_employee.section_code',$value->section_code);
                $total_Monthly_filter = $total_Monthly_filter->first();

                if($total_Daily_filter->new_basic_wage_proposed){
                    $cal_daily = ($total_Daily_filter->new_basic_wage_proposed/$total_Daily_filter->current_salary_wage-1)*100;
                }else{
                    $cal_daily = '';
                }
                if($total_Monthly_filter->new_salary_wage_month){
                    $cal_month = ($total_Monthly_filter->new_salary_wage_month/$total_Monthly_filter->current_salary_wage_month-1)*100;
                }else{
                    $cal_month = '';
                }
                $percent_daily = '';
                $percent_monthly = '';
                if($section_total){
                    $percent_daily = ($section_total->percent_daily>0?number_format($section_total->percent_daily,4).'%':'');
                }
                if($section_total){
                    $percent_monthly = ($section_total->percent_monthly>0?number_format($section_total->percent_monthly,4).'%':'');
                }
                $alldata[] = array(
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "Total"=> '<div style="padding:16px;">'.($cal_daily!=''?number_format($cal_daily,4).'%':'').'</div>',
                    "Total2"=> '<div style="padding:16px;">'.($cal_month!=''?number_format($cal_month,4).'%':'').'</div>',
                    "percent_daily"=> '<div style="padding:16px;">'.$percent_daily.'</div>',
                    "percent_monthly"=> '<div style="padding:16px;">'.$percent_monthly.'</div>',
                );
            }
        }
        $totalRecords = $totalDisplay = count($count_data);
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $alldata
        ];
        echo json_encode($result);
    }

    public function chart_pa_grade(Request $request)
    {
        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_year       = $request->input('search_year');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
        // }
        
        $userID = Auth::user()->id;

        // $salary_all = DB::table('tb_employee_evaluator')
        // ->select('employee_no')
        // ->orwhere('tb_employee_evaluator.position_code','103')
        // ->orwhere('tb_employee_evaluator.position_code','105')
        // ->orwhere('tb_employee_evaluator.position_code','106')
        // ->orwhere('tb_employee_evaluator.position_code','114')
        // ->get();
        // if(!empty($salary_all)){
        //     foreach($salary_all as $key => $val){
        //         $section_codex = DB::table('tb_employee_final_score')
        //         ->select('tb_employee.section_code')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.evaluator_no',$val->employee_no)
        //         ->groupBy('section_code')
        //         ->get();
        //         $section_code_comma = '';
        //         if(!empty($section_codex)){
        //             foreach($section_codex AS $valx){
        //                 $sub = substr($valx->section_code,0,1);
        //                 if($sub == '1' || $sub == '2' || $sub == '6' || $sub == '7' || $sub == '8' || $sub == '9' || $sub == 'Y' || $sub == 'Z'){
        //                     $section_codexxx = DB::table('tb_section')->where('tb_section.section_code', 'like',''.$sub.'%')->get();
        //                     if(!empty($section_codexxx)){
        //                         foreach($section_codexxx AS $valxx){
        //                             $section_code_comma .= $valxx->section_code.',';
        //                         }
        //                     }
        //                 }else{
        //                     $section_code_comma .= $valx->section_code.',';
        //                 }
        //             }
        //         }
        //         $section_code_comma = substr($section_code_comma,0,-1);
        //         $caewf = explode(',',$section_code_comma);
        //         $result3 = array_unique( $caewf );
        //         $tre = implode(",", $result3);
        //         $salary_all[$key]->section_code = $tre;
        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.id', $val->id )
        //         ->update([
        //             "criteria_score_eva" => $val->criteria_score_old
        //         ]);
        //     }
        // }
        // $result = [
        //     'salary_all'=>$salary_all
        // ];
        // echo json_encode($result); 
        // exit;

        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $data1 = DB::table('users_model_has_roles')
        // ->where('users_model_has_roles.model_id',$userID);
        // $data1->where(function ($query) {
        //     $query->orWhere('users_model_has_roles.role_id','3');
        //     $query->orWhere('users_model_has_roles.role_id','4');
        //     $query->orWhere('users_model_has_roles.role_id','7');
        // });
        // $data1 = $data1->count();

        // if($data1 == 0){
        //     $division_code = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.division_code'
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        //     $new_division_code = [];
        //     if(count($division_code)>0){
        //         foreach ($division_code as $value) {
        //             array_push($new_division_code,$value->division_code);
        //         }
        //     }

            $countdata = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee_final_score.grade_proposed',
            'tb_grade_action.percent',
            'tb_employee_final_score.rec_year',
            'tb_employee_final_score.employee_no')
            ->whereNotNull('tb_employee_final_score.grade_proposed')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_grade_action','tb_grade_action.grade_name','=','tb_employee_final_score.grade_proposed')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->where('tb_employee.employee_status_description','Passed')
            // ->where('tb_employee_final_score.salary_type','Monthly')
            ->where('tb_employee_final_score.freeze_to_gmdm','1')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_grade.year','like','%'.$previousYear.'%')
            ->whereNull('tb_employee_final_score.not_up_salary')
            ;
            $countdata = $countdata->get();
            $result = [
                'countdata'=>$countdata,
            ];
            echo json_encode($result);
            exit; 
            // $countdata = DB::table('tb_employee_final_score')
            // ->select('tb_employee_final_score.grade_proposed',
            //         'tb_grade_action.percent'
            // )
            // ->whereNotNull('tb_employee_final_score.grade_proposed')
            // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            // ->leftJoin('tb_grade_action','tb_grade_action.grade_name','=','tb_employee_final_score.grade_proposed')
            // ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            // // ->whereIn('tb_employee.division_code',$new_division_code)
            // ->where('tb_employee_final_score.salary_type','Monthly')
            // ;

            $orisoft_code = Auth::user()->orisoft_code;
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000026" && $orisoft_code != "000002" && $orisoft_code != "990002"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_code);

                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_code);
            }
            if($orisoft_code == "000023"){
                if(trans(request()->segment(1)) != 'mtl'){
                    $countdata = $countdata->where('tb_employee.section_code','G3TC');
                }
            }
            if($orisoft_code == "000047"){
                $countdata = $countdata->where('tb_employee.section_code','G3AC');
            }
            if($orisoft_code == "000026"){
                if(trans(request()->segment(1)) == 'manager'){
                    if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by1','000026');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
                }else{
                    if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000026');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
                }
                
            }
        // }else{
        //     $countdata = DB::table('tb_employee_final_score')
        //     ->select('tb_employee_final_score.grade_proposed',
        //             'tb_grade_action.percent'
        //     )
        //     ->whereNotNull('tb_employee_final_score.grade_proposed')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->leftJoin('tb_grade_action','tb_grade_action.grade_name','=','tb_employee_final_score.grade_proposed')
        //     ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        //     ->where('tb_employee_final_score.salary_type','Monthly')
        //     ;
        // }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $countdata->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $countdata->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $countdata->whereIn('tb_employee.section_code', $search_section);
            }
        }
        $countdata = $countdata->get();


        ///////////////////////////////////////////////////////
        // $salary_all = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        //         'tb_employee.grade_code AS grade_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.rec_year',$previousYear)
        // ->get();

        // if(!empty($salary_all)){
        //     foreach($salary_all AS $val){
        //         $salary_type = 'Monthly';
        //         if($val->grade_code == 'L800'){
        //             $salary_type = 'Daily';
        //         }
        //         $salary_old = 0;
        //         if($salary_type == 'Monthly'){
        //             if($val->service_days < 2000){
        //                 $salary_old = 15000;
        //             }else if($val->service_days >= 2000 && $val->service_days < 4000){
        //                 $salary_old = 20000;
        //             }else if($val->service_days >= 4000 && $val->service_days < 6000){
        //                 $salary_old = 25000;
        //             }else if($val->service_days >= 6000 && $val->service_days < 8000){
        //                 $salary_old = 30000;
        //             }else if($val->service_days >= 8000 && $val->service_days < 10000){
        //                 $salary_old = 35000;
        //             }else if($val->service_days >= 10000){
        //                 $salary_old = 40000;
        //             }
        //         }else{
        //             if($val->service_days < 2000){
        //                 $salary_old = 300;
        //             }else if($val->service_days >= 2000 && $val->service_days < 4000){
        //                 $salary_old = 350;
        //             }else if($val->service_days >= 4000 && $val->service_days < 6000){
        //                 $salary_old = 400;
        //             }else if($val->service_days >= 6000 && $val->service_days < 8000){
        //                 $salary_old = 450;
        //             }else if($val->service_days >= 8000 && $val->service_days < 10000){
        //                 $salary_old = 500;
        //             }else if($val->service_days >= 10000){
        //                 $salary_old = 600;
        //             }
        //         }
                
        //         $salary_month_old = $salary_old;
        //         if($salary_type == 'Daily'){
        //             $salary_month_old = (float)$salary_old*26;
        //         }

        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.id', $val->id )
        //         ->update([
        //             "salary_type" => $salary_type,
        //             "salary_old" => $salary_old,
        //             "bsalary_wage" => $salary_old,
        //             "salary_month_old" => $salary_month_old
        //         ]);
        //     }
        // }
        
        ///////////////////////////////////////////////////////

        /////////////////////////// Case รีเซ็ตรหัส และ ออโต้ปรับ Role Evaluator ////////////////////////////
        // $all_users = DB::table('users')->where('id' ,'15' )->get();
        // if(!empty($all_users)){
        //     foreach($all_users AS $val){
        //         DB::table('users')->where('id', $val->id )->update([
        //             "password" => Hash::make($val->email)
        //         ]);
        //         // $check_users_model_has_roles = DB::table('users_model_has_roles')
        //         //     ->where('users_model_has_roles.model_id',$val->id)
        //         //     ->where('users_model_has_roles.role_id','8')
        //         //     ->count();
        //         //     if($check_users_model_has_roles == 0){
        //         //         DB::table('users_model_has_roles')->insert([
        //         //             'role_id' => '8',
        //         //             'model_type' => 'App\Models\User',
        //         //             'model_id' => $val->id
        //         //         ]);
        //         //     }
        //     }
        // }
        
        
        // if(!empty($salary_all)){
        //     foreach($salary_all AS $val){
        //         $salary_type = 'Monthly';
        //         if($val->grade_code == 'L800'){
        //             $salary_type = 'Daily';
        //         }
        //         $salary_old = 0;
        //         if($salary_type == 'Monthly'){
        //             if($val->service_days < 2000){
        //                 $salary_old = 15000;
        //             }else if($val->service_days >= 2000 && $val->service_days < 4000){
        //                 $salary_old = 20000;
        //             }else if($val->service_days >= 4000 && $val->service_days < 6000){
        //                 $salary_old = 25000;
        //             }else if($val->service_days >= 6000 && $val->service_days < 8000){
        //                 $salary_old = 30000;
        //             }else if($val->service_days >= 8000 && $val->service_days < 10000){
        //                 $salary_old = 35000;
        //             }else if($val->service_days >= 10000){
        //                 $salary_old = 40000;
        //             }
        //         }else{
        //             if($val->service_days < 2000){
        //                 $salary_old = 300;
        //             }else if($val->service_days >= 2000 && $val->service_days < 4000){
        //                 $salary_old = 350;
        //             }else if($val->service_days >= 4000 && $val->service_days < 6000){
        //                 $salary_old = 400;
        //             }else if($val->service_days >= 6000 && $val->service_days < 8000){
        //                 $salary_old = 450;
        //             }else if($val->service_days >= 8000 && $val->service_days < 10000){
        //                 $salary_old = 500;
        //             }else if($val->service_days >= 10000){
        //                 $salary_old = 600;
        //             }
        //         }
                
        //         $salary_month_old = $salary_old;
        //         if($salary_type == 'Daily'){
        //             $salary_month_old = (float)$salary_old*26;
        //         }

        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.id', $val->id )
        //         ->update([
        //             "salary_type" => $salary_type,
        //             "salary_old" => $salary_old,
        //             "bsalary_wage" => $salary_old,
        //             "salary_month_old" => $salary_month_old
        //         ]);
        //     }
        // }
        
        ///////////////////////////////////////////////////////

        /////////////////////////// Case ออโต้ปรับ Position code Evaluator ////////////////////////////
        // $tb_employee_evaluator = DB::table('tb_employee_evaluator')->get();
        // if(!empty($tb_employee_evaluator)){
        //     foreach($tb_employee_evaluator AS $val){
        //         $tb_position = DB::table('tb_position')->where('position_description',$val->position_description)->first();
        //         if($tb_position){
        //             DB::table('tb_employee_evaluator')->where('id', $val->id )->update([
        //                 "position_code" => $tb_position->position_code
        //             ]);
        //         }
        //     }
        // }

        /////////////////////////// Case อัพเดท divi ผู้ประเมิน ////////////////////////////
        // $tb_employee_evaluator = DB::table('tb_employee_evaluator')->whereNull('department_code')->get();
        // if(!empty($tb_employee_evaluator)){
        //     foreach($tb_employee_evaluator AS $val){
        //         $getdata = DB::table('tb_employee')
        //         // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee.orisoft_no',$val->employee_no)->first();
        //         if($getdata){
        //             DB::table('tb_employee_evaluator')->where('id', $val->id )->update([
        //                 // "division_code" => $getdata->division_code,
        //                 // "division_description" => $getdata->division_description,
        //                 "department_code" => $getdata->department_code,
        //                 "department_description" => $getdata->department_description,
        //                 // "position_description" => $getdata->position_description,
        //                 // "position_code" => $getdata->position_code,
        //                 // "position_description" => $getdata->position_description,
        //             ]);
        //         }
        //         // $getdata = DB::table('tb_division')
        //         // ->where('tb_division.division_code',$val->division_code)->first();
        //         // if($getdata){
        //         //     DB::table('tb_employee_evaluator')->where('id', $val->id )->update([
        //         //         // "division_code" => $getdata->division_code,
        //         //         "division_description" => $getdata->division_description,
        //         //         // "department_code" => $getdata->department_code,
        //         //         // "position_description" => $getdata->position_description,
        //         //         // "position_code" => $getdata->position_code,
        //         //         // "position_description" => $getdata->position_description,
        //         //     ]);
        //         // }
                
        //     }
        // }

        // $counta = [];
        // $tb_employee_evaluator = DB::table('tb_employee_evaluator')->get();
        // if(!empty($tb_employee_evaluator)){
        //     foreach($tb_employee_evaluator AS $val){
        //         $countUser = Users::where('orisoft_code', $val->employee_no)->count();
        //         if($countUser == 0){
        //             array_push($counta,$val->employee_no);
        //             $data = ['name' => $val->employee_name_en];
        //             $data['orisoft_code'] = $val->employee_no;
        //             $data['profile_photo_path'] = NULL;
        //             $data['password'] = Hash::make($val->employee_no.'@meyer-mil.com');
        //             $user = Users::updateOrCreate(['email' => $val->employee_no.'@meyer-mil.com'], $data);

        //             $dataUsers = Users::where('orisoft_code', $val->employee_no)->first();
        //             $check_users_model_has_roles = DB::table('users_model_has_roles')
        //             ->where('users_model_has_roles.model_id',$dataUsers->id)
        //             ->where('users_model_has_roles.role_id','8')
        //             ->count();
        //             if($check_users_model_has_roles == 0){
        //                 DB::table('users_model_has_roles')->insert([
        //                     'role_id' => '8',
        //                     'model_type' => 'App\Models\User',
        //                     'model_id' => $dataUsers->id
        //                 ]);
        //             }
        //         }
        //     }
        // }
        
        /////////////////////////// Case อัพเดท divi ผู้ประเมิน ////////////////////////////
        // $tb_employee_evaluator = DB::table('tb_employee_evaluator')->whereNull('section_code')->get();
        // if(!empty($tb_employee_evaluator)){
        //     foreach($tb_employee_evaluator AS $val){
        //         $getdata = DB::table('tb_employee')
        //         // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee.orisoft_no',$val->employee_no)->first();
        //         if($getdata){
        //             DB::table('tb_employee_evaluator')->where('id', $val->id )->update([
        //                 // "grade_code" => $getdata->grade_code,
        //                 // "division_code" => $getdata->division_code,
        //                 // "division_description" => $getdata->division_description,
        //                 // "department_code" => $getdata->department_code,
        //                 // "department_description" => $getdata->department_description,
        //                 // "position_description" => $getdata->position_description,
        //                 // "position_code" => $getdata->position_code,
        //                 // "position_description" => $getdata->position_description,
        //                 "section_code" => $getdata->section_code,
        //                 "section_description" => $getdata->section_description,
        //             ]);
        //         }
                
        //     }
        // }
        // $tb_employee_evaluator = DB::table('users')->whereNull('section_code')->get();
        // if(!empty($tb_employee_evaluator)){
        //     foreach($tb_employee_evaluator AS $val){
        //         $getdata = DB::table('tb_employee')
        //         ->where('tb_employee.orisoft_no',$val->orisoft_code)->first();
        //         if($getdata){
        //             DB::table('users')->where('id', $val->id )->update([
        //                 "section_code" => $getdata->section_code,
        //                 "section_description" => $getdata->section_description,
        //             ]);
        //         }
                
        //     }
        // }

        // $ccc = [];
        // $countUser = Users::whereNotNull('section_code')->get();
        // if(count($countUser) > 0){
        //     foreach($countUser AS $val){
        //         $count1 = DB::table('users_model_has_roles')->where('model_id',$val->id)->where('role_id','8')->count();
        //         if($count1 > 0){
        //             $count2 = DB::table('tb_employee_evaluator')->where('employee_no',$val->orisoft_code)->count();
        //                 if($count2 == 0){
        //                     // array_push($ccc,$val->id);
        //                     $previousYear = date('Y');
        //                     $row = DB::table('tb_employee')->where('section_code',$val->section_code)->first();
                            
        //                     $CreateEmployeeFinalScore = EmployeeEvaluator::create([
        //                         "rec_year" => $previousYear,
        //                         "employee_no" => $val->orisoft_code,
        //                         "evaluator_active" => '1',
        //                         "employee_name_th" => $val->name,
        //                         "employee_name_en" => $val->name,
        
        //                         "grade_code" => $row->grade_code,
        //                         "division_code" => $row->division_code,
        //                         "division_description" => $row->division_description,
        //                         "department_code" => $row->department_code,
        //                         "department_description" => $row->department_description,
        //                         "section_code" => $row->section_code,
        //                         "section_description" => $row->section_description,
        //                         "position_description" => $row->position_description,
        //                         "position_code" => $row->position_code,
        
        //                         "created_by" => Auth::user()->id,
        //                         "updated_by" => '0',
        //                         "created_at" => date('Y-m-d H:i:s'),
        //                         "updated_at" => null,
        //                     ]);
        //                 }
        //         }
        //     }
        // }
        
        /////////////////////////// Case อัพเดท เงิน ////////////////////////////
        // $salary_all = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        //         'tb_employee.grade_code AS grade_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.rec_year',$previousYear)
        // ->get();
        // if(!empty($salary_all)){
        //     foreach($salary_all AS $val){
        //         $salary_type = 'Monthly';
        //         if($val->grade_code == 'L800'){
        //             $salary_type = 'Daily';
        //         }
        //         $salary_old = 0;
        //         if($salary_type == 'Monthly'){
        //             $salary_old = 20000;
        //         }else{
        //             $salary_old = 300;
        //         }
                
        //         $salary_month_old = $salary_old;
        //         if($salary_type == 'Daily'){
        //             $salary_month_old = (float)$salary_old*26;
        //         }

        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.id', $val->id )
        //         ->update([
        //             "salary_type" => $salary_type,
        //             "salary_old" => $salary_old,
        //             "bsalary_wage" => $salary_old,
        //             "salary_month_old" => $salary_month_old
        //         ]);
        //     }
        // }
        
        // $salary_all = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        //         'tb_employee.grade_code AS grade_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee.section_code','G4MS')
        // // ->where('tb_employee_final_score.employee_no','001224')
        // ->get();
        // if(!empty($salary_all)){
        //     foreach($salary_all AS $val){
        //         $salary_allsss = DB::table('tb_employee_final_score2')->where('tb_employee_final_score2.employee_no',$val->employee_no)->first();
        //         // dd($salary_allsss);
        //         // $salary_type = 'Monthly';
        //         // if($val->grade_code == 'L800'){
        //         //     $salary_type = 'Daily';
        //         // }
        //         // $salary_old = 0;
        //         // if($salary_type == 'Monthly'){
        //         //     $salary_old = 20000;
        //         // }else{
        //         //     $salary_old = 300;
        //         // }
                
        //         // $salary_month_old = $salary_old;
        //         // if($salary_type == 'Daily'){
        //         //     $salary_month_old = (float)$salary_old*26;
        //         // }

        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.employee_no', $val->employee_no )
        //         ->update([
        //             "previous_form" => $salary_allsss->previous_form,
        //             "form_import" => $salary_allsss->form_import,
        //             "group_form_id" => $salary_allsss->group_form_id,
        //             "previous_evaluator_no" => $salary_allsss->previous_evaluator_no,
        //             "evaluator_no" => $salary_allsss->evaluator_no,
        //             "evaluator_name_th" => $salary_allsss->evaluator_name_th,
        //             "evaluator_name_en" => $salary_allsss->evaluator_name_en,
        //             "evaluation_criteria_id" => $salary_allsss->evaluation_criteria_id,
        //             "criteria_score_old" => $salary_allsss->criteria_score_old,
        //             "criteria_score_new" => $salary_allsss->criteria_score_new,
        //             "total_score" => $salary_allsss->total_score,
        //             "total_score_old" => $salary_allsss->total_score_old,
        //             "pa_grade" => $salary_allsss->pa_grade,
        //             "pa_grade_edit" => $salary_allsss->pa_grade_edit,
        //             "adjust_grade_old1" => $salary_allsss->adjust_grade_old1,
        //             "adjust_grade_old2" => $salary_allsss->adjust_grade_old2,
        //             "adjust_grade_old3" => $salary_allsss->adjust_grade_old3,
        //             "status_evaluation" => $salary_allsss->status_evaluation,
        //             "freeze" => $salary_allsss->freeze,
        //         ]);
        //     }
        // }
        // dd($salary_all);
        // exit;

        // $salary_all = DB::table('tb_employee_evaluator')
        // ->where('tb_employee_evaluator.position_code','103')
        // ->where('tb_employee_evaluator.position_code','105')
        // ->where('tb_employee_evaluator.position_code','106')
        // ->where('tb_employee_evaluator.position_code','114')
        // ->get();
        // if(!empty($salary_all)){
        //     foreach($salary_all AS $val){
        //         $salary_all = DB::table('tb_employee_evaluator2')
        //         ->select('criteria_score_old')
        //         ->where('tb_employee_evaluator2.criteria_score_old','!=','')
        //         ->first();
        //         // DB::table('tb_employee_final_score')
        //         // ->where('tb_employee_final_score.id', $val->id )
        //         // ->update([
        //         //     "criteria_score_eva" => $val->criteria_score_old
        //         // ]);
        //     }
        // }

        // $qwe = DB::table('tb_employee_final_score')
        // // ->where('freeze','0')
        
        // // ->orwhere('attendance_abt','>','0')
        // // ->orwhere('attendance_vwar','>','0')
        // // ->orwhere('attendance_wwar','>','0')
        // // ->orwhere('attendance_sus','>','0')
        // ->where('total_score','>','0');
        // $qwe->where(function ($query) {
        //     $query->orWhere('attendance_abt','>','0');
        //     $query->orWhere('attendance_vwar','>','0');
        //     $query->orWhere('attendance_wwar','>','0');
        //     $query->orWhere('attendance_sus','>','0');
        // });
        // // ->where('employee_no','019132')
        // $qwe = $qwe->orderBy('employee_no','ASC')->get();
        // if(!empty($qwe)){
        //     foreach($qwe as $key => $val){
        //         // $calcompliance = 10-($val->attendance_abt+($val->attendance_vwar*2)+($val->attendance_wwar*5)+($val->attendance_sus*10));
        //         // $qwe[$key]->compliance_score_cal = $calcompliance;
        //         $callll = 0;
        //         $expl = explode(',',$val->criteria_score_new);
        //         if(!empty($expl)){
        //             foreach($expl as $key2 => $value2) {
        //                 $test2 = DB::table('group_form_topic')
        //                 ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
        //                 ->where('group_form.form_year_use_start','like','%'.$previousYear.'%')
        //                 ->where('group_form_topic.group_form_id',$val->group_form_id)
        //                 ->orderBy('group_form_topic.id','ASC')
        //                 ->get();
        //                 foreach($test2 as $key3 => $value3) {
        //                     if($key2 == $key3){
        //                         if($value2>0){
        //                             $callll += $value2*$value3->topic_weight;
        //                         }
                                
        //                     }
        //                 }
        //             }
        //         }

        //         $test22 = DB::table('group_form')
        //                 ->where('group_form.form_year_use_start','like','%'.$previousYear.'%')
        //                 ->where('group_form.id',$val->group_form_id)
        //                 ->first();
        //         $callll = $callll+($val->compliance_score*$test22->compliance_weight);

        //         $attendance_score = round($val->attendance_score);
        //         if($attendance_score >= 0 && $attendance_score <= 2){
        //             $val->attendance_score = 10;
        //         }else if($attendance_score >= 17 && $attendance_score <= 18){
        //             $val->attendance_score = 2;
        //         }else if($attendance_score >= 15 && $attendance_score <= 16){
        //             $val->attendance_score = 3;
        //         }else if($attendance_score >= 13 && $attendance_score <= 14){
        //             $val->attendance_score = 4;
        //         }else if($attendance_score >= 11 && $attendance_score <= 12){
        //             $val->attendance_score = 5;
        //         }else if($attendance_score >= 9 && $attendance_score <= 10){
        //             $val->attendance_score = 6;
        //         }else if($attendance_score >= 7 && $attendance_score <= 8){
        //             $val->attendance_score = 7;
        //         }else if($attendance_score >= 5 && $attendance_score <= 6){
        //             $val->attendance_score = 8;
        //         }else if($attendance_score >= 3 && $attendance_score <= 4){
        //             $val->attendance_score = 9;
        //         }else{
        //             $val->attendance_score = 1;
        //         }

        //         $callll = $callll+($val->attendance_score*$test22->criteria_weight);
        //         $qwe[$key]->total_score = $callll;

        //         // DB::table('tb_employee_final_score')
        //         // ->where('tb_employee_final_score.id', $val->id )
        //         // ->update([
        //         //     "total_score" => $callll
        //         // ]);
        //     }
        // }

        // $qwe = DB::table('tb_employee_final_score')
        // ->where('group_form_id','1')
        // ->where('id','283');
        // // ->where('total_score','0');
        // $qwe = $qwe->orderBy('employee_no','ASC')->get();
        
        // $testtt = DB::table('tb_employee_final_score')
        // ->where('group_form_id','1')
        // ->where('total_score','>','0');
        // $testtt = $testtt->orderBy('employee_no','ASC')->first();
        
        // if(!empty($qwe)){
        //     foreach($qwe as $key => $val){
                
        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.id', $val->id )
        //         ->update([
        //             "criteria_score_eva" => $testtt->criteria_score_eva,
        //             "criteria_score_new" => $testtt->criteria_score_new,
        //             "criteria_score_old" => $testtt->criteria_score_old,
        //             "grade_proposed" => $testtt->grade_proposed,
        //             "grade_proposed_manager" => $testtt->grade_proposed_manager,
        //             "grade_proposed_old" => $testtt->grade_proposed_old,
        //             "pa_grade" => $testtt->pa_grade,
        //             "percent_proposed" => $testtt->percent_proposed,
        //             "percent_proposed_gmdm" => $testtt->percent_proposed_gmdm,
        //             "percent_proposed_old" => $testtt->percent_proposed_old,
        //             "percent_proposed_old_gmdm" => $testtt->percent_proposed_old_gmdm,
        //             "status_evaluation" => $testtt->status_evaluation,
        //             "total_score" => $testtt->total_score,
        //             "total_score_old" => $testtt->total_score_old,
        //             "adjust_grade" => $testtt->adjust_grade,
        //             "freeze" => $testtt->freeze,
        //             "freeze_to_pagrade" => $testtt->freeze_to_pagrade,
        //             // "percent_proposed_old" => $testtt->percent_proposed_old,

        //         ]);
        //     }
        // }

        $bell_curve = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        // ->where('tb_grade_action.grade_name','!=','U')
        // ->where('tb_grade_action.grade_name','!=','CD')
        ->orderBy('tb_grade_action.id', 'ASC')->get();


        // if(trans(request()->segment(1)) == 'mtl'){
        //     $qwe = DB::table('tb_employee_final_score')
        //     ->select('tb_employee_final_score.*','tb_employee.grade_code')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->where('tb_employee_final_score.service_days','!=','365')
        //     ->where('tb_employee_final_score.freeze_to_gmdm_edit','1')
        //     ->where('tb_employee_final_score.amount_proposed_gmdm','0.00');
        //     $qwe = $qwe->orderBy('employee_no','ASC')->get();
        //     if(!empty($qwe)){
        //         foreach($qwe as $key => $value){
        //             if($value->grade_code == 'L800'){
        //                 $current = $value->salary_old;
        //             }else{
        //                 $current = $value->salary_month_old;
        //             }
        //             if($value->grade_code == 'L800'){
        //                 if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
        //                     $bsalary_wage = $value->l800avg_wage;
        //                 }else{
        //                     $bsalary_wage = $current;
        //                 }
        //             }else{
        //                 if($value->bsalary_wage){
        //                     $bsalary_wage = $value->bsalary_wage;
        //                 }else{
        //                     $bsalary_wage = $current;
        //                 }
        //             }
        //             if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
        //                 if($value->service_days > 365){
        //                     $value->service_days = 365;
        //                 }
        //                 $service_days1 = $value->service_days/365;
        //             }else{
        //                 $service_days1 = $value->service_days/365;
        //             }
                    
        //             $service_days2 = $service_days1;
                    
        //             $qwe[$key]->company_suggestged_amount_new = $bsalary_wage*($value->company_suggested_per/100)*$service_days2;
        //             // $qwe[$key]->company_suggestged_amount_new = $bsalary_wage*($value->company_suggested_per/100)*$service_days2;
        //             $company_suggestged_new_basic = $value->company_suggestged_new_basic;
        //             if($value->grade_code == 'L800'){
        //                 $company_suggestged_new_basic = round($qwe[$key]->company_suggestged_amount_new+$current);
        //             }else{
        //                 $company_suggestged_new_basic = round($qwe[$key]->company_suggestged_amount_new+$bsalary_wage,-1);
        //             }
        //             $qwe[$key]->company_suggestged_new_basic_new = $company_suggestged_new_basic;
        //             $amount_proposed = $value->amount_proposed;
        //             if($bsalary_wage > 0){
        //                 if($value->percent_proposed){
        //                     $amount_proposed = $bsalary_wage*($value->percent_proposed/100)*$service_days2;
        //                 }else{
        //                     $amount_proposed = $bsalary_wage*($value->percent_proposed_old/100)*$service_days2;
        //                 }
        //             }
        //             $qwe[$key]->amount_proposed_new = $amount_proposed;
        //             if($value->grade_code == 'L800'){
        //                 $salary_new = round($amount_proposed+$current);
        //             }else{
        //                 $salary_new = round($amount_proposed+$current,-1);
        //             }
        //             $qwe[$key]->salary_new_new = $salary_new;
        //             $salary_month_new = ($value->salary_month_new?$value->salary_month_new:0);
        //             if($salary_new > 0){
        //                 if($value->grade_code == 'L800'){
        //                     if($value->grade_proposed == 'CD'){
        //                         $salary_month_newx = $salary_new*27.5;
        //                         $salary_month_new = round($salary_month_newx,-1);
        //                     }else{
        //                         $salary_month_new = round($salary_new)*26;
        //                     }
        //                 }else{
        //                     $salary_month_new = round($salary_new,-1);
        //                 }
        //             }
        //             $qwe[$key]->salary_month_new_new = $salary_month_new;


        //             DB::table('tb_employee_final_score')
        //             ->where('tb_employee_final_score.id', $value->id )
        //             ->update([
        //                 // "amount_proposed" => $amount_proposed,
        //                 // "salary_new" => $salary_new,
        //                 // "salary_month_new" => $salary_month_new,

        //                 "amount_proposed_gmdm" => $amount_proposed,
        //                 "salary_new_gmdm" => $salary_new,
        //                 "salary_month_new_gmdm" => $salary_month_new,
        //                 "final_by_md_gm_amount" => $salary_month_new
        //             ]);
        //         }
        //     }
        // }

        $result = [
            'countdata'=>$countdata,
            'bell_curve'=>$bell_curve,
            // 'qwe'=>$qwe,
            // 'testtt'=>$testtt
        ];
        echo json_encode($result); 
    }

    public function chart_pa_grade_manager(Request $request)
    {
        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_month_day      = $request->input('search_month_day');
        $search_grade      = $request->input('search_grade');

        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        $countdata = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_employee_final_score.grade_proposed',
        'tb_grade_action.percent')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_grade_action','tb_grade_action.grade_name','=','tb_employee_final_score.grade_proposed')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_grade.year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($search_division_code == "all"){
            $checka = strpos($orisoft_all_code->division_code,',');
            $arr_division_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->division_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_division_code,$value);
                    }
                }
            }else{
                array_push($arr_division_code,$orisoft_all_code->division_code);
            }
            $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_code);
        }

        if($search_department_code == "all"){
            $arr_department_code = [];
            $checka = strpos($orisoft_all_code->department_code,',');
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->department_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_department_code,$value);
                    }
                }
            }else{
                array_push($arr_department_code,$orisoft_all_code->department_code);
            }
            $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_code);
        }
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)
        
        // exit;
        if($search_division_code != "all"){
            $countdata->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $countdata->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $countdata->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $countdata->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $countdata->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $countdata->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_grade != "all"){
            $countdata->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "0"){
            if($search_status == '1'){
                $countdata->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $countdata->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        
        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $countdata->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $countdata->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $countdata->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $countdata = $countdata->orderBy('tb_employee_final_score.total_score', 'DESC')->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->get();
        // dd($datarow);
        // exit;

        $bell_curve = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->where('tb_grade_action.grade_name','!=','U')
        ->where('tb_grade_action.grade_name','!=','CD')
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        $percentAR = 0;
        $percentP = 0;
        $percentA = 0;
        $percentB = 0;
        $percentC = 0;
        $percentD = 0;
        $percentE = 0;
        $countall = count($countdata);
        if($bell_curve){
            foreach ($bell_curve as $keyx => $valuex) {
                if($valuex->grade_name == 'AR'){
                    $percentAR = $valuex->percent;
                }
                if($valuex->grade_name == 'P'){
                    $percentP = $valuex->percent;
                }
                if($valuex->grade_name == 'A'){
                    $percentA = $valuex->percent;
                }
                if($valuex->grade_name == 'B'){
                    $percentB = $valuex->percent;
                }
                if($valuex->grade_name == 'C'){
                    $percentC = $valuex->percent;
                }
                if($valuex->grade_name == 'D'){
                    $percentD = $valuex->percent;
                }
                if($valuex->grade_name == 'E'){
                    $percentE = $valuex->percent;
                }
            }
        }
        $calAR = round(($countall*$percentAR)/100);
        $calP = round(($countall*$percentP)/100);
        $calA = round(($countall*$percentA)/100);
        $calB = round(($countall*$percentB)/100);
        $calC = round(($countall*$percentC)/100);
        $calD = round(($countall*$percentD)/100);
        $calE = round(($countall*$percentE)/100);
        if($countdata){
            foreach ($countdata as $key => $value) {
                $theo_grade = '';
                if($calAR > 0){
                    $theo_grade = 'AR';
                    $calAR -= 1;
                }else if($calP > 0){
                    $theo_grade = 'P';
                    $calP -= 1;
                }else if($calA > 0){
                    $theo_grade = 'A';
                    $calA -= 1;
                }else if($calB > 0){
                    $theo_grade = 'B';
                    $calB -= 1;
                }else if($calC > 0){
                    $theo_grade = 'C';
                    $calC -= 1;
                }else if($calD > 0){
                    $theo_grade = 'D';
                    $calD -= 1;
                }else{
                    $theo_grade = 'E';
                    $calE -= 1;
                }
                $value->pa_grade = $theo_grade;
            }
        }


        $result = [
            'countdata'=>$countdata,
            // 'arr'=>$arr,
            // 'qwe'=>$qwe
        ];
        echo json_encode($result); 
    }

    public function chart_pa_grade_salary(Request $request)
    {
        $search_division      = $request->input('search_division_code');
        $search_department      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_month_day      = $request->input('search_month_day');
        $search_grade      = $request->input('search_grade');
        $search_not_up_salary       = $request->input('search_not_up_salary');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        $countdata = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee_final_score.grade_proposed_manager',
        'tb_employee_final_score.grade_proposed',
        'tb_employee_final_score.freeze_to_gmdm',
        'tb_grade_action.percent',
        'tb_employee_final_score.employee_no')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_grade_action','tb_grade_action.grade_name','=','tb_employee_final_score.grade_proposed_manager')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_grade.year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();
        if($search_not_up_salary == "1"){
            $countdata->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $countdata->whereNull('tb_employee_final_score.not_up_salary');
        }
        // $countdata = $countdata->get();
        // dd($countdata);
        // exit;
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checka = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_all_code->division_code);
                    }
                    $countdata->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
            }
            if(!isset($search_department)){
                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $countdata->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
            }
            if(!isset($search_section)){
                $arr_section_code = [];
                $checka = strpos($orisoft_all_code->section_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_all_code->section_code);
                }
                $countdata->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                    }
                });
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    if(count($department)>0){
                        foreach ($department as $value) {
                            array_push($arr_countsection,$value->department_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.department_code',$arr_countsection);
                }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
        }
        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $countdata->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $countdata->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $countdata->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $countdata->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $countdata->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $countdata->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_grade != "all"){
            $countdata->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all"){
            if($search_status == "-1"){
                $countdata->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_status != "all"){
            if($search_status == "-1"){
                $countdata->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $countdata->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $countdata->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $countdata->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $countdata = $countdata->get();
        if($countdata){
            foreach ($countdata as $keyx => $valuex) {
                if($valuex->freeze_to_gmdm == 1){
                    $countdata[$keyx]->grade_proposed_manager;
                }
            }
        }
        // dd($countdata);
        // exit;

        $bell_curve = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        // ->where('tb_grade_action.grade_name','!=','U')
        // ->where('tb_grade_action.grade_name','!=','CD')
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        // $percentAR = 0;
        // $percentP = 0;
        // $percentA = 0;
        // $percentB = 0;
        // $percentC = 0;
        // $percentD = 0;
        // $percentE = 0;
        // $countall = count($countdata);
        // if($bell_curve){
        //     foreach ($bell_curve as $keyx => $valuex) {
        //         if($valuex->grade_name == 'AR'){
        //             $percentAR = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'P'){
        //             $percentP = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'A'){
        //             $percentA = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'B'){
        //             $percentB = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'C'){
        //             $percentC = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'D'){
        //             $percentD = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'E'){
        //             $percentE = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'U'){
        //             $percentU = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'CD'){
        //             $percentCD = $valuex->percent;
        //         }
        //     }
        // }
        // $calAR = round(($countall*$percentAR)/100);
        // $calP = round(($countall*$percentP)/100);
        // $calA = round(($countall*$percentA)/100);
        // $calB = round(($countall*$percentB)/100);
        // $calC = round(($countall*$percentC)/100);
        // $calD = round(($countall*$percentD)/100);
        // $calE = round(($countall*$percentE)/100);
        // $calU = round(($countall*$percentU)/100);
        // $calCD = round(($countall*$percentCD)/100);
        // if($countdata){
        //     foreach ($countdata as $key => $value) {
        //         $theo_grade = '';
        //         if($calAR > 0){
        //             $theo_grade = 'AR';
        //             $calAR -= 1;
        //         }else if($calP > 0){
        //             $theo_grade = 'P';
        //             $calP -= 1;
        //         }else if($calA > 0){
        //             $theo_grade = 'A';
        //             $calA -= 1;
        //         }else if($calB > 0){
        //             $theo_grade = 'B';
        //             $calB -= 1;
        //         }else if($calC > 0){
        //             $theo_grade = 'C';
        //             $calC -= 1;
        //         }else if($calD > 0){
        //             $theo_grade = 'D';
        //             $calD -= 1;
        //         }else if($calE > 0){
        //             $theo_grade = 'E';
        //             $calE -= 1;
        //         }else if($calU > 0){
        //             $theo_grade = 'U';
        //             $calU -= 1;
        //         }else{
        //             $theo_grade = 'CD';
        //             $calCD -= 1;
        //         }
                
        //         $value->grade_proposed = $theo_grade;
                
        //     }
        // }


        $result = [
            'countdata'=>$countdata,
            'bell_curve'=>$bell_curve,
            // 'qwe'=>$qwe
        ];
        echo json_encode($result); 
    }

    public function chart_pa_grade_dmgm(Request $request)
    {
        $search_division      = $request->input('search_division_code');
        $search_department      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_month_day      = $request->input('search_month_day');
        $search_grade      = $request->input('search_grade');

        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        $submit_to_dmgm = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee_final_score.rec_year',
        'tb_employee_final_score.employee_no',
        'tb_employee_final_score.grade_proposed',
        'tb_grade_action.percent',
        'tb_employee.section_code')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_grade_action','tb_grade_action.grade_name','=','tb_employee_final_score.grade_proposed')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_grade.year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_gmdm','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        // $submit_to_dmgm->where('tb_employee_final_score.freeze_to_gmdm', '1');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $percent_department_count = DB::table('tb_percent_department_action')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year','like','%'.$search_year.'%')
        ->where('tb_percent_department_action.approve_by2', $orisoft_code )
        ->count();
        $percent_department_count3 = DB::table('tb_percent_department_action')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year','like','%'.$search_year.'%')
        ->where('tb_percent_department_action.approve_by3', $orisoft_code )
        ->count();
        $arr_section_code = [];
        if($percent_department_count > 0 && $percent_department_count3 == 0){
            $section1 = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$search_year.'%')
            ->where('tb_percent_department_action.approve_by2',$orisoft_code)
            ->groupBy('tb_percent_department_action.section_code')
            ->orderBy('tb_section.section_code', 'ASC')->get();
            if(count($section1)>0){
                foreach ($section1 as $value) {
                    array_push($arr_section_code,$value->section_code);
                }
            }
        }else if($percent_department_count3 == 0){
            $section1 = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$search_year.'%')
            ->where('tb_percent_department_action.approve_by2',$orisoft_code)
            ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
            ->groupBy('tb_percent_department_action.section_code')
            ->orderBy('tb_section.section_code', 'ASC')->get();
            if(count($section1)>0){
                foreach ($section1 as $value) {
                    array_push($arr_section_code,$value->section_code);
                }
            }
        }
        // dd($arr_section_code);
        // exit;
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if($percent_department_count > 0 || $percent_department_count3 > 0){
                if(count($arr_section_code) > 0){
                    $submit_to_dmgm->where(function ($query) use($arr_section_code) {
                        foreach ($arr_section_code as $value) {
                            $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                        }
                    });
                }
            }else{
                if(!isset($search_division)){
                        $checka = strpos($orisoft_all_code->division_code,',');
                        $arr_division_code = [];
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->division_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_division_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_division_code,$orisoft_all_code->division_code);
                        }
                        $submit_to_dmgm->where(function ($query) use($arr_division_code) {
                            foreach ($arr_division_code as $value) {
                                $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                            }
                        });
                }
                if(!isset($search_department)){
                    $arr_department_code = [];
                    $checka = strpos($orisoft_all_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_all_code->department_code);
                    }
                    $submit_to_dmgm->where(function ($query) use($arr_department_code) {
                        foreach ($arr_department_code as $value) {
                            $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                        }
                    });
                }
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }
        if($orisoft_code == "000002"){
            if($percent_department_count > 0 || $percent_department_count3 > 0){
                if(count($arr_section_code) > 0){
                    $submit_to_dmgm->where(function ($query) use($arr_section_code) {
                        foreach ($arr_section_code as $value) {
                            $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                        }
                    });
                }
            }else{
                if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }else{
                if($percent_department_count > 0 || $percent_department_count3 > 0){
                    if(count($arr_section_code) > 0){
                        $submit_to_dmgm->where(function ($query) use($arr_section_code) {
                            foreach ($arr_section_code as $value) {
                                $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                            }
                        });
                    }
                }else{
                    if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000026');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                    
                    }
                }
            }
            
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $submit_to_dmgm->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $submit_to_dmgm->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $submit_to_dmgm->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $submit_to_dmgm->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $submit_to_dmgm->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $submit_to_dmgm->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_grade != "all"){
            $submit_to_dmgm->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all"){
            if($search_status == "-1"){
                $submit_to_dmgm->where('tb_employee_final_score.status_salary','0');
            }else{
                $submit_to_dmgm->where('tb_employee_final_score.status_salary',$search_status);
            }
        }

        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $submit_to_dmgm->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $submit_to_dmgm->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $submit_to_dmgm = $submit_to_dmgm->groupBy('tb_employee_final_score.employee_no')->get();
        // dd($submit_to_dmgm);
        // exit;

        $bell_curve = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        // ->where('tb_grade_action.grade_name','!=','U')
        // ->where('tb_grade_action.grade_name','!=','CD')
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        // $percentAR = 0;
        // $percentP = 0;
        // $percentA = 0;
        // $percentB = 0;
        // $percentC = 0;
        // $percentD = 0;
        // $percentE = 0;
        // $percentU = 0;
        // $percentCD = 0;
        // $countall = count($submit_to_dmgm);
        // if($bell_curve){
        //     foreach ($bell_curve as $keyx => $valuex) {
        //         if($valuex->grade_name == 'AR'){
        //             $percentAR = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'P'){
        //             $percentP = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'A'){
        //             $percentA = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'B'){
        //             $percentB = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'C'){
        //             $percentC = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'D'){
        //             $percentD = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'E'){
        //             $percentE = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'U'){
        //             $percentU = $valuex->percent;
        //         }
        //         if($valuex->grade_name == 'CD'){
        //             $percentCD = $valuex->percent;
        //         }
        //     }
        // }
        // $calAR = round(($countall*$percentAR)/100);
        // $calP = round(($countall*$percentP)/100);
        // $calA = round(($countall*$percentA)/100);
        // $calB = round(($countall*$percentB)/100);
        // $calC = round(($countall*$percentC)/100);
        // $calD = round(($countall*$percentD)/100);
        // $calE = round(($countall*$percentE)/100);
        // $calU = round(($countall*$percentU)/100);
        // $calCD = round(($countall*$percentCD)/100);
        // if($submit_to_dmgm){
        //     foreach ($submit_to_dmgm as $key => $value) {
        //         $theo_grade = '';
        //         if($calAR > 0){
        //             $theo_grade = 'AR';
        //             $calAR -= 1;
        //         }else if($calP > 0){
        //             $theo_grade = 'P';
        //             $calP -= 1;
        //         }else if($calA > 0){
        //             $theo_grade = 'A';
        //             $calA -= 1;
        //         }else if($calB > 0){
        //             $theo_grade = 'B';
        //             $calB -= 1;
        //         }else if($calC > 0){
        //             $theo_grade = 'C';
        //             $calC -= 1;
        //         }else if($calD > 0){
        //             $theo_grade = 'D';
        //             $calD -= 1;
        //         }else if($calE > 0){
        //             $theo_grade = 'E';
        //             $calE -= 1;
        //         }else if($calU > 0){
        //             $theo_grade = 'U';
        //             $calU -= 1;
        //         }else{
        //             $theo_grade = 'CD';
        //             $calCD -= 1;
        //         }
                
        //         $value->grade_proposed = $theo_grade;
                
        //     }
        // }
        
        if($percent_department_count > 0 || $percent_department_count3 > 0){
            $result = [
                'countdata'=>$submit_to_dmgm,
                'bell_curve'=>$bell_curve,
                // 'qwe'=>$qwe
            ];
        }else{
            if(Auth::user()->can('view review salary')){
                $result = [
                    'countdata'=>$submit_to_dmgm,
                    'bell_curve'=>$bell_curve,
                    // 'qwe'=>$qwe
                ];
            }else{
                $result = [];
            }
        }
        
        
        echo json_encode($result); 
    }

    public function check_row(Request $request)
    {
        $user_id      = $request->input('user_id');
        $data1 = DB::table('users_model_has_roles')
        ->where('users_model_has_roles.model_id',$user_id);
        $data1 = $data1->first();

        $data2 = DB::table('users_role_has_permissions')
        ->where('users_role_has_permissions.role_id',$data1->role_id);
        $data2 = $data2->orderBy('permission_id','ASC')->first();

        $data3 = DB::table('users_permissions')
        ->where('users_permissions.id',$data2->permission_id)
        ->where('users_permissions.name','like','%view%');
        $data3 = $data3->orderBy('id','ASC')->first();

        $data4 = DB::table('users_roles')->where('users_roles.id',$data1->role_id)->first();
        if(!$data3){
            if($data4->name == "Admin"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view users%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "HR Manager"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view dashboards%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "HR Assistant"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view dashboards%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "Dept-Manager"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view review evaluate employees%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "Top Management"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view review salary%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
            if($data4->name == "Evaluator"){
                $data3 = DB::table('users_permissions')
                ->where('users_permissions.name','like','%view evaluate employees%');
                $data3 = $data3->orderBy('id','ASC')->first();
            }
        }       
        
        $result = [
            'data3'=>$data3,
            'data4'=>$data4
        ];
        echo json_encode($result); 
    }

    public function check_user(Request $request)
    {
        $name      = $request->input('name');
        $orisoft_code      = $request->input('orisoft_code');
        $email      = $request->input('email');
        $data1 = DB::table('users')
        ;

        $data1->where(function ($query) use($name) {
            $query->orWhere('users.name','like','%'.$name.'%');
        });

        $data1->where(function ($query) use($orisoft_code) {
            $query->orWhere('users.orisoft_code','like','%'.$orisoft_code.'%');
        });

        $data1->where(function ($query) use($email) {
            $query->orWhere('users.email','like','%'.$email.'%');
        });

        $data1 = $data1->count();

        $result = [
            'count'=>$data1
        ];
        echo json_encode($result); 
    }
}
