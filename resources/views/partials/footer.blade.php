<footer>
    <div class="footer-inner">
      <div class="footer-col brand-col">
        <div class="footer-logo">{{ config('app.name') }}</div>
        <p>ម្ហូបឆ្ងាញ់ពិសារ សាខា<br/>បន្ទាយមានជ័យ</p>
        <div class="socials">
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-tiktok"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-telegram"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>ម៉ឺនុយ</h4>
        <a href="#">ម្ហូបខ្មែរ</a>
        <a href="#">ភីហ្សា</a>
        <a href="#">បឺហ្គឺ</a>
        <a href="#">ភេសជ្ជៈ</a>
      </div>
      <div class="footer-col">
        <h4>ក្រុមហ៊ុន</h4>
        <a href="#">អំពីយើង</a>
        <a href="#">ការងារ</a>
        <a href="#">ភ្នាក់ងារ</a>
        <a href="#">ព័ត៌មាន</a>
      </div>
      <div class="footer-col">
        <h4>ទំនាក់ទំនង</h4>
        <p><i class="fa fa-phone"></i> +855 067 267 968</p>
        <p><i class="fa fa-envelope"></i> thorngdy632@gmail.com</p>
        <p><i class="fa fa-location-dot"></i> បន្ទាយមានជ័យ</p>
        <p><i class="fa fa-clock"></i> ក្រុងសិរីសោភ័ណ</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p><i>@if(date('Y')) {{ date('Y') }} @endif {{ config('app.name') }}. All rights reserved</i></p>
    </div>
  </footer>

  <div id="cartOverlay" class="cart-overlay" onclick="toggleCart()"></div>
  <div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
      <div class="cart-header-left">
        <i class="fa-solid fa-bag-shopping"></i>
        <h2>កន្ត្រក</h2>
      </div>
      <button class="close-cart" onclick="toggleCart()">✕</button>
    </div>
    <div id="cartItems" class="cart-items"></div>
    <div id="cartFooter" class="cart-footer">
      <div class="cart-row"><span>តម្លៃដើម</span><span id="cartSubtotal">$0.00</span></div>
      <div class="cart-row cart-total-row"><span>សរុប</span><span id="cartTotal">$0.00</span></div>
      <button class="checkout-btn" onclick="checkout()" id="checkoutBtn">បញ្ជាទិញឥឡូវនេះ</button>
    </div>
  </div>
  <div id="toast" class="toast"></div>
