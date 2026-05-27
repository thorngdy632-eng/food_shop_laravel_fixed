<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "THORNG DY'S SHOP")</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wdth,wght@62.5,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  
    <style>
        /* បង្ហាញស្តាយល៍កន្ត្រកទំនិញតែពេលមិនមែនជា Admin ប៉ុណ្ណោះ */
        @if(!auth()->check() || auth()->user()->role !== 'admin')
        #sideCartDrawer {
            position: fixed;
            top: 0;
            right: -460px;
            width: 100%;
            max-width: 420px;
            height: 100vh;
            background: #121212;
            box-shadow: -5px 0 25px rgba(0,0,0,0.6);
            z-index: 99999;
            transition: right 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #222;
        }
        #sideCartDrawer.open { right: 0; }
        #sideCartOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 99998;
            display: none;
        }
        #sideCartOverlay.open { display: block; }
        @endif
    </style>
    @stack('styles')
</head>
<body>

    {{-- ── User Sidebar (for non-admin) ── --}}
    @if(!auth()->check() || auth()->user()->role !== 'admin')
        <div id="userSidebar" class="user-sidebar">
            <div class="sidebar-header" style="text-align:center;padding-bottom:15px;border-bottom:1px solid #ddd;">
                @auth
                    <img src="{{ asset('assets/Overal/logo.png') }}" alt="Avatar" class="user-avatar">
                    <h4 style="margin:8px 0 2px;color:#333;">{{ auth()->user()->name }}</h4>
                    <small style="color:#888;">{{ auth()->user()->email }}</small>
                @else
                    <img src="{{ asset('assets/Overal/logo.png') }}" alt="Guest" class="user-avatar">
                    <h4 style="margin:8px 0 2px;color:#333;">ភ្ញៀវ</h4>
                    <small style="color:#888;">សូមចុះឈ្មោះ</small>
                @endauth
            </div>
            <ul class="sidebar-menu">
                <li onclick="window.location.href='{{ url('/') }}'"><i class="fa fa-home"></i> ទំព័រដើម</li>
                @auth
                    <li onclick="window.location.href='{{ url('/') }}'"><i class="fa fa-user"></i> ប្រវត្តិរូប</li>
                    <li onclick="window.location.href='{{ route('order.history') }}'"><i class="fa fa-clock-rotate"></i> ប្រវត្តិកម្ម៉ង់</li>
                @else
                    <li onclick="window.location.href='{{ route('login') }}'"><i class="fa fa-sign-in"></i> ចុះឈ្មោះ</li>
                    <li onclick="window.location.href='{{ route('register') }}'"><i class="fa fa-user-plus"></i> ចុះឈ្មោះថ្មី</li>
                @endauth
            </ul>
        </div>
        <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    @endif

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    {{-- ── ផ្ទាំង Side Cart HTML Element (លាក់ចោលសម្រាប់ Admin) ── --}}
    @if(!auth()->check() || auth()->user()->role !== 'admin')
        <div id="sideCartDrawer">
            <div style="padding: 20px; background: #1a1a1a; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #252525;">
                <h3 style="color: #fff; margin: 0; font-family: 'Kantumruy Pro', 'Noto Sans Khmer', sans-serif; font-size: 1.2rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-cart-shopping"></i> កន្ត្រកទំនិញរបស់អ្នក
                </h3>
                <button onclick="toggleSideCart()" style="background: transparent; border: none; color: #ff4d4f; font-size: 1.4rem; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="sideCartItemsContainer" style="flex: 1; overflow-y: auto; padding: 20px;">
                <div style="text-align: center; color: #888; margin-top: 50px; font-family: 'Kantumruy Pro';">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 2rem; color: #32e622; margin-bottom: 10px;"></i>
                    <p>កំពុងទាញយកទិន្នន័យ...</p>
                </div>
            </div>
        </div>
        <div id="sideCartOverlay" onclick="toggleSideCart()"></div>
    @endif

    @include('partials.footer')

    <script>window.APP_URL = "{{ url('/') }}";</script>
    <script src="{{ asset('js/script.js') }}"></script>

    {{-- ── ផ្នែក JavaScript គ្រប់គ្រងកន្ត្រកទំនិញ (លាក់ចោលសម្រាប់ Admin) ── --}}
    @if(!auth()->check() || auth()->user()->role !== 'admin')
    <script>
        function toggleSideCart() {
            const drawer = document.getElementById('sideCartDrawer');
            const overlay = document.getElementById('sideCartOverlay');
            if(!drawer || !overlay) return;
            drawer.classList.toggle('open');
            overlay.classList.toggle('open');
            if (drawer.classList.contains('open')) { fetchSideCartView(); }
        }

        async function fetchSideCartView() {
            try {
                const response = await fetch("{{ url('/cart') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (response.ok) {
                    document.getElementById('sideCartItemsContainer').innerHTML = await response.text();
                } else {
                    document.getElementById('sideCartItemsContainer').innerHTML = 
                        `<p style="color:#ff4d4f; text-align:center; font-family:'Kantumruy Pro';">មានបញ្ហាក្នុងការទាញទិន្នន័យ!</p>`;
                }
            } catch (error) { console.error("Error fetching cart:", error); }
        }

        window.handleQtyChange = async function(foodId, amount) {
            const qtyText = document.getElementById(`side-qty-text-${foodId}`);
            if (!qtyText) return;
            let currentQty = parseInt(qtyText.textContent);
            let newQty = currentQty + amount;
            if (newQty < 1 || newQty > 99) return;
            qtyText.textContent = newQty;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const response = await fetch('{{ route("cart.update") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ food_id: foodId, quantity: newQty, _token: token })
                });
                const data = await response.json();
                if (data.success) {
                    if (document.getElementById('drawer-cart-total')) document.getElementById('drawer-cart-total').textContent = parseFloat(data.total).toFixed(2);
                    if (document.getElementById('cartCount')) document.getElementById('cartCount').textContent = data.cart_count;
                } else { qtyText.textContent = currentQty; }
            } catch (error) { qtyText.textContent = currentQty; }
        };

        window.handleRemoveItem = async function(foodId) {
            if (!confirm('តើអ្នកពិតជាចង់លុបមុខម្ហូបនេះចេញពីកន្ត្រកមែនទេ?')) return;
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const response = await fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ food_id: foodId, _token: token })
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById(`side-row-${foodId}`)?.remove();
                    if (document.getElementById('drawer-cart-total')) document.getElementById('drawer-cart-total').textContent = parseFloat(data.total).toFixed(2);
                    if (document.getElementById('cartCount')) document.getElementById('cartCount').textContent = data.cart_count;
                    if (parseInt(data.cart_count) === 0) { fetchSideCartView(); }
                }
            } catch (error) { console.error(error); }
        };
    </script>
    @endif

    @stack('scripts')
</body>
</html>