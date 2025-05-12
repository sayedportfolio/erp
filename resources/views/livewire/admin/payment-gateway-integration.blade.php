<div>
    <!-- Session-based notifications -->
    @if (session('message'))
    <div class="alert alert-{{ session('type') }} p-4 mb-4 rounded-lg bg-{{ session('type') === 'success' ? 'green' : (session('type') === 'error' ? 'red' : 'yellow') }}-100 border border-{{ session('type') === 'success' ? 'green' : (session('type') === 'error' ? 'red' : 'yellow') }}-300 text-{{ session('type') === 'success' ? 'green' : (session('type') === 'error' ? 'red' : 'yellow') }}-800">
        {{ session('message') }}
    </div>
    @endif

    <!-- Button to open modal -->
    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
        Add Payment Gateway
    </button>

    <!-- Modal for creating/editing -->
    @if ($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
            <h2 class="text-xl font-semibold mb-4">{{ $editing ? 'Edit' : 'Add' }} Payment Gateway</h2>
            <form wire:submit.prevent="save">
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" wire:model.debounce.500ms="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- API Key -->
                <div class="mb-4">
                    <label for="api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                    <input type="text" id="api_key" wire:model.debounce.500ms="api_key" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('api_key') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Secret Key -->
                <div class="mb-4">
                    <label for="secret_key" class="block text-sm font-medium text-gray-700">Secret Key</label>
                    <input type="text" id="secret_key" wire:model.debounce.500ms="secret_key" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('secret_key') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Active Checkbox -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="status" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <!-- Form Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="closeModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" wire:loading.attr="disabled" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 disabled:opacity-50 flex items-center">
                        <span wire:loading wire:target="save" class="inline-block animate-spin rounded-full h-5 w-5 border-t-2 border-white mr-2"></span>
                        {{ $editing ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Gateways Table -->
    <div class="mt-6 overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-sm rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 p-3 text-left text-sm text-gray-700">Name</th>
                    <th class="border border-gray-200 p-3 text-left text-sm text-gray-700">API Key</th>
                    <th class="border border-gray-200 p-3 text-left text-sm text-gray-700">Secret Key</th>
                    <th class="border border-gray-200 p-3 text-left text-sm text-gray-700">Status</th>
                    <th class="border border-gray-200 p-3 text-center text-sm text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gateways as $gateway)
                <tr>
                    <td class="border border-gray-200 p-3">{{ $gateway->name }}</td>
                    <td class="border border-gray-200 p-3">{{ $gateway->api_key }}</td>
                    <td class="border border-gray-200 p-3">{{ $gateway->secret_key }}</td>
                    <td class="border border-gray-200 p-3">{{ $gateway->status ? 'Active' : 'Inactive' }}</td>
                    <td class="border border-gray-200 p-3 flex justify-content-center gap-1">
                        <button wire:click="edit({{ $gateway->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition duration-200">
                            Edit
                        </button>
                        <button wire:click="delete({{ $gateway->id }})" wire:loading.attr="disabled" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200 flex items-center">
                            <span wire:loading wire:target="delete({{ $gateway->id }})" class="inline-block animate-spin rounded-full h-4 w-4 border-t-2 border-white mr-2"></span>
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border border-gray-200 p-3 text-center text-gray-500">No payment gateways found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>