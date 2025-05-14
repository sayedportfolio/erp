<div class="container mx-auto px-4 py-6 bg-gray-50 min-h-screen font-inter">
    <!-- Filters and Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-6">
        <!-- Search  Project -->
        <div class="flex flex-wrap items-center gap-3 flex-grow">
            <div class="relative w-full sm:w-64">
                <i class="bi bi-search absolute left-3 top-2.5 text-gray-400 text-sm" aria-hidden="true"></i>
                <input
                    type="text"
                    wire:model.debounce.500ms="search"
                    placeholder="Enter project number..."
                    class="pl-8 pr-2 py-2 w-full rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                    aria-label="Search projects" />
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <button
                wire:click="create"
                title="Add New Project"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-teal-500 text-white hover:bg-teal-600 transition"
                aria-label="Add new project">
                <i class="bi bi-plus-circle text-lg"></i>
            </button>
            <button
                wire:click="$set('filterStatus', 'completed')"
                title="Completed Projects"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-green-100 text-green-700 hover:bg-green-200 transition"
                aria-label="Completed projects">
                <i class="bi bi-check-circle-fill text-lg"></i>
            </button>
            <button
                wire:click="$set('filterStatus', 'active')"
                title="Active Projects"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition"
                aria-label="Active projects">
                <i class="bi bi-check-circle text-lg"></i>
            </button>
            <button
                wire:click="$set('filterStatus', 'inactive')"
                title="Inactive Projects"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition"
                aria-label="Inactive projects">
                <i class="bi bi-slash-circle text-lg"></i>
            </button>
            <button
                wire:click="$set('filterStatus', 'rejected')"
                title="Rejected Projects"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-red-100 text-yellow-700 hover:bg-yellow-200 transition"
                aria-label="Rejected Projects">
                <i class="bi bi-x-circle text-lg"></i>
            </button>
            <button
                wire:click="bulkDelete"
                wire:confirm="Are you sure you want to delete the selected users?"
                title="Delete Selected Projects"
                class="w-10 h-10 flex items-center justify-center rounded-md bg-red-500 text-white hover:bg-red-600 transition"
                aria-label="Delete selected projects">
                <i class="bi bi-trash text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Project add or delete modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-5000">
        <div class="absolute bg-white rounded-lg shadow-xl w-full max-w-4xl top-5 bottom-5 p-3 flex flex-col"
            x-data="{ tab: 'Basic', tabs: ['Basic', 'HostingDetails', 'integrationDetails', 'documents'] }">
            <!-- Modal Header -->
            <div class="flex justify-between items-center">
                <!-- Tab Headers -->
                <div class="flex items-center gap-3">
                    <template x-for="t in tabs" :key="t" class="space-x-6">
                        <button
                            @click="tab = t"
                            :class="{'border-b-2 border-blue-600 text-blue-600': tab === t, 'text-gray-500 hover:text-gray-700 border-b-2 border-transparent': tab !== t }"
                            class="py-2 px-1 font-medium text-sm focus:outline-none transition-colors duration-200 capitalize">
                            <span x-text="t.replace(/([A-Z])/g, ' $1')"></span>
                        </button>
                    </template>
                </div>
                <!-- Close Icon -->
                <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-3">
                <!-- Basic Tab -->
                <div x-show="tab === 'Basic'" x-transition>
                    <div class="flex justify-center gap-6 mb-3">
                        <button wire:click="$set('projectType', 'regular')" class="flex items-center px-3 py-2 justify-center rounded bg-blue-100 text-green-700 hover:bg-green-200">
                            <i class="bi bi-check-circle-fill text-lg"></i>&nbsp;Regular
                        </button>
                        <button wire:click="$set('projectType', 'custom')" class="flex items-center px-3 py-2 justify-center rounded bg-yellow-100 text-green-700 hover:bg-green-200">
                            <i class="bi bi-list-check text-lg"></i>&nbsp;Customize
                        </button>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Left Column: Client Dropdown -->
                        <div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Client *</label>
                                <select wire:model.defer="form.basic.client"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" selected disabled class="text-muted">Select Client</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client->id}}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                                <input wire:model.defer="form.basic.start_date" type="date" placeholder="Project name ..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expected End Date *</label>
                                <input wire:model.defer="form.basic.expected_end_date" type="date" placeholder="Project name ..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type *</label>
                                <select wire:model.defer="form.basic.payment_type"
                                    class="w-full px-3 py-2 pr-8 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" selected disabled class="text-muted">Select Project Category</option>
                                    @foreach($payment_types as $payment_type)
                                    <option value="{{ $payment_type }}">{{ $payment_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Right Column: Project Cards -->
                        <div>
                            @if($projectType == 'regular')
                            @foreach($regularProjects as $rproject)
                            <div class="mb-4">
                                <div wire:click="getRegularProjectDetails({{ $rproject->id }})"
                                    class="cursor-pointer transition-all duration-300 hover:shadow-lg bg-light rounded-2xl p-4 flex  gap-4 border hover:border-blue-500">
                                    <div class="bg-blue-100 text-blue-600 p-2 rounded-full w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $rproject->name }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $rproject->description }}</p>
                                        <p class="text-sm text-gray-700 mt-2 font-medium">
                                            💰 Cost: {{ number_format($rproject->cost, 2) }} ৳
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif($projectType == 'custom')
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                <select wire:model.defer="form.basic.project_category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" selected disabled class=" text-muted">Select Project Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Name *</label>
                                <input wire:model.defer="form.basic.name" type="text" placeholder="Project name ..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Description *</label>
                                <textarea wire:model.defer="form.basic.description" rows="5" placeholder="Project description..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Cost *</label>
                                <input wire:model.defer="form.basic.cost" type="text" placeholder="Project cost ..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- HostingDetails Tab -->
                <div x-show="tab === 'HostingDetails'" x-transition>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium">Hosting Details</h4>
                        <button wire:click.prevent="addHosting" type="button" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-blue-600">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>

                    @foreach($hostingDetails as $index => $hosting)
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg relative" wire:key="hosting-{{ $index }}">
                        @if($index > 0)
                        <button
                            wire:click.prevent="removeHosting({{ $index }})"
                            type="button"
                            class="absolute top-1 right-1 text-red-500 hover:text-red-700">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        @endif

                        <div class="space-y-4">
                            <input
                                wire:model="hostingDetails.{{ $index }}.host_name"
                                type="text"
                                placeholder="Host name ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="hostingDetails.{{ $index }}.host_url"
                                type="text"
                                placeholder="Host url ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="hostingDetails.{{ $index }}.host_username"
                                type="text"
                                placeholder="Host username ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="hostingDetails.{{ $index }}.host_password"
                                type="password"
                                placeholder="Host password ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    @endforeach
                </div>


                <!-- IntegrationDetails Tab -->
                <div x-show="tab === 'integrationDetails'" x-transition>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium">Integration Details</h4>
                        <button wire:click.prevent="addIntegration" type="button" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-blue-600">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>

                    @foreach($integrationDetails as $index => $integration)
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg relative" wire:key="integration-{{ $index }}">
                        @if($index > 0)
                        <button
                            wire:click.prevent="removeIntegration({{ $index }})"
                            type="button"
                            class="absolute top-1 right-1 text-red-500 hover:text-red-700">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        @endif

                        <div class="space-y-4">
                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_name"
                                type="text"
                                placeholder="Integration name ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_url"
                                type="text"
                                placeholder="Integration url ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_username"
                                type="text"
                                placeholder="Integration username ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_password"
                                type="password"
                                placeholder="Integration password ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_key"
                                type="password"
                                placeholder="Integration key ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">

                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_index"
                                type="password"
                                placeholder="Integration index ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">

                            <input
                                wire:model="integrationDetails.{{ $index }}.inte_token"
                                type="password"
                                placeholder="Integration token ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Documents Tab -->
                <div x-show="tab === 'documents'" x-transition>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium">Documents</h4>
                        <button wire:click.prevent="addDocument" type="button" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-blue-600">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>

                    @foreach($documents as $index => $document)
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg relative" wire:key="document-{{ $index }}">
                        @if($index > 0)
                        <button
                            wire:click.prevent="removeDocument({{ $index }})"
                            type="button"
                            class="absolute top-1 right-1 text-red-500 hover:text-red-700">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        @endif

                        <div class="space-y-4">
                            <input
                                wire:model="documents.{{ $index }}.inte_title"
                                type="text"
                                placeholder="Document title ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input
                                wire:model="documents.{{ $index }}.inte_file"
                                type="file"
                                placeholder="Document file ..."
                                class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="relative w-full px-6 py-3 bg-white mt-auto">
                <div class="flex justify-between items-center">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <div class="flex space-x-3">
                        <button type="button"
                            @click="tab = tabs[tabs.indexOf(tab) - 1]"
                            x-show="tabs.indexOf(tab) > 0"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                        <button type="button"
                            @click="tab = tabs[tabs.indexOf(tab) + 1]"
                            x-show="tabs.indexOf(tab) < tabs.length - 1"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Next
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>