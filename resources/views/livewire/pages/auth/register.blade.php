<?php

use Illuminate\Support\Str;
use k1fl1k\truefalsegame\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['id'] = Str::ulid();
        $validated['avatar'] = 'storage/images/user.svg';

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('truth-or-lie.gamehub', absolute: false), navigate: true);
    }
};
?>

<div class="flex h-screen w-full overflow-hidden font-sans bg-[#1a1a1a] text-[#f5f5f5]">
    <!-- Left background image panel -->
    <div class="left" style="background-image: url('{{ asset('images/truefalse.png') }}');"></div>

    <!-- Right registration panel -->
    <div class="right flex flex-col justify-center items-center w-full px-6">
        <div class="logo mb-2">TrueFalse</div>
        <div class="subtitle mb-6">Join and make your day brighter</div>

        <form wire:submit="register" class="w-full max-w-md">
            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="username" :value="__('Username')"/>
                <x-text-input wire:model="username" id="username" class="block mt-1 w-full"
                              type="text"
                              name="username" required autofocus autocomplete="username"/>
                <x-input-error :messages="$errors->get('username')" class="mt-2"/>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email"
                              name="email" required autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')"/>
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                              type="password"
                              name="password" required autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                <x-text-input wire:model="password_confirmation" id="password_confirmation"
                              class="block mt-1 w-full" type="password"
                              name="password_confirmation" required autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col items-center gap-3">
                <button class="button btn-gold w-full">
                    {{ __('Register') }}
                </button>

                <a class="button btn-dark w-full text-center" href="{{ route('login') }}"
                   wire:navigate>
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
    </div>
</div>
