<?php

namespace App\Imports;

use App\Models\EmployeeLogModel;
use App\Models\EmployeeModel;
use Maatwebsite\Excel\Concerns\ToModel;


class ImportFileEmployee implements ToModel
{
    private $id_file;

    public function __construct($id_file)
    {
        $this->id_file = $id_file;
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
    public function model(array $row)
    {
        //  dd($row, $this->id_file);

        if (!isset($row[2])) {
            return null;
        }
        // ini_set('max_execution_time',180);
        // ini_set('memory_limit', '1024M');

        $Emp = EmployeeLogModel::create([
            "ID_FILE" => $this->id_file,
            "ORISOFT_NO" => sprintf("%06d", $row[0]),
            "ENG_TITLE" => $row[1],
            "TH_TITLE" => $row[2],
            "EMPLOYEE_LOCAL_NAME" => $row[3],
            "EMPLOYEE_NAME" => $row[4],
            "GRADE_CODE" => $row[5],
            "DIVISION_CODE" => $row[6],
            "DEPARTMENT_CODE" => $row[7],
            "SECTION_CODE" => $row[8],
            "POSITION_DESCRIPTION" => $row[9],
            "SECTION_DESCRIPTION" => $row[10],
            "DEPARTMENT_DESCRIPTION" => $row[11],
            "DIVISION_DESCRIPTION" => $row[12],
            "GRADE_DESCRIPTION" => $row[13],
            "ref_log_id" => $row[14],
            "BIRTH_DATE" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
            "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16]),
            "EMPLOYEE_TYPE" => $row[17],
            "EMPLOYEE_TYPE_DESCRIPTION" => $row[18],
            "HOME_CONTACT1" => $row[19],
            "MAIL_ADDRESS1" => $row[20],
            "POSITION_CODE" => $row[21],
            "DATE_RESIGNED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[22]),
            "DATE_RETIREMENT" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[23]),
            "DATE_CONFIRMED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[24]),
            "EMPLOYEE_STATUS" => $row[25],
            "EMPLOYEE_STATUS_DESCRIPTION" => $row[26],
        ]);
        $count = EmployeeModel::where('orisoft_no',sprintf("%06d", $row[0]))->count();
        if($count == 0){
            $newEmp = new EmployeeModel;
        }else{
            $rowdata = EmployeeModel::where('orisoft_no',sprintf("%06d", $row[0]))->orderBy('id','desc')->first();
            $newEmp = EmployeeModel::find($rowdata->id);
        }
        $newEmp->employee_import_id = $this->id_file;
        $newEmp->orisoft_no = $Emp->ORISOFT_NO;
        $newEmp->title_en = $Emp->ENG_TITLE ;
        $newEmp->title_th = $Emp->TH_TITLE ;
        $newEmp->employee_local_name_th = $Emp->EMPLOYEE_LOCAL_NAME ;
        $newEmp->employee_local_name_en = $Emp->EMPLOYEE_NAME;
        $newEmp->grade_code = $Emp->GRADE_CODE;
        $newEmp->division_code = $Emp->DIVISION_CODE;
        $newEmp->department_code = $Emp->DEPARTMENT_CODE;
        $newEmp->section_code = $Emp->SECTION_CODE;
        $newEmp->position_description = $Emp-> POSITION_DESCRIPTION;
        $newEmp->section_description = $Emp-> SECTION_DESCRIPTION;
        $newEmp->department_description = $row[11];
        $newEmp->division_description = $Emp->DIVISION_DESCRIPTION;
        $newEmp->grade_description = $Emp->GRADE_DESCRIPTION;
        $newEmp->ref_log_id = $Emp->ID;
        $newEmp->birth_date = $Emp->BIRTH_DATE;
        $newEmp->date_joined = $Emp->DATE_JOINED;
        $newEmp->employee_type = $Emp->EMPOLYEE_TYPE;
        $newEmp->employee_type_description = $Emp->EMPLOYEE_TYPE_DESCRIPTION;
        $newEmp->home_contact_1 = $Emp->HOME_CONTACT1;
        $newEmp->mail_address_1 = $Emp->MAIL_ADDRESS1;
        $newEmp->position_code = $Emp->POSITION_CODE;
        $newEmp->date_resigned = $Emp->DATE_RESIGNED;
        $newEmp->date_retirement = $Emp->DATE_RETIREMENT;
        $newEmp->date_confirmed = $Emp->DATE_CONFIRMED;
        $newEmp->employee_status = $Emp->EMPLOYEE_STATUS;
        $newEmp->employee_status_description = $Emp->EMPLOYEE_STATUS_DESCRIPTION;
        $newEmp->sort  = $Emp->sort;
        $newEmp->updated_at = date('Y-m-d H:i:s');
        $newEmp->save();
    }
}
