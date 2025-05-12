<?php

namespace App\Livewire\Client;

use App\Models\Billing_Address;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Billing extends Component
{
    public $editMode = false;
    public $countries, $states, $cities;
    public $client;
    public $selectedCity, $selectedState, $selectedCountry;
    public $organization, $address, $pin_code, $client_id, $city_id, $cityName, $stateName, $countryName;

    public function mount()
    {
        $this->countries = Country::all();
        $this->states = State::all();
        $this->cities = City::all();

        // Get client
        $this->client = Client::where('user_id', Auth::id())->with('billingAddress.city.state.country')->first();

        // If billing address exists, pre-fill fields
        if ($this->client) {
            $this->client_id = $this->client->id;

            if ($this->client->billingAddress) {
                $billingAddress = $this->client->billingAddress;
                $this->organization = $billingAddress->organization_name;
                $this->address = $billingAddress->address;
                $this->pin_code = $billingAddress->pin_code;
                $this->city_id = $billingAddress->city_id;
                $this->cityName = $billingAddress->city->name ?? null;
                $this->stateName = $billingAddress->city->state->name ?? null;
                $this->countryName = $billingAddress->city->state->country->name ?? null;
                $this->selectedCity = $billingAddress->city->name ?? null;
                $this->selectedState = $billingAddress->city->state->name ?? null;
                $this->selectedCountry = $billingAddress->city->state->country->name ?? null;
            }
        }
    }

    public function enableEdit()
    {
        $this->editMode = true;
    }

    public function updatedSelectedCity($cityId)
    {
        $city = City::with('state.country')->find($cityId);
        if ($city) {
            $this->selectedState = $city->state->name;
            $this->selectedCountry = $city->state->country->name;
            $this->selectedCity = $city->name;
        }
    }

    public function updatedSelectedState($state_id)
    {
        $this->cities = City::where('state_id', $state_id)->get();
        $this->selectedCity = null;
        $this->city_id = null;
    }

    public function updatedSelectedCountry($country_id)
    {
        $this->states = State::where('country_id', $country_id)->get();
        $this->selectedState = null;
        $this->cities = collect();
        $this->selectedCity = null;
        $this->city_id = null;
    }

    public function updateShippingAddress()
    {
        $this->validate([
            'organization' => 'required|string',
            'address'      => 'required|string',
            'pin_code'     => 'required|numeric',
            'client_id'    => 'required|numeric',
            'city_id'      => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            if (!$this->client->billingAddress) {
                Billing_Address::create([
                    'organization_name' => $this->organization,
                    'address'           => $this->address,
                    'pin_code'          => $this->pin_code,
                    'client_id'         => $this->client_id,
                    'city_id'           => $this->city_id,
                ]);
            } else {
                $this->client->billingAddress->update([
                    'organization_name' => $this->organization,
                    'address'           => $this->address,
                    'pin_code'          => $this->pin_code,
                    'client_id'         => $this->client_id,
                    'city_id'           => $this->city_id,
                ]);
            }

            DB::commit();
            session()->flash('message', 'Billing Address is updated successfully');
            $this->editMode = false;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Billing Address update failed', ['error' => $e->getMessage()]);
            session()->flash('error', 'Billing Address is not updated');
        }
    }

    public function render()
    {
        return view('livewire.client.billing');
    }
}
