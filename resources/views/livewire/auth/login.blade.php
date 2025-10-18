<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        $this->redirectIntended(default: route('produtos.index', absolute: false), navigate: true);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
            <!-- Header with improved spacing and typography -->
            <div class="text-center space-y-2">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Bem-vindo de volta') }}</h1>
                <p class="text-gray-600">{{ __('Entre na sua conta') }}</p>
            </div>

            <!-- Session Status with better styling -->
            <x-auth-session-status class="text-center bg-green-50 text-green-700 p-3 rounded-lg" :status="session('status')" />

            <form wire:submit="login" class="space-y-5">
                <!-- Email with floating label effect -->
                <div class="space-y-2">
                    <flux:input
                        wire:model="email"
                        :label="__('Endereço de email')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="seu@email.com"
                        class="w-full px-4 py-3  rounded-lg focus:border-gray-500 focus:ring-gray-500 transition-all duration-200"
                    />
                </div>

                <!-- Password with improved UX -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <flux:input
                            wire:model="password"
                            :label="__('Senha')"
                            type="password"
                            required
                            autocomplete="current-password"
                            :placeholder="__('Digite sua senha')"
                            viewable
                            class="w-full px-4 py-3 focus:border-gray-500 focus:ring-gray-500 transition-all duration-200"
                        />
                    </div>
                    
                    @if (Route::has('password.request'))
                        <div class="text-right">
                            <flux:link 
                                :href="route('password.request')" 
                                wire:navigate
                                class="text-sm text-gray-600 hover:text-gray-800 transition-colors duration-200"
                            >
                                {{ __('Esqueceu a senha?') }}
                            </flux:link>
                        </div>
                    @endif
                </div>

                <!-- Remember Me with better styling -->
                <div class="flex items-center justify-between py-2">
                    <flux:checkbox 
                        wire:model="remember" 
                        :label="__('Lembrar de mim')"
                        class="text-gray-600"
                    />
                </div>

                <!-- Login button with loading state -->
                <flux:button 
                    variant="primary" 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-gray-600 to-gray-600 hover:from-gray-700 hover:to-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:ring-4 focus:ring-gray-200"
                    data-test="login-button"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-75 cursor-not-allowed"
                >
                    <span wire:loading.remove>{{ __('Entrar') }}</span>
                    <span wire:loading class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Signing in...') }}
                    </span>
                </flux:button>
            </form>

            <!-- Sign up link with improved design -->
            @if (Route::has('register'))
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        {{ __('Novo na nossa plataforma?') }}
                        <flux:link 
                            :href="route('register')" 
                            wire:navigate
                            class="font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 ml-1"
                        >
                            {{ __('Cria uma conta') }}
                        </flux:link>
                    </p>
                </div>
            @endif
               <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        <flux:link 
                            :href="route('produtos.index')" 
                            wire:navigate
                            class="font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 ml-1"
                        >
                            {{ __('Voltar') }}
                        </flux:link>
                    </p>
                </div>
        </div>
    </div>
</div>
