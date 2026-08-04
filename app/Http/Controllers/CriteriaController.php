<?php

namespace App\Http\Controllers;
use App\DataTables\CriteriaDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CriteriaController extends Controller
{
    public function index(CriteriaDataTable $dataTable)
    {
        $datarow = DB::table('evaluation_criteria');
        $datarow = $datarow->orderBy('id', 'ASC')->get();
        return view('pages.formEvaluate.criteria.index', [
            "datarow" => $datarow,
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        // return $dataTable->render('pages.formEvaluate.criteria.index');
        // return view('pages.formEvaluate.criteria.index');
    }

    public function table_criteria_getdata(Request $request)
    {
        // ****** ใช้ในกรณัี Query จาก Database ******
        // $i = 1;
        // $search     = $request->input('search')['value'];
        // $start      = $request->input('start');
        // $pagestart  = $request->input('start')+1;
        // $length     = $request->input('length');
        // $field      = $request->input('order')[0]['column'];
        // $order      = $request->input('order')[0]['dir'];
        // $fieldby    = 'users.id';
        // $orderby    = 'asc';

        // if(empty($start)){
        //     $start = 0; 
        // }
         
        // if(empty($length)){
        //     $length = 10;
        // }

        // $gatall = DB::table('users')
        // ->select('users.id AS id',
        //         'users.name AS name',
        //         'users.email AS email'
        // );
        // $count_data = DB::table('users')
        // ->select('users.id AS id',
        //         'users.name AS name',
        //         'users.email AS email'
        // );

        // if(!empty($search)){
        //     $gatall->where(function ($query) use($search) {
        //         $query->orWhere('users.name','like','%'.$search.'%');
        //         $query->orWhere('users.email','like','%'.$search.'%');
        //     });

        //     $count_data->where(function ($query) use($search) {
        //         $query->orWhere('users.name','like','%'.$search.'%');
        //         $query->orWhere('users.email','like','%'.$search.'%');
        //     });
        // }

        // if(empty($field)){
        //     $fieldby = 'users.id';
        //     $orderby = 'asc';
        // }
        // else{
        //     if($field == 1){
        //         $fieldby = 'users.id';
        //     }else if($field == 2){
        //         $fieldby = 'users.name';
        //     }else if($field == 3){
        //         $fieldby = 'users.email';
        //     }
        // }
        
        // if($order){
        //     $order = $order;
        // }
        // else{
        //     $order = 'asc';
        // }
        // $gatall->orderBy($fieldby,$order);
        // $gatall = $gatall->skip($start)->take($length)->get();

        // $count_data = $count_data->orderBy('users.id', 'DESC')->count();
        
        // if(count($gatall)>0){
        //     foreach ($gatall as $value) {
        //         $checkbox = '<input type="checkbox">';
        //         $data[] = array(
        //             "checkbox" =>  $checkbox,
        //             "no" =>  $pagestart,
        //             "department_name" =>  'แผนกA',
        //             "percent" =>  '50%',
        //             "user_id" =>  $value->id,
        //             "name" =>  $value->name,
        //             "email" =>  $value->email,
        //             "fieldby" =>  $fieldby,
        //             "orderby" =>  $order,
        //         );
        //         $pagestart++;
        //     }
        // }else{
        //     $data = [];
        // }

        // $totalRecords = $totalDisplay = $count_data;
        // $result = [
        //     'recordsTotal'    => $totalRecords,
        //     'recordsFiltered' => $totalDisplay,
        //     'data'            => $data,
        // ];

        
        // ****** ใช้ในกรณัี Mockup data ******
        for ($i=1; $i < 11; $i++) { 
            $checkbox = '<input type="checkbox">';
            $data[] = array(
                "checkbox" =>  $checkbox,
                "no" =>  $i,
                "title_th" =>  'การทำงานเป็นทีม',
                "title_en" =>  'Team player',
                "date" => 'วว/ดด/ปปปป'
            );  
        }
        
        $result = [
            'recordsTotal'    => 1,
            'recordsFiltered' => 1,
            'data'            => $data,
        ];
        echo json_encode($result); 

    }

    public function criteria_addedit(Request $request)
    {
        if($request->input('id') > 0){
            $id = DB::table('evaluation_criteria')->where('id', $request->input('id') )
                    ->update([
                        'title_th' => $request->input('title_th'),
                        'title_en' => $request->input('title_en'),
                        'updated' => date('Y:m:d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);
        }else{
            $id = DB::table('evaluation_criteria')->insert([
                'title_th' => $request->input('title_th'),
                'title_en' => $request->input('title_en'),
                'created' => date('Y:m:d H:i:s'),
                'created_by' => Auth::user()->id
            ]);
        }
        

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

    public function criteria_getdata(Request $request)
    {
        $data = DB::table('evaluation_criteria')->where('id', $request->input('id') )->first();
        
        echo json_encode($data); 

    }
    
    public function criteria_changeactive(Request $request)
    {
        $id = DB::table('evaluation_criteria')->where('id', $request->input('id') )->update(['criteria_active' => $request->input('status')]);

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
