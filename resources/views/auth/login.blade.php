<!DOCTYPE html>
<html lang="km">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ចូលប្រើប្រាស់ — THORNG DY'S SHOP</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wdth,wght@62.5,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }
    body {
      font-family: 'Noto Sans Khmer', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .auth-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;

      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url("{{ asset('assets/Overal/bg.jpg') }}");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;

      padding: 40px 20px;
      box-sizing: border-box;
    }
    .auth-card {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      z-index: 10;
    }
    .shop-logo {
      width: 80px; height: 80px;
      background: #4dff47;
      border-radius: 50%;
      margin: 0 auto 20px;
      display: flex; justify-content: center; align-items: center;
      overflow: hidden;
    }
    .shop-logo img { width: 100%; height: 100%; object-fit: cover; }
    .input-group { position: relative; margin-bottom: 20px; }
    .input-group i.main-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a4b0be; }
    .input-group input {
      width: 100%; padding: 14px 45px; border: 2px solid #f1f2f6; border-radius: 12px;
      outline: none; font-size: 14px;
    }
    .input-group input:focus { border-color: #4dff47; }
    .btn-submit {
      width: 100%; padding: 14px; background: linear-gradient(135deg, #4dff47, #27ae60);
      color: white; border: none; border-radius: 12px; cursor: pointer;
      font-size: 1rem; font-weight: bold; transition: 0.3s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(77,255,71,0.3); }
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 20px 0; color: #a4b0be; font-size: 0.85rem;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: #e0e0e0;
    }
    .btn-google {
      width: 100%; padding: 12px;
      background: white; border: 1px solid #ddd; border-radius: 12px;
      cursor: pointer; font-size: 0.95rem; font-weight: 600;
      display: flex; align-items: center; justify-content: center; gap: 10px;
      color: #333; text-decoration: none; transition: 0.2s;
    }
    .btn-google:hover { background: #f5f5f5; border-color: #bbb; }
    .alert { padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; }
    .alert-error { background: #ffeaea; color: #ff4757; }
    .alert-success { background: #eaffea; color: #2ed573; }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="shop-logo">
        <img src="{{ asset('assets/Overal/logo.jfif') }}" alt="LOGO">
      </div>

      <h2 style="margin-bottom: 5px; color: #2c3e50; text-align: center;">WELCOME TO OUR SHOP</h2>
      <p style="color: #747d8c; margin-bottom: 20px; font-size: 14px; text-align: center;">ម្ហូបឆ្ងាញ់ សេវាកម្មរហ័ស</p>

      @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
      @endif
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group">
          <i class="fa-solid fa-envelope main-icon"></i>
          <input type="email" name="email" placeholder="អ៊ីមែល" required>
        </div>
        <div class="input-group">
          <i class="fa-solid fa-lock main-icon"></i>
          <input type="password" name="password" placeholder="លេខសម្ងាត់" required>
        </div>
        <button type="submit" name="login" class="btn-submit">ចូលប្រើប្រាស់</button>
      </form>

      <div class="divider">ឬ</div>

      @if(Route::has('login.google'))
      <a href="{{ route('login.google') }}" class="btn-google">
        <i class="fa-brands fa-google"></i>
        ចូលប្រើជាមួយ Google
      </a>
      @endif

      <p style="text-align: center; margin-top: 15px;">
        មិនទាន់មានគណនី? <a href="{{ route('register') }}" style="color: #4dff47; text-decoration: none; font-weight: bold;">ចុះឈ្មោះ</a>
      </p>
    </div>
  </div>
</body>
</html>
