<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\CompanyDetails as ModelsCompanyDetails;
use Livewire\Component;

class CompanyDetails extends Component
{
    public $company;
    public $name, $phone, $email, $address, $pin_code, $city_id, $status;
    public $cities = [];
    public $showModal = false;

    public function mount()
    {
        $this->company = ModelsCompanyDetails::first();
        $this->cities = City::all();

        if ($this->company) {
            $this->fill($this->company->only([
                'name',
                'phone',
                'email',
                'address',
                'pin_code',
                'city_id',
                'status'
            ]));
        }
    }

    public function render()
    {
        return view('livewire.admin.company-details');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'pin_code' => 'required|numeric',
            'city_id' => 'required|exists:cities,id',
        ]);

        $this->company->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'pin_code' => $this->pin_code,
            'city_id' => $this->city_id,
            'status' => $this->status,
        ]);

        $this->showModal = false;
    }
}
