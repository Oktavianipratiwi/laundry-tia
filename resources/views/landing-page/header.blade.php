<header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <!-- Logo -->
                <div class="header-left">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                        <span class="app-brand-logo demo"> <img src="../assets/img/laundry.png" width="40pt" height="40pt" alt="">
                        </span>
                        <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
                        </a>
                    </div>
                    <div class="menu-wrapper  d-flex align-items-center">
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav> 
                                <ul id="navigation">                                                                                          
                                    <li class="active"><a href="{{ url('') }}">Beranda</a></li>
                                    <!-- <li><a href="about.html">Tentang</a></li>
                                    <li><a href="services.html">Layanan</a></li> -->
                                    <!-- <li><a href="contact.html">Kontak</a></li> -->
                                    <li><a href="#">Masuk Ke Halaman Web</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('login') }}">Masuk</a></li>
                                            <li><a href="{{ route('register') }}">Daftar</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    
                </div> 
                <div class="header-right d-none d-lg-block">
                    <a href="https://api.whatsapp.com/send?phone=085355340303" target="_blank" class="header-btn1"><img src="{{ asset('assets-landing-page/img/icon/call.png') }}"><img src="{{ asset('assets-landing-page/img/icon/call.png') }}}}" alt="">085355340303</a>
                    <a href="{{ route('register') }}" class="header-btn2">Buat Akun Anda</a>
                </div>
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>