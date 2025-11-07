<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo / Branding --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition">
                    HSL Dashboard
                </a>
            </div>

            {{-- Desktop Links --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'border-b-2 border-indigo-500 text-gray-900' : 'border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300' }} px-3 py-2 text-lg font-medium transition">
                    Dashboard
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('products.index') }}"
                       class="{{ request()->routeIs('products.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300' }} px-3 py-2 text-lg font-medium transition">
                        Products
                    </a>
                @endif

                <a href="{{ route('orders.index') }}"
                   class="{{ request()->routeIs('orders.*') ? 'border-b-2 border-indigo-500 text-gray-900' : 'border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300' }} px-3 py-2 text-lg font-medium transition">
                    Orders
                </a>
            </div>

            {{-- User Menu --}}
            <div class="hidden sm:flex sm:items-center relative">
                <div x-data="{ openMenu: false }" class="relative">
                    <button @click="openMenu = !openMenu"
                            class="flex items-center text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        <span class="mr-2 font-medium">{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openMenu" @click.away="openMenu = false" x-transition
                         class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-lg py-2 z-20">
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile Hamburger --}}
            <div class="sm:hidden flex items-center">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden bg-white border-t border-gray-200 shadow-inner">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block ps-3 pe-4 py-2 border-l-4 text-base font-medium rounded-r-lg transition">
                Dashboard
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('products.index') }}"
                   class="{{ request()->routeIs('products.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block ps-3 pe-4 py-2 border-l-4 text-base font-medium rounded-r-lg transition">
                    Products
                </a>
            @endif
            <a href="{{ route('orders.index') }}"
               class="{{ request()->routeIs('orders.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block ps-3 pe-4 py-2 border-l-4 text-base font-medium rounded-r-lg transition">
                Orders
            </a>
        </div>

        {{-- Mobile User Menu --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
