<header id="mainHeader" style="background-color: #111; width: 100%;">
  <div class="header-inner" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; flex-wrap: wrap; gap: 15px;">
    
    {{-- ── ផ្នែកខាងឆ្វេង៖ Logo + Admin Button / Hamburger ── --}}
    <div class="header-left" style="display: flex; align-items: center; gap: 15px;">
      @auth
        @if(auth()->user()->role === 'admin')
          {{-- ប៊ូតុងទៅកាន់ផ្ទាំងគ្រប់គ្រងសម្រាប់ Admin ── --}}
          <a href="{{ url('/admin/dashboard') }}" style="
              display: inline-flex; align-items: center; gap: 8px;
              background-color: #8ce49c; color: #1e4620;
              padding: 8px 16px; border-radius: 8px;
              text-decoration: none; white-space: nowrap;
              font-family: 'Noto Sans Khmer', sans-serif;
              font-weight: 500; font-size: 1.1rem;
              transition: all 0.2s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
          ">
            <i class="fa-solid fa-chart-line"></i> ទៅកាន់ផ្ទាំងគ្រប់គ្រង
          </a>
        @else
          {{-- ប៊ូតុង Hamburger សម្រាប់ Customer ធម្មតា ── --}}
          <button class="user-toggle-btn" onclick="toggleSidebar()" style="cursor: pointer;">
            <i class="fa-solid fa-bars"></i>
          </button>
        @endif
      @else
        {{-- ប៊ូតុង Hamburger សម្រាប់ Guest មិនទាន់ Login ── --}}
        <button class="user-toggle-btn" onclick="toggleSidebar()" style="cursor: pointer;">
          <i class="fa-solid fa-bars"></i>
        </button>
      @endauth

      {{-- Logo ទំព័រដើម ── --}}
      <a class="logo" href="{{ url('/') }}" style="display: flex; align-items: center; gap: 8px; text-decoration: none; white-space: nowrap;">
        <img src="{{ asset('assets/Overal/logo.png') }}" alt="Logo" style="width: 40px; height: 40px;">
        <span class="logo-text" style="color: #fff; font-weight: bold; font-size: 1.2rem;">THORNG DY'S SHOP</span>
      </a>
    </div>

    {{-- ── ផ្នែកកណ្ដាល៖ តំណភ្ជាប់ម៉ឺនុយទាំង ៦ ── --}}
    <nav class="nav-links" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
      <a href="#" class="nav-active" style="white-space: nowrap; text-decoration: none;">ម៉ឺនុយ</a>
      <a href="#" style="white-space: nowrap; text-decoration: none;">អំពីយើង</a>
      <a href="#" style="white-space: nowrap; text-decoration: none;">កក់តុ</a>
      <a href="#" style="white-space: nowrap; text-decoration: none;">សេវាកម្ម</a>
      <a href="#" style="white-space: nowrap; text-decoration: none;">ទំនាក់ទំនង</a>
      <a href="#" style="white-space: nowrap; text-decoration: none;">ការងារ</a>
    </nav>

    {{-- ── ផ្នែកខាងស្ដាំ៖ កន្ត្រកទំនិញ (Fixed Size & Symmetry) + ប៊ូតុងចាកចេញ ── --}}
    <div class="header-right" style="display: flex; align-items: center; gap: 15px;">
      
      @if(!auth()->check() || auth()->user()->role !== 'admin')
        {{-- ប៊ូតុងកន្ត្រកទំនិញ៖ កំណត់ min-width និង padding ឱ្យទំហំប៉ុនប៊ូតុងធម្មតាឥតខ្ចោះ ── --}}
        <div class="cart-btn" onclick="toggleSideCart()" style="
            cursor: pointer; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px;
            background-color: #8ce49c; 
            color: #1e4620;
            
            /* កូដគន្លឹះពង្រីកទំហំឱ្យស្មើប៊ូតុង 'ការងារ' */
            padding: 8px 16px; 
            min-width: 90px; 
            height: 45px;
            border-radius: 8px;
            
            box-sizing: border-box;
            transition: all 0.2s ease;
        ">
          <i class="fa-solid fa-bag-shopping" style="font-size: 1rem;"></i>
          <span class="cart-count" id="cartCount" style="
              background-color: #000; 
              color: #fff; 
              font-size: 0.85rem;
              font-weight: bold;
              padding: 2px 8px;
              border-radius: 20px;
              display: inline-flex;
              align-items: center;
              justify-content: center;
              min-width: 20px;
              height: 20px;
          ">{{ array_sum(array_column(Session::get('cart', []), 'quantity')) }}</span>
        </div>
      @endif

      @auth
        {{-- ប៊ូតុងចាកចេញ (Logout) ពណ៌ក្រហម គម្លាតពីគេ ២៥px ── --}}
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();" style="
            display: inline-flex; align-items: center; gap: 8px;
            margin-left: 25px; background-color: #ff4d4f; color: #fff;
            padding: 8px 16px; height: 45px; border-radius: 8px;
            text-decoration: none; white-space: nowrap;
            font-family: 'Noto Sans Khmer', sans-serif;
            box-sizing: border-box;
            font-weight: 500; font-size: 0.95rem;
            transition: all 0.2s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        ">
          <i class="fa-solid fa-right-from-bracket"></i> ចាកចេញ
        </a>
        
        <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      @endauth

    </div>

  </div>

  <script>
    function toggleSidebar() {
      var s = document.getElementById('userSidebar');
      var o = document.getElementById('sidebarOverlay');
      if (s) s.classList.toggle('active');
      if (o) o.classList.toggle('active');
    }
  </script>
</header>