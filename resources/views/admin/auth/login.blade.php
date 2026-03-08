<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('layouts.projectName') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .input-glass:focus {
            background: rgba(255, 255, 255, 0.95);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            position: relative;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                linear-gradient(-45deg, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(59, 130, 246, 0.4);
        }

        .logo-glow {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
        }

        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .feature-icon {
            transition: all 0.3s ease;
        }

        .feature-icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="min-h-screen gradient-bg">
    <!-- Grid Pattern -->
    <div class="absolute inset-0 grid-pattern"></div>
    
    <!-- Animated Circles -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
    <div class="absolute top-40 right-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse" style="animation-delay: 4s;"></div>
    
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative z-10">
        <!-- Header Section -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo/Icon -->
            {{-- <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-2xl flex items-center justify-center logo-glow transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
            </div> --}}

            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                    FabTrace
                </h1>
                <p class="text-blue-200 text-sm font-medium mb-1">
                    Defect Management System
                </p>
            </div>

            <!-- Language Toggle -->
            <div class="text-center mt-6">
                <div class="inline-flex bg-white bg-opacity-10 backdrop-blur-sm rounded-full p-1 shadow-lg">
                    <a href="?lang=jp"
                        class="px-5 py-2 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20 rounded-full transition-all duration-200">
                        日本語
                    </a>
                    <span class="text-white opacity-30 flex items-center mx-1">|</span>
                    <a href="?lang=en"
                        class="px-5 py-2 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20 rounded-full transition-all duration-200">
                        English
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="mt-8 sm:mt-10 sm:mx-auto w-full max-w-md">

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-400 bg-red-50 px-4 py-3 text-red-700 shadow-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="glass-effect py-8 px-6 sm:py-10 sm:px-8 shadow-2xl rounded-2xl sm:rounded-3xl relative overflow-hidden">
                <!-- Decorative gradient corner -->
                <div class="absolute top-0 right-0 w-32 h-32 sm:w-40 sm:h-40 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-10 transform translate-x-16 sm:translate-x-20 -translate-y-16 sm:-translate-y-20"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-tr from-indigo-400 to-purple-600 rounded-full opacity-10 transform -translate-x-12 sm:-translate-x-16 translate-y-12 sm:translate-y-16"></div>

                <div class="relative z-10">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-1 sm:mb-2">Welcome Back</h3>
                    <p class="text-blue-100 text-xs sm:text-sm mb-6 sm:mb-8">Sign in to access your dashboard</p>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Username Field -->
                        <div class="relative mb-5 sm:mb-6">
                            <div class="relative">
                                <input placeholder=" " id="username" name="username" type="text"
                                    {{-- value="{{ old('username', 'superadmin') }}"  --}}
                                    required
                                    class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-6 text-slate-900 input-glass border-2 border-white border-opacity-30 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400 text-sm sm:text-base" />
                                <label for="username"
                                    class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200 peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2 peer-focus:text-xs peer-focus:text-blue-600 peer-[:not(:placeholder-shown)]:top-1.5 sm:peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-600 font-medium">
                                    {{ __('login.username') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('username')
                                <div class="mt-2 flex items-center text-red-400 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="relative mb-4 sm:mb-4">
                            <div class="relative">
                                <input value="" placeholder=" " id="password" name="password" type="password"
                                    required
                                    class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-6 text-slate-900 input-glass border-2 border-white border-opacity-30 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400 text-sm sm:text-base" />
                                <label for="password"
                                    class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200 peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2 peer-focus:text-xs peer-focus:text-blue-600 peer-[:not(:placeholder-shown)]:top-1.5 sm:peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-600 font-medium">
                                    {{ __('login.password') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center">
                                    <button type="button" onclick="togglePassword()"
                                        class="text-slate-500 hover:text-slate-700 transition-colors duration-200 focus:outline-none">
                                        <svg id="eye-open" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg id="eye-closed" class="w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="mt-2 flex items-center text-red-400 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-5 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                            <div class="flex items-center">
                                <input id="remember_token" value="true" type="checkbox" name="remember_me"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-white border-opacity-50 rounded transition duration-150 ease-in-out cursor-pointer" />
                                <label for="remember_token" class="ml-2 block text-xs sm:text-sm text-blue-100 cursor-pointer select-none">
                                    {{ __('login.remember_me') }}
                                </label>
                            </div>
                            {{-- <div class="text-xs sm:text-sm">
                                <a href="#" class="font-medium text-blue-300 hover:text-blue-200 transition duration-150 ease-in-out">
                                    {{ __('login.forgot_pass') }}
                                </a>
                            </div> --}}
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3 sm:mb-4">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-3 sm:py-4 px-6 border border-transparent text-sm sm:text-base font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 btn-hover transition-all duration-200 shadow-lg active:scale-95">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('login.sign_in_button') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-6 text-center px-4">
                <p class="text-xs sm:text-sm text-slate-300">
                    © 2025 Defect Management System. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.01)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>

</html>