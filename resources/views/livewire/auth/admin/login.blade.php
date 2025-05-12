<div class="flex justify-center items-center min-h-screen">
    <div class="glossy-bg p-8 w-96 rounded-lg shadow-lg">

        @if(session()->has('message'))
        <div class="text-green-500 text-center mb-4">{{ session('message') }}</div>
        @endif

        @if(session()->has('error'))
        <div class="text-red-500 text-center mb-4">{{ session('error') }}</div>
        @endif

        @if($showLoginForm)
        <h2 class="text-center mb-6">Login</h2>
        <form wire:submit.prevent="login">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input wire:model="email" type="email"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input wire:model="password" type="password"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your password"
                    required>
            </div>
            <p class="mt-4 text-end">
                <a href="javascript:void(0);" wire:click.prevent="openPasswordResetForm"
                    class="text-blue-500 text-decoration-none">Forgot Password</a>
            </p>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg" wire:loading.attr="disabled"
                wire:target="login">
                <span wire:loading.remove wire:target="login">Login</span>
                <span wire:loading wire:target="login">Processing...</span>
            </button>
        </form>
        @endif

        @if($showPasswordResetForm)
        <!-- Password Reset Form -->
        <h2 class="text-center mb-6">Reset Password</h2>
        <form wire:submit.prevent="passwordReset">
            @if(!$showOTPField)
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input wire:model="email" type="email"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your email" required>
                <span class="text-red-500">@error('email') {{ $message }} @enderror</span>
            </div>
            <p class="mt-4 text-center">
                <a href="#" wire:click.prevent="sendOTP" class="text-blue-500 text-decoration-none">Send OTP</a>
            </p>
            @else
            <div class="mb-4">
                <label for="otp" class="block text-gray-700">OTP</label>
                <input wire:model="otp" type="text"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your OTP" required>
                <span class="text-red-500">@error('otp') {{ $message }} @enderror</span>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input wire:model="password" type="password"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your password"
                    required>
                <span class="text-red-500">@error('password') {{ $message }} @enderror</span>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input wire:model="password_confirmation" type="password"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" placeholder="Confirm your password"
                    required>
                <span class="text-red-500">@error('password_confirmation') {{ $message }} @enderror</span>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg" wire:loading.attr="disabled"
                wire:loading.class="bg-gray-400" wire:target="passwordReset">
                <span wire:loading.remove wire:target="passwordReset">Save</span>
                <span wire:loading wire:target="passwordReset">Processing...</span>
            </button>
            @endif
            <p class="mt-4 text-center">
                Don't need to reset password? <a href="javascript:void(0);" wire:click.prevent="openLoginForm"
                    class="text-blue-500">Login here</a>
            </p>
        </form>
        @endif
    </div>
</div>