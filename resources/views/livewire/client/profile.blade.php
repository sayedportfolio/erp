<div class="container-xxl">
    <div class="container">
        <div class="row">
            {{-- left panel --}}
            <div class="col-md-3 col-sm-12">
                <div class="w-40 relative mx-auto text-center">
                    {{-- Image Display --}}
                    <div class="relative">
                        <img src="{{ $newImage ? $newImage->temporaryUrl() : asset('storage/' . $image) }}"
                            class="w-40 h-40 object-cover rounded-full border shadow">

                        {{-- Edit Icon --}}
                        <label class="absolute bottom-1 right-1 bg-white p-1 rounded-full shadow cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L6 11.172V14h2.828l8.586-8.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 16a2 2 0 002 2h12a2 2 0 002-2H2z" clip-rule="evenodd" />
                            </svg>
                            <input type="file" wire:model="newImage" class="hidden">
                        </label>
                    </div>

                    {{-- Image Update Button --}}
                    @if ($newImage)
                    <button wire:click="updateImage"
                        class="mt-3 px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                        Update
                    </button>
                    @endif

                    {{-- Message --}}
                    @if (session()->has('message'))
                    <div class="mt-2 text-green-600 text-sm">{{ session('message') }}</div>
                    @endif

                    {{-- Error --}}
                    @error('error')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- Right Panel --}}
            <div class="col-md-9 col-sm-12">
                {{-- Basic Details Section --}}
                <div class="row">
                    <div class="col-12 rounded shadow p-4 mb-4">
                        <div class="flex justify-content-between mb-4">
                            <span class="title fw-semibold fs-5 border-bottom pb-1">Basic Details</span>
                            @if (!$editMode)
                            <a href="javascript:void(0);" wire:click="enableEdit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @endif
                        </div>
                        @if ($editMode)
                        {{-- Hidden input field --}}
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Name</label>
                            <input type="text" value="{{ $name }}" wire:model.defer="name" readonly class="w-full border rounded p-1">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Date of Birth</label>
                            <input type="date" value="{{ $dob }}" wire:model.defer="dob" class="w-full border rounded p-1">
                            @error('dob') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <label class="text-sm font-medium mb-1">Gender</label>
                            <div class="">
                                Male <input type="radio" name="gender" wire:model.defer="gender" value="male" class="mx-2">
                                Femail <input type="radio" name="gender" wire:model.defer="gender" value="female" class="mx-2">
                                Other <input type="radio" name="gender" wire:model.defer="gender" value="other" class="mx-2">
                                @error('dob') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Phone Number</label>
                            <input type="text" value="{{ $phone }}" wire:model.defer="phone" class="w-full border rounded p-1">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="text" value="{{ $email }}" wire:model.defer="email" class="w-full border rounded p-1">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium mb-1">Address</label>
                            <textarea type="text" value="{{ $address }}" wire:model.defer="address" class="w-full border rounded p-1" rows="3"></textarea>
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <button wire:click="updateDetails" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Update
                            </button>
                        </div>
                        @else
                        <div class="flex justify-content-between border-bottom pb-2 mb-3">
                            <span class="fw-semibold fs-6">Name</span>
                            <span>{{ $name }}</span>
                        </div>
                        <div class="flex justify-content-between border-bottom pb-2 mb-3">
                            <span class="fw-semibold fs-6">Date Of Birth</span>
                            <span>{{ $dob ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-content-between border-bottom pb-2 mb-3">
                            <span class="fw-semibold fs-6">Gender</span>
                            <span>{{ $gender ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-content-between border-bottom pb-2 mb-3">
                            <span class="fw-semibold fs-6">Phone Number</span>
                            <span>{{ $phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-content-between border-bottom pb-2 mb-3">
                            <span class="fw-semibold fs-6">Email</span>
                            <span>{{ $email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-content-between mb-3">
                            <span class="fw-semibold fs-6">Address</span>
                            <span>{{ $address ?? 'N/A' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                {{-- KYC Details Section --}}
                <div class="row">
                    <div class="col-12 rounded shadow p-4 mb-4">
                        <div class="mb-4">
                            <span class="title fw-semibold fs-5 border-bottom pb-1">KYC Details</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <label class="block text-sm font-medium mb-1">Aadhar Number</label>
                            @if($aadhar_number != null)
                            <input type="text" value="{{ $aadhar_number }}" wire:model.defer="aadhar_number" readonly class="w-full border rounded p-1">
                            @else
                            <a href="javascript:void(0);" class="text-decoration-none">Verify Now</a>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <label class="block text-sm font-medium mb-1">PAN Number</label>
                            @if($pan_number != null)
                            <input type="text" value="{{ $pan_number }}" wire:model.defer="pan_number" readonly class="w-full border rounded p-1">
                            @else
                            <a href="javascript:void(0);" class="text-decoration-none">Verify Now</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>