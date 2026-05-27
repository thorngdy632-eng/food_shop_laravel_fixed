@extends('layouts.app')

@section('title', "THORNG DY'S SHOP - ទំព័រដើម")

@section('content')

<section class="hero">
  <div class="hero-glow g1"></div>
  <div class="hero-glow g2"></div>
  <div class="hero-left">
    <p class="hero-eyebrow"><span class="dot"></span> បើកម៉ោង ៧ព្រឹក — ១០យប់</p>
    <h1 class="hero-title"><span class="accent">ឆ្ងាញ់</span></h1>
    <p class="hero-desc">គ្រឿងផ្សំស្រស់ៗ រៀបចំដោយអ្នកជំនាញ <br/>តោះនៅចាំដល់ណាទៀត?</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="document.getElementById('menuSection').scrollIntoView({behavior:'smooth'})">
        <i class="fa fa-bowl-food"></i> មើលម៉ឺនុយ
      </button>
      <button class="btn-ghost"><i class="fa fa-phone"></i> <table>ទំនាក់ទំនង</table></button>
    </div>
  </div>
  <div class="hero-right">
    <div class="hero-cards">
      <div class="hcard hc1"><img src="{{ asset('assets/Pizza/Margherita.jpg') }}" alt="Pizza" style="width: 90px; height: 90px; border-radius: 20px;"><p>ភីហ្សា</p></div>
      <div class="hcard hc2"><img src="{{ asset('assets/Burger/Cheeseburger.jpg') }}" alt="Burger" style="width: 90px; height: 90px; border-radius: 20px;"><p>បឺហ្គឺ</p></div>
      <div class="hcard hc3"><img src="{{ asset('assets/Khmer_food/Amok.jpg') }}" alt="Khmer Food" style="width: 90px; height: 90px; border-radius: 20px;"><p>ម្ហូបខ្មែរ</p></div>
      <div class="hcard hc4"><img src="{{ asset('assets/Boiled_noodle/Glassnoodles.jpg') }}" alt="Noodles" style="width: 90px; height: 90px; border-radius: 20px;"><p>មីស្ងោរ</p></div>
      <div class="hcard hc5"><img src="{{ asset('assets/Sushi/Salmonnigiri.jpg') }}" alt="Sushi" style="width: 90px; height: 90px; border-radius: 20px;"><p>សូស៊ី</p></div>
      <div class="hcard hc6"><img src="{{ asset('assets/Drink/Icedcoffee.jpg') }}" alt="Drinks" style="width: 90px; height: 90px; border-radius: 20px;"><p>ភេសជ្ជៈ</p></div>
    </div>
  </div>
</section>

<div class="stats-bar">
  <div class="stat-item"><strong>20+</strong><span>ម្ហូបក្នុងម៉ឺនុយ</span></div>
  <div class="stat-sep"></div>
  <div class="stat-item"><strong>4.9 ★</strong><span>ការវាយតម្លៃ</span></div>
  <div class="stat-sep"></div>
  <div class="stat-item"><strong>30 នាទី</strong><span>ដឹកជញ្ជូន</span></div>
  <div class="stat-sep"></div>
  <div class="stat-item"><strong>10,000+</strong><span>អតិថិជនពេញចិត្ត</span></div>
</div>

<section class="menu-section" id="menuSection">
  <div class="menu-header">
    <div>
      <p class="eyebrow">សូមជ្រើសរើសមុខម្ហូប</p>
      <h2 class="menu-title">តើអ្នកចង់ញុាំអ្វី ?</h2>
    </div>
    <div class="search-wrap">
      <i class="fa fa-magnifying-glass"></i>
      <input type="text" id="searchInput" placeholder="ស្វែងរកម្ហូប..." oninput="filterFoods()"/>
    </div>
  </div>

  <div class="cats" id="cats">
    <button class="cat active" data-cat="all" onclick="setCategory('all',this)">ទាំងអស់</button>
    <button class="cat" data-cat="khmer" onclick="setCategory('khmer',this)">ម្ហូបខ្មែរ</button>
    <button class="cat" data-cat="pizza" onclick="setCategory('pizza',this)">ភីហ្សា</button>
    <button class="cat" onclick="setCategory('burger',this)">បឺហ្គឺ</button>
    <button class="cat" onclick="setCategory('drinks',this)">ភេសជ្ជៈ</button>
    <button class="cat" onclick="setCategory('dessert',this)">បង្អែម</button>
    <button class="cat" onclick="setCategory('noodles',this)">គុយទាវ</button>
  </div>

  <div class="food-grid" id="foodGrid"></div>

  <div class="empty-state" id="emptyState" style="display:none">
    <img src="{{ asset('assets/Overal/Not.png') }}" alt="Not Found" style="width: 80px; height: 80px; margin-bottom: 15px;">
    <p>រកមិនឃើញម្ហូបទេ</p>
    <small>សូមព្យាយាមស្វែងរកម្ដងទៀត</small>
  </div>
</section>

<script>
    window.isAdminUser = @json(auth()->check() && auth()->user()->role === 'admin');
</script>

@endsection