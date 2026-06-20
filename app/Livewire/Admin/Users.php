<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Traits\WithToast;

#[Layout('layouts.admin')]
class Users extends Component {
    use WithPagination, WithToast;

    public $search = '';
    public $roleFilter = '';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function updatingRoleFilter() {
        $this->resetPage();
    }

    public function updateRole($userId, $role) {
        User::findOrFail($userId)->update(['role' => $role]);
        $this->notify('User role updated successfully.', 'success');
    }

    public function delete($id) {
        User::findOrFail($id)->delete();
        $this->notify('User deleted.', 'success');
    }

    public function render() {
        $users = User::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->when($this->roleFilter, function($query) {
                $query->where('role', $this->roleFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users', ['users' => $users]);
    }
}
