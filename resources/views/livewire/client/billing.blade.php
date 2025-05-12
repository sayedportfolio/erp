<div class="container-xxl py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 rounded shadow p-4 mb-4">
                <div class="flex justify-content-between mb-4">
                    <span class="title fw-semibold fs-5 border-bottom pb-1">Shipping Address</span>
                    @if (!$editMode)
                    <a href="javascript:void(0);" wire:click="enableEdit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    @endif
                </div>

                @if ($editMode)
                <form wire:submit.prevent="updateShippingAddress">
                    <div class="mb-3">
                        <label for="organization" class="block text-sm font-medium mb-1">Organization</label>
                        <input id="organization" type="text" wire:model.defer="organization" class="w-full border rounded p-1">
                        @error('organization') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="block text-sm font-medium mb-1">Address</label>
                        <textarea id="address" wire:model.defer="address" class="w-full border rounded p-1" rows="3"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pincode" class="block text-sm font-medium mb-1">Pin Code</label>
                        <input id="pincode" type="text" wire:model.defer="pin_code" class="w-full border rounded p-1">
                        @error('pin_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- City Dropdown -->
                    <div x-data="{ searchCity: '{{ $selectedCity}}', open: false }" class="relative mb-3">
                        <label for="city" class="block text-sm font-medium mb-1">City</label>
                        <input type="text"
                            placeholder="Search city..."
                            x-model="searchCity"
                            @focus="open = true"
                            @click.away="open = false"
                            class="w-full border rounded p-2 mb-1">

                        <div x-show="open" class="absolute z-50 bg-white border w-full max-h-48 overflow-y-auto rounded shadow">
                            @foreach($cities as $city)
                            <div x-show="searchCity === '' || '{{ strtolower($city->name) }}'.includes(searchCity.toLowerCase())"
                                @click="$wire.set('city_id', {{ $city->id }}); open = false; searchCity = '{{ $city->name }}'"
                                class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
                                {{ $city->name }}
                            </div>
                            @endforeach
                        </div>

                        <input type="hidden" wire:model="city_id">
                        @error('city_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- State Dropdown -->
                    <div x-data="{ searchState: '{{ $selectedState}}', open: false }" class="relative mb-3">
                        <label for="state" class="block text-sm font-medium mb-1">State</label>
                        <input type="text"
                            placeholder="Search state..."
                            x-model="searchState"
                            @focus="open = true"
                            @click.away="open = false"
                            class="w-full border rounded p-2 mb-1">

                        <div x-show="open" class="absolute z-50 bg-white border w-full max-h-48 overflow-y-auto rounded shadow">
                            @foreach($states as $state)
                            <div x-show="searchState === '' || '{{ strtolower($state->name) }}'.includes(searchState.toLowerCase())"
                                @click="$wire.set('selectedState', {{ $state->id }}); open = false; searchState = '{{ $state->name }}'"
                                class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
                                {{ $state->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Country Dropdown -->
                    <div x-data="{ searchCountry: '{{ $selectedCountry }}', open: false }" class="relative mb-3">
                        <label for="country" class="block text-sm font-medium mb-1">Country</label>
                        <input type="text"
                            placeholder="Search country..."
                            x-model="searchCountry"
                            @focus="open = true"
                            @click.away="open = false"
                            class="w-full border rounded p-2 mb-1">

                        <div x-show="open" class="absolute z-50 bg-white border w-full max-h-48 overflow-y-auto rounded shadow">
                            @foreach($countries as $country)
                            <div x-show="searchCountry === '' || '{{ strtolower($country->name) }}'.includes(searchCountry.toLowerCase())"
                                @click="$wire.set('selectedCountry', {{ $country->id }}); open = false; searchCountry = '{{ $country->name }}'"
                                class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
                                {{ $country->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="mb-4">
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg"
                            wire:loading.attr="disabled"
                            wire:loading.class="bg-gray-400"
                            wire:target="updateShippingAddress">
                            <span wire:loading.remove wire:target="updateShippingAddress">Save</span>
                            <span wire:loading wire:target="updateShippingAddress">Processing...</span>
                        </button>
                    </div>
                </form>

                @else
                <!-- View Mode -->
                <div class="flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-semibold fs-6">Organization</span>
                    <span>{{ $organization }}</span>
                </div>
                <div class="flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-semibold fs-6">Address</span>
                    <span>{{ $address ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-semibold fs-6">Pin Code</span>
                    <span>{{ $pin_code ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-semibold fs-6">City</span>
                    <span>{{ $cityName ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-semibold fs-6">State</span>
                    <span>{{ $stateName ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-semibold fs-6">Country</span>
                    <span>{{ $countryName ?? 'N/A' }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>