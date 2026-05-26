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
        /* ── CSS សម្រាប់បញ្ជាផ្ទាំង Side Cart Drawer ── */
        #sideCartDrawer {
            position: fixed;
            top: 0;
            right: -460px; /* លាក់នៅខាងស្តាំអេក្រង់សិន */
            width: 100%;
            max-width: 420px;
            height: 100vh;
            background: #121212; /* ពណ៌ខ្មៅដិត Dark Mode */
            box-shadow: -5px 0 25px rgba(0,0,0,0.6);
            z-index: 99999; /* ឱ្យវានៅពីលើគេបង្អស់ */
            transition: right 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #222;
        }

        /* ពេលថែម Class .open ឱ្យវាហើបចេញមក */
        #sideCartDrawer.open {
            right: 0;
        }

        /* ផ្ទៃងងឹត (Overlay) នៅខាងក្រោយ */
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
        #sideCartOverlay.open {
            display: block;
        }
    </style>
  
    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    <div id="sideCartDrawer">
        <div style="padding: 20px; background: #1a1a1a; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #252525;">
            <h3 style="color: #fff; margin: 0; font-family: 'Kantumruy Pro', 'Noto Sans Khmer', sans-serif; font-size: 1.2rem; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-cart-shopping"></i> កន្ត្រកទំនិញរបស់អ្នក
            </h3>
            <button onclick="toggleSideCart()" style="background: transparent; border: none; color: #ff4d4f; font-size: 1.4rem; cursor: pointer; transition: transform 0.2s;">
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

    @include('partials.footer')

    <script>window.APP_URL = "{{ url('/') }}";</script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        function toggleSideCart() {
            const drawer = document.getElementById('sideCartDrawer');
            const overlay = document.getElementById('sideCartOverlay');
            
            drawer.classList.toggle('open');
            overlay.classList.toggle('open');

            // បើផ្ទាំងធ្លាក់មក (Open) ឱ្យទៅ Fetch ទិន្នន័យថ្មីភ្លាម
            if (drawer.classList.contains('open')) {
                fetchSideCartView();
            }
        }

        // មុខងារហៅ AJAX ទៅទាញយកទម្រង់ HTML ពី Route /cart មកញាត់ចូលក្នុង Container ចំហៀង
        async function fetchSideCartView() {
            try {
                const response = await fetch("{{ url('/cart') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (response.ok) {
                    const html = await response.text();
                    document.getElementById('sideCartItemsContainer').innerHTML = html;
                } else {
                    document.getElementById('sideCartItemsContainer').innerHTML = 
                        `<p style="color:#ff4d4f; text-align:center; font-family:'Kantumruy Pro';">មានបញ្ហាក្នុងការទាញទិន្នន័យ!</p>`;
                }
            } catch (error) {
                console.error("Error fetching cart:", error);
            }
        }

        // ── មុខងារសកលសម្រាប់ បូក/ដក ចំនួនម្ហូប (Global Function) ──
        window.handleQtyChange = async function(foodId, amount) {
            const qtyText = document.getElementById(`side-qty-text-${foodId}`);
            if (!qtyText) return;

            let currentQty = parseInt(qtyText.textContent);
            let newQty = currentQty + amount;

            if (newQty < 1 || newQty > 99) return;

            qtyText.textContent = newQty;

            try {
                const tokenElement = document.querySelector('meta[name="csrf-token"]');
                const token = tokenElement ? tokenElement.content : '';

                const response = await fetch('{{ route("cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ 
                        food_id: foodId, 
                        quantity: newQty,
                        _token: token 
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    if (document.getElementById('drawer-cart-total')) {
                        document.getElementById('drawer-cart-total').textContent = parseFloat(data.total).toFixed(2);
                    }
                    if (document.getElementById('cartCount')) {
                        document.getElementById('cartCount').textContent = data.cart_count;
                    }
                } else {
                    qtyText.textContent = currentQty;
                }
            } catch (error) {
                console.error("Error updating cart quantity:", error);
                qtyText.textContent = currentQty;
            }
        };

        // ── មុខងារសកលសម្រាប់ លុបមុខម្ហូបចេញពីកន្ត្រក (Global Function) ──
        window.handleRemoveItem = async function(foodId) {
            if (!confirm('តើអ្នកពិតជាចង់លុបមុខម្ហូបនេះចេញពីកន្ត្រកមែនទេ?')) return;

            try {
                const tokenElement = document.querySelector('meta[name="csrf-token"]');
                const token = tokenElement ? tokenElement.content : '';

                const response = await fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ 
                        food_id: foodId,
                        _token: token 
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    const rowElement = document.getElementById(`side-row-${foodId}`);
                    if (rowElement) rowElement.remove();

                    if (document.getElementById('drawer-cart-total')) {
                        document.getElementById('drawer-cart-total').textContent = parseFloat(data.total).toFixed(2);
                    }
                    if (document.getElementById('cartCount')) {
                        document.getElementById('cartCount').textContent = data.cart_count;
                    }

                    if (parseInt(data.cart_count) === 0) {
                        fetchSideCartView();
                    }
                }
            } catch (error) {
                console.error("Error removing cart item:", error);
            }
        };
    </script>

    @stack('scripts')
</body>
</html>