<?php

namespace App\Http\Controllers;
use App\DataTables\GroupFormDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\formEvaluate\formEvaluate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GroupFormController extends Controller
{
    public function index(GroupFormDataTable $dataTable)
    {
        $group_form = DB::table('group_form');
        $group_form = $group_form->orderBy('id', 'ASC')->get();
        return view('pages.formEvaluate.groupForm.index', [
            'year' => DB::table('group_form')->orderby('created', 'desc')->groupBy('form_year_use_start')->get(),
            "datarow" => $group_form
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        // return $dataTable->render('pages.formEvaluate.groupForm.index');
        // return view('pages.formEvaluate.groupForm.index');
    }

    public function addpage()
    {   
        $datenow = date('Y');
        $year = [];
        for ($i=$datenow; $i < $datenow+5; $i++) { 
            $year[] = $i;
        }
        $evaluation_criteria = DB::table('evaluation_criteria');
        $evaluation_criteria = $evaluation_criteria->orderBy('id', 'ASC')->get();
        return view('pages.formEvaluate.groupForm.add', [
            "id" => "",
            "evaluation_criteria" => $evaluation_criteria,
            "year" => $year
        ]);
    }
    
    public function edit(Request $request, $test,$id){
        $datenow = date('Y');
        $year = [];
        for ($i=$datenow; $i < $datenow+5; $i++) { 
            $year[] = $i;
        }
        $evaluation_criteria = DB::table('evaluation_criteria');
        $evaluation_criteria = $evaluation_criteria->orderBy('id', 'ASC')->get();
        return view('pages.formEvaluate.groupForm.add', [
            "id" => $id,
            "evaluation_criteria" => $evaluation_criteria,
            "year" => $year
        ]);
    }

    public function table_groupform_getdata(Request $request)
    {
        $searchText      = $request->input('searchText');
        $form_year_use_start      = $request->input('form_year_use_start');
        $serach_status      = $request->input('serach_status');
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'group_form.id';

        // $like = $request->Like;
        // dd($request->input('searchText'));
        // exit;
        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        $gatall = formEvaluate::select('group_form.*');

        $count_data = formEvaluate::select('group_form.*');

        if($searchText != ""){
            $searchText = $searchText;
            $gatall->where(function ($query) use($searchText) {
                $query->orWhere('group_form.form_th','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_en','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_year_use_start','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_year_use_end','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_ref','like','%'.$searchText.'%');
            });
            $count_data->where(function ($query) use($searchText) {
                $query->orWhere('group_form.form_th','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_en','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_year_use_start','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_year_use_end','like','%'.$searchText.'%');
                $query->orWhere('group_form.form_ref','like','%'.$searchText.'%');
            });
        }
        if($form_year_use_start != ""){
            $gatall->where('group_form.form_year_use_start', 'like','%'.$form_year_use_start.'%');
            $count_data->where('group_form.form_year_use_start', 'like','%'.$form_year_use_start.'%');
        }
        if($serach_status != ""){
            $gatall->where('group_form.status', $serach_status);
            $count_data->where('group_form.status', $serach_status);
        }

        if(!empty($search)){
            $gatall->where(function ($query) use($search) {
                $query->orWhere('group_form.form_th','like','%'.$search.'%');
                $query->orWhere('group_form.form_en','like','%'.$search.'%');
                $query->orWhere('group_form.form_year_use_start','like','%'.$search.'%');
                $query->orWhere('group_form.form_year_use_end','like','%'.$search.'%');
                $query->orWhere('group_form.form_ref','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('group_form.form_th','like','%'.$search.'%');
                $query->orWhere('group_form.form_en','like','%'.$search.'%');
                $query->orWhere('group_form.form_year_use_start','like','%'.$search.'%');
                $query->orWhere('group_form.form_year_use_end','like','%'.$search.'%');
                $query->orWhere('group_form.form_ref','like','%'.$search.'%');
            });
        }

        if(empty($field)){
            $fieldby = 'group_form.id';
        }
        else{
            if($field == 2){
                $fieldby = 'group_form.form_th';
            }else if($field == 3){
                $fieldby = 'group_form.create_date';
            }else if($field == 4){
                $fieldby = 'group_form.form_year_use_start';
            }else if($field == 5){
                $fieldby = 'group_form.revise';
            }else if($field == 6){
                $fieldby = 'group_form.form_ref';
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

        $count_data = $count_data->orderBy('group_form.form_year_use_start', 'DESC')->count();

        if(count($gatall)>0){
            foreach ($gatall as $value) {
                $checkbox = '<input type="checkbox">';
                $data[] = array(
                    "no" =>  $pagestart,
                    "form_th" =>  $value->form_th,
                    "create_date" =>  $value->create_date,
                    "form_year_use_start" =>  $value->form_year_use_start,
                    "revise" =>  $value->revise,
                    "form_ref" =>  $value->form_ref,
                    "status" =>  $value->status,
                    "id" =>  $value->id,
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
        // $html = '
        //         <div style="display: flex;align-items: center;justify-content: center;">
        //             <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
        //                 <input class="form-check-input h-30px w-50px" type="checkbox" value="" id="flexSwitchDefault"/>
        //             </div>
        //             <div class="flex-center-new" style="border-radius: 4px;background: #E8FFF3;width: 74px;height: 15px;">
        //                 <span style="color: #50CD89;">Active</span>
        //             </div>
        //         </div>';
        // for ($i=1; $i < 11; $i++) { 
        //     $checkbox = '<input type="checkbox">';
        //     $data[] = array(
        //         "checkbox" =>  $checkbox,
        //         "no" =>  $i,
        //         "form" =>  'F1',
        //         "date1" =>  'วว/ดด/ปปปป',
        //         "date2" => 'ปปปป - ปปปป',
        //         "revise" =>  '0',
        //         "ref" =>  '-',
        //         "status" =>  $html
        //     );  
        // }
        
        // $result = [
        //     'recordsTotal'    => 1,
        //     'recordsFiltered' => 1,
        //     'data'            => $data,
        // ];
        // echo json_encode($result); 

    }

    public function group_form_addedit(Request $request)
    {
        if($request->input('id') > 0){
            $first = DB::table('group_form')->select('revise')->where('id', $request->input('id') )->first();
            $revise = $first->revise+1;
            DB::table('group_form')->where('id', $request->input('id') )->update([
                'form_th' => $request->input('form_th'),
                'form_en' => $request->input('form_en'),
                'form_type' => $request->input('form_type'),
                'form_year_use_start' => $request->input('form_year_use_start'),
                'form_year_use_end' => $request->input('form_year_use_end'),
                'form_ref' => $request->input('form_ref'),
                'code1' => $request->input('code1'),
                'code2' => $request->input('code2'),
                'code3' => $request->input('code3'),
                'code4' => $request->input('code4'),
                'code5' => $request->input('code5'),
                'criteria_weight_status' => $request->input('criteria_weight_status'),
                'criteria_weight' => $request->input('criteria_weight'),
                'compliance_weight_status' => $request->input('compliance_weight_status'),
                'compliance_weight' => $request->input('compliance_weight'),
                'revise' => $revise,
                'updated' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);

            $list_score           = $request->input('list_score');
            if(isset($list_score)){
                if(count($list_score) > 0){
                    DB::table('group_form_score_level')->where('group_form_id', $request->input('id'))->delete();
                    foreach($list_score AS $p){
                        DB::table('group_form_score_level')->insert([
                            'group_form_id' => $request->input('id'),
                            'score_start' => $p['score_start'],
                            'score_end' => $p['score_end'],
                            'score_level_th' => $p['score_level_th'],
                            'score_level_en' => $p['score_level_en'],
                            'created' => date('Y:m:d H:i:s'),
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
            }

            $list_topic           = $request->input('list_topic');
            if(isset($list_topic)){
                if(count($list_topic) > 0){
                    DB::table('group_form_topic')->where('group_form_id', $request->input('id'))->delete();
                    foreach($list_topic AS $p){
                        DB::table('group_form_topic')->insert([
                            'group_form_id' => $request->input('id'),
                            'evaluation_criteria_id' => $p['evaluation_criteria_id'],
                            'topic_weight' => $p['topic_weight'],
                            'detail_high_th' => $p['detail_high_th'],
                            'detail_high_en' => $p['detail_high_en'],
                            'detail_medium_th' => $p['detail_medium_th'],
                            'detail_medium_en' => $p['detail_medium_en'],
                            'detail_low_th' => $p['detail_low_th'],
                            'detail_low_en' => $p['detail_low_en'],
                            'created' => date('Y:m:d H:i:s'),
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
            }

            $data['data'][] = array(
                "status" =>  200,
            );
        }else{
            $id = DB::table('group_form')->insertGetId([
                'form_th' => $request->input('form_th'),
                'form_en' => $request->input('form_en'),
                'form_type' => $request->input('form_type'),
                'form_year_use_start' => $request->input('form_year_use_start'),
                'form_year_use_end' => $request->input('form_year_use_end'),
                'form_ref' => $request->input('form_ref'),
                'code1' => $request->input('code1'),
                'code2' => $request->input('code2'),
                'code3' => $request->input('code3'),
                'code4' => $request->input('code4'),
                'code5' => $request->input('code5'),
                'criteria_weight_status' => $request->input('criteria_weight_status'),
                'criteria_weight' => $request->input('criteria_weight'),
                'compliance_weight_status' => $request->input('compliance_weight_status'),
                'compliance_weight' => $request->input('compliance_weight'),
                'revise' => '0',
                'status' => '1',
                'create_date' => date('Y-m-d'),
                'created' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ]);

            $list_score           = $request->input('list_score');
            if(isset($list_score)){
                if(count($list_score) > 0){
                    foreach($list_score AS $p){
                        DB::table('group_form_score_level')->insert([
                            'group_form_id' => $id,
                            'score_start' => $p['score_start'],
                            'score_end' => $p['score_end'],
                            'score_level_th' => $p['score_level_th'],
                            'score_level_en' => $p['score_level_en'],
                            'created' => date('Y:m:d H:i:s'),
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
            }

            $list_topic           = $request->input('list_topic');
            if(isset($list_topic)){
                if(count($list_topic) > 0){
                    foreach($list_topic AS $p){
                        DB::table('group_form_topic')->insert([
                            'group_form_id' => $id,
                            'evaluation_criteria_id' => $p['evaluation_criteria_id'],
                            'topic_weight' => $p['topic_weight'],
                            'detail_high_th' => $p['detail_high_th'],
                            'detail_high_en' => $p['detail_high_en'],
                            'detail_medium_th' => $p['detail_medium_th'],
                            'detail_medium_en' => $p['detail_medium_en'],
                            'detail_low_th' => $p['detail_low_th'],
                            'detail_low_en' => $p['detail_low_en'],
                            'created' => date('Y:m:d H:i:s'),
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
            }

            // if(date('Y-m') <= (date('Y').'-2')){
            //     $checkYear = date('Y', strtotime('-1 year'));
            // }else{
                $checkYear = date('Y');
            // }
            DB::table('tb_employee_final_score')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
            ->where('tb_employee_final_score.status_pa','1')
            ->update([
                "status_pa" => '2'
            ]);
            
            
            
            $data['data'][] = array(
                "status" =>  200,
            );
        }
        
        echo json_encode($data); 

    }

    public function criteria_get_evaluation_criteria(Request $request)
    {
        $data = DB::table('evaluation_criteria')->where('id', $request->input('id') )->first();
        echo json_encode($data); 
    }

    public function get_edit_data(Request $request)
    {
        $group_form = DB::table('group_form')->where('id', $request->input('id') )->first(); 
        $group_form_score_level = DB::table('group_form_score_level')->where('group_form_id', $request->input('id') )->get(); 
        $group_form_topic = DB::table('group_form_topic')
        ->leftJoin('evaluation_criteria','evaluation_criteria.id','=','group_form_topic.evaluation_criteria_id')
        ->select('group_form_topic.*',
                 'evaluation_criteria.title_th AS evaluation_criteria_title_th',
                 'evaluation_criteria.title_en AS evaluation_criteria_title_en'
        )
        ->where('group_form_id', $request->input('id') )->get(); 

        $data = array(
            'group_form' => $group_form,
            'group_form_score_level' => $group_form_score_level,
            'group_form_topic' => $group_form_topic
        );
        echo json_encode($data);
    }

    public function group_form_changeactive(Request $request)
    {
        $id = DB::table('group_form')->where('id', $request->input('id') )->update(['status' => $request->input('status')]);

        if($id){
            $data['data'][] = array(
                "id" =>  $id,
                "status" =>  200,
            );
        }else{
            $data['data'][] = array(
                "id" =>  '',
                "status" =>  500,
            );
        }
        echo json_encode($data); 
        

    }

    public function copy_data(Request $request)
    {
        $group_form = DB::table('group_form')->where('id', $request->input('id') )->first(); 
        
        $id = DB::table('group_form')->where('id', $request->input('id') )->insertGetId([
            'form_th' => $group_form->form_th,
            'form_en' => $group_form->form_en,
            'form_type' => $group_form->form_type,
            'form_year_use_start' => date('Y'),
            'form_year_use_end' => date('Y'),
            'form_ref' => $group_form->form_ref,
            'code1' => $group_form->code1,
            'code2' => $group_form->code2,
            'code3' => $group_form->code3,
            'code4' => $group_form->code4,
            'code5' => $group_form->code5,
            'criteria_weight_status' => $group_form->criteria_weight_status,
            'criteria_weight' => $group_form->criteria_weight,
            'compliance_weight_status' => $group_form->compliance_weight_status,
            'compliance_weight' => $group_form->compliance_weight,
            'revise' => 0,
            'status' => '1',
            'create_date' => date('Y-m-d'),
            'created' => date('Y:m:d H:i:s'),
            'created_by' => Auth::user()->id
        ]);

        $group_form_score_level = DB::table('group_form_score_level')->where('group_form_id', $request->input('id') )->get(); 
        if(count($group_form_score_level) > 0){
            foreach($group_form_score_level AS $p){
                DB::table('group_form_score_level')->insert([
                    'group_form_id' => $id,
                    'score_start' => $p->score_start,
                    'score_end' => $p->score_end,
                    'score_level_th' => $p->score_level_th,
                    'score_level_en' => $p->score_level_en,
                    'created' => date('Y:m:d H:i:s'),
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        $group_form_topic = DB::table('group_form_topic')->where('group_form_id', $request->input('id') )->get(); 
        if(count($group_form_topic) > 0){
            foreach($group_form_topic AS $p){
                DB::table('group_form_topic')->insert([
                    'group_form_id' => $id,
                    'evaluation_criteria_id' => $p->evaluation_criteria_id,
                    'topic_weight' => $p->topic_weight,
                    'detail_high_th' => $p->detail_high_th,
                    'detail_high_en' => $p->detail_high_en,
                    'detail_medium_th' => $p->detail_medium_th,
                    'detail_medium_en' => $p->detail_medium_en,
                    'detail_low_th' => $p->detail_low_th,
                    'detail_low_en' => $p->detail_low_en,
                    'created' => date('Y:m:d H:i:s'),
                    'created_by' => Auth::user()->id
                ]);
            }
        }
        $data = array(
            'status' => 200
        );
        echo json_encode($data);
    }
}
