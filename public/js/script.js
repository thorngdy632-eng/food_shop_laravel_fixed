// =============================================
//  ហាងម្ហូប BITES — script.js
// =============================================

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
const BASE_URL = window.APP_URL || '';

// ===== ទិន្នន័យម្ហូប =====
const foods = [
  { id: 30, name: "Chocolate Cake", category: "dessert", emoji: "", image: "assets/Dessert/Chocolate.jpg", price: 6.99, desc: "នំសូកូឡា មានរសជាតិផ្អែមឆ្ងាញ់", rating: 4.8, reviews: 120, badge: "ថ្មី" },
  { id: 1, name: "អាម៉ុក ត្រី", category: "khmer", emoji: "", image: "assets/Khmer_food/Amok.jpg", price: 9.99, desc: "ម្ហូបជាតិដ៏ល្បី — ត្រីស្ងោរក្នុងខ្ទិ៍ គ្រឿង ស្លឹកក្រូចសើច និងម្ទេស។", rating: 4.9, reviews: 480, badge: "ម្ហូបជាតិ" },
  { id: 2, name: "បាយសាច់ជ្រូក", category: "khmer", emoji: "", image: "assets/Khmer_food/Bay.jpg", price: 7.50, desc: "បាយសក្តៅៗ ជាមួយសាច់ជ្រូកអាំងទន់ៗ និងជ្រក់ត្រសក់ — អាហារពេលព្រឹកដ៏ល្អបំផុត។", rating: 4.8, reviews: 390, badge: "ពេញនិយម" },
  { id: 5, name: "ភីហ្សា ម៉ាហ្គារីតា", category: "pizza", emoji: "", image: "assets/Pizza/Margherita.jpg", price: 12.99, desc: "ទឹកប៉េងប៉ោះ San Marzano ឈីស mozzarella ស្រស់ និងស្លឹក basil។", rating: 4.8, reviews: 320, badge: "ពេញនិយម" },
  { id: 8, name: "បឺហ្គឺ Smash ពីរជាន់", category: "burger", emoji: "", image: "assets/Burger/Cheeseburger.jpg", price: 13.99, desc: "សាច់គោ smash ពីរជាន់ ឈីស American ត្រសក់ និងទឹកជ្រលក់ពិសេស។", rating: 4.9, reviews: 512, badge: "លក់ដាច់" },
  { id: 11, name: "រ៉ាម៉ែន Tonkotsu", category: "noodles", emoji: "", image: "assets/Boiled_noodle/Glassnoodles.jpg", price: 14.50, desc: "ស៊ុបឆ្អឹងជ្រូកដ៏ឈ្ងុយឆ្ងាញ់ សាច់ជ្រូកបំពង និងស៊ុតជ័រពងទា។", rating: 4.9, reviews: 430, badge: "គេចូលចិត្ត" },
  { id: 14, name: "រ៉ូល Salmon Dragon", category: "sushi", emoji: "", image: "assets/Sushi/Salmonnigiri.jpg", price: 18.99, desc: "បង្គា tempura ខាងក្នុង ស្រោបដោយសាច់ត្រី salmon ស្រស់ និង avocado។", rating: 4.9, reviews: 295, badge: "ថ្មី" },
  { id: 21, name: "កាហ្វេត្រជាក់", category: "drinks", emoji: "", image: "assets/Drink/Icedcoffee.jpg", price: 4.99, desc: "គ្រាប់កាហ្វេលីងថ្មីៗ រសជាតិដិតឈ្ងុយ រលោង ជួយឱ្យស្បែកកាយស្រស់ស្រាយ។", rating: 4.9, reviews: 520, badge: "លក់ដាច់" },
];

const catLabels = {
  khmer:   "ម្ហូបខ្មែរ",
  pizza:   "ភីហ្សា",
  burger:  "បឺហ្គឺ",
  noodles: "មីស្ងោរ",
  sushi:   "សូស៊ី",
  dessert: "បង្អែម",
  drinks:  "ភេសជ្ជៈ",
};

const badgeClass = {
  "ម្ហូបជាតិ":      "badge-nation",
  "ថ្មី":           "badge-new",
  "ជម្រើសចុងភៅ":   "badge-chef",
  "លក់ដាច់":      "badge-nation",
  "ពេញនិយម":     "badge-new"
};

let activeCategory = 'all';
let searchQuery = '';

// ───── INIT ─────
document.addEventListener('DOMContentLoaded', () => {
  renderFoods(foods);
  window.addEventListener('scroll', () => {
    const header = document.getElementById('mainHeader');
    if (header) {
      header.style.boxShadow = window.scrollY > 40 ? '0 4px 30px rgba(0,0,0,0.6)' : 'none';
    }
  });
});

// ───── RENDER ─────
function renderFoods(items) {
  const grid = document.getElementById('foodGrid');
  const empty = document.getElementById('emptyState');
  if (!grid) return;

  if (!items.length) {
    grid.innerHTML = '';
    if (empty) empty.style.display = 'block';
    return;
  }
  if (empty) empty.style.display = 'none';

  grid.innerHTML = items.map((f, i) => {
    const bClass = f.badge ? (badgeClass[f.badge] || '') : '';
    const badge = f.badge ? `<span class="food-badge ${bClass}">${f.badge}</span>` : '';
    const thumb = f.image
      ? `<img src="${f.image}" class="food-img-full" alt="${f.name}" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">`
      : `<div class="food-emoji">${f.emoji}</div>`;

    return `
    <div class="food-card" style="animation-delay:${i * 0.045}s">
      <div class="food-thumb" data-cat="${f.category}">
        ${thumb}
        ${badge}
      </div>
      <div class="food-body">
        <p class="food-cat-label" data-cat="${f.category}">${catLabels[f.category] || f.category}</p>
        <h3 class="food-name">${f.name}</h3>
        <p class="food-stars">${stars(f.rating)}<span>(${f.reviews.toLocaleString()})</span></p>
        <p class="food-desc">${f.desc}</p>
        <div class="food-footer-row">
          <div class="food-price"><sup>$</sup>${f.price.toFixed(2)}</div>
          <button class="add-btn" onclick="addToCart(${f.id})" title="បន្ថែមទៅកន្ត្រក">+</button>
        </div>
      </div>
    </div>`;
  }).join('');
}

function stars(r) {
  let s = '';
  for (let i = 0; i < Math.floor(r); i++) s += '★';
  if (r % 1 >= 0.5) s += '½';
  return s + ' ';
}

// ───── FILTER ─────
function setCategory(cat, btn) {
  activeCategory = cat;
  document.querySelectorAll('.cat').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
  applyFilters();
}

function filterFoods() {
  const input = document.getElementById('searchInput');
  searchQuery = input ? input.value.toLowerCase().trim() : '';
  applyFilters();
}

function applyFilters() {
  let res = foods;
  if (activeCategory !== 'all') res = res.filter(f => f.category === activeCategory);
  if (searchQuery) res = res.filter(f =>
    f.name.toLowerCase().includes(searchQuery) ||
    f.desc.toLowerCase().includes(searchQuery)
  );
  renderFoods(res);
}

// ───── HELPER ─────
function assetUrl(path) {
  if (!path) return '';
  const base = (window.APP_URL || '').replace(/\/+$/, '');
  const cleanPath = path.startsWith('/') ? path : '/' + path;
  return base + cleanPath;
}

// ───── CART ─────

function addToCart(id) {
  fetch(BASE_URL + '/cart/add', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify({ food_id: id, quantity: 1 })
  })
  .then(response => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
  })
  .then(data => {
    if(data.success) {
        toast("✅ ថែមរួចរាល់!");
        updateBadge(data.cart_count);
    } else {
        toast("❌ " + (data.message || "មិនអាចថែមបានទេ"));
    }
  })
  .catch(err => {
    console.error("Cart Error:", err);
    toast("❌ មិនអាចបន្ថែមទៅកន្ត្រកបាន");
  });
}

function updateBadge(count) {
  const cartCountEl = document.getElementById('cartCount');
  if (cartCountEl) {
    cartCountEl.textContent = count;
  }
}

function fetchCartData() {
  return fetch(BASE_URL + '/cart/data', {
    headers: { 'Accept': 'application/json' }
  })
  .then(res => {
    if (!res.ok) throw new Error("មិនអាចទាញទិន្នន័យកន្ត្រកបានទេ");
    return res.json();
  });
}

function changeQty(id, newQty) {
  if (newQty < 1) return;
  fetch(BASE_URL + '/cart/update-qty', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify({ food_id: id, quantity: newQty })
  })
  .then(res => {
    if (!res.ok) throw new Error("មិនអាចធ្វើបច្ចុប្បន្នភាពបានទេ");
    return res.json();
  })
  .then(data => {
    if(data.success) {
      updateBadge(data.cart_count);
      fetchCartData().then(syncCartUI);
    }
  })
  .catch(err => console.error("Cart Error:", err));
}

function toggleCart() {
  const sidebar = document.getElementById("cartSidebar");
  const overlay = document.getElementById("cartOverlay");
  if (!sidebar || !overlay) return;

  const isOpen = sidebar.classList.contains("open");
  if (!isOpen) {
    fetchCartData().then(syncCartUI);
  }

  sidebar.classList.toggle("open");
  overlay.classList.toggle("open");
  document.body.classList.toggle("cart-open");
}

function syncCartUI(data) {
  const cart = data.items || [];
  const totalQty = data.cart_count || 0;
  const subtotal = cart.reduce((s, c) => s + (parseInt(c.quantity) || 0) * (parseFloat(c.price) || 0), 0);
  const delivery = cart.length ? 2.00 : 0;
  const grand = subtotal + delivery;

  updateBadge(totalQty);

  const itemsEl = document.getElementById('cartItems');
  const footerEl = document.getElementById('cartFooter');

  if (!cart.length) {
    if (itemsEl) {
      itemsEl.innerHTML = `
        <div class="cart-empty">
          <div class="cart-empty-icon">🛒</div>
          <p>កន្ត្រករបស់អ្នកទទេ</p>
          <span>បន្ថែមម្ហូបដែលអ្នកចូលចិត្ត</span>
        </div>`;
    }
    if (footerEl) footerEl.style.display = 'none';
    return;
  }

  if (itemsEl) {
    itemsEl.innerHTML = cart.map(c => `
      <div class="cart-item">
        <div class="cart-item-thumb">
          <img src="${assetUrl(c.image)}" style="width:100%; height:100%; object-fit:cover; border-radius:8px;" onerror="this.src='${assetUrl('assets/Overal/logo.png')}'">
        </div>
        <div class="cart-item-info">
          <div class="cart-item-name">${c.name}</div>
          <div class="cart-item-price">$${(c.price * c.quantity).toFixed(2)}</div>
        </div>
        <div class="cart-item-controls">
          <button class="qty-btn" onclick="changeQty(${c.food_id},${c.quantity - 1})">−</button>
          <span class="qty-val">${c.quantity}</span>
          <button class="qty-btn" onclick="changeQty(${c.food_id},${c.quantity + 1})">+</button>
        </div>
      </div>`).join('');
  }

  const subEl = document.getElementById('cartSubtotal');
  if (subEl) subEl.textContent = `$${subtotal.toFixed(2)}`;

  const totalEl = document.getElementById('cartTotal');
  if (totalEl) totalEl.textContent = `$${grand.toFixed(2)}`;

  if (footerEl) footerEl.style.display = 'block';
}

function checkout() {
  window.location.href = BASE_URL + '/checkout';
}

// ───── TOAST ─────
let _toastTimer;
function toast(msg) {
  const el = document.getElementById('toast');
  if (!el) return;
  el.textContent = msg;
  el.classList.add('show');
  clearTimeout(_toastTimer);
  _toastTimer = setTimeout(() => el.classList.remove('show'), 2800);
}

// ───── SIDEBAR ─────
function toggleSidebar() {
  const sidebar = document.getElementById('userSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  if (sidebar) sidebar.classList.toggle('active');
  if (overlay) overlay.classList.toggle('active');
}
