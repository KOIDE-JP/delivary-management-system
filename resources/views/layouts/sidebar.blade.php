<style>
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.5);
    }

    .sidebar-glass {
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(20px);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .menu-item-glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
    }

    .menu-item-glass:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .menu-item-glass.active {
        background: rgba(59, 130, 246, 0.15);
        border-left: 3px solid #3b82f6;
    }

    .submenu-item-glass {
        background: rgba(255, 255, 255, 0.03);
    }

    .submenu-item-glass:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .submenu-item-glass.active {
        background: rgba(59, 130, 246, 0.1);
        border-left: 2px solid #3b82f6;
    }
</style>

<div class="max-w-62.5 ease-nav-brand z-990 fixed">
    <!-- Modern Glassmorphic Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-72 sidebar-glass shadow-2xl flex flex-col transition-transform duration-300 ease-in-out xl:translate-x-0 -translate-x-full">

        <!-- Header with Logo -->
        <div class="h-19.5 flex items-center justify-start p-6 border-b border-white border-opacity-10">
            <div class="xl:hidden">
                <i id="close-mobile-menu"
                    class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times text-slate-300 hover:text-white transition-colors"
                    sidenav-close></i>
            </div>
            <a class="flex items-center space-x-3 px-2 py-2 m-0 text-sm whitespace-nowrap group">
                <!-- Logo Icon -->
                <div
                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg flex items-center justify-center transform group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-bold text-white block leading-tight">
                        DMS
                    </span>
                    <span class="text-xs text-blue-300">
                        Delivery Management System
                    </span>
                </div>
            </a>
        </div>

        <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-white/20 to-transparent" />

        <!-- Navigation -->
        <div id="sidebar_main_content"
            class="items-center block w-auto max-h-screen overflow-x-hidden overflow-y-auto h-[80vh] grow basis-full">
            <ul class="flex flex-col mb-0 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">

                <!-- Dashboard -->
                <li class="w-full child-menu-list">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'active text-white' : '' }}"
                        aria-expanded="false">

                        <div
                            class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg mr-3 group-hover:shadow-blue-500/50 transition-shadow duration-200">
                            <i class="fa-solid fa-house-chimney text-white text-sm"></i>
                        </div>

                        <span
                            class="font-medium group-hover:translate-x-1 duration-300 opacity-100 pointer-events-none ease-soft transition-transform">
                            {{ __('layouts.dashboard') }}
                        </span>
                    </a>
                </li>
                
                <!-- Statuses Menu -->
                {{-- @if (auth()->user()->hasPermission('statuses.index') || auth()->user()->hasPermission('statuses.create'))
                    <li class="mt-2 w-full" x-data="{ open: {{ request()->routeIs('statuses.*') ? 'true' : 'false' }} }">
                        <a href="javascript:;" @click="open = !open"
                            class="flex items-center justify-between px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group"
                            :class="{ 'text-white bg-white/10': open }">

                            <div class="flex items-center">
                                <div
                                    class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg shadow-lg mr-3 group-hover:shadow-emerald-500/50 transition-shadow duration-200">
                                    <svg fill="#FFFFFF" width="16px" height="16px" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
                                            10-4.48 10-10S17.52 2 12 2zm1 17.93c-2.83.48-5.48-1.51-5.96-4.34
                                            -.48-2.83 1.51-5.48 4.34-5.96 2.83-.48 5.48 1.51 5.96 4.34
                                            .48 2.83-1.51 5.48-4.34 5.96z" />
                                    </svg>
                                </div>
                                <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">
                                    {{ __('layouts.statuses') }}
                                </span>
                            </div>

                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>

                        <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                            @if (auth()->user()->hasPermission('statuses.create'))
                                <li class="child-menu-list">
                                    <a href="{{ route('statuses.create') }}"
                                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('statuses.create') ? 'active font-semibold text-white' : '' }}">
                                        <div
                                            class="w-2 h-2 bg-green-400 rounded-full mr-3 shadow-sm shadow-green-400/50">
                                        </div>
                                        {{ __('layouts.add_status') }}
                                    </a>
                                </li>
                            @endif

                            @if (auth()->user()->hasPermission('statuses.index'))
                                <li class="child-menu-list">
                                    <a href="{{ route('statuses.index') }}"
                                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('statuses.index') ? 'active font-semibold text-white' : '' }}">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50">
                                        </div>
                                        {{ __('layouts.all_statuses') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif --}}



                <!-- Master Data Menu -->
                <!-- Destinations Menu -->
{{-- @if (auth()->user()->hasPermission('destinations.index') || auth()->user()->hasPermission('destinations.create')) --}}
    <li class="mt-2 w-full" x-data="{ open: {{ request()->routeIs('destinations.*') ? 'true' : 'false' }} }">
        <a href="javascript:;" @click="open = !open"
            class="flex items-center justify-between px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group"
            :class="{ 'text-white bg-white/10': open }">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-lg shadow-lg mr-3 group-hover:shadow-amber-500/50 transition-shadow duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">
                    {{ __('layouts.destinations') }}
                </span>
            </div>
            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </a>
        <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
            @if (auth()->user()->hasPermission('destinations.create'))
                <li class="child-menu-list">
                    <a href="{{ route('destinations.create') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('destinations.create') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-3 shadow-sm shadow-green-400/50"></div>
                        {{ __('layouts.add_destination') }}
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasPermission('destinations.index'))
                <li class="child-menu-list">
                    <a href="{{ route('destinations.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('destinations.index') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50"></div>
                        {{ __('layouts.all_destinations') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>
{{-- @endif --}}


<!-- Carriers Menu -->
{{-- @if (auth()->user()->hasPermission('carriers.index') || auth()->user()->hasPermission('carriers.create')) --}}
    <li class="mt-2 w-full" x-data="{ open: {{ request()->routeIs('carriers.*') ? 'true' : 'false' }} }">
        <a href="javascript:;" @click="open = !open"
            class="flex items-center justify-between px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group"
            :class="{ 'text-white bg-white/10': open }">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-sky-500 to-cyan-600 rounded-lg shadow-lg mr-3 group-hover:shadow-cyan-500/50 transition-shadow duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM3 4h2l2.5 10h9.5l2-7H6" />
                    </svg>
                </div>
                <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">
                    {{ __('layouts.carriers') }}
                </span>
            </div>
            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </a>
        <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
            @if (auth()->user()->hasPermission('carriers.create'))
                <li class="child-menu-list">
                    <a href="{{ route('carriers.create') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('carriers.create') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-3 shadow-sm shadow-green-400/50"></div>
                        {{ __('layouts.add_carrier') }}
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasPermission('carriers.index'))
                <li class="child-menu-list">
                    <a href="{{ route('carriers.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('carriers.index') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50"></div>
                        {{ __('layouts.all_carriers') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>
{{-- @endif --}}


<!-- Truck Types Menu -->
{{-- @if (auth()->user()->hasPermission('truck-types.index') || auth()->user()->hasPermission('truck-types.create')) --}}
    <li class="mt-2 w-full" x-data="{ open: {{ request()->routeIs('truck-types.*') ? 'true' : 'false' }} }">
        <a href="javascript:;" @click="open = !open"
            class="flex items-center justify-between px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group"
            :class="{ 'text-white bg-white/10': open }">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg shadow-lg mr-3 group-hover:shadow-emerald-500/50 transition-shadow duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3m0 0h3l3 3v4h-6m0 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">
                    {{ __('layouts.truck_types') }}
                </span>
            </div>
            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </a>
        <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
            @if (auth()->user()->hasPermission('truck-types.create'))
                <li class="child-menu-list">
                    <a href="{{ route('truck-types.create') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('truck-types.create') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-3 shadow-sm shadow-green-400/50"></div>
                        {{ __('layouts.add_truck_type') }}
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasPermission('truck-types.index'))
                <li class="child-menu-list">
                    <a href="{{ route('truck-types.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('truck-types.index') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50"></div>
                        {{ __('layouts.all_truck_types') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>
{{-- @endif --}}


<!-- Freight Rates Menu -->
{{-- @if (auth()->user()->hasPermission('freight-rates.index') || auth()->user()->hasPermission('freight-rates.create')) --}}
    <li class="mt-2 w-full" x-data="{ open: {{ request()->routeIs('freight-rates.*') ? 'true' : 'false' }} }">
        <a href="javascript:;" @click="open = !open"
            class="flex items-center justify-between px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group"
            :class="{ 'text-white bg-white/10': open }">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-lg shadow-lg mr-3 group-hover:shadow-yellow-500/50 transition-shadow duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">
                    {{ __('layouts.freight_rates') }}
                </span>
            </div>
            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </a>
        <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
            @if (auth()->user()->hasPermission('freight-rates.create'))
                <li class="child-menu-list">
                    <a href="{{ route('freight-rates.create') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('freight-rates.create') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-3 shadow-sm shadow-green-400/50"></div>
                        {{ __('layouts.add_freight_rate') }}
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasPermission('freight-rates.index'))
                <li class="child-menu-list">
                    <a href="{{ route('freight-rates.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('freight-rates.index') ? 'active font-semibold text-white' : '' }}">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50"></div>
                        {{ __('layouts.all_freight_rates') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>
{{-- @endif --}}

                <!-- Users Menu -->
                @if (auth()->user()->hasPermission('users.index') || auth()->user()->hasPermission('users.create') || auth()->user()->hasPermission('role.list'))

                <li class="mt-2 w-full" x-data="{ open: {{ request()->routeIs('users.*') || request()->routeIs('role.list') ? 'true' : 'false' }} }">
                    <a href="javascript:;" @click="open = !open"
                        class="flex items-center justify-between px-4 py-3.5 text-slate-200 rounded-xl menu-item-glass hover:text-white transition-all duration-200 group"
                        :class="{ 'text-white bg-white/10': open }">
                        <div class="flex items-center">
                            <div
                                class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg mr-3 group-hover:shadow-purple-500/50 transition-shadow duration-200">
                                <svg fill="#FFFFFF" width="16px" height="16px" viewBox="0 0 46 42"
                                    version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(1.000000, 0.000000)">
                                                    <path class="opacity-60"
                                                        d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z">
                                                    </path>
                                                    <path class=""
                                                        d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z">
                                                    </path>
                                                    <path class=""
                                                        d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">
                                {{ __('layouts.users') }}
                            </span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>

                    <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                        @if (auth()->user()->hasPermission('users.create')) 
                        <li class="child-menu-list">
                            <a href="{{ route('users.create') }}"
                                class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('users.create') ? 'active font-semibold text-white' : '' }}">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3 shadow-sm shadow-green-400/50">
                                </div>
                                {{ __('layouts.add_user') }}
                            </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('users.index')) 
                        <li class="child-menu-list">
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('users.index') ? 'active font-semibold text-white' : '' }}">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50">
                                </div>
                                {{ __('layouts.all_users') }}
                            </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('role.list'))
                        <li class="child-menu-list">
                            <a href="{{ route('role.list') }}"
                                class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg submenu-item-glass hover:text-white transition-all duration-200 {{ request()->routeIs('role.list') ? 'active font-semibold text-white' : '' }}">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 shadow-sm shadow-yellow-400/50">
                                </div>
                                {{ __('layouts.role') }}
                            </a>
                        </li>
                        @endif

                        {{-- @if (auth()->user()->hasPermission('users.deleteUsers')) --}}
                        <li class="child-menu-list">
                            <a href="{{ route('users.deleteUsers') }}"
                                class="flex items-center px-4 py-2.5 text-sm text-slate-300 rounded-lg
                                    submenu-item-glass hover:text-white transition-all duration-200
                                    {{ request()->routeIs('users.deleteUsers*') ? 'active font-semibold text-white' : '' }}">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 shadow-sm shadow-blue-400/50"></div>
                                {{ __('layouts.deleted_users') }}
                            </a>
                        </li>


                        {{-- @endif --}}



                    </ul>
                </li>
                @endif

            </ul>
        </div>

        <!-- Bottom branding/info -->
        <div class="p-4 border-t border-white border-opacity-10">
            <div class="flex items-center justify-center space-x-2 text-xs text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
                <span>
                    {{ __('layouts.secured_system') }}
                </span>
            </div>
        </div>
    </aside>
</div>

<!-- Mobile Menu Toggle -->
{{-- <button id="mobile-menu-toggle"
    class="xl:hidden fixed top-4 left-4 z-[60] p-2.5 bg-slate-800 bg-opacity-90 backdrop-blur-lg rounded-xl shadow-xl border border-white border-opacity-10 hover:bg-opacity-100 transition-all duration-200">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button> --}}

@push('scripts')
    <script>
        $(document).ready(function() {

            // Toggle sidebar visibility on mobile
            $('#mobile-menu-toggle').on('click', function() {
                $('#sidebar').toggleClass('-translate-x-full');

            });

            $('#close-mobile-menu').on('click', function() {
                $('#sidebar').toggleClass('-translate-x-full');
            });

            // Close sidebar on outside click
            $(document).on('click', function(event) {
                const $sidebar = $('#sidebar');
                const $toggleButton = $('#mobile-menu-toggle');

                // Check if sidebar is open and click was outside sidebar and toggle button
                if (
                    !$sidebar.hasClass('-translate-x-full') && // Sidebar is open
                    !$sidebar.is(event.target) && $sidebar.has(event.target).length === 0 &&
                    !$toggleButton.is(event.target) && $toggleButton.has(event.target).length === 0
                ) {
                    $sidebar.addClass('-translate-x-full'); // Close the sidebar
                }
            });

            const activeLink = $('.child-menu-list a.active');
            if (activeLink.length) {
                const container = $('#sidebar_main_content');
                const offsetTop = activeLink.offset().top - container.offset().top + container.scrollTop() - 100;

                container.animate({
                    scrollTop: offsetTop
                }, 300);
            }

        });
    </script>
@endpush
