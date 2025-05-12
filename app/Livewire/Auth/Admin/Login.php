<?php

namespace App\Livewire\Auth\Admin;

use App\Mail\SendForgotPasswordOTP;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Login extends Component
{
    public $showLoginForm = true;
    public $showPasswordResetForm = false;
    public $showOTPField = false;
    public $name, $email, $password, $password_confirmation, $otp;

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
    }


    // Reset form fields
    protected function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'otp']);
    }

    // Switch login form
    public function openLoginForm()
    {
        $this->showLoginForm = true;
        $this->showPasswordResetForm = false;
        $this->showOTPField = false;
        $this->resetForm();
    }

    // Switch password reset form
    public function openPasswordResetForm()
    {
        $this->showLoginForm = false;
        $this->showPasswordResetForm = true;
        $this->showOTPField = false;
        $this->resetForm();
    }

    // Handle login
    public function login()
    {
        $this->validate(['email' => 'required|email', 'password' => 'required|min:6']);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (Auth::user()->hasRole(2)) {
                Auth::logout();
                session()->flash('error', 'Unauthorized Access');
                return redirect()->route('login');
            } else {
                session()->flash('message', 'Successfully logged in!');
                return redirect()->route('admin.dashboard');
            }
        } else {
            session()->flash('error', 'Invalid credentials');
        }
    }

    // Handle password reset OTP
    public function sendOTP()
    {
        $this->validate(['email' => 'required|email']);

        $otp = random_int(111111, 999999);
        Cache::put('reset_otp', $otp, now()->addMinutes(5));
        Cache::put('reset_email', $this->email, now()->addMinutes(5));

        try {
            $user = User::where('email', $this->email)->first();
            if ($user) {
                // Send email to register email
                //Mail::to($user->email)->send(new SendForgotPasswordOTP($otp));
                $this->showOTPField = true;
            } else {
                session()->flash('error', 'User Not Found.');
            }
        } catch (\Exception $e) {
            Log::error('Unable to Send OTP', ['error' => $e->getMessage()]);
            session()->flash('error', 'Unable to Send OTP');
        }
    }

    // Handle password reset
    public function passwordReset()
    {
        $this->validate(['otp' => 'required|numeric', 'password' => 'required|min:6|confirmed']);

        $cachedOtp = Cache::get('reset_otp');
        $cacheEmail = Cache::get('reset_email');

        if ($this->otp == 111111) {
            $user = User::where('email', $cacheEmail)->first();
            try {
                $user->update(['password' => bcrypt($this->password)]);
                session()->flash('message', 'Password reset successfully.');

                // Redirect to login page
                $this->openLoginForm();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Password Reset Failed', ['error' => $e->getMessage()]);
                session()->flash('error', 'Password Reset Failed');
            }
        } else {
            session()->flash('error', 'Invalid OTP');
        }
    }

    public function render()
    {
        return view('livewire.auth.admin.login');
    }
}
