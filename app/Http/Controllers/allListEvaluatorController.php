<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class allListEvaluatorController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.allListEvaluator.index');
    }
    public function table_evaluator_getdata(Request $request)
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
                "department_name" =>  'แผนกA',
                "percent" =>  '50%',
            );  
        }
        
        $result = [
            'recordsTotal'    => 1,
            'recordsFiltered' => 1,
            'data'            => $data,
        ];
        echo json_encode($result); 

    }

    public function table_alistE_getdata(Request $request)
    {
        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id','tb_employee_final_score.rec_year','tb_employee_final_score.created_at')
        ->groupBy('tb_employee_final_score.rec_year')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $substr = substr($value->rec_year,0,4);
                $cut = explode(' ',$value->created_at);
                $cut1 = explode('-',$cut[0]);
                $newdata = $cut1[2].'/'.$cut1[1].'/'.$cut1[0];
                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">',
                    "order"=> $key+1,
                    "title"=> "Review Lists of Evaluated Employees ".$substr,
                    "dateC"=> $newdata,
                    "action"=> "",
                    "year"=>$substr
                );  
            }
        }
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result); 

    }
}
