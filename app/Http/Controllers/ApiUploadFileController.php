<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportFileEmployee;
use App\Imports\ImportEmployee;
use App\Models\EmployeeLogModel;
use App\Models\ImportEmployeeModel;
use App\Models\EmployeeModel;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ApiUploadFileController extends Controller
{
    public function call_import_employee(Request $request)
    {
        $ImpFile = ImportEmployeeModel::where('id_file', $request->id_file)->get();

        if (count($ImpFile) == 0) {
            $statusCode = 500;
            $msg = [
                'status' => 500,
                'message' => 'Data is not found.'
            ];
            return response()->json($msg, $statusCode);
        }
        return response()->json($ImpFile[0], 200);
    }
    public function find_employee(Request $request)
    {
        $empLog = EmployeeLogModel::where('ID_FILE', $request->id_file)->get();

        if (count($empLog) == 0) {
            $statusCode = 500;
            $msg = [
                'status' => 500,
                'message' => 'Data is not found.'
            ];
            return response()->json($msg, $statusCode);
        }
        return response()->json($empLog, 200);
    }
    public function get_import_employee()
    {
        $empLog = ImportEmployeeModel::all();
        return ($empLog);
    }


}
