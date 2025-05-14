<?php

namespace App\Livewire\Admin;

use App\Models\Client;
use App\Models\ProjectCategory;
use App\Models\RegularProject;
use Livewire\Component;

class Projects extends Component
{

    public $showModal = false;
    public $clients;
    public $categories;
    public $regularProjects;
    public $selectedRegularProjectId;
    public $projectType = null;
    public $payment_types = [];
    public $hostingDetails = [
        [
            'host_name' => '',
            'host_url' => '',
            'host_username' => '',
            'host_password' => ''
        ]
    ];

    public $integrationDetails = [
        [
            'inte_name' => '',
            'inte_url' => '',
            'inte_username' => '',
            'inte_password' => '',
            'inte_key' => '',
            'inte_index' => '',
            'inte_token' => '',
        ]
    ];

    public $documents = [
        [
            'doc_title' => '',
            'doc_file' => '',
        ]
    ];

    public function mount()
    {
        $this->payment_types = [
            'advance',
            'full payment',
            'partial',
            'installment',
            'final settlement'
        ];
        $this->clients = Client::where(['status' => 1])->get();
        $this->regularProjects = RegularProject::where(['status' => 1])->get();
        $this->categories = ProjectCategory::where(['status' => 1])->get();
    }

    public function create()
    {
        $this->showModal = true;
    }

    public function addHosting()
    {
        $this->hostingDetails[] = [
            'host_name' => '',
            'host_url' => '',
            'host_username' => '',
            'host_password' => ''
        ];
    }

    public function addIntegration()
    {
        $this->integrationDetails[] = [
            'inte_name' => '',
            'inte_url' => '',
            'inte_username' => '',
            'inte_password' => '',
            'inte_key' => '',
            'inte_index' => '',
            'inte_token' => '',
        ];
    }

    public function addDocument()
    {
        $this->documents[] = [
            'inte_name' => '',
            'inte_url' => '',
            'inte_username' => '',
            'inte_password' => '',
            'inte_key' => '',
            'inte_index' => '',
            'inte_token' => '',
        ];
    }

    public function removeHosting($index)
    {
        unset($this->hostingDetails[$index]);
        $this->hostingDetails = array_values($this->hostingDetails); // Re-index array
    }

    public function removeIntegration($index)
    {
        unset($this->integrationDetails[$index]);
        $this->integrationDetails = array_values($this->integrationDetails); // Re-index array
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents); // Re-index array
    }

    public function formReset() {}

    public function save() {}

    public function render()
    {
        return view('livewire.admin.projects');
    }
}
