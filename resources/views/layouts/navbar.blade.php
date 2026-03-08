<?php
$path = parse_url(url()->current(), PHP_URL_PATH);
// Remove leading slash if present
$path = ltrim($path, '/');
// Split the path into segments
$segments = explode('/', $path);
?>
<style>
    .navbar-glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .notification-badge {
        animation: pulse-notification 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse-notification {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: .8;
            transform: scale(1.05);
        }
    }

    .notification-dropdown-glass {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .user-dropdown-glass {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    /* Mobile Bottom Nav Styles */
    .bottom-nav-glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .safe-area-bottom {
        padding-bottom: env(safe-area-inset-bottom);
    }

    .bottom-nav-item {
        color: #64748b;
        transition: all 0.2s;
    }

    .bottom-nav-item:hover {
        color: #3b82f6;
    }

    .bottom-nav-item.active {
        color: #3b82f6;
    }

    /* Mobile user menu from bottom */
    .mobile-user-menu {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        transform: translateY(100%);
        transition: transform 0.3s ease-in-out;
    }

    .mobile-user-menu.show {
        transform: translateY(0);
    }

    .mobile-menu-overlay {
        transition: opacity 0.3s ease-in-out;
    }

    /* Adjust notification dropdown position on mobile */
    /* @media (max-width: 767px) {
        #notifications {
            right: 50% !important;
            transform: translateX(50%);
            bottom: 70px;
            top: auto !important;
            margin-top: 0 !important;
        }
    } */
</style>

<!-- Desktop Navbar (Hidden on Mobile) -->
<nav class="md:flex relative flex-wrap items-center justify-between px-2 sm:px-4 md:px-6 py-3 mx-2 md:mx-6 transition-all duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start navbar-glass shadow-lg z-110"
    navbar-main navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-2 sm:px-4 py-1 mx-auto flex-wrap-inherit">
        <nav class="w-full">
            <!-- Enhanced Breadcrumb -->
            <ol
                class="flex flex-wrap items-center pt-1 pr-3 sm:pr-4 md:pr-6 lg:pr-12 xl:pr-16 bg-transparent rounded-lg gap-1 sm:gap-2">
                <li class="leading-normal text-xs sm:text-sm shrink-0">
                    <a class="text-slate-600 hover:text-blue-600 transition-colors duration-200 flex items-center justify-center w-8 h-8 rounded-lg hover:bg-blue-50"
                        href="/" title="Home">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>

                @foreach ($segments as $segment)
                    @if (!is_numeric($segment))
                        <li class="text-xs sm:text-sm capitalize leading-normal text-slate-700 
                      flex items-center min-w-0
                      before:content-['/'] before:text-slate-400 before:mr-1 sm:before:mr-2 
                      before:shrink-0 before:text-xs sm:before:text-sm before:font-light"
                            aria-current="page">
                            <span
                                class="truncate max-w-[100px] sm:max-w-[150px] md:max-w-[200px] lg:max-w-none font-medium px-2 py-1 rounded-lg hover:bg-slate-100 transition-colors duration-200"
                                title="{{ __('layouts.segment.' . ucfirst(strtolower($segment))) }}">
                                {{ __('layouts.segment.' . ucfirst(strtolower($segment))) }}
                            </span>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>

        <div class="w-full flex justify-end items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full gap-2 sm:gap-3">

                <!-- Notification Bell -->
                <li class="relative">
                    <button id="notification-button"
                        class="cursor-pointer relative inline-flex items-center justify-center p-2.5 rounded-xl text-slate-600 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 group"
                        aria-label="Notifications">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:scale-110 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>

                        <!-- Animated Badge -->
                        <span id="notification-count"
                            class="notification-badge absolute -top-1 -right-1 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold min-w-5 h-5 rounded-full flex items-center justify-center px-1 shadow-lg shadow-red-500/50">
                            0
                        </span>
                    </button>

                    <!-- Enhanced Notifications Dropdown -->
                    <div id="notifications"
                        class="absolute right-[-65px] md:right-0 mt-2 w-80 notification-dropdown-glass rounded-2xl shadow-2xl max-h-80 z-50 hidden overflow-hidden">
                        <!-- Header -->
                        <div
                            class="px-4 py-3 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100 rounded-t-2xl">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                        </path>
                                    </svg>
                                    Notifications
                                </h3>
                            </div>
                        </div>

                        <!-- Notification List -->
                        <div id="notification-list"
                            class="relative divide-y divide-slate-100 max-h-64 overflow-y-auto z-50">

                        </div>
                    </div>
                </li>

                <!-- Language Switcher -->
                <li class="flex items-center">
                    @php
                        $currentLocale = app()->getLocale();
                        $newLocale = $currentLocale === 'en' ? 'jp' : 'en';
                        $newFlagImage = $newLocale === 'en' ? 'en.jpg' : 'jp.png';
                        $newLabel = $newLocale === 'en' ? 'English' : '日本語';
                    @endphp

                    <a href="{{ request()->fullUrlWithQuery(['lang' => $newLocale]) }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                        title="Switch Language">
                        <img src="{{ asset('assets/img/' . $newFlagImage) }}" alt="{{ $newLocale }}"
                            class="w-5 h-4 shadow-sm border border-slate-200">
                        <span class="hidden sm:inline">{{ $newLabel }}</span>
                    </a>
                </li>

                <!-- User Profile Dropdown -->
                <li class="hidden md:flex items-center pl-1 sm:pl-2">
                    <div class="relative group">
                        <button
                            class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 focus:outline-none cursor-pointer transition-all duration-200">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg flex items-center justify-center ring-2 ring-blue-100">
                                <i class="fa-solid fa-user text-white text-sm"></i>
                            </div>
                            <span
                                class="text-sm font-medium text-slate-700 hidden md:block">{{ Auth::user()->name ?? 'User' }}</span>
                            <svg class="w-4 h-4 text-slate-500 hidden md:block transition-transform duration-200 group-hover:rotate-180"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            class="absolute right-0 z-50 mt-0 w-56 user-dropdown-glass rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto pointer-events-none transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 overflow-hidden">
                            <!-- User Info Header -->
                            <div
                                class="px-4 py-3 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
                                <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name ?? 'User' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ Auth::user()->email ?? 'user@example.com' }}
                                </p>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                {{-- @permission('user.profileUpdate') --}}
                                <a href="{{ route('user.profileUpdate') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class="fa fa-user-circle text-blue-600"></i>
                                    </div>
                                    <span class="font-medium">{{ __('layouts.profile_update') }}</span>
                                </a>

                                <a href="{{ route('user.changePassword') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class="fa-solid fa-key text-blue-600"></i>
                                    </div>
                                    <span class="font-medium">{{ __('layouts.change_password') }}</span>
                                </a>
                                {{-- @endpermission --}}

                                {{-- @permission('user.settings') --}}
                                {{-- <a href="{{ route('user.settings') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                            <i class="fa fa-cog text-blue-600"></i>
                                        </div>
                                        <span class="font-medium">{{ __('layouts.user_settings') }}</span>
                                    </a> --}}
                                {{-- @endpermission --}}
                            </div>

                            <!-- Logout -->
                            <div class="border-t border-slate-200 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                            <i class="fa fa-sign-out text-red-600"></i>
                                        </div>
                                        <span class="font-medium">{{ __('layouts.logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Mobile Bottom Navigation (Visible only on Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bottom-nav-glass safe-area-bottom w-full">
    <div class="relative">
        <!-- Center Plus Button (floats above) -->
        <button id="center-action-button"
            class="absolute left-1/2 transform -translate-x-1/2 -top-8 w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-200 ring-4 ring-white">
            <i id="plus-icon" class="fa-solid fa-plus text-white text-xl transition-transform duration-300"></i>
        </button>

        <!-- Navigation Items -->
        <div class="flex items-center justify-around px-4 py-3">
            <!-- Sidebar Toggle -->
            <button id="mobile-menu-toggle"
                class="bottom-nav-item flex flex-col items-center justify-center min-w-[60px] transition-all">
                <i class="fa-solid fa-bars text-xl mb-1"></i>
                <span class="text-xs font-medium">Menu</span>
            </button>

            <!-- Dashboard/Home -->
            <a href="/"
                class="bottom-nav-item active flex flex-col items-center justify-center min-w-[60px] transition-all">
                <i class="fa-solid fa-house text-xl mb-1"></i>
                <span class="text-xs font-medium">Home</span>
            </a>

            <!-- Spacer for center button -->
            <div class="w-14"></div>

            <!-- Notifications -->
            <button id="notification-button-mobile"
                class="bottom-nav-item flex flex-col items-center justify-center min-w-[60px] transition-all relative">
                <i class="fa-solid fa-bell text-xl mb-1"></i>
                <span class="text-xs font-medium">Alerts</span>
                <!-- Notification badge -->
                <span class="absolute top-0 right-3 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- User Profile -->
            <button id="mobile-menu-button"
                class="bottom-nav-item flex flex-col items-center justify-center min-w-[60px] transition-all">
                <div
                    class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg flex items-center justify-center ring-2 ring-blue-100 mb-1">
                    <i class="fa-solid fa-user text-white text-xs"></i>
                </div>
                <span class="text-xs font-medium">Profile</span>
            </button>
        </div>
    </div>
</nav>

<!-- Center Action Menu (Radial Menu) -->
<div id="center-action-menu" class="md:hidden fixed bottom-24 left-1/2 transform -translate-x-1/2 z-40 hidden">
    <div class="relative">
        <!-- Menu Items Container -->
        <div class="flex flex-col gap-3 items-center pb-6">
            <!-- Add your custom action buttons here -->

            <a href="{{ "" }}"
                class="action-menu-item bg-white rounded-full shadow-xl p-4 hover:scale-110 transition-all duration-200 opacity-0">
                <i class="fa-solid fa-plus text-red-600 text-xl pr-2"></i>Add Defect
            </a>

            <a href="{{ "" }}"
                class="action-menu-item bg-white rounded-full shadow-xl p-4 hover:scale-110 transition-all duration-200 opacity-0">
                <i class="fa-solid fa-list text-blue-600 text-xl pr-2"></i>Defects
            </a>
        </div>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay"
    class="md:hidden fixed inset-0 bg-opacity backdrop-blur-sm z-40 hidden mobile-menu-overlay opacity-0"></div>

<!-- Mobile User Menu (Slide from bottom) -->
<div id="mobile-user-menu"
    class="md:hidden fixed bottom-0 left-0 right-0 z-50 mobile-user-menu rounded-t-3xl shadow-2xl pb-4">
    <!-- Handle Bar -->
    <div id="handle-bar" class="flex justify-center pt-3 pb-2">
        <div class="w-12 h-1.5 bg-slate-300 rounded-full"></div>
    </div>

    <!-- User Info Header -->
    <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg flex items-center justify-center ring-2 ring-blue-100">
                <i class="fa-solid fa-user text-white text-lg"></i>
            </div>
            <div>
                <p class="text-base font-semibold text-slate-900">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-sm text-slate-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="py-3 px-3">
        @permission('user.profileUpdate')
            <a href="{{ route('user.profileUpdate') }}"
                class="flex items-center gap-4 px-4 py-3 text-base text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 rounded-xl mb-1">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fa fa-user-circle text-blue-600"></i>
                </div>
                <span class="font-medium">{{ __('layouts.profile_update') }}</span>
            </a>

            <a href="{{ route('user.changePassword') }}"
                class="flex items-center gap-4 px-4 py-3 text-base text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 rounded-xl mb-1">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid fa-key text-blue-600"></i>
                </div>
                <span class="font-medium">{{ __('layouts.change_password') }}</span>
            </a>
        @endpermission

        {{-- @permission('user.settings')
            <a href="{{ route('user.settings') }}"
                class="flex items-center gap-4 px-4 py-3 text-base text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 rounded-xl mb-1">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fa fa-cog text-blue-600"></i>
                </div>
                <span class="font-medium">{{ __('layouts.user_settings') }}</span>
            </a>
        @endpermission --}}
    </div>

    <!-- Logout -->
    <div class="border-t border-slate-200 py-3 px-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-4 px-4 py-3 text-base text-red-600 hover:bg-red-50 transition-colors duration-200 rounded-xl">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <i class="fa fa-sign-out text-red-600"></i>
                </div>
                <span class="font-medium">{{ __('layouts.logout') }}</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        var userId = {{ Auth::id() }};
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notification-button');
            const notificationButtonMobile = document.getElementById('notification-button-mobile');
            const notificationCount = document.getElementById('notification-count');
            const notificationCountMobile = document.getElementById('notification-count-mobile');
            const notificationsContainer = document.getElementById('notifications');
            const notificationList = document.getElementById('notification-list');

            // Mobile menu elements
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileUserMenu = document.getElementById('mobile-user-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const handleBar = document.getElementById('handle-bar');

            // Toggle dropdown (desktop)
            if (notificationButton) {
                notificationButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    notificationsContainer.classList.toggle('hidden');
                });
            }

            if (notificationButtonMobile) {
                notificationButtonMobile.addEventListener('click', function(event) {
                    event.stopPropagation();
                    notificationsContainer.classList.toggle('hidden');
                });
            }

            // Center Action Button
            const centerActionButton = document.getElementById('center-action-button');
            const centerActionMenu = document.getElementById('center-action-menu');
            const plusIcon = document.getElementById('plus-icon');
            const actionMenuItems = document.querySelectorAll('.action-menu-item');

            let isMenuOpen = false;

            if (centerActionButton) {
                centerActionButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    isMenuOpen = !isMenuOpen;

                    if (isMenuOpen) {
                        // Open menu
                        centerActionMenu.classList.remove('hidden');
                        plusIcon.style.transform = 'rotate(45deg)';

                        // Animate menu items
                        actionMenuItems.forEach((item, index) => {
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            }, index * 50);
                        });
                    } else {
                        // Close menu
                        plusIcon.style.transform = 'rotate(0deg)';

                        actionMenuItems.forEach((item, index) => {
                            setTimeout(() => {
                                item.style.opacity = '0';
                                item.style.transform = 'translateY(10px)';
                            }, index * 30);
                        });

                        setTimeout(() => {
                            centerActionMenu.classList.add('hidden');
                        }, actionMenuItems.length * 30 + 100);
                    }
                });
            }

            // Close center menu when clicking outside
            document.addEventListener('click', function(event) {
                if (isMenuOpen && !centerActionMenu.contains(event.target) && !centerActionButton.contains(
                        event.target)) {
                    isMenuOpen = false;
                    plusIcon.style.transform = 'rotate(0deg)';

                    actionMenuItems.forEach((item, index) => {
                        setTimeout(() => {
                            item.style.opacity = '0';
                            item.style.transform = 'translateY(10px)';
                        }, index * 30);
                    });

                    setTimeout(() => {
                        centerActionMenu.classList.add('hidden');
                    }, actionMenuItems.length * 30 + 100);
                }
            });

            // Toggle mobile menu
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileUserMenu.classList.add('show');
                    mobileMenuOverlay.classList.remove('hidden');
                    setTimeout(() => {
                        mobileMenuOverlay.classList.remove('opacity-0');
                        mobileMenuOverlay.classList.add('opacity-100');
                    }, 10);
                });
            }
            if (handleBar) {
                handleBar.addEventListener('click', function() {
                    closeMobileMenu();
                });
            }

            // Close mobile menu
            function closeMobileMenu() {
                mobileUserMenu.classList.remove('show');
                mobileMenuOverlay.classList.remove('opacity-100');
                mobileMenuOverlay.classList.add('opacity-0');
                setTimeout(() => {
                    mobileMenuOverlay.classList.add('hidden');
                }, 300);
            }

            if (mobileMenuOverlay) {
                mobileMenuOverlay.addEventListener('click', closeMobileMenu);
            }

            // Hide dropdown if clicked outside
            document.addEventListener('click', function(event) {
                if (!notificationsContainer.contains(event.target) &&
                    !notificationButton?.contains(event.target)) {
                    notificationsContainer.classList.add('hidden');
                }
            });



            function renderNotifications(response) {
                let notifications = response.data || response; // handle array or {data:[]}
                // let count = response.count !== undefined ? response.count : notifications.length;
                let count = 0;

                notificationList.innerHTML = '';

                if (notifications.length === 0) {
                    notificationList.innerHTML = `<div id="empty-state" class="flex flex-col items-center justify-center py-12 px-6">
                    <!-- Bell Icon -->
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    
                    <!-- Text Content -->
                    <h3 class="text-sm font-medium text-gray-900 mb-1">No notifications yet</h3>
                    <p class="text-xs text-gray-500 text-center leading-relaxed">
                        You're all caught up! We'll notify you when<br>
                        something important happens.
                    </p>
                </div>`;
                } else {
                    notifications.forEach(item => {
                        let notificationData = item.data;
                        let notificationType = item.type;
                        console.log('Processing notification item:', item.type);
                        console.log('Notification data:', notificationData);
                        if (typeof notificationData === "string") {
                            try {
                                notificationData = JSON.parse(notificationData);
                            } catch (e) {
                                // keep string if not JSON
                            }
                        }
                        console.log('User id:', notificationData.user_id);
                        // if(notificationData.manager_id === userId) {


                        //     const notification = document.createElement('div');
                        //     notification.className =
                        //         "group p-4 hover:bg-red-50 transition-colors duration-150 cursor-pointer relative";
                        //     notification.innerHTML = `
                    //         <div class="flex items-start space-x-3">
                    //             <!-- Icon -->
                    //             <div class="flex-shrink-0">
                    //                 <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    //                     <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    //                         <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    //                     </svg>
                    //                 </div>
                    //             </div>
                    //             <!-- Content -->
                    //             <div class="flex-1 min-w-0">
                    //                 <p class="text-sm font-medium text-gray-900">${notificationData.title || 'Defects Notification'}</p>
                    //                 <p class="text-xs text-gray-600 mt-1">
                    //                     ${notificationData.part_no ? `Defects part has created. Part No:${notificationData.part_no} ` : (notificationData.message || '')}
                    //                 </p>
                    //                 <p class="text-xs text-gray-500 mt-1">${item.created_at ? new Date(item.created_at).toLocaleString() : ''}</p>
                    //             </div>
                    //             <!-- Close button -->
                    //             <button class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150 text-gray-400 hover:text-red-500 p-1">
                    //                 <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    //                     <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    //                 </svg>
                    //             </button>
                    //         </div>
                    //         <!-- Unread indicator -->
                    //         <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-red-500 rounded-r-full"></div>
                    //     `;

                        //     // Mark as read on row click
                        //     notification.addEventListener('click', function() {
                        //         markAsRead(item.id, notification);
                        //     });

                        //     // Mark as read on cross button click
                        //     notification.querySelector('button').addEventListener('click', function(e) {
                        //         e.stopPropagation();
                        //         markAsRead(item.id, notification);
                        //     });

                        //     notificationList.appendChild(notification);
                        //     count++;
                        // }
                        if (notificationData.manager_id === userId || notificationData.user_id === userId) {

                            const notification = document.createElement('div');
                            notification.className =
                                "group p-4 hover:bg-blue-50 transition-colors duration-150 cursor-pointer relative";

                            notification.innerHTML = `
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M10 2a6 6 0 00-6 6v4.586l-1.707 1.707A1 1 0 004 16h12a1 1 0 00.707-1.707L16 12.586V8a6 6 0 00-6-6zM10 18a2 2 0 002-2H8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            ${
                                                notificationData.manager_id === userId
                                                    ? (notificationData.title || 'Defects Notification') 
                                                    
                                                    : notificationData.user_id === userId
                                                        ? (() => {
                                                            let text = '';
                                                            // Proposed solution
                                                            if (notificationType === 'manager-approved-proposed-solution') {
                                                                text += `Proposed Solutions approved for ${notificationData.proposed_solution_plan}`;
                                                            }
                                                            // Recurrence prevention
                                                            if (notificationType === 'manager-approved-recurrence-prevention') {
                                                                text += `
                            Recurrence Prevention approved
                            for $ {
                                notificationData.recurrence_prevention_plan
                            }
                            `;
                                                            }

                                                            return text;
                                                        })()
                                                        
                                                    : ''
                                            }
                                        </p>


                                        <p class="text-xs text-gray-600 mt-1">
                                            ${notificationData.part_no 
                                                ? `Defect part created. Part No: ${notificationData.part_no}` 
                                                : (notificationData.message || '')
                                            }
                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">
                                            ${item.created_at ? new Date(item.created_at).toLocaleString() : ''}
                                        </p>
                                    </div>

                                    <button class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150 text-gray-400 hover:text-red-500 p-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-blue-500 rounded-r-full"></div>
                            `;

                            notification.addEventListener('click', function() {
                                markAsRead(item.id, notification);
                            });

                            notification.querySelector('button').addEventListener('click', function(e) {
                                e.stopPropagation();
                                markAsRead(item.id, notification);
                            });

                            notificationList.appendChild(notification);
                            count++;
                        }

                    });
                }

                // update count for desktop only
                if (notificationCount) notificationCount.innerText = count;
            }


            // Load notifications from DB
            function loadNotifications() {
                fetch('/notifications/latest')
                    .then(res => res.json())
                    .then(data => {
                        renderNotifications(data);
                    });
            }

            loadNotifications();

            // Mark as read (AJAX)
            function markAsRead(id, element) {
                fetch(`/notifications/read/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            element.remove();
                            let count = parseInt(notificationCount?.innerText) || 0;
                            let newCount = count > 0 ? count - 1 : 0;
                            if (notificationCount) notificationCount.innerText = newCount;
                        }
                    });
            }

            // Real-time listener
            if (typeof Echo !== 'undefined') {
                Echo.channel('my-channel')
                    .listen('.my-event', (e) => {
                        // if (e.manager_id === currentUserId) {
                        //     // console.log('New defect notification for you:', e.part_no);
                        //     loadNotifications();
                        // }

                        loadNotifications();
                    });
            }
        });
    </script>
@endpush
