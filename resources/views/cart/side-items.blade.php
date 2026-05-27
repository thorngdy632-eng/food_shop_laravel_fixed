{{-- resources/views/cart/side-items.blade.php --}}

@if(empty($cart))
    <div style="text-align: center; padding: 60px 20px; color: #888; font-family: 'Noto Sans Khmer', sans-serif;">
        <i class="fa-solid fa-basket-shopping" style="font-size: 3rem; color: #4dff47; margin-bottom: 15px;"></i>
        <h4 style="color: #fff; margin-bottom: 5px;">កន្ត្រករបស់អ្នកទទេ</h4>
        <p style="font-size: 0.85rem; color: #666;">សូមបន្ថែមមុខម្ហូបដែលអ្នកចូលចិត្ត</p>
    </div>
@else
    {{-- បញ្ជីរាយមុខម្ហូប --}}
    @foreach($cart as $key => $item)
        @php
            $foodId = $item['food_id'] ?? str_replace('food_', '', $key);
        @endphp
        
        <div class="side-item-row" id="side-row-{{ $foodId }}" data-food-id="{{ $foodId }}" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #222;">
            
            {{-- ផ្នែកខាងឆ្វេង៖ រូបភាព និង ឈ្មោះ តម្លៃ --}}
            <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                <img src="{{ asset($item['image']) }}" style="width: 65px; height: 65px; border-radius: 12px; object-fit: cover; border: 1px solid #252525;" onerror="this.src='{{ asset('assets/Overal/logo.png') }}'">
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <span style="color: #fff; font-weight: bold; font-family: 'Noto Sans Khmer'; font-size: 0.95rem;">{{ $item['name'] }}</span>
                    <span style="color: #4dff47; font-weight: bold; font-size: 0.9rem;">${{ number_format($item['price'], 2) }}</span>
                </div>
            </div>

            {{-- ផ្នែកកណ្តាល៖ ប៊ូតុង បូក/ដក ចំនួន --}}
            <div style="display: flex; align-items: center; gap: 8px; background: #1a1a1a; padding: 4px 8px; border-radius: 6px; border: 1px solid #282828; margin-right: 15px;">
                <button type="button" onclick="handleQtyChange('{{ $foodId }}', -1)" style="width: 24px; height: 24px; border-radius: 4px; background: #4dff47; border: none; color: #000; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                <span id="side-qty-text-{{ $foodId }}" style="color: #fff; font-weight: bold; font-size: 0.9rem; min-width: 20px; text-align: center;">{{ $item['quantity'] }}</span>
                <button type="button" onclick="handleQtyChange('{{ $foodId }}', 1)" style="width: 24px; height: 24px; border-radius: 4px; background: #4dff47; border: none; color: #000; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
            </div>

            {{-- ផ្នែកខាងស្តាំ៖ ប៊ូតុងលុបចេញ --}}
            <button type="button" onclick="handleRemoveItem('{{ $foodId }}')" style="background: transparent; border: none; color: #ff4d4f; cursor: pointer; font-size: 1.1rem; padding: 5px;">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    @endforeach

    {{-- ផ្នែកទឹកប្រាក់សរុប និងប៊ូតុង Checkout --}}
    <div style="margin-top: 25px; padding-top: 15px; border-top: 1px dashed #282828;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <span style="color: #888; font-family: 'Noto Sans Khmer'; font-size: 0.95rem;">ទឹកប្រាក់សរុប៖</span>
            <span style="color: #fff; font-weight: 900; font-size: 1.5rem;">$<span id="drawer-cart-total">{{ number_format($total, 2) }}</span></span>
        </div>
        
        {{-- ── ពិនិត្យលក្ខខណ្ឌ Login ── --}}
        @auth
            {{-- បើបាន Login រួចរាល់៖ បង្ហាញប៊ូតុងពណ៌បៃតងទៅកាន់ទំព័រ Checkout --}}
            <a href="{{ route('checkout.index') }}" style="display: block; background: #4dff47; color: #000; text-align: center; padding: 14px; border-radius: 30px; text-decoration: none; font-weight: bold; font-family: 'Noto Sans Khmer'; font-size: 1rem; transition: background 0.2s;">
                បន្តទៅកាន់ការទូទាត់ប្រាក់ <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i>
            </a>
        @else
            {{-- បើមិនទាន់ Login ទេ៖ បង្ហាញសារព្រមាន និងប៊ូតុងពណ៌លឿងទៅកាន់ទំព័រ Login --}}
            <div style="text-align: center; padding: 5px 0; font-family: 'Noto Sans Khmer', sans-serif;">
                <p style="color: #ff4d4f; font-size: 0.85rem; margin-bottom: 12px; font-weight: bold;">
                    <i class="fa-solid fa-triangle-exclamation"></i> សូមចូលគណនីជាមុនសិន ទើបអាចបញ្ជាទិញបាន!
                </p>
                <a href="{{ route('login') }}" style="display: block; background: #ffaa00; color: #000; text-align: center; padding: 14px; border-radius: 30px; text-decoration: none; font-weight: bold; font-size: 1rem; transition: background 0.2s;">
                    <i class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i> ចូលគណនី / Login
                </a>
            </div>
        @endauth
    </div>
@endif