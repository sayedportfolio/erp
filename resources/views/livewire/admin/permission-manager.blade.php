<div class="container py-4">
    <h2 class="mb-4">Permission Management</h2>

    @if (session()->has('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="{{ $isEditing ? 'updatePermission' : 'createPermission' }}">
        <div class="mb-3">
            <label for="permission_name" class="form-label">Permission Name</label>
            <input type="text" wire:model="permission_name" class="form-control" id="permission_name">
            @error('permission_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="group" class="form-label">Group</label>
            <input type="text" wire:model="group" class="form-control" id="group" placeholder="e.g., user, reports">
            @error('group') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="remark" class="form-label">Remark</label>
            <textarea wire:model="remark" class="form-control" id="remark"></textarea>
            @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-{{ $isEditing ? 'warning' : 'primary' }}">
            {{ $isEditing ? 'Update' : 'Create' }} Permission
        </button>
        @if($isEditing)
        <button type="button" wire:click="resetFields" class="btn btn-secondary">Cancel</button>
        @endif
    </form>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Group</th>
                <th>Remark</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->group ?? 'N/A' }}</td>
                <td>{{ $permission->remark }}</td>
                <td>
                    <button wire:click="editPermission({{ $permission->id }})" class="btn btn-sm btn-warning">Edit</button>
                    <button wire:click="deletePermission({{ $permission->id }})" class="btn btn-sm btn-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No permissions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>