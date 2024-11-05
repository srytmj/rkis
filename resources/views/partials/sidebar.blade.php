   
    {{-- <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End --> --}}

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menu-light ">
        <div class="navbar-wrapper  ">
            <div class="navbar-content scroll-div ">

                <div class="">
                    <div class="main-menu-header">
                        <img class="img-radius" src="{{ asset('assets/images/user/avatar-2.jpg') }}"
                            alt="User-Profile-Image">

                        <div class="user-details">
                            {{-- <div id="more-details">{{ $users->name }}<i class="fa fa-caret-down"></i></div> --}}
                            <div id="more-details">Admin<i class="fa fa-caret-down"></i></div>
                        </div>
                    </div>
                    <div class="collapse" id="nav-user-link">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="user-profile.html" data-toggle="tooltip"
                                    title="View Profile"><i class="feather icon-user"></i></a></li>
                            <li class="list-inline-item"><a href="email_inbox.html"><i class="feather icon-mail"
                                        data-toggle="tooltip" title="Messages"></i><small
                                        class="badge badge-pill badge-primary">5</small></a></li>
                            <li class="list-inline-item"><a href="auth-signin.html" data-toggle="tooltip" title="Logout"
                                    class="text-danger"><i class="feather icon-power"></i></a></li>
                        </ul>
                    </div>
                </div>

                <ul class="nav pcoded-inner-navbar">
                        <li class="nav-item"><a href="{{route('dashboard.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>
                        <li class="nav-item"><a href="{{route('akun.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Akun</span></a></li>

                        <li class="nav-item pcoded-hasmenu">
                            <a class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                <span class="pcoded-mtext">Laporan</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li><a href="{{route('jurnalumum')}}">Jurnal Umum</a></li>
                                <li><a href="{{route('bukubesar')}}">Buku Besar</a></li>
                            </ul>
                        </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->