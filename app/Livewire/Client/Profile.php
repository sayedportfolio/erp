<?php

namespace App\Livewire\Client;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class Profile extends Component
{
    use WithFileUploads;

    public $editMode = false;

    public $client;
    public $image;
    public $newImage;


    public $name, $dob, $gender, $phone, $email, $address, $pin_code, $aadhar_number, $pan_number;

    public function mount()
    {
        $this->client = Client::where(['user_id' => Auth::id()])->get()->first();

        if ($this->client) {
            $this->name = $this->client->name;
            $this->dob = $this->client->dob;
            $this->gender = $this->client->gender;
            $this->phone = $this->client->phone;
            $this->email = $this->client->email;
            $this->address = $this->client->address;
            $this->pin_code = $this->client->pin_code;
            $this->aadhar_number = $this->client->aadhar_number;
            $this->pan_number = $this->client->pan_number;
            $this->image = (isset($this->client->image)) ? $this->client->image : "";
        }
    }

    public function updatedNewImage()
    {
        $this->validate([
            'newImage' => 'image|max:1024', // Max 1MB
        ]);
    }

    public function updateImage()
    {
        $this->validate([
            'newImage' => 'required|image|max:1024',
        ]);

        $path = $this->newImage->store('clients', 'public');
        $this->image = $path;
        $this->newImage = null;

        try {
            if ($this->client == null) {
                Client::create([
                    'user_id' => Auth::id(),
                    'image' => $this->image
                ]);
            } else {
                Client::where(['user_id' => Auth::id()])->update(['image' => $this->image]);
            }

            session()->flash('message', 'Profile image updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::disk('public')->exists($this->image)) {
                Storage::disk('public')->delete($this->image);
            }
            Log::error('Profile image was not updated.', ['error' => $e->getMessage()]);
            session()->flash('error', 'Profile image was not updated.');
        }
    }

    public function enableEdit()
    {
        $this->editMode = true;
    }

    public function updateDetails()
    {
        $this->validate([
            'dob' => 'required|date',
            'gender' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            $this->client->update([
                'dob' => $this->dob,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            $this->editMode = false;
            session()->flash('message', 'Details updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.client.profile');
    }
}
