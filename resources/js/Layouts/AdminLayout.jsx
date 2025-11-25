import { Head, Link, useForm } from '@inertiajs/react';

export default function AdminLayout({ children, title = 'Admin Panel' }) {
    const { post } = useForm();

    const logout = () => {
        post(route('logout'));
    };

    return (
        <>
            <Head title={title} />
            <div className="min-h-screen flex bg-gray-50">
                {/* Sidebar */}
                <aside className="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white shadow-lg">
                    <div className="flex items-center h-16 bg-blue-600 px-4">
                        <h1 className="text-xl font-bold text-white">AgroWaste Admin</h1>
                    </div>
                    <nav className="flex flex-col h-full">
                        <div className="flex-1 px-4 mt-6">
                            <div className="space-y-1">
                                <Link 
                                    href={route('admin.dashboard')} 
                                    className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${route().current('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'} transition-colors`}
                                >
                                    <span className="mr-3 text-lg">📊</span>
                                    Dashboard
                                </Link>
                                <Link 
                                    href={route('admin.modules.index')} 
                                    className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${route().current('admin.modules.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'} transition-colors`}
                                >
                                    <span className="mr-3 text-lg">📚</span>
                                    Modules
                                </Link>
                                <Link 
                                    href={route('admin.videos.index')} 
                                    className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${route().current('admin.videos.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'} transition-colors`}
                                >
                                    <span className="mr-3 text-lg">🎬</span>
                                    Videos
                                </Link>
                                <Link 
                                    href={route('admin.quizzes.index')} 
                                    className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${route().current('admin.quizzes.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'} transition-colors`}
                                >
                                    <span className="mr-3 text-lg">📝</span>
                                    Quizzes
                                </Link>
                                <Link 
                                    href={route('admin.users.index')} 
                                    className={`group flex items-center px-2 py-2 text-sm font-medium rounded-md ${route().current('admin.users.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'} transition-colors`}
                                >
                                    <span className="mr-3 text-lg">👥</span>
                                    Users
                                </Link>
                            </div>
                        </div>
                        <div className="px-4 py-4 border-t border-gray-200">
                            <span className="block text-sm text-gray-500 mb-2">Admin</span>
                            <button 
                                onClick={logout}
                                className="w-full text-left text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md transition-colors"
                            >
                                Logout
                            </button>
                        </div>
                    </nav>
                </aside>

                {/* Main content */}
                <div className="flex-1 lg:ml-64">
                    <main>
                        <div className="py-6">
                            <div className="px-4 sm:px-6 lg:px-8">
                                {children}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
