<div>
    
<header class="border-b border-border bg-background">
    <div class="flex items-center justify-between py-4 border-b border-gray-200">
        <!-- Logo/Brand -->
        <div class="flex items-center">
            <a href="/" class="text-2xl font-bold text-gray-900 hover:text-gray-700 transition-colors">
              Mine Ecomerce Twala
            </a>
        </div>

        <!-- Navigation & Auth -->
        @if (Route::has('login'))
            <nav class="flex items-center gap-6">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Olá, {{ Auth::user()->name }}</span>
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Dashboard
                        </a>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 text-gray-700 text-sm font-medium hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Entrar
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Registar
                            </a>
                        @endif
                    </div>
                @endauth
            </nav>
        @endif
    </div>
</header>


</div>