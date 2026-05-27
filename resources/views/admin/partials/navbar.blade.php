<nav class="bg-black text-white px-6 py-4 flex items-center justify-content-between relative shadow-md">
    
    <div class="flex items-center gap-3">
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center gap-2 text-sm shadow-sm whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                    </svg>
                    <span>ទៅកាន់ផ្ទាំងគ្រប់គ្រង</span>
                </a>
            @else
                <button class="p-2 bg-green-200 text-gray-700 hover:text-green-600 rounded-lg focus:outline-none" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            @endif
        @else
            <button class="p-2 bg-green-200 text-gray-700 hover:text-green-600 rounded-lg focus:outline-none" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        @endauth
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ url('/') }}" class="flex items-center gap-2 no-underline text-white">
            <span class="font-bold text-lg md:text-xl tracking-wide">THORNG DY'S SHOP</span>
        </a>
    </div>

    <div class="flex items-center gap-4">
        @auth
            @if(auth()->user()->role !== 'admin')
                <button onclick="toggleSideCart()" class="relative p-2 text-gray-300 hover:text-green-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span id="cartCount" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs px-1.5 min-w-[18px] text-center">0</span>
                </button>
            @endif
        @else
            <button onclick="toggleSideCart()" class="relative p-2 text-gray-300 hover:text-green-400 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs px-1.5 min-w-[18px] text-center">0</span>
            </button>
        @endauth
    </div>

</nav>