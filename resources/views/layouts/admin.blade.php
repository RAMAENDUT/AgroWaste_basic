<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - AgroWaste Academy')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white shadow-lg">
            <div class="flex items-center h-16 bg-blue-600 px-4">
                <h1 class="text-xl font-bold text-white">AgroWaste Admin</h1>
            </div>
            <nav class="flex flex-col h-full">
                <div class="flex-1 px-4 mt-6">
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                            <span class="mr-3 text-lg">📊</span>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.modules.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('admin/modules*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                            <span class="mr-3 text-lg">📚</span>
                            Modules
                        </a>
                        <a href="{{ route('admin.videos.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('admin/videos*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                            <span class="mr-3 text-lg">🎬</span>
                            Videos
                        </a>
                        <a href="{{ route('admin.quizzes.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('admin/quizzes*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                            <span class="mr-3 text-lg">📝</span>
                            Quizzes
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('admin/users*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                            <span class="mr-3 text-lg">👥</span>
                            Users
                        </a>
                    </div>
                </div>
                <div class="px-4 py-4 border-t border-gray-200">
                    <span class="block text-sm text-gray-500 mb-2">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 lg:ml-64">
            <!-- Mobile header -->
            <div class="bg-white shadow-sm border-b border-gray-200 lg:hidden">
                <div class="px-4 sm:px-6">
                    <div class="flex justify-between items-center py-4">
                        <h2 class="text-lg font-semibold text-gray-900">@yield('title', 'Admin Panel')</h2>
                        <button onclick="toggleMobileMenu()" class="text-gray-500 focus:outline-none">
                            <span class="text-2xl">☰</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main>
                <div class="py-6">
                    <div class="px-4 sm:px-6 lg:px-8">
                        @if(session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobileMenu" class="hidden lg:hidden fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
        <div class="flex items-center h-16 bg-blue-600 px-4">
            <h1 class="text-xl font-bold text-white flex-1">AgroWaste Admin</h1>
            <button onclick="toggleMobileMenu()" class="text-white focus:outline-none">
                <span class="text-2xl">✕</span>
            </button>
        </div>
        <nav class="flex flex-col h-full">
            <div class="flex-1 px-4 mt-6">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="mr-3 text-lg">📊</span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.modules.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="mr-3 text-lg">📚</span>
                        Modules
                    </a>
                    <a href="{{ route('admin.videos.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="mr-3 text-lg">🎬</span>
                        Videos
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="mr-3 text-lg">📝</span>
                        Quizzes
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="mr-3 text-lg">👥</span>
                        Users
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>
</body>
</html>
