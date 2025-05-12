<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Permission; // Use custom Permission model

class RoleManager extends Component
{
    public $roles;
    public $name;
    public $role_id;
    public $isEdit = false;
    public $selectedPermissions = [];
    public $groupedPermissions;
    public $selectAllGroups = [];
    public $selectAll = false;

    protected $rules = [
        'name' => 'required|string|min:3|unique:roles,name|regex:/^[a-zA-Z0-9_-]+$/',
    ];

    public function mount()
    {
        $this->loadRoles();
        $this->loadPermissions();
    }

    public function loadRoles()
    {
        $this->roles = Role::orderBy('name')->get();
    }

    public function loadPermissions()
    {
        $this->groupedPermissions = Permission::all()->groupBy('group')->map(function ($group) {
            return $group->pluck('name', 'id');
        })->toArray();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->role_id = null;
        $this->isEdit = false;
        $this->selectedPermissions = [];
        $this->selectAllGroups = [];
        $this->selectAll = false;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        try {
            $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success', 'Role created successfully.');
            $this->resetForm();
            $this->loadRoles();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->name = $role->name;
        $this->role_id = $role->id;
        $this->isEdit = true;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->updateSelectAllState();
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|min:3|unique:roles,name,' . $this->role_id . '|regex:/^[a-zA-Z0-9_-]+$/',
        ]);

        try {
            $role = Role::findOrFail($this->role_id);
            $role->update(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success', 'Role updated successfully.');
            $this->resetForm();
            $this->loadRoles();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Role::findOrFail($id)->delete();
            session()->flash('success', 'Role deleted successfully.');
            $this->loadRoles();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

    public function toggleGroup($group)
    {
        $groupPermissions = array_keys($this->groupedPermissions[$group] ?? []);
        if ($this->selectAllGroups[$group] ?? false) {
            $this->selectedPermissions = array_merge($this->selectedPermissions, $groupPermissions);
        } else {
            $this->selectedPermissions = array_diff($this->selectedPermissions, $groupPermissions);
        }
        $this->selectedPermissions = array_unique($this->selectedPermissions);
        $this->updateSelectAllState();
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPermissions = collect($this->groupedPermissions)->flatten()->toArray();
            $this->selectAllGroups = array_fill_keys(array_keys($this->groupedPermissions), true);
        } else {
            $this->selectedPermissions = [];
            $this->selectAllGroups = [];
        }
    }

    public function updateSelectAllState()
    {
        foreach ($this->groupedPermissions as $group => $permissions) {
            $groupPermissions = array_keys($permissions);
            $this->selectAllGroups[$group] = count(array_intersect($groupPermissions, $this->selectedPermissions)) === count($groupPermissions);
        }

        $allPermissions = collect($this->groupedPermissions)->flatten()->toArray();
        $this->selectAll = count(array_intersect($allPermissions, $this->selectedPermissions)) === count($allPermissions);
    }

    public function updatedSelectedPermissions()
    {
        $this->updateSelectAllState();
    }

    public function render()
    {
        return view('livewire.admin.role-manager');
    }
}
