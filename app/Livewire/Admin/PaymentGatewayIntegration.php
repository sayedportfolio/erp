<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Encryption\DecryptException;

class PaymentGatewayIntegration extends Component
{
    public $name;
    public $api_key;
    public $secret_key;
    public bool $status = true;
    public bool $editing = false;
    public ?int $editingId = null;
    public bool $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'api_key' => 'required|string|max:255',
        'secret_key' => 'required|string|max:255',
        'status' => 'boolean',
    ];

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $gateways = PaymentGateway::all();
        return view('livewire.admin.payment-gateway-integration', compact('gateways'));
    }

    /**
     * Open the modal for creating or editing a payment gateway.
     */
    public function openModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    /**
     * Close the modal and reset the form.
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /**
     * Save or update a payment gateway.
     */
    public function save(): void
    {
        try {
            $validated = $this->validate();

            // Log validated data for debugging
            Log::debug('Validated data:', $validated);

            // Encrypt sensitive fields
            $data = [
                'name' => $validated['name'],
                'api_key' => $validated['api_key'],
                'secret_key' => $validated['secret_key'],
                'status' => $validated['status'],
            ];

            if ($this->editing && $this->editingId) {
                $gateway = PaymentGateway::findOrFail($this->editingId);
                $gateway->update($data);
                $this->notify('Payment Gateway updated successfully!', 'success');
            } else {
                PaymentGateway::create($data);
                $this->notify('Payment Gateway added successfully!', 'success');
            }

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            Log::warning('Validation failed: ' . implode(', ', $errors));
            $this->notify('Validation failed: ' . implode(', ', $errors), 'error');
        } catch (\Exception $e) {
            Log::error('Failed to save payment gateway: ' . $e->getMessage());
            $this->notify('An error occurred while saving the payment gateway.', 'error');
        }
    }

    /**
     * Edit an existing payment gateway.
     *
     * @param int $id
     */
    public function edit(int $id): void
    {
        try {
            $gateway = PaymentGateway::findOrFail($id);
            $this->editing = true;
            $this->editingId = $id;
            $this->name = $gateway->name;
            $this->api_key = $gateway->api_key;
            $this->secret_key = $gateway->api_key;
            $this->status = $gateway->api_key;
            $this->status = $gateway->status;
            $this->showModal = true;
        } catch (\Exception $e) {
            Log::error('Failed to load payment gateway ID ' . $id . ': ' . $e->getMessage());
            $this->notify('An error occurred while loading the payment gateway.', 'error');
        }
    }

    /**
     * Delete a payment gateway.
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        try {
            PaymentGateway::findOrFail($id)->delete();
            $this->notify('Payment Gateway deleted successfully!', 'success');
        } catch (\Exception $e) {
            Log::error('Failed to delete payment gateway: ' . $e->getMessage());
            $this->notify('An error occurred while deleting the payment gateway.', 'error');
        }
    }

    /**
     * Reset the form fields.
     */
    private function resetForm(): void
    {
        $this->reset(['name', 'api_key', 'secret_key', 'status', 'editing', 'editingId']);
        $this->status = true;
    }

    /**
     * Dispatch a notification to the front-end or flash a session message.
     *
     * @param string $message
     * @param string $type
     */
    private function notify(string $message, string $type): void
    {
        $this->dispatch('notify', message: $message, type: $type);
        session()->flash('message', $message);
        session()->flash('type', $type);
    }
}
