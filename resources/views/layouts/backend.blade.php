<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ getSetting('web_description') }}">
    <meta name="author" content="{{ getSetting('web_owner') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ getSetting('web_name') }}</title>

    <link rel="shortcut icon" href="{{ berkas(getSetting('favicon')) ?: asset('assets/images/logo_lampung.png') }}">

    <!-- Google Fonts & Font Awesome 6 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ callassetspath('backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">

    <!-- Vendor Stylesheets needed for Datatables & Form plugins -->
    <link href="{{ callassetspath('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ callassetspath('backend/lib/summernote/summernote-bs4.min.css') }}">
    <link href="{{ callassetspath('backend/lib/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/nestable/jquery.nestable.css') }}" rel="stylesheet">

    <!-- Tailwind CSS CDN with Custom Theme Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            800: '#0B2545',
                            900: '#061D38',
                            950: '#031024',
                        },
                        bappeda: {
                            blue: '#1A56DB',
                            gold: '#F59E0B',
                            hover: '#1E40AF',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Modern Admin Clean Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ==========================================================================
           BAPPEDA ADMIN MODERN THEME OVERRIDES (BULLETPROOF & PROPORTIONAL)
           ========================================================================== */

        /* 1. Modal Reset - MUST be fixed, centered, and hidden by default */
        .modal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 99999 !important;
            display: none;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            outline: 0 !important;
            background-color: rgba(15, 23, 42, 0.65) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
        }
        .modal.show, .modal.in, .modal[style*="display: flex"], .modal[style*="display: block"] {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .modal-dialog {
            position: relative !important;
            width: 100% !important;
            max-width: 460px !important;
            margin: 1.5rem !important;
            pointer-events: auto !important;
        }
        .modal-content {
            background-color: #FFFFFF !important;
            border-radius: 1.25rem !important;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            overflow: hidden !important;
        }

        /* 2. Card Section Wrapper (.br-section-wrapper) */
        .br-section-wrapper {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1.25rem !important;
            padding: 1.5rem !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04) !important;
            margin-bottom: 1.5rem !important;
            overflow: hidden !important;
        }
        @media (max-width: 640px) {
            .br-section-wrapper {
                padding: 1rem !important;
                border-radius: 1rem !important;
            }
        }

        /* 3. Card Options & Action Buttons */
        .card-options {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            margin-bottom: 1.25rem !important;
        }
        .btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.45rem !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 700 !important;
            font-size: 0.8125rem !important;
            line-height: 1.25 !important;
            border-radius: 0.75rem !important;
            padding: 0.55rem 1.15rem !important;
            transition: all 0.15s ease-in-out !important;
            text-decoration: none !important;
            border: 1px solid transparent !important;
            cursor: pointer !important;
            box-sizing: border-box !important;
        }
        .btn-sm {
            padding: 0.45rem 0.9rem !important;
            font-size: 0.75rem !important;
            border-radius: 0.625rem !important;
        }
        .btn-xs {
            padding: 0.25rem 0.55rem !important;
            font-size: 0.7rem !important;
            border-radius: 0.5rem !important;
        }
        .btn-success {
            background-color: #10B981 !important;
            color: #FFFFFF !important;
            box-shadow: 0 2px 4px 0 rgba(16, 185, 129, 0.25) !important;
        }
        .btn-success:hover {
            background-color: #059669 !important;
            transform: translateY(-1px) !important;
            color: #FFFFFF !important;
        }
        .btn-danger {
            background-color: #EF4444 !important;
            color: #FFFFFF !important;
            box-shadow: 0 2px 4px 0 rgba(239, 68, 68, 0.25) !important;
        }
        .btn-danger:hover {
            background-color: #DC2626 !important;
            transform: translateY(-1px) !important;
            color: #FFFFFF !important;
        }
        .btn-primary {
            background-color: #1A56DB !important;
            color: #FFFFFF !important;
            box-shadow: 0 2px 4px 0 rgba(26, 86, 219, 0.25) !important;
        }
        .btn-primary:hover {
            background-color: #1E40AF !important;
            transform: translateY(-1px) !important;
            color: #FFFFFF !important;
        }
        .btn-secondary, .btn-default {
            background-color: #F8FAFC !important;
            color: #475569 !important;
            border: 1px solid #CBD5E1 !important;
        }
        .btn-secondary:hover, .btn-default:hover {
            background-color: #F1F5F9 !important;
            color: #1E293B !important;
        }
        .btn-info {
            background-color: #0EA5E9 !important;
            color: #FFFFFF !important;
        }
        .btn-warning {
            background-color: #F59E0B !important;
            color: #FFFFFF !important;
        }

        /* 4. DataTables Full Modern Wrapper */
        .table-wrapper {
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 1rem !important;
            margin-bottom: 1rem !important;
            background: #FFFFFF !important;
        }
        .dataTables_wrapper {
            font-family: 'Poppins', sans-serif !important;
            font-size: 0.8125rem !important;
            color: #334155 !important;
            width: 100% !important;
        }
        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-bottom: 1rem !important;
        }
        .dataTables_wrapper .dataTables_length label {
            font-size: 0.75rem !important;
            color: #64748B !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #CBD5E1 !important;
            border-radius: 0.625rem !important;
            padding: 0.4rem 1.75rem 0.4rem 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #1E293B !important;
            background-color: #F8FAFC !important;
            outline: none !important;
            cursor: pointer !important;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            margin-bottom: 1rem !important;
        }
        .dataTables_wrapper .dataTables_filter label {
            font-size: 0.75rem !important;
            color: #64748B !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #CBD5E1 !important;
            border-radius: 0.625rem !important;
            padding: 0.45rem 0.875rem !important;
            font-size: 0.75rem !important;
            color: #1E293B !important;
            background-color: #FFFFFF !important;
            outline: none !important;
            transition: all 0.15s ease !important;
            min-width: 160px !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1A56DB !important;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15) !important;
        }
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none !important;
                width: 100% !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }
            .dataTables_wrapper .dataTables_filter {
                margin-top: 0.5rem !important;
            }
            .dataTables_wrapper .dataTables_filter input {
                width: 100% !important;
            }
        }

        /* 5. DataTables Table Grid */
        table.dataTable {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin: 0 !important;
            clear: both !important;
        }
        table.dataTable thead th {
            background-color: #F8FAFC !important;
            color: #0B2545 !important;
            font-weight: 800 !important;
            font-size: 0.7rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 0.875rem 1rem !important;
            border-top: none !important;
            border-bottom: 2px solid #E2E8F0 !important;
            vertical-align: middle !important;
            white-space: nowrap !important;
        }
        table.dataTable tbody td {
            padding: 0.875rem 1rem !important;
            color: #334155 !important;
            font-size: 0.8125rem !important;
            border-bottom: 1px solid #F1F5F9 !important;
            vertical-align: middle !important;
        }
        table.dataTable tbody tr:hover td {
            background-color: #F8FAFC !important;
        }
        table.dataTable tfoot td {
            padding: 0.875rem 1rem !important;
            background-color: #FAFAFA !important;
            border-top: 1px solid #E2E8F0 !important;
            vertical-align: middle !important;
        }

        /* Table Action Icons */
        table.dataTable td a, 
        table.dataTable td button {
            color: #64748B;
            font-size: 0.875rem;
            padding: 0.35rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
        }
        table.dataTable td a:hover, 
        table.dataTable td button:hover {
            color: #1A56DB;
            background-color: #EFF6FF;
        }
        table.dataTable td a[data-delete]:hover,
        table.dataTable td a.btn-danger:hover {
            color: #EF4444 !important;
            background-color: #FEF2F2 !important;
        }

        /* 6. DataTables Info & Pagination */
        .dataTables_wrapper .dataTables_info {
            float: left !important;
            font-size: 0.75rem !important;
            color: #64748B !important;
            font-weight: 600 !important;
            padding-top: 1rem !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right !important;
            padding-top: 0.75rem !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.25rem !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.35rem 0.75rem !important;
            border-radius: 0.5rem !important;
            border: 1px solid #E2E8F0 !important;
            background: #FFFFFF !important;
            color: #475569 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #EFF6FF !important;
            color: #1A56DB !important;
            border-color: #BFDBFE !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #1A56DB !important;
            color: #FFFFFF !important;
            border-color: #1A56DB !important;
            font-weight: 800 !important;
            box-shadow: 0 1px 2px 0 rgba(26, 86, 219, 0.3) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            background: #F8FAFC !important;
            border-color: #E2E8F0 !important;
            color: #94A3B8 !important;
        }
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                float: none !important;
                width: 100% !important;
                text-align: center !important;
                justify-content: center !important;
            }
        }

        /* 7. Forms, Labels, Select2 & Inputs */
        .form-control, input[type="text"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
            width: 100% !important;
            background-color: #FFFFFF !important;
            border: 1px solid #CBD5E1 !important;
            border-radius: 0.75rem !important;
            padding: 0.625rem 0.875rem !important;
            font-size: 0.8125rem !important;
            font-family: 'Poppins', sans-serif !important;
            color: #1E293B !important;
            outline: none !important;
            transition: all 0.15s ease-in-out !important;
            box-sizing: border-box !important;
        }
        .form-control:focus, input:focus, select:focus, textarea:focus {
            border-color: #1A56DB !important;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15) !important;
        }
        .control-label, label {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #334155 !important;
            margin-bottom: 0.35rem !important;
            display: block !important;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            border: 1px solid #CBD5E1 !important;
            border-radius: 0.75rem !important;
            height: 42px !important;
            padding: 6px 12px !important;
            background-color: #FFFFFF !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1E293B !important;
            font-size: 0.8125rem !important;
            line-height: 28px !important;
            padding-left: 0 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        /* 8. Breadcrumb & Pageheader Modern Styling */
        .br-pageheader {
            display: flex !important;
            align-items: center !important;
            margin-bottom: 0.5rem !important;
        }
        .br-pageheader .breadcrumb {
            display: flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #64748B !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }
        .br-pageheader .breadcrumb-item + .breadcrumb-item::before {
            content: "/" !important;
            padding-right: 0.5rem !important;
            color: #CBD5E1 !important;
        }
        .br-pageheader .breadcrumb-item a {
            color: #1A56DB !important;
            text-decoration: none !important;
        }
        .br-pageheader .breadcrumb-item.active {
            color: #94A3B8 !important;
        }
        .br-pagetitle {
            display: flex !important;
            align-items: center !important;
            gap: 0.875rem !important;
            margin-bottom: 1.25rem !important;
        }
        .br-pagetitle i {
            width: 40px !important;
            height: 40px !important;
            border-radius: 0.75rem !important;
            background-color: #EFF6FF !important;
            color: #1A56DB !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 1.25rem !important;
            flex-shrink: 0 !important;
        }
        .br-pagetitle h4 {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #0F172A !important;
            margin: 0 !important;
            line-height: 1.2 !important;
        }
        .br-pagetitle p {
            font-size: 0.75rem !important;
            color: #64748B !important;
            margin: 0 !important;
        }

        /* ==========================================================================
           MODERN NESTABLE MENU MANAGER HIERARCHY STYLING (CLEAR TREE STRUCTURE)
           ========================================================================== */
        .dd {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            width: 100%;
            list-style: none;
            font-size: 13px;
            line-height: 20px;
        }
        .dd-list {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        /* Nested Submenu Indentation with Distinct Tree Line */
        .dd-list .dd-list {
            padding-left: 36px !important;
            margin-top: 8px !important;
            margin-bottom: 8px !important;
            border-left: 2px dashed #93C5FD !important; /* Soft blue dashed guide line */
            margin-left: 18px !important;
        }
        @media (max-width: 640px) {
            .dd-list .dd-list {
                padding-left: 18px !important;
                margin-left: 10px !important;
            }
        }
        .dd-item,
        .dd-empty,
        .dd-placeholder {
            display: block;
            position: relative;
            margin: 8px 0;
            padding: 0;
            min-height: 48px;
            font-size: 13px;
        }
        /* Drag Placeholder */
        .dd-placeholder,
        .dd-empty {
            margin: 8px 0 !important;
            padding: 0 !important;
            min-height: 48px !important;
            background: #EFF6FF !important;
            border: 2px dashed #3B82F6 !important;
            border-radius: 14px !important;
            box-sizing: border-box !important;
        }
        /* Collapse / Expand Buttons */
        .dd-item > button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: absolute !important;
            left: 48px !important;
            top: 12px !important;
            cursor: pointer !important;
            width: 24px !important;
            height: 24px !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #EFF6FF !important;
            color: #1A56DB !important;
            border: 1px solid #BFDBFE !important;
            border-radius: 8px !important;
            font-size: 15px !important;
            font-weight: 800 !important;
            line-height: 1 !important;
            z-index: 10 !important;
            transition: all 0.15s ease !important;
        }
        .dd-item > button:hover {
            background: #1A56DB !important;
            color: #FFFFFF !important;
        }
        .dd-item > button[data-action="collapse"]:before {
            content: '−' !important;
            display: block !important;
        }
        .dd-item > button[data-action="expand"]:before {
            content: '+' !important;
            display: block !important;
        }

        /* Modern Menu Item Card (.dd3-content) */
        .dd3-content {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            min-height: 50px !important;
            margin: 6px 0 !important;
            padding: 8px 14px 8px 50px !important;
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 14px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03) !important;
            transition: all 0.15s ease-in-out !important;
            position: relative !important;
            box-sizing: border-box !important;
            font-family: 'Poppins', sans-serif !important;
        }
        .dd-item.has-children > .dd3-content {
            padding-left: 80px !important;
        }
        .dd3-content:hover {
            border-color: #BFDBFE !important;
            box-shadow: 0 4px 10px -2px rgba(26, 86, 219, 0.08) !important;
            background: #F8FAFC !important;
        }

        /* Modern Drag Grip Handle (.dd3-handle) */
        .dd3-handle {
            position: absolute !important;
            margin: 0 !important;
            left: 0 !important;
            top: 0 !important;
            bottom: 0 !important;
            cursor: grab !important;
            width: 42px !important;
            background: #F8FAFC !important;
            border-right: 1px solid #E2E8F0 !important;
            border-top-left-radius: 14px !important;
            border-bottom-left-radius: 14px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #94A3B8 !important;
            transition: all 0.15s ease !important;
        }
        .dd3-handle:hover {
            background: #EFF6FF !important;
            color: #1A56DB !important;
        }
        .dd3-handle:before {
            content: "\f58e" !important;
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            font-size: 13px !important;
        }

        /* Pull-right buttons wrapper */
        .pull-right {
            float: right !important;
            margin-left: auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            flex-shrink: 0 !important;
        }
        .btn-xss {
            padding: 5px 9px !important;
            font-size: 11px !important;
            border-radius: 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            line-height: 1 !important;
        }
    </style>

    @stack('styles')

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="bg-[#F4F7FC] text-slate-800 font-sans antialiased flex h-screen overflow-hidden">

    <!-- ========================================================================
         1. SIDEBAR (Matching Mockup with Responsive Drawer)
         ======================================================================== -->
    <aside id="admin-sidebar" 
           class="w-64 bg-[#061D38] text-white flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out z-50 fixed inset-y-0 left-0 lg:static lg:translate-x-0 -translate-x-full shadow-2xl lg:shadow-none"
           style="background-image: url('{{ asset('assets/images/footer_skyline_lampung.png') }}'); background-repeat: no-repeat; background-position: bottom left; background-size: 100% auto;">
        
        <!-- Dark gradient overlay over the background image -->
        <div class="absolute inset-0 bg-[#061D38]/90 pointer-events-none"></div>

        <!-- Sidebar Header (Brand Logo) -->
        <div class="relative z-10 h-16 sm:h-20 flex items-center gap-3 px-5 border-b border-white/10 flex-shrink-0">
            <img src="{{ berkas(getSetting('logo')) ?: asset('assets/images/logo_lampung.png') }}" 
                 alt="Logo Bappeda" 
                 onerror="this.onerror=null;this.src='{{ asset('assets/images/logo_lampung.png') }}'"
                 class="h-9 sm:h-10 w-auto object-contain drop-shadow">
            <div class="leading-tight">
                <div class="text-white font-black text-sm tracking-wider uppercase">BAPPEDA</div>
                <div class="text-blue-200/90 font-extrabold text-[10px] tracking-wider uppercase">PROVINSI LAMPUNG</div>
            </div>
            <!-- Mobile Close Button -->
            <button type="button" id="btn-sidebar-close" class="lg:hidden ml-auto text-white/70 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="relative z-10 flex-1 overflow-y-auto px-3.5 py-4 space-y-1.5 text-xs font-medium">
            
            <!-- 1. Dashboard -->
            @php $isDashActive = Request::is('dashboard') && !Request::is('dashboard/*'); @endphp
            <a href="{{ url('/dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ $isDashActive ? 'bg-[#1A56DB] text-white font-bold shadow-md shadow-blue-900/40' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i class="fas fa-house-chimney text-sm w-4 text-center"></i>
                <span class="flex-1">Dashboard</span>
            </a>

            <!-- 2. Berita & Informasi -->
            @php $isPostActive = Request::is('dashboard/post*') || Request::is('dashboard/pages*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isPostActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-newspaper text-sm w-4 text-center"></i>
                        <span>Berita & Informasi</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isPostActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isPostActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/post/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/post/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Berita</a>
                    <a href="{{ url('/dashboard/post/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/post/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Berita</a>
                    <a href="{{ url('/dashboard/postcategory/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/postcategory*') ? 'text-white font-bold bg-white/10' : '' }}">Kategori Berita</a>
                    <a href="{{ url('/dashboard/tag/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/tag*') ? 'text-white font-bold bg-white/10' : '' }}">Tag Berita</a>
                    <a href="{{ url('/dashboard/pages/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/pages*') ? 'text-white font-bold bg-white/10' : '' }}">Halaman Statis</a>
                </div>
            </div>

            <!-- 3. Agenda Kegiatan -->
            @php $isAgendaActive = Request::is('dashboard/agenda*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isAgendaActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="far fa-calendar-check text-sm w-4 text-center"></i>
                        <span>Agenda Kegiatan</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isAgendaActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isAgendaActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/agenda/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/agenda/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Agenda</a>
                    <a href="{{ url('/dashboard/agenda/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/agenda/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Agenda</a>
                </div>
            </div>

            <!-- 4. Dokumen Publik -->
            @php $isDocActive = Request::is('dashboard/download*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isDocActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-folder-open text-sm w-4 text-center"></i>
                        <span>Dokumen Publik</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isDocActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isDocActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/download/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/download/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Dokumen</a>
                    <a href="{{ url('/dashboard/download/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/download/create') ? 'text-white font-bold bg-white/10' : '' }}">Unggah Dokumen</a>
                    <a href="{{ url('/dashboard/downloadcategory/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/downloadcategory*') ? 'text-white font-bold bg-white/10' : '' }}">Kategori Dokumen</a>
                </div>
            </div>

            <!-- 5. Galeri & Media -->
            @php $isMediaActive = Request::is('dashboard/gallery*') || Request::is('dashboard/album*') || Request::is('dashboard/video*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isMediaActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-images text-sm w-4 text-center"></i>
                        <span>Galeri & Media</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isMediaActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isMediaActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/gallery/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/gallery*') ? 'text-white font-bold bg-white/10' : '' }}">Foto Galeri</a>
                    <a href="{{ url('/dashboard/album/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/album*') ? 'text-white font-bold bg-white/10' : '' }}">Album Foto</a>
                    <a href="{{ url('/dashboard/video/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/video*') ? 'text-white font-bold bg-white/10' : '' }}">Video Kegiatan</a>
                </div>
            </div>

            <!-- 6. Layanan PPID -->
            @php $isPpidActive = Request::is('dashboard/permohonan-informasi*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isPpidActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-shield-halved text-sm w-4 text-center"></i>
                        <span>Layanan PPID</span>
                    </div>
                    @php $pendingPpid = \App\Models\PermohonanInformasi::where('status', 'pending')->count(); @endphp
                    <div class="flex items-center gap-1.5 ml-auto">
                        @if($pendingPpid > 0)
                            <span class="px-1.5 py-0.5 rounded-full bg-amber-500 text-slate-950 font-black text-[9px]">{{ $pendingPpid }}</span>
                        @endif
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isPpidActive ? 'rotate-180' : '' }}"></i>
                    </div>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isPpidActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/permohonan-informasi/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/permohonan-informasi*') ? 'text-white font-bold bg-white/10' : '' }}">
                        Permohonan Masuk
                        @if($pendingPpid > 0)
                            <span class="ml-1 text-amber-400 font-bold">({{ $pendingPpid }})</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- 7. Pengaturan Konten -->
            @php $isContentActive = Request::is('dashboard/slider*') || Request::is('dashboard/pegawai*') || Request::is('dashboard/linkterkait*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isContentActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-sliders text-sm w-4 text-center"></i>
                        <span>Pengaturan Konten</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isContentActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isContentActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/slider/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/slider*') ? 'text-white font-bold bg-white/10' : '' }}">Slider Banner</a>
                    <a href="{{ url('/dashboard/pegawai/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/pegawai*') ? 'text-white font-bold bg-white/10' : '' }}">Data Pejabat & Pegawai</a>
                    <a href="{{ url('/dashboard/linkterkait/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/linkterkait*') ? 'text-white font-bold bg-white/10' : '' }}">Link Terkait / Mitra Kerja</a>
                </div>
            </div>

            <!-- 8. Laporan & Menu -->
            @php $isReportActive = Request::is('dashboard/menu*') || Request::is('dashboard/activitylogs*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isReportActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-pie text-sm w-4 text-center"></i>
                        <span>Laporan & Menu</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isReportActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isReportActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/menu/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/menu*') ? 'text-white font-bold bg-white/10' : '' }}">Struktur Menu Website</a>
                    @if(Auth::check() && optional(Auth::user())->hasRole('superadmin'))
                        <a href="{{ url('/dashboard/activitylogs/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/activitylogs*') ? 'text-white font-bold bg-white/10' : '' }}">Log Aktivitas Pengguna</a>
                    @endif
                </div>
            </div>

            <!-- 9. Pengguna -->
            @php $isUserActive = Request::is('dashboard/users*') || Request::is('dashboard/roles*') || Request::is('dashboard/permissions*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isUserActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-users-gear text-sm w-4 text-center"></i>
                        <span>Pengguna</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isUserActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isUserActive ? '' : 'hidden' }}">
                    @if(Auth::check() && (optional(Auth::user())->hasRole('superadmin') || optional(Auth::user())->hasRole('admin')))
                        <a href="{{ url('/dashboard/users/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/users/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Pengguna</a>
                        <a href="{{ url('/dashboard/users/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/users/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Pengguna</a>
                        @if(optional(Auth::user())->hasRole('superadmin'))
                            <a href="{{ url('/dashboard/roles/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/roles*') ? 'text-white font-bold bg-white/10' : '' }}">Role & Hak Akses</a>
                            <a href="{{ url('/dashboard/permissions/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/permissions*') ? 'text-white font-bold bg-white/10' : '' }}">Izin (Permissions)</a>
                        @endif
                    @else
                        @if(Auth::check())
                            <a href="{{ url('/dashboard/users/'.Hashids::encode(Auth::user()->id).'/edit') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5">Edit Akun Saya</a>
                        @endif
                    @endif
                </div>
            </div>

            <!-- 10. Pengaturan Sistem -->
            @php $isSettingActive = Request::is('dashboard/settings*') || Request::is('dashboard/theme*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isSettingActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-gear text-sm w-4 text-center"></i>
                        <span>Pengaturan Sistem</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isSettingActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isSettingActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/settings') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/settings*') ? 'text-white font-bold bg-white/10' : '' }}">Pengaturan Umum (Logo & Kontak)</a>
                    @if(Auth::check() && optional(Auth::user())->hasRole('superadmin'))
                        <a href="{{ url('/dashboard/theme/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/theme*') ? 'text-white font-bold bg-white/10' : '' }}">Tema Tampilan</a>
                    @endif
                </div>
            </div>

        </nav>

        <!-- Sidebar Footer -->
        <div class="relative z-10 px-5 py-4 border-t border-white/10 text-[10px] text-slate-400">
            <div class="font-bold text-white/90">Bappeda Provinsi Lampung</div>
            <div>&copy; {{ date('Y') }}. All rights reserved.</div>
        </div>
    </aside>

    <!-- Mobile Sidebar Dark Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-40 hidden transition-opacity lg:hidden"></div>

    <!-- ========================================================================
         2. MAIN CONTENT AREA (Topbar + Page View)
         ======================================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- TOP NAVIGATION BAR (Matching Mockup & Fully Responsive) -->
        <header class="h-16 sm:h-20 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 flex-shrink-0 shadow-sm">
            
            <!-- Left: Toggle & Global Search Bar -->
            <div class="flex items-center gap-2 sm:gap-4 flex-1 max-w-xl">
                <!-- Hamburger Button (Mobile Drawer Toggle) -->
                <button type="button" id="btn-sidebar-toggle" class="p-2 -ml-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition focus:outline-none lg:hidden">
                    <i class="fas fa-bars text-lg"></i>
                </button>

                <!-- Search Input Bar with Ctrl+K badge -->
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" id="admin-search-input" 
                           placeholder="Cari berita, agenda, dokumen..." 
                           class="w-full pl-9 pr-3 sm:pr-14 py-2 sm:py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs text-slate-800 placeholder-slate-400 transition">
                    <span class="absolute inset-y-0 right-0 pr-2.5 hidden sm:flex items-center pointer-events-none">
                        <kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 bg-white border border-slate-200 rounded shadow-xs">Ctrl + K</kbd>
                    </span>
                </div>
            </div>

            <!-- Right: Notifications & User Profile -->
            <div class="flex items-center gap-2 sm:gap-4">
                
                <!-- Notification Bell -->
                <a href="{{ url('dashboard/permohonan-informasi/table') }}" class="relative p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition" title="Notifikasi Permohonan">
                    <i class="fas fa-bell text-base"></i>
                    @if($pendingPpid > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-rose-500 text-white font-bold text-[9px] flex items-center justify-center">
                            {{ $pendingPpid }}
                        </span>
                    @endif
                </a>

                <!-- User Profile Capsule with Dropdown -->
                <div class="relative">
                    <button type="button" id="btn-user-dropdown" class="flex items-center gap-2 p-1.5 rounded-full sm:rounded-xl hover:bg-slate-100 transition focus:outline-none">
                        @if(Auth::check() && Auth::user()->picture)
                            <img src="{{ berkas(Auth::user()->picture) }}" alt="{{ optional(Auth::user())->name }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border border-slate-200">
                        @else
                            <img src="{{ callassetspath('backend/images/avatar.jpg') }}" alt="User" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border border-slate-200">
                        @endif
                        <div class="hidden sm:block text-left leading-tight pr-1">
                            <div class="text-xs font-bold text-slate-800">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</div>
                            <div class="text-[10px] text-slate-500">
                                {{ Auth::check() ? (optional(Auth::user())->hasRole('superadmin') ? 'Super Administrator' : (optional(Auth::user())->hasRole('admin') ? 'Administrator' : 'Editor')) : 'Administrator' }}
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400 hidden sm:block"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 text-xs">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <div class="font-bold text-slate-900">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</div>
                            <div class="text-[11px] text-slate-500 truncate">{{ Auth::check() ? Auth::user()->email : 'admin@lampungprov.go.id' }}</div>
                        </div>
                        <div class="py-1">
                            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition text-decoration-none">
                                <i class="fas fa-globe text-blue-600 w-4"></i>
                                <span>Kunjungi Website</span>
                            </a>
                            <a href="{{ Auth::check() ? url('/dashboard/users/'.Hashids::encode(Auth::user()->id).'/edit') : '#' }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition text-decoration-none">
                                <i class="fas fa-user-pen text-indigo-600 w-4"></i>
                                <span>Edit Profil Saya</span>
                            </a>
                            <a href="{{ url('/dashboard/settings') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition text-decoration-none">
                                <i class="fas fa-sliders text-amber-600 w-4"></i>
                                <span>Pengaturan Website</span>
                            </a>
                        </div>
                        <div class="border-t border-slate-100 pt-1">
                            <a href="{{ url('/logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center gap-2.5 px-4 py-2 text-rose-600 hover:bg-rose-50 transition font-semibold text-decoration-none">
                                <i class="fas fa-arrow-right-from-bracket w-4"></i>
                                <span>Keluar (Logout)</span>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- FLASH NOTIFICATION ALERT -->
        @if (Session::has('flash_message'))
            <div class="px-4 sm:px-6 lg:px-8 pt-5">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2 font-medium">
                        <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                        <span>{{ Session::get('flash_message') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 p-1">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-3.5 sm:p-6 lg:p-8">
            @yield('content')
        </main>

    </div>

    <!-- ========================================================================
         3. DELETE CONFIRMATION MODAL (Fixed, Modern, Hidden by Default)
         ======================================================================== -->
    <div id="alertalldel" class="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none !important;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center p-6 sm:p-8">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4 shadow-sm">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-slate-800 mb-1">Konfirmasi Hapus Data</h3>
                    <p class="text-xs text-slate-500 mb-6 leading-relaxed max-w-xs mx-auto">
                        Apakah Anda yakin ingin menghapus data yang dipilih? Data yang telah dihapus tidak dapat dipulihkan kembali.
                    </p>
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" class="btn btn-secondary px-5 py-2.5 rounded-xl font-bold text-xs" data-dismiss="modal" onclick="closeDeleteModal()">
                            Batal
                        </button>
                        <button type="button" class="btn btn-danger px-5 py-2.5 rounded-xl font-bold text-xs" id="confirmdel">
                            Ya, Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Scripts -->
    <script src="{{ callassetspath('backend/lib/jquery/jquery.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/popper.js/popper.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/fancybox/jquery.fancybox.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/nestable/jquery.nestable.js') }}"></script>
    <script src="{{ callassetspath('backend/js/deleter.js') }}"></script>

    <!-- Custom Interactive UI Logic -->
    <script>
        $(function () {
            // Sidebar Submenu Collapsible Toggle
            $('.menu-toggle').click(function () {
                var submenu = $(this).next('.submenu');
                var chevron = $(this).find('.chevron-icon');
                submenu.toggleClass('hidden');
                chevron.toggleClass('rotate-180');
            });

            // Mobile Sidebar Toggle & Drawer
            $('#btn-sidebar-toggle').on('click', function (e) {
                e.stopPropagation();
                $('#admin-sidebar').removeClass('-translate-x-full');
                $('#sidebar-backdrop').removeClass('hidden');
            });

            $('#btn-sidebar-close, #sidebar-backdrop').on('click', function () {
                $('#admin-sidebar').addClass('-translate-x-full');
                $('#sidebar-backdrop').addClass('hidden');
            });

            // User Profile Dropdown Toggle
            $('#btn-user-dropdown').click(function (e) {
                e.stopPropagation();
                $('#user-dropdown-menu').toggleClass('hidden');
            });

            $(document).click(function () {
                $('#user-dropdown-menu').addClass('hidden');
            });

            // Keyboard shortcut Ctrl + K focus to search bar
            $(document).keydown(function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    $('#admin-search-input').focus();
                }
            });

            // Modal Handlers (Handles all modals reliably)
            var targetDeleteForm = null;

            $(document).on('click', '[data-target="#alertalldel"], [data-toggle="modal"][data-target="#alertalldel"]', function (e) {
                e.preventDefault();
                targetDeleteForm = $(this).closest('form');
                $('#alertalldel').fadeIn(150).css('display', 'flex');
            });

            $(document).on('click', '[data-toggle="modal"]', function (e) {
                var target = $(this).data('target');
                if (target && target !== '#alertalldel') {
                    e.preventDefault();
                    $(target).fadeIn(150).css('display', 'flex');
                }
            });

            window.closeDeleteModal = function () {
                $('#alertalldel').fadeOut(150);
            };

            $(document).on('click', '[data-dismiss="modal"], .modal .close', function (e) {
                e.preventDefault();
                $(this).closest('.modal').fadeOut(150);
            });

            $(document).on('click', '.modal', function (e) {
                if ($(e.target).hasClass('modal')) {
                    $(this).fadeOut(150);
                }
            });

            $('#confirmdel').on('click', function () {
                if (targetDeleteForm && targetDeleteForm.length) {
                    targetDeleteForm.submit();
                } else {
                    $('form[action*="deleteall"]').submit();
                }
            });
        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
