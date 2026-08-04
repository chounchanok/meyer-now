<?php

namespace App\Http\Livewire;

use App\Models\EmployeeModel;
use Livewire\Component;

class EmployeeAutocomplete extends Component
{
    public $qurey = '';
    public $results = array();
    public $event;

    //Receive:
    // public function mount($orisoft_code)
    // {
    //     $this->emp_name = $orisoft_code;
    // }

    // Fetch records
    public function updatedQurey()
    {
        if (!empty($this->qurey)) {

            $this->results = EmployeeModel::orderby('orisoft_no', 'asc')
                ->select(['id', 'orisoft_no', 'employee_local_name_th', 'employee_local_name_en', 'section_description'])
                ->where('orisoft_no', 'like', '%' . $this->qurey . '%')
                ->limit(5)
                ->get();
        } else {
            $this->results = [];
        }
    }

    // Fetch record by ID
    public function select($id = 0)
    {
        $this->results = [];
        $this->qurey = '';
        $this->emitUp($this->event, $id);
    }

    public function render()
    {
        return view('livewire.employee-autocomplete');
    }
}
