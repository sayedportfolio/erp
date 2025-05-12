<div class="container py-4">
    <h2 class="mb-4">Role Management</h2>

    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" wire:model="name" class="form-control" id="name" placeholder="Role Name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Permissions Section -->
        <div class="mb-3">
            <h4>Assign Permissions</h4>
            <div class="form-check mb-3">
                <input type="checkbox" wire:model="selectAll" wire:change="toggleSelectAll" class="form-check-input" id="selectAll">
                <label class="form-check-label" for="selectAll">Select All Permissions</label>
            </div>
            @foreach($groupedPermissions as $group => $permissions)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="form-check">
                        <input type="checkbox" wire:model="selectAllGroups.{{ $group }}" wire:change="toggleGroup('{{ $group }}')" class="form-check-input" id="group_{{ $group }}">
                        <label class="form-check-label" for="group_{{ $group }}">{{ ucfirst(str_replace('_', ' ', $group)) }} Permissions</label>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($permissions as $id => $name)
                    <div class="form-check">
                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $name }}" class="form-check-input" id="permission_{{ $id }}">
                        <label class="form-check-label" for="permission_{{ $id }}">{{ $name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <button class="btn btn-{{ $isEdit ? 'warning' : 'primary' }}" type="submit">
                {{ $isEdit ? 'Update' : 'Add' }} Role
            </button>
            @if($isEdit)
            <button type="button" wire:click="resetForm" class="btn btn-secondary">Cancel</button>
            @endif
        </div>
    </form>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Permissions</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->permissions->pluck('name')->implode(', ') ?: 'None' }}</td>
                <td class="text-end">
                    <button wire:click="edit({{ $role->id }})" class="btn btn-sm btn-warning">Edit</button>
                    <button wire:click="delete({{ $role->id }})" class="btn btn-sm btn-danger"
                        onclick="confirm('Are you sure you want to delete this role?') || event.stopImmediatePropagation()">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No roles found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>