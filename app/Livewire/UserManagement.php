<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class UserManagement extends Component
{
    use WithPagination;

    public $editingUserId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $isEditing = false;
    public $showModal = false;
    public $viewingUser = null;
    public $showViewModal = false;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createUser()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->editingUserId ?? 'NULL'),
            'password' => $this->isEditing ? 'nullable' : 'required|string|min:6|confirmed',
        ]);

        if ($this->isEditing) {
            $user = User::findOrFail($this->editingUserId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            if ($this->password) {
                $user->update(['password' => bcrypt($this->password)]);
            }

        $this->dispatch('swal:toast', type: 'success', message: 'User updated successfully!');

        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);

        $this->dispatch('swal:toast', type: 'success', message: 'User created successfully!');
        }

        $this->resetForm();
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        $this->resetPage();

    $this->dispatch('swal:toast', type: 'success', message: 'User deleted successfully!');
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    public function closeViewModal()
    {
        $this->reset(['viewingUser', 'showViewModal']);
    }

    protected function resetForm()
    {
        $this->reset([
            'name',
            'email',
            'password',
            'password_confirmation',
            'editingUserId',
            'isEditing',
            'showModal',
        ]);
    }

    public function viewUser($id)
    {
        $this->viewingUser = User::findOrFail($id);
        $this->showViewModal = true;
    }

    public function render()
    {
        return view('livewire.user-management', [
            'users' => User::where('id', '!=', Auth::id())->paginate(5),
        ]);
    }
}
