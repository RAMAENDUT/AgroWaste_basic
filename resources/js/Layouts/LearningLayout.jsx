import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export default function LearningLayout({ children }) {
    const { auth } = usePage().props;
    const { post } = useForm();
    const [sidebarOpen, setSidebarOpen] = useState(false);

    // Persist sidebar state in localStorage
    useEffect(() => {
        const savedState = localStorage.getItem('sidebarOpen');
        if (savedState !== null) {
            setSidebarOpen(savedState === 'true');
        }
    }, []);

    const toggleSidebar = () => {
        const newState = !sidebarOpen;
        setSidebarOpen(newState);
        localStorage.setItem('sidebarOpen', newState.toString());
    };

    const logout = () => {
        post(route('logout'));
    };

    return (
        <>
            <Head title="AgroWaste Academy" />
            <div className="min-h-screen flex bg-neutral-900">
                {/* Sidebar */}
                <aside className={`fixed top-0 left-0 h-screen transition-all duration-300 z-40 ${
                    sidebarOpen ? 'w-60' : 'w-16'
                } hidden md:flex flex-col bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-green-50 shadow-xl overflow-hidden`}>
                    {/* Header */}
                    <div className={`px-5 pt-6 pb-4 border-b border-green-700/40 ${!sidebarOpen && 'px-2'}`}>
                        <Link href={route('home')} className={`flex items-center gap-2 font-semibold ${!sidebarOpen && 'justify-center'}`}>
                            <span className="w-8 h-8 flex items-center justify-center rounded-md bg-yellow-500 text-neutral-900 text-lg flex-shrink-0">🌱</span>
                            {sidebarOpen && (
                                <span className="leading-tight whitespace-nowrap overflow-hidden">
                                    <span>AgroWaste</span><br />
                                    <span className="text-[10px] font-normal text-green-200">Academy</span>
                                </span>
                            )}
                        </Link>
                    </div>

                    {/* Navigation */}

                    <nav className={`flex-1 py-4 space-y-1 text-sm overflow-y-auto ${sidebarOpen ? 'px-2' : 'px-1'}`}>
                        <Link 
                            href={route('home')} 
                            className={`flex items-center gap-3 py-2.5 rounded-md transition ${
                                route().current('home') ? 'bg-green-600 text-white shadow' : 'text-green-100 hover:bg-green-700/50'
                            } ${sidebarOpen ? 'px-3' : 'px-2 justify-center'}`}
                            title={!sidebarOpen ? 'Home' : ''}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            {sidebarOpen && <span className="whitespace-nowrap">Home</span>}
                        </Link>
                        <Link 
                            href={route('modules.index')} 
                            className={`flex items-center gap-3 py-2.5 rounded-md transition ${
                                route().current('modules.*') ? 'bg-green-600 text-white shadow' : 'text-green-100 hover:bg-green-700/50'
                            } ${sidebarOpen ? 'px-3' : 'px-2 justify-center'}`}
                            title={!sidebarOpen ? 'Modul' : ''}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            {sidebarOpen && <span className="whitespace-nowrap">Modul</span>}
                        </Link>
                        <Link 
                            href={route('videos.index')} 
                            className={`flex items-center gap-3 py-2.5 rounded-md transition ${
                                route().current('videos.*') ? 'bg-green-600 text-white shadow' : 'text-green-100 hover:bg-green-700/50'
                            } ${sidebarOpen ? 'px-3' : 'px-2 justify-center'}`}
                            title={!sidebarOpen ? 'Video' : ''}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            {sidebarOpen && <span className="whitespace-nowrap">Video</span>}
                        </Link>
                        <Link 
                            href={route('quizzes.index')} 
                            className={`flex items-center gap-3 py-2.5 rounded-md transition ${
                                route().current('quizzes.*') ? 'bg-green-600 text-white shadow' : 'text-green-100 hover:bg-green-700/50'
                            } ${sidebarOpen ? 'px-3' : 'px-2 justify-center'}`}
                            title={!sidebarOpen ? 'Quiz' : ''}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {sidebarOpen && <span className="whitespace-nowrap">Quiz</span>}
                        </Link>
                        <Link 
                            href={route('profile.edit')} 
                            className={`flex items-center gap-3 py-2.5 rounded-md transition ${
                                route().current('profile.*') ? 'bg-green-600 text-white shadow' : 'text-green-100 hover:bg-green-700/50'
                            } ${sidebarOpen ? 'px-3' : 'px-2 justify-center'}`}
                            title={!sidebarOpen ? 'Profil' : ''}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {sidebarOpen && <span className="whitespace-nowrap">Profil</span>}
                        </Link>
                    </nav>
                    <div className={`mt-auto space-y-3 text-[11px] ${sidebarOpen ? 'p-4' : 'p-2'}`}>
                        {sidebarOpen && (
                            <div className="bg-green-700/40 rounded-md p-3 leading-relaxed">
                                Platform edukasi untuk mengelola limbah pertanian menjadi produk bernilai ekonomi tinggi
                            </div>
                        )}
                        <button 
                            onClick={logout}
                            className={`w-full py-2 rounded-md border border-green-600 text-green-100 hover:bg-green-600/20 text-xs flex items-center gap-2 justify-center transition ${
                                sidebarOpen ? 'px-3' : 'px-2'
                            }`}
                            title={!sidebarOpen ? 'Logout' : ''}
                        >
                            <svg className="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {sidebarOpen && <span>Logout</span>}
                        </button>
                    </div>
                </aside>

                {/* Toggle Button - Fixed on Main Content */}
                <button
                    onClick={toggleSidebar}
                    className={`hidden md:flex fixed top-6 z-50 w-10 h-10 bg-green-600 hover:bg-green-500 rounded-r-lg shadow-lg items-center justify-center text-white transition-all duration-300 ${
                        sidebarOpen ? 'left-60' : 'left-16'
                    }`}
                    title={sidebarOpen ? 'Tutup Sidebar' : 'Buka Sidebar'}
                >
                    <svg 
                        className={`w-5 h-5 transition-transform duration-300 ${!sidebarOpen && 'rotate-180'}`} 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                {/* Main Content */}
                <main className={`flex-1 bg-neutral-50 overflow-y-auto transition-all duration-300 ${
                    sidebarOpen ? 'md:ml-60' : 'md:ml-16'
                }`}>
                    {children}
                </main>
            </div>
        </>
    );
}
