<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AddUserModal extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $role = [];
    public $orisoft_code;

    public $edit_mode = false;

    protected $rules = [];


    protected function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email' . ($this->edit_mode ? ",{$this->edit_mode}" : ''),
            'role' => 'required|array',
        ];
    }

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
    ];

    public function render()
    {
        if (Auth::user()->hasRole('Developer')) {
            $roles = Role::with('permissions')->get();
        } else {
            $roles = Role::with('permissions')->where('id', '>', '1')->get();
        }
        return view('livewire.user.add-user-modal', compact('roles'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();
        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data = ['name' => $this->name];
            $data = ['orisoft_code' => $this->orisoft_code];
            if (!$this->edit_mode) {
                $data['password'] = Hash::make($this->email);
            }

            // // Create a new user record in the database
            $user = User::updateOrCreate(['email' => $this->email], $data);

            if ($this->edit_mode) {
                // Assign selected role for user
                $user->syncRoles($this->role);

                // Emit a success event with a message
                $this->emit('success', __('User updated'));
            } else {
                // dd($this->role);
                // Assign selected role for user
                $user->syncRoles($this->role);
                // $user->assignRole($this->role);

                // Send a password reset link to the user's email
                // Password::sendResetLink($user->only('email'));

                // Emit a success event with a message
                $this->emit('success', __('New user created'));
            }
        });

        // Reset the form fields after successful submission
        $this->reset();
    }

    public function deleteUser($id)
    {
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->emit('error', 'User cannot be deleted');
            return;
        }

        // Delete the user record with the specified ID
        User::destroy($id);

        // Emit a success event with a message
        $this->emit('success', 'User successfully deleted');
    }

    public function updateUser($id)
    {
        $this->edit_mode = $id;

        $user = User::find($id);

        $this->id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->orisoft_code = $user->orisoft_code;
        $this->role = $user->roles?->pluck('name') ?? [];
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function removeEmployee()
    {
        $this->orisoft_code = null;
    }
}
