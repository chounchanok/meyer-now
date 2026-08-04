<?php

namespace App\Http\Livewire\Permission;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleList extends Component
{
    public array|Collection $roles;

    protected $listeners = ['success' => 'updateRoleList'];

    public function render()
    {
        if (Auth::user()->hasRole('Developer')) {
            $this->roles = Role::with('permissions')->get();
        }else{
            $this->roles = Role::with('permissions')->where('id', '>' ,'1')->get();
        }
        return view('livewire.permission.role-list');
    }

    public function updateRoleList()
    {
        if (Auth::user()->hasRole('Developer')) {
            $this->roles = Role::with('permissions')->get();
        }else{
            $this->roles = Role::with('permissions')->where('id', '>' ,'1')->get();
        }
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
