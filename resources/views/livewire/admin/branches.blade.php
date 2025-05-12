<div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 shadow-lg rounded-2xl space-y-6 font-sans">
    <!-- Flash Messages -->
    @if (session()->has('message'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-4 transform transition-all duration-300 hover:scale-[1.01]" role="alert">
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-4 transform transition-all duration-300 hover:scale-[1.01]" role="alert">
        {{ session('error') }}
    </div>
    @endif
    @if ($errors->has('validation'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-4 transform transition-all duration-300 hover:scale-[1.01]" role="alert">
        {{ $errors->first('validation') }}
    </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Branch Management</h1>
        <button wire:click="openModal"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm shadow-md transition-all duration-200 hover:shadow-lg">
            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Branch
        </button>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4 items-center">
        <div class="relative w-full md:w-1/3">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name or code"
                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all duration-200" />
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <select wire:model="filterStatus" class="w-full md:w-1/4 py-2.5 px-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all duration-200">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto rounded-lg bg-white shadow-sm">
        <!-- Table Loader -->
        <div wire:loading wire:target="search, filterStatus" class="absolute inset-0 bg-white/80 flex items-center justify-center z-10">
            <div class="text-center">
                <div class="w-10 h-10 border-4 border-t-transparent border-indigo-500 rounded-full animate-spin mb-3"></div>
                <div class="text-sm text-gray-600">Loading branches...</div>
            </div>
        </div>

        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-200 text-xs uppercase tracking-wider text-gray-700">
                <tr>
                    <th class="px-6 py-3">Code</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Company</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">City</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branches as $branch)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4">{{ $branch->code }}</td>
                    <td class="px-6 py-4 font-medium">{{ $branch->name }}</td>
                    <td class="px-6 py-4">{{ $branch->company->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $branch->phone ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $branch->city->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <button wire:click="toggleStatus({{ $branch->id }})"
                            class="px-3 py-1 text-xs rounded-full {{ $branch->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} transition-colors duration-200">
                            {{ $branch->status ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 text-center space-x-3">
                        <button wire:click="edit({{ $branch->id }})"
                            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors duration-200">Edit</button>
                        <button wire:click="delete({{ $branch->id }})"
                            class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors duration-200">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">No branches found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if ($showModal)
    <div class="fixed inset-0 z-5000 flex items-center justify-center bg-black/60 transition-opacity duration-300">
        <div class="relative bg-white w-full max-w-2xl p-8 rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 animate-in">
            <!-- Loader -->
            <div wire:loading wire:target="save"
                class="absolute inset-0 bg-white/90 flex items-center justify-center z-50 rounded-2xl">
                <div class="text-center">
                    <div class="w-10 h-10 border-4 border-t-transparent border-indigo-500 rounded-full animate-spin mb-3"></div>
                    <div class="text-sm text-gray-700">Saving...</div>
                </div>
            </div>

            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-bold text-gray-900">
                    {{ $branchId ? 'Edit Branch' : 'Create Branch' }}
                </h2>
                <button wire:click="$set('showModal', false)"
                    class="text-gray-500 hover:text-red-600 text-2xl transition-colors duration-200">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Branch Code</label>
                    <input type="text" wire:model.defer="code" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                    @error('code') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Branch Name</label>
                    <input type="text" wire:model.defer="name" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                    @error('name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" wire:model.defer="phone" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                    @error('phone') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model.defer="email" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                    @error('email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" wire:model.defer="address" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                    @error('address') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- PIN -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">PIN Code</label>
                    <input type="number" wire:model.defer="pin_code" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                    @error('pin_code') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <select wire:model.defer="city_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" wire:model.defer="status" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-all duration-200" />
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                    @error('status') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-8 text-end space-x-3">
                <button type="button" wire:click="$set('showModal', false)"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg transition-all duration-200 hover:shadow">
                    Cancel
                </button>
                <button type="button" wire:click="save" wire:loading.attr="disabled"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg transition-all duration-200 hover:shadow disabled:opacity-50">
                    <span wire:loading.remove>{{ $branchId ? 'Update' : 'Create' }}</span>
                    <span wire:loading class="flex items-center">
                        <svg class="w-5 h-5 animate-spin mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>