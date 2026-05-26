<header id="mainHeader">
  <div class="header-inner">
    <div class="header-left" style="display: flex; align-items: center; gap: 15px;">
      <button class="user-toggle-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
      </button>

      <a class="logo" href="{{ url('/') }}">
        <img src="{{ asset('assets/Overal/logo.png') }}" alt="Logo" style="width: 45px; height: 45px;">
        <span class="logo-text">THORNG DY'S SHOP</span>
      </a>
    </div>

    <nav class="nav-links">
      <a href="#" class="nav-active">ម៉ឺនុយ</a>
      <a href="#">អំពីយើង</a>
      <a href="#">កក់តុ</a>
      <a href="#">សេវាកម្ម</a>
      <a href="#">ទំនាក់ទំនង</a>
      <a href="#">ការងារ</a>
    </nav>

    <div class="header-actions">
      {{-- ── កែប្រែត្រង់នេះ៖ ដក href ចេញ រួចថែម onclick="toggleSideCart()" ដើម្បីឱ្យវាហើបផ្ទាំងចំហៀងមកលើទំព័រដើម ── --}}
      <div class="cart-btn" onclick="toggleSideCart()" style="cursor: pointer; position: relative; display: inline-block;">
        <i class="fa-solid fa-bag-shopping"></i>
        <span class="cart-count" id="cartCount">{{ array_sum(array_column(Session::get('cart', []), 'quantity')) }}</span>
      </div>
    </div>
  </div>

  {{-- ── ផ្នែក User Sidebar ── --}}
  <div class="user-sidebar" id="userSidebar">
    @auth
        <div class="sidebar-header" style="text-align: center; padding: 20px 0; border-bottom: 1px solid #eee;">
            <img src="{{ asset('assets/profiles/' . (session('user_image') ?: 'default.jfif')) }}?v={{ time() }}"
                 class="user-avatar"
                 style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #a6e7a0; object-fit: cover;">

            <h3 style="margin: 10px 0 5px; color: #333;">{{ auth()->user()->name ?? session('user_name') }}</h3>
            <span class="role-badge" style="background: #e0e0e0; padding: 2px 10px; border-radius: 12px; font-size: 0.75rem;">
                {{ ucfirst(auth()->user()->role ?? 'user') }}
            </span>
        </div>

        <ul class="sidebar-menu" style="list-style: none; padding: 20px;">
            <li onclick="toggleProfileModal()" style="padding: 12px 0; cursor: pointer;">
                <i class="fa-solid fa-user"></i> My Profile
            </li>
            <li style="padding: 12px 0; cursor: pointer;">
                <i class="fa-solid fa-clock-rotate-left"></i> Order History
            </li>
            <a href="{{ route('logout') }}" style="text-decoration: none; color: #e74c3c;"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <li style="padding: 12px 0; cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </li>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    @else
        <div class="sidebar-header" style="text-align: center; padding: 40px 20px;">
            <div style="width: 80px; height: 80px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <i class="fa-solid fa-user-slash" style="font-size: 2rem; color: #ccc;"></i>
            </div>
            <h3 style="color: #333;">សូមស្វាគមន៍!</h3>
            <p style="font-size: 0.85rem; color: #777; margin-bottom: 25px;">សូមចូលប្រើប្រាស់ ដើម្បីធ្វើការបញ្ជាទិញ</p>

            <div style="display: flex; flex-direction: column; gap: 10px; padding: 0 10px;">
                <a href="{{ route('login') }}" class="btn-auth-login" style="background: #4dff47; color: white; padding: 12px; border-radius: 10px; text-decoration: none; font-weight: bold; transition: 0.3s;">
                    ចូលប្រើប្រាស់ (Login)
                </a>
                <a href="{{ route('register') }}" class="btn-auth-register" style="border: 2px solid #4dff47; color: #4dff47; padding: 10px; border-radius: 10px; text-decoration: none; font-weight: bold; transition: 0.3s;">
                    ចុះឈ្មោះ (Register)
                </a>
            </div>
        </div>
    @endauth
  </div>

  {{-- ── ផ្ទាំង Profile Modal ── --}}
  <div id="profileModal" class="modal-overlay" style="display: none;">
    <div class="profile-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-gear"></i> កែសម្រួលព័ត៌មានផ្ទាល់ខ្លួន</h3>
            <span class="close-modal" onclick="toggleProfileModal()">&times;</span>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="profile-upload-section">
                    <div class="image-container">
                        <img src="{{ asset('assets/profiles/' . (session('user_image') ?: 'default.jfif')) }}" id="previewImg" alt="Profile">
                        <label for="fileInput" class="upload-icon">
                            <i class="fa-solid fa-camera"></i>
                        </label>
                    </div>
                    <p style="font-size: 0.8rem; color: #777; margin-top: 5px;">ប្តូររូបភាព Profile</p>
                    <input type="file" id="fileInput" name="profile_image" accept="image/*" onchange="previewFile()" style="display: none;">
                </div>

                <div class="input-field">
                    <label><i class="fa-solid fa-id-card"></i> ឈ្មោះពេញ</label>
                    <input type="text" name="fullname" value="{{ auth()->user()->name ?? session('user_name') }}" required placeholder="បញ្ចូលឈ្មោះពេញរបស់អ្នក">
                </div>

                <div class="input-field">
                    <label><i class="fa-solid fa-pen-to-square"></i> ជីវប្រវត្តិ (Biographical Info)</label>
                    <textarea name="bio" rows="3" placeholder="រៀបរាប់ខ្លីៗពីខ្លួនអ្នក...">{{ auth()->user()->bio ?? session('user_bio') ?? '' }}</textarea>
                </div>

                <div class="security-divider">
                    <span>សុវត្ថិភាពគណនី</span>
                </div>

                <div class="input-field">
                    <label style="color: #e74c3c;"><i class="fa-solid fa-lock"></i> លេខសម្ងាត់ចាស់ (តម្រូវឱ្យមាន)</label>
                    <input type="password" name="old_password" placeholder="បញ្ជាក់លេខសម្ងាត់ចាស់ (តែពេលចង់ដូរលេខថ្មី)">
                </div>

                <div class="input-field">
                    <label><i class="fa-solid fa-key"></i> លេខសម្ងាត់ថ្មី (ទុកទទេបើមិនដូរ)</label>
                    <input type="password" name="new_password" placeholder="បញ្ចូលលេខសម្ងាត់ថ្មី (បើមាន)">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" name="update_profile" class="btn-update">
                    <i class="fa-solid fa-floppy-disk"></i> រក្សាទុកការផ្លាស់ប្តូរ
                </button>
            </div>
        </form>
    </div>
  </div>

  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
</header>