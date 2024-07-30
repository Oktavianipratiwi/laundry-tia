<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="../assets/img/laundry.png" width="40pt" height="40pt" alt="">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('variables.templateName') }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @php
    $userRole = Auth::user()->role;
    @endphp

    @foreach ($menuData[0]->menu as $menu)
    {{-- Menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
    </li>
    @else
    @php
    $showMenu = true;

    if ($userRole !== 'admin') {
    // Hide specific menus for 'pegawai' and 'pelanggan'
    if (in_array($menu->slug, ['courier-index', 'customers-index'])) {
    $showMenu = false;
    }
    }
    if ($userRole === 'pegawai') {
    if (in_array($menu->slug, ['transactions-index'])) {
    $showMenu = false;
    }
    }

    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    } elseif (isset($menu->submenu)) {
    if (is_array($menu->slug)) {
    foreach ($menu->slug as $slug) {
    if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
    $activeClass = 'active open';
    }
    }
    } else {
    if (str_contains($currentRouteName, $menu->slug) && strpos($currentRouteName, $menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    @endphp

    @if ($showMenu)
    {{-- Main menu --}}
    <li class="menu-item {{ $activeClass }}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
        @endisset
      </a>

      {{-- Submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
      @endisset
    </li>
    @endif
    @endif
    @endforeach
  </ul>

</aside>