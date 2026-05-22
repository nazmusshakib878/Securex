<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="/site/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --admin-bg: #f3f6fb;
            --admin-panel: #ffffff;
            --admin-ink: #172033;
            --admin-muted: #687386;
            --admin-line: #e5eaf2;
            --admin-primary: #1d4ed8;
            --admin-sidebar: #111827;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-ink);
        }

        #sidebarMenu {
            width: 280px;
            min-height: 100vh;
            transition: transform .25s ease;
            background: linear-gradient(180deg, #111827 0%, #172033 100%);
            box-shadow: 16px 0 40px rgba(15, 23, 42, .12);
        }

        #sidebarMenu .nav-link {
            color: rgba(255, 255, 255, .72);
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: .65rem;
            margin-bottom: .25rem;
            padding: .75rem .9rem;
            transition: all .2s ease;
        }

        #sidebarMenu .nav-link.active,
        #sidebarMenu .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, .11);
            transform: translateX(3px);
        }

        #sidebarMenu .nav-link i {
            width: 1.1rem;
            text-align: center;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(37, 99, 235, .32);
        }

        .content-wrapper {
            flex: 1;
            transition: margin .25s ease;
            min-width: 0;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 1040;
        }

        @media (max-width: 991.98px) {
            #sidebarMenu {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1050;
                transform: translateX(-100%);
                min-height: 100vh;
            }

            #sidebarMenu.show {
                transform: translateX(0);
            }

            .content-wrapper {
                margin-left: 0;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }

        .admin-topbar {
            background: rgba(255, 255, 255, .92);
            border-bottom: 1px solid var(--admin-line);
            backdrop-filter: blur(14px);
        }

        .admin-page {
            padding: 1.5rem;
        }

        .card,
        .card-transparent {
            background: var(--admin-panel);
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
        }

        .stat-card {
            overflow: hidden;
            position: relative;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            inset: auto -30px -35px auto;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(29, 78, 216, .08);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .table > :not(caption) > * > * {
            padding: 1rem .9rem;
        }

        .table thead th {
            color: var(--admin-muted);
            font-size: .76rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--admin-line);
        }

        .form-control,
        .form-select {
            border-color: var(--admin-line);
            border-radius: 8px;
            min-height: 46px;
        }

        .btn {
            border-radius: 8px;
        }

        .btn-primary {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .page-header-kicker {
            color: var(--admin-muted);
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .dashboard-shell {
            max-width: 1180px;
        }

        .dashboard-hero {
            background: linear-gradient(135deg, #0f766e 0%, #155e75 54%, #312e81 100%);
            border-radius: 8px;
            color: #fff;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1.5rem;
            align-items: end;
            padding: 2rem;
            box-shadow: 0 18px 45px rgba(15, 118, 110, .22);
        }

        .dashboard-hero-copy {
            max-width: 650px;
        }

        .dashboard-hero-copy p {
            color: rgba(255, 255, 255, .78);
        }

        .dashboard-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            justify-content: flex-end;
        }

        .dashboard-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .metric-tile {
            background: var(--admin-panel);
            border: 1px solid var(--admin-line);
            border-left: 4px solid var(--metric-color);
            border-radius: 8px;
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
            min-height: 126px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .05);
        }

        .metric-blue {
            --metric-color: #2563eb;
            --metric-soft: rgba(37, 99, 235, .11);
        }

        .metric-green {
            --metric-color: #059669;
            --metric-soft: rgba(5, 150, 105, .12);
        }

        .metric-orange {
            --metric-color: #d97706;
            --metric-soft: rgba(217, 119, 6, .13);
        }

        .metric-purple {
            --metric-color: #7c3aed;
            --metric-soft: rgba(124, 58, 237, .12);
        }

        .metric-icon {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            background: var(--metric-soft);
            color: var(--metric-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex: 0 0 auto;
        }

        .metric-tile span,
        .metric-tile small {
            color: var(--admin-muted);
            display: block;
        }

        .metric-tile span {
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .metric-tile strong {
            display: block;
            font-size: 2rem;
            line-height: 1.1;
            margin: .2rem 0;
        }

        .dashboard-focus-card {
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
        }

        .dashboard-count-badge {
            background: #e0f2fe;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            color: #075985;
            font-size: .8rem;
            font-weight: 700;
            padding: .45rem .75rem;
            white-space: nowrap;
        }

        .dashboard-booking-list,
        .message-stack {
            display: grid;
            gap: .75rem;
        }

        .booking-row {
            background: #fff;
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            display: grid;
            grid-template-columns: auto minmax(150px, 1.4fr) minmax(120px, 1fr) auto auto;
            gap: .85rem;
            align-items: center;
            padding: .85rem;
        }

        .booking-avatar {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #ecfeff;
            color: #0f766e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .booking-main strong,
        .booking-main span {
            display: block;
        }

        .booking-main span,
        .booking-service {
            color: var(--admin-muted);
            font-size: .88rem;
        }

        .message-note {
            border: 1px solid var(--admin-line);
            border-left: 4px solid #0f766e;
            border-radius: 8px;
            padding: .9rem 1rem;
            background: #fff;
        }

        .message-note span {
            color: var(--admin-muted);
            display: block;
            font-size: .9rem;
            margin-top: .2rem;
        }

        .empty-dashboard-state {
            border: 1px dashed var(--admin-line);
            border-radius: 8px;
            color: var(--admin-muted);
            padding: 1.5rem;
            text-align: center;
        }

        .dashboard-shortcuts {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .shortcut-link {
            background: #fff;
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            color: var(--admin-ink);
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: 1rem;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .shortcut-link:hover {
            color: var(--admin-primary);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .08);
            transform: translateY(-2px);
        }

        .shortcut-link i {
            color: #0f766e;
            font-size: 1.25rem;
        }

        @media (max-width: 575.98px) {
            .admin-page {
                padding: 1rem;
            }
        }

        @media (max-width: 1199.98px) {
            .dashboard-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .dashboard-hero {
                grid-template-columns: 1fr;
                padding: 1.35rem;
            }

            .dashboard-hero-actions {
                justify-content: flex-start;
            }

            .booking-row {
                grid-template-columns: auto minmax(0, 1fr);
            }

            .booking-service,
            .booking-row .badge,
            .booking-row small {
                grid-column: 2;
            }

            .dashboard-shortcuts {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .dashboard-metrics {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="d-flex">
        @include('common.admin-panel.sidebar')

        <div class="content-wrapper w-100">
            <header class="admin-topbar py-3 px-4 d-flex align-items-center justify-content-between sticky-top">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggleBtn" type="button"><i class="bi bi-list"></i></button>
                    <div>
                        <div class="page-header-kicker">Securex Admin</div>
                        <h1 class="h5 mb-0">Dashboard</h1>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a class="btn btn-outline-secondary d-none d-md-inline-flex align-items-center gap-2" href="{{ route('home') }}"><i class="bi bi-globe"></i> View Site</a>
                    <a class="btn btn-primary d-inline-flex align-items-center gap-2" href="{{ route('viewServiceAddForm') }}"><i class="bi bi-plus-lg"></i> Add Service</a>
                </div>
            </header>

            <div class="admin-page">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
        const sidebarMenu = document.getElementById('sidebarMenu');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function openSidebar() {
            sidebarMenu.classList.add('show');
            sidebarBackdrop.classList.add('show');
        }

        function closeSidebar() {
            sidebarMenu.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
        }

        if (sidebarToggleBtn && sidebarCloseBtn && sidebarMenu && sidebarBackdrop) {
            sidebarToggleBtn.addEventListener('click', openSidebar);
            sidebarCloseBtn.addEventListener('click', closeSidebar);
            sidebarBackdrop.addEventListener('click', closeSidebar);
        }
    </script>
</body>

</html>
