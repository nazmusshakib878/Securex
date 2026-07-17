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
            background: linear-gradient(180deg, #0f172a 0%, #172033 58%, #111827 100%);
            box-shadow: 16px 0 40px rgba(15, 23, 42, .12);
        }

        .sidebar-menu-label {
            color: rgba(255, 255, 255, .45);
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .12em;
            margin: 1rem 0 .55rem;
            text-transform: uppercase;
        }

        .sidebar-quick-card {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 8px;
            margin-bottom: 1.1rem;
            padding: .9rem;
        }

        .sidebar-quick-card span,
        .sidebar-quick-card strong {
            display: block;
        }

        .sidebar-quick-card span {
            color: #7dd3fc;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .08em;
            margin-bottom: .25rem;
            text-transform: uppercase;
        }

        .sidebar-quick-card strong {
            color: #fff;
            font-size: .92rem;
        }

        .admin-sidebar-nav {
            gap: .3rem;
        }

        #sidebarMenu .nav-link {
            color: rgba(255, 255, 255, .76);
            border: 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: .7rem;
            margin-bottom: 0;
            min-height: 46px;
            padding: .55rem .65rem;
            position: relative;
            transition: all .2s ease;
        }

        #sidebarMenu .nav-link.active,
        #sidebarMenu .nav-link:hover {
            color: #fff;
            background: rgba(125, 211, 252, .1);
            transform: translateX(2px);
        }

        #sidebarMenu .nav-link.active {
            background: linear-gradient(90deg, rgba(14, 165, 233, .22), rgba(255, 255, 255, .08));
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(125, 211, 252, .18);
        }

        #sidebarMenu .nav-link.active::before {
            content: "";
            position: absolute;
            inset: .55rem auto .55rem 0;
            width: 3px;
            border-radius: 0 999px 999px 0;
            background: #38bdf8;
        }

        #sidebarMenu .nav-index {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: rgba(15, 23, 42, .5);
            color: rgba(255, 255, 255, .58);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .02em;
        }

        #sidebarMenu .nav-link.active .nav-index {
            background: #38bdf8;
            color: #082f49;
        }

        #sidebarMenu .nav-link-logout {
            margin-top: .6rem;
            color: #fecaca;
        }

        #sidebarMenu .nav-link-logout .nav-index {
            background: rgba(248, 113, 113, .14);
            color: #fecaca;
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

        .booking-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            align-items: center;
        }

        .booking-actions .action-form {
            display: inline-flex;
            min-width: 0;
        }

        .booking-actions .btn {
            white-space: nowrap;
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

        .ops-dashboard {
            max-width: 1220px;
        }

        .ops-titlebar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .ops-title-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: .65rem;
        }

        .ops-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 1.25rem;
            align-items: start;
        }

        .ops-main,
        .ops-side {
            display: grid;
            gap: 1.25rem;
        }

        .ops-summary {
            background: #102a43;
            border-radius: 8px;
            color: #fff;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: end;
            padding: 1.5rem;
            box-shadow: 0 18px 38px rgba(16, 42, 67, .18);
        }

        .ops-summary-copy span {
            color: #7dd3fc;
            display: block;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .08em;
            margin-bottom: .5rem;
            text-transform: uppercase;
        }

        .ops-summary-copy h3 {
            font-size: 1.6rem;
            margin-bottom: .45rem;
        }

        .ops-summary-copy p {
            color: rgba(255, 255, 255, .72);
            margin-bottom: 0;
            max-width: 620px;
        }

        .ops-summary-actions {
            display: flex;
            gap: .6rem;
        }

        .ops-summary-actions a {
            border: 1px solid rgba(255, 255, 255, .26);
            border-radius: 8px;
            color: #fff;
            font-size: .9rem;
            font-weight: 700;
            padding: .65rem .85rem;
            text-decoration: none;
            white-space: nowrap;
        }

        .ops-section-card,
        .ops-stat-panel,
        .ops-shortcuts {
            background: #fff;
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            box-shadow: 0 14px 32px rgba(15, 23, 42, .05);
        }

        .ops-section-card {
            padding: 1rem;
        }

        .ops-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .ops-section-head span,
        .ops-section-head a {
            color: var(--admin-primary);
            font-size: .85rem;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .ops-table {
            display: grid;
            gap: .65rem;
        }

        .ops-table-row {
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            display: grid;
            grid-template-columns: minmax(220px, 1.3fr) minmax(120px, .8fr) auto minmax(90px, auto);
            gap: .85rem;
            align-items: center;
            padding: .85rem;
        }

        .ops-person {
            display: flex;
            align-items: center;
            gap: .75rem;
            min-width: 0;
        }

        .ops-avatar {
            background: #dbeafe;
            border-radius: 8px;
            color: #1d4ed8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            font-weight: 800;
            height: 40px;
            width: 40px;
        }

        .ops-person strong,
        .ops-person small,
        .ops-message strong,
        .ops-message span {
            display: block;
        }

        .ops-person small,
        .ops-service,
        .ops-message span {
            color: var(--admin-muted);
            font-size: .88rem;
        }

        .ops-stat-panel {
            display: grid;
            gap: .2rem;
            padding: .8rem;
        }

        .ops-stat-item {
            border-bottom: 1px solid var(--admin-line);
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: .35rem .85rem;
            align-items: center;
            padding: .85rem .4rem;
        }

        .ops-stat-item:last-child {
            border-bottom: 0;
        }

        .ops-stat-item span {
            color: var(--admin-muted);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .ops-stat-item strong {
            font-size: 2rem;
            line-height: 1;
        }

        .ops-stat-item i {
            background: #f1f5f9;
            border-radius: 8px;
            color: #0f766e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            grid-row: span 2;
            height: 42px;
            width: 42px;
        }

        .ops-message-list {
            display: grid;
            gap: .65rem;
        }

        .ops-message {
            background: #f8fafc;
            border-left: 3px solid #0f766e;
            border-radius: 8px;
            padding: .8rem .9rem;
        }

        .ops-shortcuts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .7rem;
            padding: .8rem;
        }

        .ops-shortcuts a {
            align-items: center;
            background: #f8fafc;
            border-radius: 8px;
            color: var(--admin-ink);
            display: flex;
            gap: .55rem;
            justify-content: center;
            padding: .8rem;
            text-decoration: none;
        }

        .ops-shortcuts a:hover {
            color: var(--admin-primary);
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

            .ops-layout {
                grid-template-columns: 1fr;
            }

            .ops-side {
                grid-template-columns: minmax(0, .95fr) minmax(0, 1fr);
                align-items: start;
            }
        }

        @media (max-width: 767.98px) {
            .ops-titlebar,
            .ops-summary {
                grid-template-columns: 1fr;
            }

            .ops-titlebar {
                align-items: flex-start;
                flex-direction: column;
            }

            .ops-title-actions,
            .ops-summary-actions {
                justify-content: flex-start;
            }

            .ops-side {
                grid-template-columns: 1fr;
            }

            .ops-table-row {
                grid-template-columns: 1fr;
            }

            .ops-service,
            .ops-table-row .badge,
            .ops-table-row small {
                text-align: left !important;
            }

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
