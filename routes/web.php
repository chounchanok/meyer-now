<?php

use App\Http\Controllers\allListEvaluatorController;
use App\Http\Controllers\approveSalaryController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GroupFormController;
use App\Http\Controllers\ListEvaluatorController;
use App\Http\Controllers\ManageBudgetController;
use App\Http\Controllers\ManageDepartmentController;
use App\Http\Controllers\ManageEmployeeController;
use App\Http\Controllers\MaintainController;

use App\Http\Controllers\ManageGradeController;
use App\Http\Controllers\paGradingController;
use App\Http\Controllers\REvaluateController;
use App\Http\Controllers\RSalaryController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ExceldayController;
use App\Http\Controllers\ExcelmonthController;

use App\Http\Controllers\setEvaluatorController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;
use Livewire\Controllers\HttpConnectionHandler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::middleware(['meyerLevel'])->prefix('{meyer}')->name('meyer.')->where(['meyer' => '(mil|mtl|manager)'])->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(FollowController::class)->group(function () {
            // Route::get('pa/follow/hr_page/{id}', 'hr_page')->name('hr_page');
            Route::get('pa/follow/hr_page', 'hr_page')->name('hr_page');
        });
        Route::controller(TimelineController::class)->group(function () {
            Route::get('pa/timeline/config_timeline', 'config_timeline')->name('config_timeline');
        });
        Route::name('pa.')->group(function () {
            Route::resource('/pa/timeline', TimelineController::class);
            Route::resource('/pa/follow', FollowController::class);
        });
        //ajax pa
        Route::post('/pa/timeline/add', [TimelineController::class, 'add_timeline']);
        Route::post('/pa/timeline/config_timeline/fetch/{id}', [TimelineController::class, 'fetch_config']);
        Route::post('/pa/timeline/config_timeline/edit', [TimelineController::class, 'edit_action']);
        Route::post('/pa/timeline/config_timeline/addedit', [TimelineController::class, 'addedit_action']);

        Route::post('timeline_changeactive', 'App\Http\Controllers\TimelineController@timeline_changeactive');
        Route::get('/test_enddate', 'App\Http\Controllers\TimelineController@test_enddate');


        Route::controller(GroupFormController::class)->group(function () {
            Route::get('formEvaluate/groupForm/addpage', 'addpage')->name('addpage');
            Route::post('group_form_addedit', 'App\Http\Controllers\GroupFormController@group_form_addedit');
            Route::post('criteria_get_evaluation_criteria', 'App\Http\Controllers\GroupFormController@criteria_get_evaluation_criteria');
            Route::post('get_edit_data', 'App\Http\Controllers\GroupFormController@get_edit_data');
            Route::post('group_form_changeactive', 'App\Http\Controllers\GroupFormController@group_form_changeactive');
            Route::post('copy_data', 'App\Http\Controllers\GroupFormController@copy_data');
        });
        Route::post('/pa/make/group', [TimelineController::class, 'make_group']);

        Route::name('formEvaluate.')->group(function () {
            Route::resource('/formEvaluate/criteria', CriteriaController::class);
            Route::resource('/formEvaluate/groupForm', GroupFormController::class);

            Route::post('table_groupform_getdata', 'App\Http\Controllers\GroupFormController@table_groupform_getdata');
            Route::post('criteria_addedit', 'App\Http\Controllers\CriteriaController@criteria_addedit');
            Route::post('criteria_getdata', 'App\Http\Controllers\CriteriaController@criteria_getdata');
            Route::post('criteria_del', 'App\Http\Controllers\CriteriaController@criteria_del');

            Route::get('/formEvaluate/groupForm/{id}/edit', [GroupFormController::class, 'edit'])->name('edit');
        });

        // Route::post('/formEvaluate/groupForm/addpage', [ GroupFormController::class, 'addpage']);
        // Route::get('/formEvaluate/groupForm/addpage', [GroupFormController::class, 'addpage'])->name('evaluate');

        //HR ตัดเกรด
        Route::get('/paGrading', [paGradingController::class, 'index'])->name('paGrading');
        Route::post('table_paGrading_getdata', 'App\Http\Controllers\paGradingController@table_paGrading_getdata');
        Route::post('editModal_update', 'App\Http\Controllers\paGradingController@editModal_update');
        Route::post('editModal_update_all', 'App\Http\Controllers\paGradingController@editModal_update_all');
        Route::post('bell_curve_detail', 'App\Http\Controllers\paGradingController@bell_curve_detail');
        Route::post('adjustModal_update_all', 'App\Http\Controllers\paGradingController@adjustModal_update_all');
        Route::post('editModal_theoretical_update', 'App\Http\Controllers\paGradingController@editModal_theoretical_update');

        //HR เงินเดือนที่อนุมัติแล้ว
        Route::get('/approveSalary', [approveSalaryController::class, 'index'])->name('approveSalary');
        Route::get('table_apvS_getdata', 'App\Http\Controllers\approveSalaryController@table_apvS_getdata');
        Route::post('table_ors_getdata', 'App\Http\Controllers\approveSalaryController@table_ors_getdata');
        Route::get('orisoft_excel/{id}', 'App\Http\Controllers\approveSalaryController@orisoft_excel');
        Route::post('update_status_pa', 'App\Http\Controllers\approveSalaryController@update_status_pa');
        Route::get('user_excel', 'App\Http\Controllers\approveSalaryController@user_excel');
        Route::post('table_approve_salary_getdata', 'App\Http\Controllers\approveSalaryController@table_approve_salary_getdata');
        Route::post('all_detail_approve', 'App\Http\Controllers\approveSalaryController@all_detail_approve');
        Route::post('table_approve_salary_getdata_test', 'App\Http\Controllers\approveSalaryController@table_approve_salary_getdata_test');
        Route::post('table_approve_salary_getdata_test2', 'App\Http\Controllers\approveSalaryController@table_approve_salary_getdata_test2');

        //Dept manager ตรวจสอบรายชื่อพนักงาน
        Route::get('/allListEvaluator', [allListEvaluatorController::class, 'index'])->name('allListEvaluator');
        Route::post('table_alistE_getdata', 'App\Http\Controllers\allListEvaluatorController@table_alistE_getdata');
        Route::get('/ListEvaluator', [ListEvaluatorController::class, 'index'])->name('ListEvaluator');
        Route::post('table_listE_getdata', 'App\Http\Controllers\ListEvaluatorController@table_listE_getdata');
        Route::post('ListEvaluator_update_status_all', 'App\Http\Controllers\ListEvaluatorController@ListEvaluator_update_status_all');
        Route::post('get_transferred', 'App\Http\Controllers\ListEvaluatorController@get_transferred');
        Route::post('save_transferred', 'App\Http\Controllers\ListEvaluatorController@save_transferred');
        Route::post('save_resign', 'App\Http\Controllers\ListEvaluatorController@save_resign');
        Route::post('save_resign_na', 'App\Http\Controllers\ListEvaluatorController@save_resign_na');

        Route::post('save_pass', 'App\Http\Controllers\ListEvaluatorController@save_pass');
        Route::post('filter_section', 'App\Http\Controllers\ListEvaluatorController@filter_section');
        Route::post('filter_department', 'App\Http\Controllers\ListEvaluatorController@filter_department');
        Route::post('get_division', 'App\Http\Controllers\ListEvaluatorController@get_division');
        Route::post('get_department', 'App\Http\Controllers\ListEvaluatorController@get_department');
        Route::post('get_section', 'App\Http\Controllers\ListEvaluatorController@get_section');
        Route::post('get_division_transfer', 'App\Http\Controllers\ListEvaluatorController@get_division_transfer');
        Route::post('get_section_salary', 'App\Http\Controllers\ListEvaluatorController@get_section_salary');
        Route::post('get_section_salary_jd', 'App\Http\Controllers\ListEvaluatorController@get_section_salary_jd');
        Route::post('get_section_review_salary', 'App\Http\Controllers\ListEvaluatorController@get_section_review_salary');
        Route::post('get_section_salary_approve', 'App\Http\Controllers\ListEvaluatorController@get_section_salary_approve');

        Route::post('get_section_pa_grade', 'App\Http\Controllers\ListEvaluatorController@get_section_pa_grade');
        Route::post('get_section_user', 'App\Http\Controllers\ListEvaluatorController@get_section_user');

        Route::post('get_division_salary', 'App\Http\Controllers\ListEvaluatorController@get_division_salary');
        Route::post('get_division_review_salary', 'App\Http\Controllers\ListEvaluatorController@get_division_review_salary');

        Route::post('get_department_salary', 'App\Http\Controllers\ListEvaluatorController@get_department_salary');
        Route::post('get_department_salary_jd', 'App\Http\Controllers\ListEvaluatorController@get_department_salary_jd');
        Route::post('get_department_review_salary', 'App\Http\Controllers\ListEvaluatorController@get_department_review_salary');

        Route::post('get_department_pa_grade', 'App\Http\Controllers\ListEvaluatorController@get_department_pa_grade');

        Route::get('export_excel_list_Employees', 'App\Http\Controllers\ListEvaluatorController@export_excel_list_Employees');
        Route::post('get_attendance', 'App\Http\Controllers\ListEvaluatorController@get_attendance');
        Route::post('update_attendance', 'App\Http\Controllers\ListEvaluatorController@update_attendance');

        //Dept manager กำหนดผู้ประเมิน
        Route::get('/setEvaluator', [setEvaluatorController::class, 'index'])->name('setEvaluator');
        Route::post('table_setE_getdata', 'App\Http\Controllers\setEvaluatorController@table_setE_getdata');
        Route::post('assign_evaluator', 'App\Http\Controllers\setEvaluatorController@assign_evaluator');
        Route::post('change_eva', 'App\Http\Controllers\setEvaluatorController@change_eva');
        Route::post('specify_form', 'App\Http\Controllers\setEvaluatorController@specify_form');
        Route::post('specify_eva_name', 'App\Http\Controllers\setEvaluatorController@specify_eva_name');

        Route::post('get_dashboard1', 'App\Http\Controllers\DashboardController@get_dashboard1');
        Route::post('chart_pa_grade', 'App\Http\Controllers\DashboardController@chart_pa_grade');
        Route::post('chart_pa_grade_manager', 'App\Http\Controllers\DashboardController@chart_pa_grade_manager');
        Route::post('chart_pa_grade_salary', 'App\Http\Controllers\DashboardController@chart_pa_grade_salary');
        Route::post('chart_pa_grade_dmgm', 'App\Http\Controllers\DashboardController@chart_pa_grade_dmgm');

        Route::post('get_salary_adjust', 'App\Http\Controllers\DashboardController@get_salary_adjust');
        Route::post('check_row', 'App\Http\Controllers\DashboardController@check_row');
        Route::post('get_salary_adjust_split', 'App\Http\Controllers\DashboardController@get_salary_adjust_split');
        Route::post('get_summary_by_division', 'App\Http\Controllers\DashboardController@get_summary_by_division');
        Route::post('get_approved_budget', 'App\Http\Controllers\DashboardController@get_approved_budget');
        Route::post('check_user', 'App\Http\Controllers\DashboardController@check_user');

        //ประเมินพนักงานและอนุมัติการประเมิน
        Route::get('/evaluate', [EvaluateController::class, 'index'])->name('evaluate');
        Route::post('table_test_getdata', 'App\Http\Controllers\EvaluateController@table_test_getdata');
        Route::post('table_test_getdata_all', 'App\Http\Controllers\EvaluateController@table_test_getdata_all');

        Route::post('table_test_getdata_m', 'App\Http\Controllers\EvaluateController@table_test_getdata_m');
        Route::post('get_form', 'App\Http\Controllers\EvaluateController@get_form');
        Route::post('get_form_all', 'App\Http\Controllers\EvaluateController@get_form_all');

        Route::post('get_form_2', 'App\Http\Controllers\EvaluateController@get_form_2');
        Route::post('update_score', 'App\Http\Controllers\EvaluateController@update_score');
        Route::post('update_remark', 'App\Http\Controllers\EvaluateController@update_remark');
        Route::post('update_remark_manager', 'App\Http\Controllers\EvaluateController@update_remark_manager');
        Route::post('check_value_null', 'App\Http\Controllers\EvaluateController@check_value_null');

        Route::post('evaluate_get_all', 'App\Http\Controllers\EvaluateController@evaluate_get_all');
        Route::post('evaluate_get_all_review', 'App\Http\Controllers\EvaluateController@evaluate_get_all_review');

        Route::post('get_compliance_attendance', 'App\Http\Controllers\EvaluateController@get_compliance_attendance');
        Route::post('gettitle', 'App\Http\Controllers\EvaluateController@gettitle');
        Route::get('/evaluateReview', [REvaluateController::class, 'index'])->name('evaluateReview');
        Route::post('Review_table_test_getdata', 'App\Http\Controllers\REvaluateController@Review_table_test_getdata');
        Route::post('Review_table_test_getdata_m', 'App\Http\Controllers\REvaluateController@Review_table_test_getdata_m');
        Route::post('Review_update_score', 'App\Http\Controllers\REvaluateController@Review_update_score');
        Route::post('Review_update_status', 'App\Http\Controllers\REvaluateController@Review_update_status');
        Route::post('Review_get_form', 'App\Http\Controllers\REvaluateController@Review_get_form');
        Route::post('Review_update_status_all', 'App\Http\Controllers\REvaluateController@Review_update_status_all');
        Route::post('count_pa_grade', 'App\Http\Controllers\EvaluateController@count_pa_grade');
        Route::post('freeze', 'App\Http\Controllers\EvaluateController@freeze');
        Route::post('freeze_to_pagrade', 'App\Http\Controllers\EvaluateController@freeze_to_pagrade');
        Route::get('export_excel_evaluate', 'App\Http\Controllers\EvaluateController@export_excel_evaluate');
        Route::post('test_freeze', 'App\Http\Controllers\EvaluateController@test_freeze');

        Route::post('get_eva', 'App\Http\Controllers\REvaluateController@get_eva');
        Route::post('get_eva_review', 'App\Http\Controllers\setEvaluatorController@get_eva_review');
        Route::post('check_value_null_review', 'App\Http\Controllers\REvaluateController@check_value_null_review');
        Route::post('get_eva_salary', 'App\Http\Controllers\setEvaluatorController@get_eva_salary');
        Route::post('get_eva_salary_review', 'App\Http\Controllers\setEvaluatorController@get_eva_salary_review');

        Route::post('get_eva_pa_grade', 'App\Http\Controllers\setEvaluatorController@get_eva_pa_grade');

        Route::post('review_get_form_all', 'App\Http\Controllers\REvaluateController@review_get_form_all');
        Route::post('review_table_test_getdata_all', 'App\Http\Controllers\REvaluateController@review_table_test_getdata_all');
        Route::post('check_approve_null', 'App\Http\Controllers\REvaluateController@check_approve_null');
        Route::post('get_eva_pagrade', 'App\Http\Controllers\setEvaluatorController@get_eva_pagrade');
        Route::post('get_form_list', 'App\Http\Controllers\setEvaluatorController@get_form_list');
        Route::get('export_excel_set_evaluate', 'App\Http\Controllers\setEvaluatorController@export_excel_set_evaluate');

        Route::get('table_rtest_getdata', 'App\Http\Controllers\REvaluateController@table_rtest_getdata');
        Route::get('export_excel_review_evaluate', 'App\Http\Controllers\REvaluateController@export_excel_review_evaluate');

        //ปรับเงินเดือนและอนุมัติปรับเงินเดือน
        Route::get('/salary', [SalaryController::class, 'index'])->name('salary');
        Route::post('table_salary_getdata', 'App\Http\Controllers\SalaryController@table_salary_getdata');
        Route::post('table_salary_getdata_review', 'App\Http\Controllers\SalaryController@table_salary_getdata_review');

        Route::get('/salaryReview', [RSalaryController::class, 'index'])->name('salaryReview');
        Route::post('table_rsalary_getdata', 'App\Http\Controllers\RSalaryController@table_rsalary_getdata');
        Route::post('approve_salary', 'App\Http\Controllers\RSalaryController@approve_salary');
        Route::post('approve_salary_all', 'App\Http\Controllers\RSalaryController@approve_salary_all');
        Route::post('approve_salary_get_all', 'App\Http\Controllers\RSalaryController@approve_salary_get_all');

        Route::post('approve_salary_approve3', 'App\Http\Controllers\RSalaryController@approve_salary_approve3');
        Route::post('approve_salary_all_approve3', 'App\Http\Controllers\RSalaryController@approve_salary_all_approve3');

        Route::post('salary_set_info', 'App\Http\Controllers\SalaryController@salary_set_info');
        Route::post('update_remark_grade', 'App\Http\Controllers\SalaryController@update_remark_grade');
        Route::post('update_remark_special', 'App\Http\Controllers\SalaryController@update_remark_special');

        Route::post('update_percent_proposed', 'App\Http\Controllers\SalaryController@update_percent_proposed');
        Route::post('update_percent_proposed_input', 'App\Http\Controllers\SalaryController@update_percent_proposed_input');
        Route::post('update_percent_proposed_input_gmdm', 'App\Http\Controllers\SalaryController@update_percent_proposed_input_gmdm');

        Route::post('all_detail', 'App\Http\Controllers\SalaryController@all_detail');
        Route::post('all_detail_review', 'App\Http\Controllers\SalaryController@all_detail_review');

        Route::post('change_grade_select', 'App\Http\Controllers\SalaryController@change_grade_select');
        Route::post('change_percent_select', 'App\Http\Controllers\SalaryController@change_percent_select');
        Route::post('get_positoon_for_change', 'App\Http\Controllers\SalaryController@get_positoon_for_change');
        Route::post('get_positoon_for_change_jd', 'App\Http\Controllers\SalaryController@get_positoon_for_change_jd');

        Route::post('update_position_grade_p', 'App\Http\Controllers\SalaryController@update_position_grade_p');
        Route::post('update_final_by_md_gm_amount', 'App\Http\Controllers\SalaryController@update_final_by_md_gm_amount');
        Route::post('update_final_by_md_gm_amount_enter', 'App\Http\Controllers\SalaryController@update_final_by_md_gm_amount_enter');

        Route::post('check_salary_null', 'App\Http\Controllers\SalaryController@check_salary_null');
        Route::post('check_salary_null_approve_hr', 'App\Http\Controllers\SalaryController@check_salary_null_approve_hr');

        Route::post('freeze_to_gmdm', 'App\Http\Controllers\SalaryController@freeze_to_gmdm');
        Route::post('freeze_to_approve_hr', 'App\Http\Controllers\SalaryController@freeze_to_approve_hr');
        Route::post('sendmail_jd', 'App\Http\Controllers\SalaryController@sendmail_jd');

        Route::post('check_new_position', 'App\Http\Controllers\SalaryController@check_new_position');
        Route::post('add_new_position', 'App\Http\Controllers\SalaryController@add_new_position');
        Route::post('update_position_grade_p_info', 'App\Http\Controllers\SalaryController@update_position_grade_p_info');
        Route::get('export_excel', 'App\Http\Controllers\SalaryController@export_excel');
        Route::get('export_excel_approve', 'App\Http\Controllers\SalaryController@export_excel_approve');
        Route::get('export_excel_approve_jd', 'App\Http\Controllers\SalaryController@export_excel_approve_jd');

        Route::post('save_jd', 'App\Http\Controllers\SalaryController@save_jd');
        Route::get('export_excel_attendance', 'App\Http\Controllers\SalaryController@export_excel_attendance');

        // Route::get('export_excel_day', 'App\Http\Controllers\ExceldayController@export_excel_day');
        // Route::get('export_excel_month', 'App\Http\Controllers\ExcelmonthController@export_excel_month');
        Route::get('/export_excel_day', [ExceldayController::class, 'export_excel_day']);
        Route::get('/export_excel_day_approve', [ExceldayController::class, 'export_excel_day_approve']);
        Route::get('/export_excel_month', [ExcelmonthController::class, 'export_excel_month']);
        Route::get('/export_excel_month_approve', [ExcelmonthController::class, 'export_excel_month_approve']);

        Route::post('update_l800avg_wage', 'App\Http\Controllers\SalaryController@update_l800avg_wage');
        Route::post('cancel_approve', 'App\Http\Controllers\SalaryController@cancel_approve');
        Route::post('set_session', 'App\Http\Controllers\SalaryController@set_session');
        Route::post('check_set_session', 'App\Http\Controllers\SalaryController@check_set_session');

        Route::controller(ManageBudgetController::class)->group(function () {
            Route::get('setting/manageBudget/managepage', 'managepage')->name('managepage');
        });
        Route::post('/setting/manageBudget/add', [ManageBudgetController::class, 'add_action']);
        Route::post('/setting/manageBudget/show/fetch/{id}', [ManageBudgetController::class, 'fetch_config']);
        Route::post('/setting/manageBudget/show/addedit', [ManageBudgetController::class, 'addedit_action']);
        Route::post('/setting/user/show/addedit', [UserManagementController::class, 'addedituser_action']);
        Route::post('/setting/user/show/editdata', [UserManagementController::class, 'edituser_action']);

        Route::post('/setting/manageGrade/add', [ManageGradeController::class, 'add_action']);
        Route::post('/setting/manageGrade/show/fetch/{id}', [ManageGradeController::class, 'fetch_config']);
        Route::post('/setting/manageGrade/show/addedit', [ManageGradeController::class, 'addedit_action']);
        Route::get('/setting/manageGrade/{id}/show', [ManageGradeController::class, 'show']);
        Route::post('grade_change_active', 'App\Http\Controllers\ManageGradeController@grade_change_active');
        Route::post('grade_changeactive', 'App\Http\Controllers\ManageGradeController@grade_changeactive');

        Route::controller(ManageDepartmentController::class)->group(function () {
            Route::get('setting/manageDepartment/managepage', 'managepage_department')->name('managepage_department');
        });
        Route::post('/setting/manageDepartment/add', [ManageDepartmentController::class, 'add_action']);
        Route::post('/setting/manageDepartment/show/fetch/{id}', [ManageDepartmentController::class, 'fetch_config']);
        Route::post('/setting/manageDepartment/show/addedit', [ManageDepartmentController::class, 'addedit_action']);
        Route::get('/setting/manageDepartment/{id}/show', [ManageDepartmentController::class, 'show']);
        Route::post('department_change_active', [ManageDepartmentController::class, 'department_change_active']);
        Route::post('department_action_change_active', [ManageDepartmentController::class, 'department_action_change_active']);

        Route::controller(ManageEmployeeController::class)->group(function () {
            Route::get('setting/manageEmployee/managepage/{id}', 'managepage_employee')->name('managepage_employee');
        });
        Route::name('setting.')->group(function () {
            Route::resource('/setting/uploadFile', UploadFileController::class);
            Route::get('/setting/uploadFile/{id}/detail', [UploadFileController::class, 'detail'])->name('brandformedit');
            Route::get('/setting/uploadFile/{id}/detail2', [UploadFileController::class, 'detail2'])->name('brandformedit2');
            Route::get('/setting/uploadFile/{id}/detail3', [UploadFileController::class, 'detail3'])->name('brandformedit3');
            Route::get('/setting/uploadFile/{id}/detail4', [UploadFileController::class, 'detail4'])->name('brandformedit4');
            Route::get('/setting/uploadFile/{id}/detail5', [UploadFileController::class, 'detail5'])->name('brandformedit5');

            Route::resource('/setting/maintain', MaintainController::class);
            Route::get('/setting/maintain/{id}/show', [MaintainController::class, 'show']);

            Route::post('setmanager', 'App\Http\Controllers\MaintainController@setmanager');
            Route::post('update_manager', 'App\Http\Controllers\MaintainController@update_manager');
            Route::post('set_top', 'App\Http\Controllers\MaintainController@set_top');
            Route::post('sendmail_manager', 'App\Http\Controllers\MaintainController@sendmail_manager');

            Route::resource('/setting/manageGrade', ManageGradeController::class);
            Route::resource('/setting/manageBudget', ManageBudgetController::class);
            Route::resource('/setting/manageDepartment', ManageDepartmentController::class);
            Route::resource('/setting/manageEmployee', ManageEmployeeController::class);
            Route::post('table_budget_getdata', 'App\Http\Controllers\ManageBudgetController@table_budget_getdata');

            Route::get('table_budget_rate_getdata/{id}', 'App\Http\Controllers\ManageBudgetController@table_budget_rate_getdata');

            Route::post('table_allgrade_getdata', 'App\Http\Controllers\ManageGradeController@table_allgrade_getdata');
            Route::get('table_grade_getdata/{id}', 'App\Http\Controllers\ManageGradeController@table_grade_getdata');

            Route::post('table_alldepartment_getdata', 'App\Http\Controllers\ManageDepartmentController@table_alldepartment_getdata');
            Route::get('table_department_getdata/{id}', 'App\Http\Controllers\ManageDepartmentController@table_department_getdata');
            Route::post('table_allemployee_getdata', 'App\Http\Controllers\ManageEmployeeController@table_allemployee_getdata');
            Route::post('table_employee_getdata/{id}', 'App\Http\Controllers\ManageEmployeeController@table_employee_getdata');
        });
        //ajax manage
        Route::post('/setting/manageEmployee/add', [ManageEmployeeController::class, 'add_manage']);
        Route::post('/get/employee/{id}', [ManageEmployeeController::class, 'fetch_employee']);
        Route::post('/edit/employee/{id}', [ManageEmployeeController::class, 'edit_employee']);
        Route::post('resignEmployee', 'App\Http\Controllers\ManageEmployeeController@resignEmployee');

        Route::name('user-management.')->group(function () {
            Route::resource('/user-management/users', UserManagementController::class);
            Route::resource('/user-management/roles', RoleManagementController::class);
            Route::resource('/user-management/permissions', PermissionManagementController::class);
        });

        //route url import
        Route::post('/import_employee', [UploadFileController::class, 'import_employee']);
        Route::post('/import_employee_evt', [UploadFileController::class, 'import_employee_evt']);
        Route::post('/import_employee_attendance', [UploadFileController::class, 'import_employee_attendance']);
        Route::post('/import_employee_score_pa', [UploadFileController::class, 'import_employee_score_pa']);
        Route::post('/import_employee_salary', [UploadFileController::class, 'import_employee_salary']);
        Route::post('/import_user', [UploadFileController::class, 'import_user']);
        Route::post('/import_increase_percent', [UploadFileController::class, 'import_increase_percent']);

        Route::get('eva_excel', 'App\Http\Controllers\UploadFileController@eva_excel');

        Route::get('alert_send_mail', 'App\Http\Controllers\MailController@alert_send_mail');
        Route::get('alert_send_mail_test', 'App\Http\Controllers\MailController@alert_send_mail_test');
        

        Route::post('check_current_password', 'App\Http\Controllers\Apps\UserManagementController@check_current_password');
        Route::post('change_password', 'App\Http\Controllers\Apps\UserManagementController@change_password');
        Route::post('check_current_password_header', 'App\Http\Controllers\Apps\UserManagementController@check_current_password_header');
        Route::post('change_password_header', 'App\Http\Controllers\Apps\UserManagementController@change_password_header');
        Route::post('get_user_data', 'App\Http\Controllers\Apps\UserManagementController@get_user_data');

    });

    Route::get('/error', function () {
        abort(500);
    });

    Route::post('table_timeline_getdata', 'App\Http\Controllers\TimelineController@table_timeline_getdata');
    Route::post('table_follow_getdata', 'App\Http\Controllers\FollowController@table_follow_getdata');
    Route::post('table_hr_getdata', 'App\Http\Controllers\FollowController@table_hr_getdata');
    Route::post('count_progress', 'App\Http\Controllers\FollowController@count_progress');
    Route::post('get_column', 'App\Http\Controllers\FollowController@get_column');
    Route::post('changeactiveuser', 'App\Http\Controllers\TimelineController@changeactiveuser');
    Route::post('reset_password', 'App\Http\Controllers\TimelineController@reset_password');

    Route::post('table_config_timeline_getdata', 'App\Http\Controllers\TimelineController@table_config_timeline_getdata');
    Route::get('table_criteria_getdata', 'App\Http\Controllers\CriteriaController@table_criteria_getdata');
    Route::get('master_group', 'App\Http\Controllers\UploadFileController@master_group');
    Route::post('criteria_changeactive', 'App\Http\Controllers\CriteriaController@criteria_changeactive');

    Route::middleware('guest')->group(function () {
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

    Route::post('/livewire/message/{name}', HttpConnectionHandler::class)
        ->name('livewire.message-meyer')
        ->middleware(config('livewire.middleware_group', ''));

    Route::get('/locale/{locale}', function (string $meyer, string $locale) {
        if (!in_array($locale, ['en', 'th'])) {
            abort(400);
        }
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    });
}); //route group meyerLevel

Route::get('/', [AuthenticatedSessionController::class, 'create']);
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('new_send_mail_mil', 'App\Http\Controllers\MailController@new_send_mail_mil');
Route::get('new_send_mail_mtl', 'App\Http\Controllers\MailController@new_send_mail_mtl');
Route::get('new_send_mail_manager', 'App\Http\Controllers\MailController@new_send_mail_manager');
Route::get('reset_password_login', 'App\Http\Controllers\MailController@reset_password_login');


Route::get('/locale/{locale}', function (string $locale) {
    if (!in_array($locale, ['en', 'th'])) {
        abort(400);
    }
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
