<?php

namespace App\Livewire\Admin;

use App\Models\Branch;
use App\Models\City;
use App\Models\CompanyDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

class Branches extends Component
{
    public $branches = [];
    public $cities = [];
    public $search = '';
    public $filterStatus = '';
    public $showModal = false;
    public $branchId = null;
    public $company_detail_id = null;
    public $code = '';
    public $name = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $pin_code = '';
    public $city_id = '';
    public $status = true;

    protected $rules = [
        'company_detail_id' => 'required|exists:company_details,id',
        'code' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'required|string|max:500',
        'pin_code' => 'required|digits:6',
        'city_id' => 'required|exists:cities,id',
        'status' => 'required|boolean',
    ];

    public function mount()
    {
        $this->loadBranches();
        $this->cities = City::all();
        $this->company_detail_id = CompanyDetails::where('status', 1)->value('id');
    }

    public function render()
    {
        return view('livewire.admin.branches');
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function save()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            Log::info('Saving branch with data:', [
                'company_detail_id' => $this->company_detail_id,
                'code' => $this->code,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'pin_code' => $this->pin_code,
                'city_id' => $this->city_id,
                'status' => $this->status,
            ]);


            Branch::updateOrCreate(
                ['id' => $this->branchId],
                [
                    'company_detail_id' => $this->company_detail_id,
                    'code' => $this->code,
                    'name' => $this->name,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'address' => $this->address,
                    'pin_code' => $this->pin_code,
                    'city_id' => $this->city_id,
                    'status' => $this->status,
                ]
            );

            DB::commit();

            $this->showModal = false;
            $this->resetFields();
            $this->loadBranches();
            session()->flash('message', $this->branchId ? 'Branch updated successfully.' : 'Branch created successfully.');
        } catch (ValidationException $e) {
            $this->addError('validation', 'Validation failed: ' . implode(', ', Arr::flatten($e->errors())));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unable to save branch details: ' . $e->getMessage());
            session()->flash('error', 'Error saving branch: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);

        $this->branchId = $branch->id;
        $this->company_detail_id = $branch->company_detail_id;
        $this->code = $branch->code;
        $this->name = $branch->name;
        $this->phone = $branch->phone;
        $this->email = $branch->email;
        $this->address = $branch->address;
        $this->pin_code = $branch->pin_code;
        $this->city_id = $branch->city_id;
        $this->status = $branch->status;
        $this->showModal = true;
    }

    public function toggleStatus($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->update(['status' => !$branch->status]);
            $this->loadBranches();
            session()->flash('message', 'Branch status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Unable to toggle branch status: ' . $e->getMessage());
            session()->flash('error', 'Failed to update branch status.');
        }
    }

    public function delete($id)
    {
        try {
            Branch::findOrFail($id)->delete();
            $this->loadBranches();
            session()->flash('message', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Unable to delete branch: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete branch.');
        }
    }

    public function resetFields()
    {
        $this->branchId = null;
        $this->code = '';
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->pin_code = '';
        $this->city_id = '';
        $this->status = true;
        $this->resetErrorBag();
    }

    public function updatedFilterStatus()
    {
        $this->loadBranches();
    }


    public function loadBranches()
    {
        $this->branches = Branch::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%'))
            ->when($this->filterStatus !== '', fn($query) => $query->where('status', $this->filterStatus))
            ->with(['company', 'city'])
            ->get();
    }
}
