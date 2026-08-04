<?php

namespace App\Imports;

use App\Models\EmployeeModel;
use Maatwebsite\Excel\Concerns\ToModel;


class ImportEmployee implements ToModel
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
        EmployeeModel::create([
            "employee_import_id" => $this->id_file,
            "position_code" => $row[1],
            "department_code" => $row[2],
            "created_at" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            "updated_at" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])
        ]);
    }
}
