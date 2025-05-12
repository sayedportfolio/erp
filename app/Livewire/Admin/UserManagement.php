<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Branch;
use App\Models\Department;
use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserManagement extends Component
{
    use WithPagination;

    // Component state
    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $filterDepartment = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $showShutter = false;
    public $shutterMode = '';
    public $editingUser = null;
    public $selectedUsers = [];
    public $selectAll = false;
    public $selectedRoles = [];
    public $selectedPermissions = [];
    public $selectAllPermissions = false;

    // Constants for user types and statuses
    public const USER_TYPES = [
        'admin' => 'Admin',
        'employee' => 'Employee',
        'client' => 'Client',
    ];

    public const STATUSES = [
        1 => 'Active',
        0 => 'Inactive',
    ];

    // Form data
    public $form = [
        'basic' => [
            'name' => '',
            'email' => '',
            'password' => '',
            'type' => 'employee',
            'phone' => '',
            'dob' => '',
            'gender' => '',
            'address' => '',
            'pin_code' => '',
            'city_id' => '',
            'aadhar_number' => '',
            'pan_number' => ''
        ],

        'employment' => [
            'branch_id' => '',
            'department_id' => '',
            'designation' => '',
            'joining_date' => '',
            'last_qualification' => ''
        ],

        'bank' => [
            'bank_account_number' => '',
            'bank_ifsc_code' => '',
        ],

        'document' => [
            'qualification_certificate' => '',
            'aadhar_certificate' => '',
            'pan_certificate' => '',
            'image' => '',
        ]

    ];



    // Validation rules for the form.
    public function rules()
    {
        return [
            // Basic
            'form.basic.name' => 'required|string|max:255',
            'form.basic.email' => 'required|email|unique:users,email,' . ($this->form['basic']['userId'] ?? 'NULL'),
            'form.basic.password' => $this->form['basic']['userId'] ? 'nullable|min:6' : 'required|min:6',
            'form.basic.type' => 'required|in:employee,admin', // or any types you have
            'form.basic.phone' => 'nullable|string|max:20',
            'form.basic.dob' => 'nullable|date',
            'form.basic.gender' => 'nullable|in:male,female,other',
            'form.basic.address' => 'nullable|string',
            'form.basic.pin_code' => 'nullable|string|max:10',
            'form.basic.city_id' => 'nullable|exists:cities,id',
            'form.basic.aadhar_number' => 'nullable|string|max:20',
            'form.basic.pan_number' => 'nullable|string|max:20',
            'form.basic.status' => 'required|in:active,inactive', // Add your statuses

            // Employment (only if employee)
            'form.employment.branch_id' => 'required_if:form.basic.type,employee|exists:branches,id',
            'form.employment.department_id' => 'required_if:form.basic.type,employee|exists:departments,id',
            'form.employment.designation' => 'nullable|string|max:255',
            'form.employment.joining_date' => 'nullable|date',
            'form.employment.last_qualification' => 'nullable|string|max:255',

            // Bank
            'form.bank.account_number' => 'nullable|string|max:50',
            'form.bank.ifsc_code' => 'nullable|string|max:20',

            // Document
            'form.documents.qualification_certificate' => 'nullable|string|max:255',
            'form.documents.aadhar_certificate' => 'nullable|string|max:255',
            'form.documents.pan_certificate' => 'nullable|string|max:255',
            'form.documents.image' => 'nullable|string|max:255',
        ];
    }


    /**
     * Initialize the component.
     */
    public function mount()
    {
        $this->resetForm();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $query = User::query()->with([
            'employee' => fn($q) => $q->with(['branch', 'department', 'city']),
        ]);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDepartment) {
            $query->whereHas('employee', fn($q) => $q->where('department_id', $this->filterDepartment));
        }

        $users = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users,
            'roles' => Role::pluck('name', 'id'),
            'permissions' => Permission::all()->groupBy('group'),
            'branches' => Branch::all(),
            'departments' => Department::all(),
            'cities' => City::all(),
        ]);
    }

    /**
     * Update selected users when selectAll changes.
     */
    public function updatedSelectAll()
    {
        $this->selectedUsers = $this->selectAll
            ? $this->users->pluck('id')->toArray()
            : [];
    }

    /**
     * Update selectAll when selectedUsers changes.
     */
    public function updatedSelectedUsers()
    {
        $this->selectAll = count($this->selectedUsers) === $this->users->count();
    }

    /**
     * Sort the table by the given field.
     *
     * @param string $field
     */
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortField = $field;
    }



    /**
     * Open the create user modal.
     */
    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    /**
     * Open the edit user modal.
     *
     * @param int $id
     */
    public function edit($id)
    {
        try {
            $user = User::with('employee')->findOrFail($id);

            $this->form = [
                'basic' => [
                    'userId' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => '',
                    'type' => $user->type,
                    'status' => $user->status,
                    'dob' => $user->employee?->dob ?? '',
                    'gender' => $user->employee?->gender ?? '',
                    'phone' => $user->employee?->phone ?? '',
                    'address' => $user->employee?->address ?? '',
                    'pin_code' => $user->employee?->pin_code ?? '',
                    'last_qualification' => $user->employee?->last_qualification ?? '',
                    'aadhar_number' => $user->employee?->aadhar_number ?? '',
                    'pan_number' => $user->employee?->pan_number ?? '',
                ],

                'employment' => [
                    'branch_id' => $user->employee?->branch_id ?? '',
                    'department_id' => $user->employee?->department_id ?? '',
                    'city_id' => $user->employee?->city_id ?? '',
                    'designation' => $user->employee?->designation ?? '',
                    'joining_date' => $user->employee?->joining_date ?? '',
                ],

                'bank' => [
                    'bank_account_number' => $user->employee?->bank_account_number ?? '',
                    'bank_ifsc_code' => $user->employee?->bank_ifsc_code ?? '',
                ],

                'document' => [
                    'qualification_certificate' => $user->employee?->qualification_certificate ?? '',
                    'aadhar_certificate' => $user->employee?->aadhar_certificate ?? '',
                    'pan_certificate' => $user->employee?->pan_certificate ?? '',
                    'image' => $user->employee?->image ?? ''
                ]

            ];

            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to load user: ' . $e->getMessage());
        }
    }

    /**
     * Save the user (create or update).
     */
    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            // Create or update User
            $user = \App\Models\User::updateOrCreate(
                ['id' => $this->form['basic']['userId'] ?? null],
                [
                    'name' => $this->form['basic']['name'],
                    'email' => $this->form['basic']['email'],
                    'password' => $this->form['basic']['password'] ? bcrypt($this->form['basic']['password']) : $user->password ?? null,
                    'type' => $this->form['basic']['type'],
                    'status' => $this->form['basic']['status'],
                ]
            );

            // Create or update Employee details
            if ($this->form['basic']['type'] === 'employee') {
                $employee = \App\Models\Employee::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone' => $this->form['basic']['phone'],
                        'dob' => $this->form['basic']['dob'],
                        'gender' => $this->form['basic']['gender'],
                        'address' => $this->form['basic']['address'],
                        'pin_code' => $this->form['basic']['pin_code'],
                        'city_id' => $this->form['basic']['city_id'],
                        'aadhar_number' => $this->form['basic']['aadhar_number'],
                        'pan_number' => $this->form['basic']['pan_number'],
                        'branch_id' => $this->form['employment']['branch_id'],
                        'department_id' => $this->form['employment']['department_id'],
                        'designation' => $this->form['employment']['designation'],
                        'joining_date' => $this->form['employment']['joining_date'],
                        'last_qualification' => $this->form['employment']['last_qualification'],
                        'bank_account_number' => $this->form['bank']['account_number'],
                        'bank_ifsc_code' => $this->form['bank']['ifsc_code'],
                        'qualification_certificate' => $this->form['documents']['qualification_certificate'],
                        'aadhar_certificate' => $this->form['documents']['aadhar_certificate'],
                        'pan_certificate' => $this->form['documents']['pan_certificate'],
                        'image' => $this->form['documents']['image'],
                    ]
                );
            }

            DB::commit();

            session()->flash('success', 'User saved successfully.');
            $this->reset('form', 'showModal'); // Reset form & close modal

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Something went wrong. ' . $e->getMessage());
        }
    }


    /**
     * Handle employee creation or update.
     *
     * @param \App\Models\User $user
     */
    protected function handleEmployee(User $user)
    {
        if ($this->form['type'] !== 'employee') {
            Employee::where('user_id', $user->id)->delete();
            return;
        }

        Employee::updateOrCreate(
            ['user_id' => $user->id],
            [
                'branch_id' => $this->form['branch_id'],
                'department_id' => $this->form['department_id'],
                'city_id' => $this->form['city_id'],
                'name' => $this->form['name'],
                'phone' => $this->form['phone'] ?: null,
                'designation' => $this->form['designation'] ?: null,
                'joining_date' => $this->form['joining_date'] ?: null,
                'dob' => $this->form['dob'] ?: null,
                'gender' => $this->form['gender'] ?: null,
                'address' => $this->form['address'] ?: null,
                'pin_code' => $this->form['pin_code'] ?: null,
                'last_qualification' => $this->form['last_qualification'] ?: null,
                'aadhar_number' => $this->form['aadhar_number'] ?: null,
                'pan_number' => $this->form['pan_number'] ?: null,
                'bank_account_number' => $this->form['bank_account_number'] ?: null,
                'bank_ifsc_code' => $this->form['bank_ifsc_code'] ?: null,
                'qualification_certificate' => $this->form['qualification_certificate'] ?: null,
                'aadhar_certificate' => $this->form['aadhar_certificate'] ?: null,
                'pan_certificate' => $this->form['pan_certificate'] ?: null,
                'image' => $this->form['image'] ?: null,
                'status' => $this->form['status'],
            ]
        );
    }


    // Reset Form 
    public function resetForm()
    {
        $this->form = [
            'basic' => [
                'userId' => null,
                'name' => '',
                'email' => '',
                'password' => '',
                'type' => 'employee',
                'status' => true
            ],
            'employment' => [
                'branch_id' => '',
                'department_id' => '',
                'city_id' => '',
                'phone' => '',
                'designation' => '',
                'joining_date' => '',
                'dob' => '',
                'gender' => '',
                'address' => '',
                'pin_code' => '',
                'last_qualification' => '',
                'aadhar_number' => '',
                'pan_number' => '',
            ],

            'bank' => [
                'bank_account_number' => '',
                'bank_ifsc_code' => '',
            ],
            'document' => [
                'qualification_certificate' => '',
                'aadhar_certificate' => '',
                'pan_certificate' => '',
                'image' => '',
            ]

        ];

        $this->showModal = false;
        $this->showShutter = false;
        $this->shutterMode = '';
        $this->editingUser = null;
        $this->selectedUsers = [];
        $this->selectAll = false;
        $this->selectedRoles = [];
        $this->selectedPermissions = [];
        $this->selectAllPermissions = false;
        $this->resetValidation();
    }

    // toggle user status 
    // public function toggleStatus($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);
    //         $user->update(['status' => !$user->status]);

    //         if ($user->employee) {
    //             $user->employee->update(['status' => $user->status]);
    //         }

    //         session()->flash('message', 'User status updated successfully.');
    //     } catch (\Exception $e) {
    //         session()->flash('error', 'Failed to update status: ' . $e->getMessage());
    //     }
    // }

    // delete user 
    // public function bulkDelete()
    // {
    //     if (empty($this->selectedUsers)) {
    //         session()->flash('error', 'No users selected.');
    //         return;
    //     }

    //     try {
    //         User::whereIn('id', $this->selectedUsers)->delete();
    //         $this->selectedUsers = [];
    //         $this->selectAll = false;
    //         session()->flash('message', 'Selected users deleted successfully.');
    //     } catch (\Exception $e) {
    //         session()->flash('error', 'Failed to delete users: ' . $e->getMessage());
    //     }
    // }

    // Show user details
    public function showDetails($id)
    {
        try {
            $this->editingUser = User::with([
                'employee' => fn($q) => $q->with(['branch', 'department', 'city']),
            ])->findOrFail($id);
            $this->showShutter = true;
            $this->shutterMode = 'details';
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to load user details: ' . $e->getMessage());
        }
    }

    // assign role to user 
    public function assignRole()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'No users selected.');
            return;
        }

        $this->editingUser = User::find($this->selectedUsers[0]);
        $this->selectedRoles = [];
        $this->showShutter = true;
        $this->shutterMode = 'roles';
    }

    // Assign permission to user 
    public function assignPermission()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'No users selected.');
            return;
        }

        $this->editingUser = User::find($this->selectedUsers[0]);
        $this->selectedPermissions = [];
        $this->selectAllPermissions = false;
        $this->showShutter = true;
        $this->shutterMode = 'permissions';
    }

    // update all permission to user
    public function updatedSelectAllPermissions()
    {
        $this->selectedPermissions = $this->selectAllPermissions
            ? Permission::pluck('id')->toArray()
            : [];
    }

    // update selected permission to user 
    public function updatedSelectedPermissions()
    {
        $allPermissionIds = Permission::pluck('id')->toArray();
        $this->selectAllPermissions = count(array_intersect($allPermissionIds, $this->selectedPermissions)) === count($allPermissionIds);
    }

    // toggle permission group
    public function togglePermissionGroup($group)
    {
        $groupPermissions = Permission::where('group', $group)->pluck('id')->toArray();
        $this->selectedPermissions = count(array_intersect($groupPermissions, $this->selectedPermissions)) === count($groupPermissions)
            ? array_diff($this->selectedPermissions, $groupPermissions)
            : array_unique(array_merge($this->selectedPermissions, $groupPermissions));

        $this->updatedSelectedPermissions();
    }

    // save assign role 
    public function saveRoles()
    {
        try {
            foreach ($this->selectedUsers as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->syncRoles($this->selectedRoles);
                }
            }
            session()->flash('message', 'Roles assigned successfully.');
            $this->closeShutter();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to assign roles: ' . $e->getMessage());
        }
    }

    // save assign permission
    public function savePermissions()
    {
        try {
            foreach ($this->selectedUsers as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->syncPermissions($this->selectedPermissions);
                }
            }
            session()->flash('message', 'Permissions assigned successfully.');
            $this->closeShutter();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to assign permissions: ' . $e->getMessage());
        }
    }

    // close shutter
    public function closeShutter()
    {
        $this->showShutter = false;
        $this->shutterMode = '';
        $this->editingUser = null;
        $this->selectedRoles = [];
        $this->selectedPermissions = [];
        $this->selectAllPermissions = false;
    }

    // close modal 
    public function closeModal()
    {
        $this->resetForm();
    }
}
