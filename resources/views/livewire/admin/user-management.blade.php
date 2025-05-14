<div class="container mx-auto px-4 py-6 bg-gray-50 min-h-screen font-inter">
    <!-- Filters and Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-6">
        <!-- Search and Department Filter -->
        <div class="flex flex-wrap items-center gap-3 flex-grow">
            <div class="relative w-full sm:w-64">
                <i class="bi bi-search absolute left-3 top-2.5 text-gray-400 text-sm" aria-hidden="true"></i>
                <input
                    type="text"
                    wire:model.debounce.500ms="search"
                    placeholder="Search..."
                    class="pl-8 pr-2 py-2 w-full rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                    aria-label="Search users" />
            </div>

            <div class="relative w-full sm:w-56">
                <i class="bi bi-building absolute left-3 top-2.5 text-gray-400 text-sm" aria-hidden="true"></i>
                <select
                    wire:model="filterDepartment"
                    class="appearance-none pl-8 pr-8 py-2 w-full rounded-md border border-gray-300 text-sm focus:ring-teal-500 focus:outline-none bg-white"
                    aria-label="Filter by department">
                    <option value="">All Departments</option>
                    @foreach ($departments as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                <i class="bi bi-caret-down-fill absolute right-3 top-2.5 text-gray-400 text-xs pointer-events-none" aria-hidden="true"></i>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <button
                wire:click="$set('filterType', 'employee')"
                title="Filter Employees"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200 transition"
                aria-label="Filter by employee type">
                <i class="bi bi-person-badge text-lg"></i>
            </button>
            <button
                wire:click="$set('filterType', 'client')"
                title="Filter Clients"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-purple-100 text-purple-700 hover:bg-purple-200 transition"
                aria-label="Filter by client type">
                <i class="bi bi-person text-lg"></i>
            </button>
            <button
                wire:click="create"
                title="Add User"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-teal-500 text-white hover:bg-teal-600 transition"
                aria-label="Add new user">
                <i class="bi bi-plus-circle text-lg"></i>
            </button>
            <button
                wire:click="$set('filterStatus', '1')"
                title="Filter Active"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-green-100 text-green-700 hover:bg-green-200 transition"
                aria-label="Filter active users">
                <i class="bi bi-check-circle text-lg"></i>
            </button>
            <button
                wire:click="$set('filterStatus', '0')"
                title="Filter Inactive"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition"
                aria-label="Filter inactive users">
                <i class="bi bi-x-circle text-lg"></i>
            </button>
            <button
                wire:click="assignRole"
                title="Assign Role"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-indigo-500 text-white hover:bg-indigo-600 transition"
                aria-label="Assign role to users">
                <i class="bi bi-shield-lock text-lg"></i>
            </button>
            <button
                wire:click="assignPermission"
                title="Assign Permission"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-cyan-500 text-white hover:bg-cyan-600 transition"
                aria-label="Assign permission to users">
                <i class="bi bi-key text-lg"></i>
            </button>
            <button
                wire:click="bulkDelete"
                wire:confirm="Are you sure you want to delete the selected users?"
                title="Delete Selected"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-red-500 text-white hover:bg-red-600 transition"
                aria-label="Delete selected users">
                <i class="bi bi-trash text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Messages -->
    @if (session('message'))
    <div class="bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-3 mb-6 rounded-md text-sm" role="alert">
        {{ session('message') }}
    </div>
    @endif
    @if (session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 rounded-md text-sm" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        <table class="min-w-full table-fixed">
            <thead class="bg-teal-500 text-white">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium">
                        <input
                            type="checkbox"
                            wire:model="selectAll"
                            class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                            aria-label="Select all users">
                    </th>
                    <th
                        wire:click="sortBy('name')"
                        class="px-4 py-2 text-left text-xs font-medium cursor-pointer"
                        aria-sort="{{ $sortField === 'name' ? ($sortDirection === 'asc' ? 'ascending' : 'descending') : 'none' }}">
                        Name @if($sortField === 'name') {{ $sortDirection === 'asc' ? '↑' : '↓' }} @endif
                    </th>
                    <th
                        wire:click="sortBy('email')"
                        class="px-4 py-2 text-left text-xs font-medium cursor-pointer"
                        aria-sort="{{ $sortField === 'email' ? ($sortDirection === 'asc' ? 'ascending' : 'descending') : 'none' }}">
                        Email @if($sortField === 'email') {{ $sortDirection === 'asc' ? '↑' : '↓' }} @endif
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium">Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2">
                        <input
                            type="checkbox"
                            wire:model="selectedUsers"
                            value="{{ $user->id }}"
                            class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                            aria-label="Select user {{ $user->name }}">
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $user->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $user->email }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ ucfirst($user->type) }}</td>
                    <td class="px-4 py-2 text-sm">
                        <span class="{{ $user->status ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <button
                            wire:click="showDetails({{ $user->id }})"
                            class="text-teal-600 hover:text-teal-800"
                            aria-label="View details for {{ $user->name }}">
                            <i class="bi bi-info-circle text-lg"></i>
                        </button>
                        <button
                            wire:click="edit({{ $user->id }})"
                            class="text-blue-600 hover:text-blue-800"
                            aria-label="Edit {{ $user->name }}">
                            <i class="bi bi-pencil text-lg"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center text-sm text-gray-500">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Shutter Sidebar -->
    <div
        x-cloak
        class="{{ $showShutter ? 'translate-x-0' : 'translate-x-full' }} fixed top-0 right-0 h-full w-full md:w-80 bg-white shadow-2xl transition-transform duration-300 z-50 border-l border-gray-200"
        aria-hidden="{{ !$showShutter }}">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">User Details</h2>
                <button
                    wire:click="closeShutter"
                    class="text-gray-500 hover:text-gray-700 transition"
                    aria-label="Close user details">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-4 py-4 overflow-y-auto text-sm text-gray-700 space-y-4 flex-1 bg-white">
                @if($shutterMode === 'details' && $editingUser)
                <div class="space-y-2">
                    <div class="grid grid-cols-2 gap-y-2">
                        <span class="font-medium text-gray-600">Name:</span>
                        <span class="text-gray-800">{{ $editingUser->name }}</span>
                        <span class="font-medium text-gray-600">Email:</span>
                        <span class="text-gray-800">{{ $editingUser->email }}</span>
                        <span class="font-medium text-gray-600">Type:</span>
                        <span class="text-gray-800">{{ ucfirst($editingUser->type) }}</span>
                        <span class="font-medium text-gray-600">Status:</span>
                        <span class="text-gray-800">
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded bg-{{ $editingUser->status ? 'green' : 'red' }}-100 text-{{ $editingUser->status ? 'green' : 'red' }}-700">
                                {{ $editingUser->status ? 'Active' : 'Inactive' }}
                            </span>
                        </span>
                        @if($editingUser->employee)
                        <span class="font-medium text-gray-600">Branch:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->branch->name ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">Department:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->department->name ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">City:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->city->name ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">Phone:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->phone ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">Designation:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->designation ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">Joining Date:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->joining_date ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">Bank Account:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->bank_account_number ?? 'N/A' }}</span>
                        <span class="font-medium text-gray-600">IFSC Code:</span>
                        <span class="text-gray-800">{{ $editingUser->employee->bank_ifsc_code ?? 'N/A' }}</span>
                        @endif
                    </div>
                </div>
                @else
                <p class="text-gray-500 italic">No details to show.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit User -->
    {{-- Modal Overlay --}}
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-5000">
        <div class="absolute bg-white rounded-lg shadow-xl w-full max-w-4xl top-5 bottom-5 overflow-auto scrollbar-none p-3" x-data="{ tab: 'basic' }">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">User Registration</h2>
                <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Tab Headers --}}
            <div class="flex space-x-8 border-b mb-6">
                <button @click="tab = 'basic'"
                    :class="{ 'border-blue-600 text-blue-600': tab === 'basic', 'text-gray-500 hover:text-gray-700': tab !== 'basic' }"
                    class="pb-3 px-1 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Basic Information
                </button>
                <button @click="tab = 'employment'"
                    :class="{ 'border-blue-600 text-blue-600': tab === 'employment', 'text-gray-500 hover:text-gray-700': tab !== 'employment' }"
                    class="pb-3 px-1 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Employment Details
                </button>
                <button @click="tab = 'bank'"
                    :class="{ 'border-blue-600 text-blue-600': tab === 'bank', 'text-gray-500 hover:text-gray-700': tab !== 'bank' }"
                    class="pb-3 px-1 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Bank Information
                </button>
                <button @click="tab = 'documents'"
                    :class="{ 'border-blue-600 text-blue-600': tab === 'documents', 'text-gray-500 hover:text-gray-700': tab !== 'documents' }"
                    class="pb-3 px-1 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Documents
                </button>
            </div>

            <form wire:submit.prevent="save">
                {{-- Basic Tab --}}
                <div x-show="tab === 'basic'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name*</label>
                            <input wire:model.defer="form.basic.name" type="text" placeholder="John Doe"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                            <input wire:model.defer="form.basic.email" type="email" placeholder="john@example.com"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                            <input wire:model.defer="form.basic.password" type="password" placeholder="••••••••"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">User Type*</label>
                            <select wire:model.defer="form.basic.type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Type</option>
                                <option value="employee">Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input wire:model.defer="form.basic.phone" type="text" placeholder="+91 9876543210"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input wire:model.defer="form.basic.dob" type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select wire:model.defer="form.basic.gender"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input wire:model.defer="form.basic.address" type="text" placeholder="123 Main St"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PIN Code</label>
                            <input wire:model.defer="form.basic.pin_code" type="text" placeholder="560001"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <select wire:model.defer="form.basic.city_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Aadhar Number</label>
                            <input wire:model.defer="form.basic.aadhar_number" type="text" placeholder="1234 5678 9012"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                            <input wire:model.defer="form.basic.pan_number" type="text" placeholder="ABCDE1234F"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select wire:model.defer="form.basic.status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Employment Tab --}}
                <div x-show="tab === 'employment'" x-transition>
                    @if($form['basic']['type'] === 'employee')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Branch*</label>
                            <select wire:model.defer="form.employment.branch_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department*</label>
                            <select wire:model.defer="form.employment.department_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Designation*</label>
                            <input wire:model.defer="form.employment.designation" type="text" placeholder="Software Engineer"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date*</label>
                            <input wire:model.defer="form.employment.joining_date" type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Qualification</label>
                            <input wire:model.defer="form.employment.last_qualification" type="text" placeholder="B.Tech in Computer Science"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    @else
                    <div class="bg-blue-50 p-4 rounded-md border border-blue-100">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-blue-700 text-sm">Employment section is only applicable for employee accounts.</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Bank Tab --}}
                <div x-show="tab === 'bank'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Number*</label>
                            <input wire:model.defer="form.bank.account_number" type="text" placeholder="1234567890"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IFSC Code*</label>
                            <input wire:model.defer="form.bank.ifsc_code" type="text" placeholder="SBIN0001234"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Documents Tab --}}
                <div x-show="tab === 'documents'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Qualification Certificate</label>
                            <div class="flex items-center">
                                <input wire:model.defer="form.documents.qualification_certificate" type="text" placeholder="URL or upload file"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                    Upload
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Aadhar Certificate</label>
                            <div class="flex items-center">
                                <input wire:model.defer="form.documents.aadhar_certificate" type="text" placeholder="URL or upload file"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                    Upload
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PAN Certificate</label>
                            <div class="flex items-center">
                                <input wire:model.defer="form.documents.pan_certificate" type="text" placeholder="URL or upload file"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                    Upload
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                            <div class="flex items-center">
                                <input wire:model.defer="form.documents.image" type="text" placeholder="URL or upload file"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-between">
                    <div>
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" @click="tab = Object.keys({basic:1, employment:1, bank:1, documents:1})[Object.keys({basic:1, employment:1, bank:1, documents:1}).indexOf(tab)-1]"
                            x-show="tab !== 'basic'"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Previous
                        </button>
                        <button type="button" @click="tab = Object.keys({basic:1, employment:1, bank:1, documents:1})[Object.keys({basic:1, employment:1, bank:1, documents:1}).indexOf(tab)+1]"
                            x-show="tab !== 'documents'"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Next
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>