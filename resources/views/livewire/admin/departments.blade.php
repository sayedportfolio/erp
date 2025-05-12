<div class="container mx-auto p-8 bg-white rounded-lg shadow-lg">
    @if (session()->has('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 border-l-4 border-green-500 rounded-md">
        <strong>{{ session('success') }}</strong>
    </div>
    @endif

    <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Department Management</h2>

        <!-- Department Form -->
        <form wire:submit.prevent="save" class="space-y-6 bg-gray-50 p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Branch Selection -->
                <div>
                    <label for="branch" class="block text-sm font-medium text-gray-700">Branch</label>
                    <select wire:model="branch_id" id="branch" class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3">
                        <option value="">-- Select Branch --</option>
                        @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Department Name</label>
                    <input type="text" wire:model="name" id="name" class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3">
                    @error('name')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="status" id="status" class="form-checkbox text-indigo-600">
                <label for="status" class="ml-2 text-sm text-gray-700">Active</label>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    {{ $department_id ? 'Update Department' : 'Add Department' }}
                </button>
                @if ($department_id)
                <button type="button" wire:click="resetForm" class="ml-3 px-6 py-3 bg-gray-300 text-gray-800 rounded-lg font-semibold hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</button>
                @endif
            </div>
        </form>

        <!-- Department Table -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Existing Departments</h3>

            <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($departments as $dept)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dept->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dept->branch->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $dept->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dept->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                                <button wire:click="edit({{ $dept->id }})" class="text-indigo-600 hover:text-indigo-900 focus:outline-none">Edit</button>
                                <button wire:click="delete({{ $dept->id }})" class="text-red-600 hover:text-red-900 focus:outline-none">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No departments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>