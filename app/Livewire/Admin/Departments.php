<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Department;
use App\Models\Branch;

class Departments extends Component
{
    public $departments, $branches;
    public $department_id;
    public $branch_id, $name, $status = true;

    public function mount()
    {
        $this->branches = Branch::all();
        $this->loadDepartments();
    }

    public function loadDepartments()
    {
        $this->departments = Department::with('branch')->get();
    }

    public function resetForm()
    {
        $this->department_id = null;
        $this->branch_id = null;
        $this->name = '';
        $this->status = true;
    }

    public function save()
    {
        $this->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
        ]);

        Department::updateOrCreate(
            ['id' => $this->department_id],
            [
                'branch_id' => $this->branch_id,
                'name' => $this->name,
                'status' => $this->status,
            ]
        );

        session()->flash('success', $this->department_id ? 'Updated successfully!' : 'Created successfully!');
        $this->resetForm();
        $this->loadDepartments();
    }

    public function edit($id)
    {
        $dept = Department::findOrFail($id);
        $this->department_id = $dept->id;
        $this->branch_id = $dept->branch_id;
        $this->name = $dept->name;
        $this->status = $dept->status;
    }

    public function delete($id)
    {
        Department::destroy($id);
        session()->flash('success', 'Deleted successfully!');
        $this->loadDepartments();
    }

    public function render()
    {
        return view('livewire.admin.departments');
    }
}
