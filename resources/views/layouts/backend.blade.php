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

    <title>@yield('title') - {{ getSetting('web_name') }}</title>

    <link rel="shortcut icon" href="{{ berkas( getSetting('favicon')) }}">

    <!-- vendor css -->
    <link href="{{ callassetspath('backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/jquery-switchbutton/jquery.switchButton.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/jquery-toggles/toggles-full.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/jt.timepicker/jquery.timepicker.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/bootstrap-datetimepicker/css/tempusdominus-bootstrap-4.min.css') }}"
          rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/nestable/jquery.nestable.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{callassetspath('backend/lib/summernote/summernote-bs4.min.css')}}">
    <link href="{{ callassetspath('backend/lib/fancybox/jquery.fancybox.css') }}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ callassetspath('backend/css/bracket.css') }}">

    @stack('styles')

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div class="br-logo"><a href="{{ url('dashboard') }}"><img src="{{ berkas( getSetting('logo')) }}"
                                                           height="50"></a>
</div>

<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
    <ul class="br-sideleft-menu">
        <li class="br-menu-item">
            <a href="{{ url('/dashboard') }}" class="br-menu-link {{ activeMenu('') }}">
                <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
                <span class="menu-item-label">Dashboard</span>
            </a>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/pages') }}">
                <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
                <span class="menu-item-label">Pages</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/pages/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/pages/table') }}">All Pages</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/pages/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/pages/create') }}">Add Pages</a></li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/post') }}">
                <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
                <span class="menu-item-label">Post</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/post/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/post/table') }}">All Posts</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/post/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/post/create') }}">Add Posts</a></li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="#" class="{{ activeMenu('dashboard/post-category') }} br-menu-link with-sub">
                <i class="menu-item-icon icon ion-ios-list-outline tx-20"></i>
                <span class="menu-item-label">Post Category</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/post-category/table') }}"
                                        class="sub-link {{activeMenu('dashboard/post-category/table')}}">All Post
                        Category</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/post-category/create') }}"
                                        class="sub-link {{activeMenu('dashboard/post-category/create')}}">Add Post
                        Category</a></li>
            </ul>
        </li>
        
        @if(app()->environment('local', 'development') || env('APP_URL') == 'https://disparekraf.lampungprov.go.id' || config('app.url') == 'https://disparekraf.lampungprov.go.id')
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/post-destination') }} {{ activeMenu('dashboard/post-review') }}">
                <i class="menu-item-icon icon ion-ios-location-outline tx-20"></i>
                <span class="menu-item-label">TripAdvisor</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/post-destination/table') }}" class="sub-link {{ activeMenu('dashboard/post-destination/table') }}">Kelola Destinasi</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/post-accommodation/table') }}" class="sub-link {{ activeMenu('dashboard/post-accommodation/table') }}">Kelola Akomodasi</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/post-culinary/table') }}" class="sub-link {{ activeMenu('dashboard/post-culinary/table') }}">Kelola Kuliner</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/post-transport/table') }}" class="sub-link {{ activeMenu('dashboard/post-transport/table') }}">Kelola Transport</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/post-review/table') }}" class="sub-link {{ activeMenu('dashboard/post-review/table') }}">Kelola Ulasan</a></li>
            </ul>
        </li>
        @endif
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/agenda/table') }}">
                <i class="menu-item-icon icon ion-ios-calendar-outline tx-20"></i>
                <span class="menu-item-label">Agenda</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/agenda/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/agenda/table') }}">All Agenda</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/agenda/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/agenda/create') }}">Add Agenda</a></li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/download') }}">
                <i class="menu-item-icon icon ion-ios-download-outline tx-20"></i>
                <span class="menu-item-label">Download</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/download/table') }}"
                                        class="sub-link {{activeMenu('dashboard/download/table')}}">All Download</a>
                </li>
                <li class="sub-item"><a href="{{ url('/dashboard/download/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/download/create') }}">Add Download</a>
                </li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/download-category') }}">
                <i class="menu-item-icon icon ion-ios-list-outline tx-20"></i>
                <span class="menu-item-label">Download Category</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/download-category/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/download-category/table') }}">All
                        Download Category</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/download-category/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/download-category/create') }}">Add
                        Download Category</a></li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/gallery') }}">
                <i class="menu-item-icon icon ion-images tx-20"></i>
                <span class="menu-item-label">Gallery</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/gallery/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/gallery/table') }}">All Gallery</a>
                </li>
                <li class="sub-item"><a href="{{ url('/dashboard/gallery/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/gallery/create') }}">Add Gallery</a>
                </li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/album') }}">
                <i class="menu-item-icon icon ion-ios-briefcase-outline tx-20"></i>
                <span class="menu-item-label">Album</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/album/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/album/table') }}">All Album</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/album/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/album/create') }}">Add Album</a></li>
            </ul>
        </li>

        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/video') }}">
                <i class="menu-item-icon icon ion-ios-play-outline tx-20"></i>
                <span class="menu-item-label">Video</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/video/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/video/table') }}">All Video</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/video/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/video/create') }}">Add Video</a></li>
            </ul>
        </li>
        <li class="br-menu-item">
            <a href="{{ url('/dashboard/contact/table') }}" class="br-menu-link {{ activeMenu('dashboard/contact') }}">
                <i class="menu-item-icon icon ion-ios-email-outline tx-20"></i>
                <span class="menu-item-label">Contact</span>
            </a>
        </li>
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/menu') }}">
                <i class="menu-item-icon icon ion-grid tx-20"></i>
                <span class="menu-item-label">Menu</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/menu/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/menu/table') }}">All Menu</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/menu/create') }}"
                                        class="sub-link {{ activeMenu('dashboard/menu/create') }}">Add Menu</a></li>
            </ul>
        </li>
        @if ((Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) && (app()->environment('local', 'development') || request()->getHost() == 'dinsos.lampungprov.go.id'))
        <li class="br-menu-item">
            <a href="{{ url('/dashboard/pendaftar-sosial/table') }}" class="br-menu-link {{ activeMenu('dashboard/pendaftar-sosial') }}">
                <i class="menu-item-icon icon ion-ios-people-outline tx-20"></i>
                <span class="menu-item-label">Pendaftar Sosial</span>
            </a>
        </li>
        @endif
        @if ((Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) && (app()->environment('local', 'development') || request()->getHost() == 'dishub.lampungprov.go.id'))
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/dishub') }}">
                <i class="menu-item-icon icon ion-ios-navigate-outline tx-20"></i>
                <span class="menu-item-label">Dishub Lampung</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/dishub/jadwal-penerbangan/table') }}" class="sub-link {{ activeMenu('dashboard/dishub/jadwal-penerbangan') }}">Jadwal Penerbangan</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/dishub/terminal/table') }}" class="sub-link {{ activeMenu('dashboard/dishub/terminal') }}">Lokasi Terminal</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/dishub/trayek-akdp/table') }}" class="sub-link {{ activeMenu('dashboard/dishub/trayek-akdp') }}">Trayek AKDP</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/dishub/tarif-tol/table') }}" class="sub-link {{ activeMenu('dashboard/dishub/tarif-tol') }}">Tarif Tol</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/dishub/catatan/table') }}" class="sub-link {{ activeMenu('dashboard/dishub/catatan') }}">Catatan Dataset</a></li>
            </ul>
        </li>
        @endif
        <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub {{ activeMenu('dashboard/slider') }}">
                <i class="menu-item-icon icon ion-ios-filing-outline tx-20"></i>
                <span class="menu-item-label">Components</span>
            </a>
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{ url('/dashboard/slider/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/slider/table') }}">Slider</a></li>
                <li class="sub-item"><a href="{{ url('/dashboard/pegawai/table') }}"
                                        class="sub-link {{ activeMenu('dashboard/slider/create') }}">Pegawai</a></li>
            </ul>
        </li>
        @if (Auth::user()->hasRole('superadmin'))
            <li class="br-menu-item">
                <a href="{{ url('/dashboard/theme/table') }}"
                   class="br-menu-link {{ activeMenu('dashboard/theme/table') }}">
                    <i class="menu-item-icon icon ion-ios-color-filter-outline tx-20"></i>
                    <span class="menu-item-label">Theme</span>
                </a>
            </li>
        @endif

        @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
            <li class="br-menu-item">
                <a href="{{ url('/dashboard/settings/table') }}"
                   class="br-menu-link {{ activeMenu('dashboard/settings/table') }}">
                    <i class="menu-item-icon icon ion-ios-gear-outline tx-20"></i>
                    <span class="menu-item-label">Settings</span>
                </a>
            </li>
        @endif
        <li class="br-menu-item">
            <a href="#"
               class="br-menu-link with-sub {{ activeMenu('dashboard/users') || activeMenu('dashboard/roles') || activeMenu('dashboard/permissions') || activeMenu('dashboard/activitylogs') }}">
                <i class="menu-item-icon icon ion-ios-contact-outline tx-20"></i>
                <span class="menu-item-label">Users</span>
            </a>
            <ul class="br-menu-sub">
                @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                    <li class="sub-item"><a href="{{ url('/dashboard/users/table') }}" class="sub-link">All Users</a>
                    </li>
                    <li class="sub-item"><a href="{{ url('/dashboard/users/create') }}" class="sub-link">Add Users</a>
                    </li>
                    @if (Auth::user()->hasRole('superadmin'))
                        <li class="sub-item"><a href="{{ url('/dashboard/roles/table') }}" class="sub-link">Roles</a>
                        </li>
                        <li class="sub-item"><a href="{{ url('/dashboard/permissions/table') }}" class="sub-link">Permissions</a>
                        </li>
                        <li class="sub-item"><a href="{{ url('/dashboard/activitylogs/table') }}" class="sub-link">User
                                Logs</a></li>
                    @endif
                @else
                    <li class="sub-item"><a
                            href="{{ url('/dashboard/users/'.Hashids::encode(Auth::user()->id).'/edit') }}"
                            class="sub-link">Update Account</a></li>
                @endif
            </ul>
        </li>
    </ul>
    <br/>
</div>

<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a>
        </div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a>
        </div>
    </div>
    <div class="br-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
                    @if (Auth::user()->picture == '')
                        <img src="{{ callassetspath('backend/images/avatar.jpg') }}" class="wd-32 rounded-circle" alt="">
                    @else
                        <img src="{{ berkas( Auth::user()->picture) }}"
                             class="wd-32 rounded-circle" alt="">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-250">
                    <div class="tx-center">
                        <a href="#">
                            @if (Auth::user()->picture == '')
                                <img src="{{ callassetspath('backend/images/avatar.jpg') }}" class="wd-80 rounded-circle"
                                     alt="">
                            @else
                                <img src="{{ berkas( Auth::user()->picture) }}"
                                     class="wd-80 rounded-circle" alt="">
                            @endif
                        </a>
                        <h6 class="logged-fullname">{{ Auth::user()->name }}</h6>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                    <hr/>
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{ url('/') }}" target="_blank"><i class="icon ion-ios-home"></i> View Web</a></li>
                        <li><a href="{{ url('/dashboard/users/'.Hashids::encode(Auth::user()->id).'/edit') }}"><i
                                    class="icon ion-ios-person"></i> Edit Profile</a></li>
                        @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                            <li><a href="{{ url('/dashboard/settings') }}"><i class="icon ion-ios-gear"></i>
                                    Settings</a></li>
                        @endif
                        <li><a href="{{ url('/logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="icon ion-power"></i> Logout</a></li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="br-mainpanel">
    @if (Session::has('flash_message'))
        <div class="main-alert">
            <div class="alert alert-warning alert-solid alert-main">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div class="d-sm-flex align-items-center justify-content-start">
                    <i class="icon ion-ios-lightbulb-outline lh-0 tx-52"></i>
                    <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
                        <h5 class="mg-b-2 pd-t-2">Info!</h5>
                        <p class="mg-b-0 tx-xs op-8">{{ Session::get('flash_message') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @yield('content')

    <footer class="br-footer">
        <div class="footer-left">
            <div class="mg-b-2">Copyright &copy; {{ date('Y') }}. {{ getSetting('web_name') }}. All Rights Reserved.
            </div>
            <div>{{ getSetting('web_owner') }} For Website</div>
        </div>
        <div class="footer-right d-flex align-items-center">
            <span class="tx-uppercase mg-r-10">Social Media:</span>
            <a target="_blank" class="pd-x-5" href="{{ getSetting('facebook') }}"><i
                    class="fa fa-facebook tx-20"></i></a>
            <a target="_blank" class="pd-x-5" href="{{ getSetting('twitter') }}"><i class="fa fa-twitter tx-20"></i></a>
        </div>
    </footer>
</div>

<div id="alertalldel" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered bd-0" role="document">
        <div class="modal-content" style="width:36em;">
            <div class="modal-body pd-25 text-center">
                <div class="swal2-icon swal2-warning" style="display:flex;"><span class="swal2-icon-text">!</span></div>
                <h2 class="lh-4 tx-inverse" style="font-size:1.875em; color:#595959;">Are you sure?</h2>
                <p class="lh-4 tx-inverse" style="font-size:1.125em; color:#595959;">You will not be able to recover
                    this entry.</p>
                <div class="text-center modal-action-footer">
                    <button type="button" class="btn btn-danger btn-sm mg-r-10" id="confirmdel" autofocus>Yes</button>
                    <button type="button" class="btn btn-default btn-sm mg-l-10" data-dismiss="modal"
                            aria-hidden="true">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ callassetspath('backend/lib/jquery/jquery.js') }}"></script>
<script src="{{ callassetspath('backend/lib/popper.js/popper.js') }}"></script>
<script src="{{ callassetspath('backend/lib/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ callassetspath('backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
<script src="{{ callassetspath('backend/lib/moment/moment.min.js') }}"></script>
<script src="{{ callassetspath('backend/lib/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ callassetspath('backend/lib/jquery-switchbutton/jquery.switchButton.js') }}"></script>
<script src="{{ callassetspath('backend/lib/peity/jquery.peity.js') }}"></script>
<script src="{{ callassetspath('backend/lib/select2/js/select2.full.min.js') }}"></script>
<script src="{{ callassetspath('backend/lib/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ callassetspath('backend/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ callassetspath('backend/lib/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ callassetspath('backend/lib/jt.timepicker/jquery.timepicker.js') }}"></script>
<script src="{{ callassetspath('backend/lib/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ callassetspath('backend/lib/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ callassetspath('backend/lib/bootstrap-datetimepicker/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ callassetspath('backend/lib/nestable/jquery.nestable.js') }}"></script>
<script src="{{ callassetspath('backend/lib/fancybox/jquery.fancybox.js') }}"></script>

<script src="{{ callassetspath('backend/js/bracket.js') }}"></script>
<script src="{{ callassetspath('backend/js/deleter.js') }}"></script>

<script>
    $(function () {
        'use strict';

        $(window).resize(function () {
            minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
            if (window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
                $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
                $('body').addClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideUp();
            } else if (window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
                $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
                $('body').removeClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideDown();
            }
        }
    });
</script>

@stack('scripts')
</body>
</html>
