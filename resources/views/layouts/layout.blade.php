<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ផ្ទាំងគ្រប់គ្រង') — THORNG DY'S SHOP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@300;400;500;600;700&family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ==========================================================================
           FIXED CODES: ADMIN PANEL MATCHING USER SIDE OVERALL THEME (DARK & NEON GREEN)
           ========================================================================== */
        :root {
            --primary: #32e622;            /* ប្តូរជាពណ៌បៃតងលេចដូចផ្ទាំង User */
            --primary-dark: #29c71b;       /* ពណ៌បៃតងដិតពេល Hover */
            --primary-light: rgba(50, 230, 34, 0.1); /* បៃតងថ្លាសម្រាប់ background background */
            --secondary: #1f1f1f;
            --sidebar-bg: #161616;         /* ពណ៌ Sidebar ងងឹតដិត */
            --sidebar-hover: #222222;      /* ពណ៌ Sidebar ពេល hover */
            --sidebar-active: #32e622;     /* ពណ៌ Sidebar សកម្ម */
            --sidebar-text: #9e9e9e;
            --sidebar-text-active: #ffffff;
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --bg: #121212;                /* ផ្ទៃ Background ក្រោយជា Dark Mode ដិត */
            --card-bg: #1a1a1a;            /* ពណ៌ប្រអប់ Card ងងឹត */
            --border: #252525;             /* ពណ៌បន្ទាត់កាត់ */
            --text: #ffffff;               /* អក្សរពណ៌ស */
            --text-muted: #888888;          /* អក្សរពណ៌ប្រផេះស្រអាប់ */
            --success: #32e622;
            --warning: #ecc94b;
            --danger: #fc8181;
            --info: #63b3ed;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            --shadow-md: 0 8px 30px rgba(50, 230, 34, 0.15);
            --radius: 16px;                /* ជ្រុងមូលកោងស្អាត (16px) ដូចផ្ទាំង User */
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Noto Sans Khmer', 'Kantumruy Pro', 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s ease, width 0.3s ease;
            overflow: hidden;
            border-right: 1px solid var(--border);
        }

        .sidebar.collapsed { width: 68px; }
        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed .sidebar-footer-info { display: none; }
        .sidebar.collapsed .nav-item { justify-content: center; padding: 14px; }
        .sidebar.collapsed .nav-icon { margin: 0; }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 18px;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
            min-height: var(--topbar-height);
            background: #121212;
        }

        .sidebar-logo-icon {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            color: #000000; /* ឱ្យរដកភ្លើងពណ៌ខ្មៅធ្លោលើរង្វង់បៃតង */
        }

        .sidebar-logo-text {
            font-size: .95rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-logo-text span {
            display: block;
            font-size: .7rem;
            font-weight: 400;
            color: var(--primary); /* ដូរអក្សរ Admin Panel ជាពណ៌បៃតងលេច */
            margin-top: 1px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0;
            scrollbar-width: thin;
            scrollbar-color: #252525 transparent;
        }

        .nav-section-title {
            padding: 14px 18px 6px;
            font-size: .65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #444444; /* ពណ៌ចំណងជើងផ្នែកស្រទន់ */
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 18px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all .2s;
            position: relative;
            cursor: pointer;
            border: none;
            background: none;
            width: calc(100% - 20px);
            margin: 2px 10px;
            border-radius: 8px;
            text-align: left;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: var(--primary);
        }

        .nav-item.active {
            background: rgba(50, 230, 34, 0.15) !important;
            color: var(--primary) !important;
            border-right: none;
        }
        
        /* បន្ថែមរស្មីឆ្នូតបៃតងតូចមួយចំហៀងពេល Active */
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 20%;
            height: 60%;
            width: 4px;
            background: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .nav-label { font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif; }

        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: #000;
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 16px 18px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
            background: #141414;
        }

        .sidebar-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            flex-shrink: 0;
        }

        .sidebar-footer-info { flex: 1; overflow: hidden; }
        .sidebar-footer-name {
            font-size: .8rem;
            font-weight: 600;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-footer-role {
            font-size: .68rem;
            color: var(--primary);
            font-weight: 500;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 0 24px;
            z-index: 900;
            transition: left .3s ease;
        }

        .topbar.shifted { left: 68px; }

        .topbar-toggle {
            background: none; border: none;
            width: 36px; height: 36px;
            border-radius: 8px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            transition: background .2s;
        }
        .topbar-toggle:hover { background: var(--bg); color: var(--primary); }

        .topbar-breadcrumb {
            font-size: .875rem;
            color: var(--text-muted);
        }
        .topbar-breadcrumb strong { color: #ffffff; }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-icon-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: none;
            background: var(--bg);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            font-size: .95rem;
            transition: all .2s;
            position: relative;
            text-decoration: none;
        }
        .topbar-icon-btn:hover { background: var(--primary-light); color: var(--primary); }

        .topbar-badge {
            position: absolute;
            top: 5px; right: 5px;
            width: 8px; height: 8px;
            background: var(--primary);
            border-radius: 50%;
            border: 2px solid var(--card-bg);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            border-radius: 12px;
            cursor: pointer;
            transition: background .2s;
            text-decoration: none;
        }
        .topbar-user:hover { background: var(--bg); }
        .topbar-user img {
            width: 34px; height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }
        .topbar-user-info { line-height: 1.2; }
        .topbar-user-name { font-size: .83rem; font-weight: 600; color: var(--text); }
        .topbar-user-role { font-size: .7rem; color: var(--primary); font-weight: 500; }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 28px;
            flex: 1;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left .3s ease;
        }

        .main-content.shifted { margin-left: 68px; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text); font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif; }
        .page-subtitle { font-size: .85rem; color: var(--text-muted); margin-top: 4px; }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;
            font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        }

        .card-body { padding: 22px; }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(50, 230, 34, 0.3);
        }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-value { font-size: 1.6rem; font-weight: 800; line-height: 1; color: #ffffff; }
        .stat-label { font-size: .8rem; color: var(--text-muted); margin-top: 4px; font-weight: 500; font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;}

        /* កែសម្រួលពណ៌ Icon ក្នុងប្រអប់ស្ថិតិឱ្យដេញពណ៌បៃតងស្អាត */
        .icon-orange { background: rgba(50,230,34,.1); color: var(--primary); }
        .icon-green  { background: rgba(50,230,34,.1); color: var(--primary); }
        .icon-blue   { background: rgba(50,230,34,.1); color: var(--primary); }
        .icon-purple { background: rgba(50,230,34,.1); color: var(--primary); }
        .icon-yellow { background: rgba(50,230,34,.1); color: var(--primary); }
        .icon-red    { background: rgba(252,129,129,.12); color: var(--danger); }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 30px;            /* ធ្វើឱ្យប៊ូតុងមូលវែងស្អាតដូចផ្ទាំង User */
            font-size: .875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
            font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        }

        .btn-secondary { background: var(--sidebar-bg); color: #ffffff; border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--border); }
        .btn-success   { background: var(--success); color: #000; }
        .btn-danger    { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #e57373; }
        .btn-warning   { background: var(--warning); color: #744210; }
        .btn-sm { padding: 6px 16px; font-size: .8rem; }
        .btn-xs { padding: 4px 12px; font-size: .75rem; }

        /* ── TABLE ── */
        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .875rem;
            background: var(--card-bg);
        }

        thead th {
            padding: 14px 16px;
            text-align: left;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--primary);          /* ក្បាលតារាងដូរជាពណ៌បៃតងលេច */
            background: #1f1f1f;           /* background ក្បាលតារាងរាងក្រាស់ជាងមុន */
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
            font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: #e0e0e0;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #222222; } /* ហាយឡាយពេល hover លើតារាង */

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-pending   { background: rgba(236,201,75,.15);  color: #ecc94b; border: 1px solid rgba(236,201,75,.3); }
        .badge-confirmed { background: rgba(99,179,237,.15);  color: #63b3ed; border: 1px solid rgba(99,179,237,.3); }
        .badge-preparing { background: rgba(159,122,234,.15); color: #9f7aea; border: 1px solid rgba(159,122,234,.3); }
        .badge-delivered { background: rgba(50, 230, 34, 0.15);  color: var(--primary); border: 1px solid rgba(50, 230, 34, 0.3); }
        .badge-cancelled { background: rgba(252,129,129,.15); color: #fc8181; border: 1px solid rgba(252,129,129,.3); }
        .badge-admin     { background: rgba(50, 230, 34, 0.15);  color: var(--primary); }
        .badge-user      { background: rgba(99,179,237,.15);  color: #63b3ed; }

        /* ── FORMS ── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: .83rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 7px;
            font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .875rem;
            font-family: 'Noto Sans Khmer', sans-serif;
            color: #ffffff;
            background: #121212;          /* ប្រអប់វាយទិន្នន័យទៅជាពណ៌ខ្មៅដិត */
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(50, 230, 34, 0.15);
        }

        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }

        .form-control::placeholder { font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif; }

        /* ── ALERTS ── */
        .alert {
            padding: 13px 18px;
            border-radius: 10px;
            font-size: .875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success { background: rgba(50, 230, 34, 0.15); color: var(--primary); border: 1px solid rgba(50, 230, 34, 0.3); }
        .alert-error   { background: rgba(252,129,129,.12); color: #fc8181; border: 1px solid rgba(252,129,129,.3); }
        .alert-info    { background: rgba(99,179,237,.12);  color: #63b3ed; border: 1px solid rgba(99,179,237,.3); }

        /* ── FOOD GRID ── */
        .food-admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 18px;
        }

        .food-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .food-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: rgba(50, 230, 34, 0.2); }

        .food-card-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        .food-card-body { padding: 14px; }
        .food-card-name { font-weight: 700; font-size: .9rem; margin-bottom: 4px; color: #ffffff; }
        .food-card-cat  { font-size: .75rem; color: var(--text-muted); margin-bottom: 8px; }
        .food-card-price { font-weight: 800; color: var(--primary); font-size: 1rem; }
        .food-card-actions { padding: 10px 14px 14px; display: flex; gap: 8px; }

        /* ── PAGINATION ── */
        .pagination { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; margin-top: 20px; }
        .pagination a, .pagination span {
            padding: 7px 12px;
            border-radius: 8px;
            font-size: .83rem;
            font-weight: 500;
            text-decoration: none;
            color: #ffffff;
            border: 1px solid var(--border);
            background: var(--card-bg);
            transition: all .2s;
        }
        .pagination a:hover { background: var(--primary); color: #000; border-color: var(--primary); }
        .pagination span[aria-current] { background: var(--primary); color: #000; border-color: var(--primary); }

        /* ── SEARCH BAR ── */
        .search-bar {
            display: flex;
            align-items: center;
            background: #121212;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0 14px;
            gap: 10px;
            width: 260px;
        }

        .search-bar input {
            border: none;
            background: none;
            padding: 9px 0;
            font-size: .875rem;
            color: #ffffff;
            width: 100%;
            font-family: 'Inter', sans-serif;
        }

        .search-bar input:focus { outline: none; }
        .search-bar i { color: var(--text-muted); }

        /* ── FILTER ROW ── */
        .filter-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        /* ── STATUS SELECTOR ── */
        .status-select {
            padding: 7px 12px;
            border: 1px solid var(--border);
            border-radius: 9px;
            font-size: .83rem;
            font-family: 'Kantumruy Pro', sans-serif;
            background: var(--card-bg);
            color: #ffffff;
            cursor: pointer;
        }

        /* ── USER AVATAR ── */
        .user-avatar-sm {
            width: 34px; height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
        }

        /* ── MISC ── */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .mb-2 { margin-bottom: 8px; }
        .text-sm { font-size: .85rem; }
        .text-xs { font-size: .75rem; }
        .text-muted { color: var(--text-muted); }
        .text-primary { color: var(--primary); }
        .font-bold { font-weight: 700; }
        .w-full { width: 100%; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 3rem; margin-bottom: 16px; color: var(--border); }
        .empty-state h3 { font-size: 1rem; margin-bottom: 6px; font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); width: var(--sidebar-width) !important; }
            .sidebar.mobile-open { transform: translateX(0); }
            .topbar { left: 0 !important; }
            .main-content { margin-left: 0 !important; padding: 16px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .topbar-user-info { display: none; }
            .search-bar { width: 180px; }
            .food-admin-grid { grid-template-columns: 1fr 1fr; }
        }

        /* ── SIDEBAR OVERLAY (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.65);
            z-index: 999;
        }
        .sidebar-overlay.active { display: block; }
    </style>
    @stack('styles')
</head>
<body>

@php
    $khmer = [
        'Dashboard'        => 'ផ្ទាំងគ្រប់គ្រង',
        'Food Management'  => 'ការគ្រប់គ្រងមុខម្ហូប',
        'Orders'           => 'ការបញ្ជាទិញ',
        'Customers'        => 'អតិថិជន',
        'Sales Analytics'  => 'ការវិភាគការលក់',
        'Reviews & Ratings' => 'ការពិនិត្យ និងការវាយតម្លៃ',
        'Coupons / Discounts' => 'គូប៉ុង / ការបញ្ចុះតម្លៃ',
        'Notifications'    => 'ការជូនដំណឹង',
        'Contact Messages' => 'សារទំនាក់ទំនង',
        'Activity Logs'    => 'កំណត់ហេតុសកម្មភាព',
        'Settings'         => 'ការកំណត់',
        'System Info'      => 'ព័ត៌មានប្រព័ន្ធ',
        'View Shop'        => 'មើលហាង',
        'Administrator'    => 'អ្នកគ្រប់គ្រង',
        'Admin Panel'      => 'ផ្ទាំងគ្រប់គ្រង',
        'Admin'            => 'អ្នកគ្រប់គ្រង',
        'Main'             => 'មេ',
        'Management'       => 'គ្រប់គ្រង',
        'Reports'          => 'របាយការណ៍',
        'System'           => 'ប្រព័ន្ធ',
        'Shop'             => 'ហាង',
        'Pending Orders'   => 'ការបញ្ជាទិញដែលរង់ចាំ',
        'Toggle sidebar'   => 'បិទ/បើកបញ្ជី',
    ];
@endphp

<aside class="sidebar" id="adminSidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <div class="sidebar-logo-icon"><i class="fa fa-fire"></i></div>
        <div class="sidebar-logo-text">
            THORNG DY'S
            <span>{{ $khmer['Admin Panel'] }}</span>
        </div>
    </a>

    <nav class="sidebar-nav">
        <span class="nav-section-title">{{ $khmer['Main'] }}</span>

        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa fa-gauge nav-icon"></i>
            <span class="nav-label">{{ $khmer['Dashboard'] }}</span>
        </a>

        <span class="nav-section-title">{{ $khmer['Management'] }}</span>

        <a href="{{ route('admin.foods') }}" class="nav-item {{ request()->routeIs('admin.foods*') ? 'active' : '' }}">
            <i class="fa fa-bowl-food nav-icon"></i>
            <span class="nav-label">{{ $khmer['Food Management'] }}</span>
        </a>

        <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <i class="fa fa-receipt nav-icon"></i>
            <span class="nav-label">{{ $khmer['Orders'] }}</span>
            @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.ai.index') }}" class="nav-item {{ request()->routeIs('admin.ai.*') ? 'active' : '' }}">
            <i class="fa fa-microchip nav-icon"></i>
            <span class="nav-label">OpenCode AI</span>
        </a>

        <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fa fa-users nav-icon"></i>
            <span class="nav-label">{{ $khmer['Customers'] }}</span>
        </a>

        <span class="nav-section-title">{{ $khmer['Reports'] }}</span>

        <a href="#" class="nav-item">
            <i class="fa fa-chart-bar nav-icon"></i>
            <span class="nav-label">{{ $khmer['Sales Analytics'] }}</span>
        </a>

        <a href="#" class="nav-item">
            <i class="fa fa-star nav-icon"></i>
            <span class="nav-label">{{ $khmer['Reviews & Ratings'] }}</span>
        </a>

        <a href="#" class="nav-item">
            <i class="fa fa-tag nav-icon"></i>
            <span class="nav-label">{{ $khmer['Coupons / Discounts'] }}</span>
        </a>

        <a href="#" class="nav-item">
            <i class="fa fa-bell nav-icon"></i>
            <span class="nav-label">{{ $khmer['Notifications'] }}</span>
        </a>

        <span class="nav-section-title">{{ $khmer['System'] }}</span>

        <a href="#" class="nav-item">
            <i class="fa fa-envelope nav-icon"></i>
            <span class="nav-label">{{ $khmer['Contact Messages'] }}</span>
        </a>

        <a href="#" class="nav-item">
            <i class="fa fa-clock-rotate-left nav-icon"></i>
            <span class="nav-label">{{ $khmer['Activity Logs'] }}</span>
        </a>

        <a href="#" class="nav-item">
            <i class="fa fa-gear nav-icon"></i>
            <span class="nav-label">{{ $khmer['Settings'] }}</span>
        </a>

        <a href="#" class="nav-item">
            <i class="fa fa-circle-info nav-icon"></i>
            <span class="nav-label">{{ $khmer['System Info'] }}</span>
        </a>

        <span class="nav-section-title">{{ $khmer['Shop'] }}</span>

        <a href="{{ route('home') }}" class="nav-item">
            <i class="fa fa-store nav-icon"></i>
            <span class="nav-label">{{ $khmer['View Shop'] }}</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <img src="{{ asset('assets/profiles/' . (auth()->user()->profile_image ?? 'default.jfif')) }}"
             alt="avatar" class="sidebar-avatar">
        <div class="sidebar-footer-info">
            <div class="sidebar-footer-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-footer-role">{{ $khmer['Administrator'] }}</div>
        </div>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleAdminSidebar()"></div>

<header class="topbar" id="adminTopbar">
    <button class="topbar-toggle" onclick="toggleAdminSidebar()" title="{{ $khmer['Toggle sidebar'] }}">
        <i class="fa fa-bars"></i>
    </button>

    <span class="topbar-breadcrumb">
        {{ $khmer['Administrator'] }} / <strong>@yield('breadcrumb', 'ផ្ទាំងគ្រប់គ្រង')</strong>
    </span>

    <div class="topbar-right">
        <a href="{{ route('admin.orders') }}" class="topbar-icon-btn" title="{{ $khmer['Pending Orders'] }}">
            <i class="fa fa-receipt"></i>
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="topbar-badge"></span>
            @endif
        </a>

        <a href="#" class="topbar-icon-btn" title="{{ $khmer['Notifications'] }}">
            <i class="fa fa-bell"></i>
        </a>

        <div style="display:flex;align-items:center;gap:8px;">
            <div class="topbar-user">
                <img src="{{ asset('assets/profiles/' . (auth()->user()->profile_image ?? 'default.jfif')) }}"
                     alt="avatar">
                <div class="topbar-user-info">
                    <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                    <div class="topbar-user-role">{{ $khmer['Admin'] }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="topbar-icon-btn" title="Logout" style="color:#fc8181;">
                    <i class="fa fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</header>

<main class="main-content" id="adminMain">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <i class="fa fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<script>
    const sidebar  = document.getElementById('adminSidebar');
    const topbar   = document.getElementById('adminTopbar');
    const main     = document.getElementById('adminMain');
    const overlay  = document.getElementById('sidebarOverlay');
    let collapsed  = false;
    let mobileMQ   = window.matchMedia('(max-width: 900px)');

    function toggleAdminSidebar() {
        if (mobileMQ.matches) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        } else {
            collapsed = !collapsed;
            sidebar.classList.toggle('collapsed', collapsed);
            topbar.classList.toggle('shifted', collapsed);
            main.classList.toggle('shifted', collapsed);
        }
    }

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => {
            a.style.transition = 'opacity .5s';
            a.style.opacity = '0';
            setTimeout(() => a.remove(), 500);
        });
    }, 3500);
</script>

@stack('scripts')
</body>
</html>