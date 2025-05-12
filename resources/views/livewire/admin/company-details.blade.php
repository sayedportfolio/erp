<div class="p-6 space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800">Company Information</h2>
        <button wire:click="openModal"
            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
            Edit Company Details
        </button>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-6 grid gap-4 md:grid-cols-2 text-gray-700">
        <div><strong>Name:</strong> {{ $company->name }}</div>
        <div><strong>Phone:</strong> {{ $company->phone ?? '—' }}</div>
        <div><strong>Email:</strong> {{ $company->email ?? '—' }}</div>
        <div><strong>Address:</strong> {{ $company->address }}</div>
        <div><strong>PIN Code:</strong> {{ $company->pin_code }}</div>
        <div><strong>City:</strong> {{ $company->city?->name }}</div>
        <div><strong>Status:</strong>
            <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                         {{ $company->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $company->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>

    {{-- Modal --}}
    @if ($showModal)
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
            <h3 class="text-xl font-bold mb-4">Edit Company Details</h3>

            <div class="grid gap-4 grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-medium">Name</label>
                    <input type="text" wire:model="name" class="w-full rounded border-gray-300" />
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Phone</label>
                    <input type="text" wire:model="phone" class="w-full rounded border-gray-300" />
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded border-gray-300" />
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">PIN Code</label>
                    <input type="text" wire:model="pin_code" class="w-full rounded border-gray-300" />
                </div>
                <div class="col-span-2">
                    <label class="block mb-1 text-sm font-medium">Address</label>
                    <textarea wire:model="address" class="w-full rounded border-gray-300"></textarea>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">City</label>
                    <select wire:model="city_id" class="w-full rounded border-gray-300">
                        <option value="">Select</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Status</label>
                    <select wire:model="status" class="w-full rounded border-gray-300">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button wire:click="$set('showModal', false)" class="text-gray-500 hover:underline">Cancel</button>
                <button wire:click="update"
                    class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                    Save
                </button>
            </div>
        </div>
    </div>
    @endif
</div>