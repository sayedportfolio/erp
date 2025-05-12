<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Permission; // Use custom Permission model

class PermissionManager extends Component
{
    public $permission_name;
    public $remark;
    public $group; // New group field
    public $permissions;
    public $permissionId;
    public $isCreating = false;
    public $isEditing = false;

    protected $rules = [
        'permission_name' => 'required|unique:permissions,name|regex:/^[a-zA-Z0-9_-]+$/',
        'remark' => 'required|max:255',
        'group' => 'required|string|max:100',
    ];

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function createPermission()
    {

        $this->validate();

        try {
            $permission = Permission::create([
                'name' => strtolower($this->permission_name),
                'group' => strtolower($this->group),
                'remark' => strtolower($this->remark),
            ]);

            session()->flash('message', 'Permission created successfully!');
            $this->resetFields();
            $this->permissions = Permission::all();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create permission: ' . $e->getMessage());
        }
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->permission_name = $permission->name;
        $this->remark = $permission->remark;
        $this->group = $permission->group;
        $this->isEditing = true;
        $this->isCreating = false;
    }

    public function updatePermission()
    {
        $this->validate([
            'permission_name' => 'required|unique:permissions,name,' . $this->permissionId . '|regex:/^[a-zA-Z0-9_-]+$/',
            'remark' => 'required|max:255',
            'group' => 'required|string|max:100',
        ]);

        try {
            $permission = Permission::findOrFail($this->permissionId);
            $permission->update([
                'name' => strtolower($this->permission_name),
                'group' => strtolower($this->group),
                'remark' => strtolower($this->remark),
            ]);
            session()->flash('message', 'Permission updated successfully!');
            $this->resetFields();
            $this->permissions = Permission::all();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update permission: ' . $e->getMessage());
        }
    }

    public function deletePermission($id)
    {
        try {
            Permission::findOrFail($id)->delete();
            session()->flash('message', 'Permission deleted successfully!');
            $this->permissions = Permission::all();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }

    public function resetFields()
    {
        $this->permission_name = '';
        $this->remark = '';
        $this->group = '';
        $this->permissionId = null;
        $this->isCreating = false;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.admin.permission-manager');
    }
}
