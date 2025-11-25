import { Head, Link, router } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function ModulesIndex({ modules, userProgress, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [filter, setFilter] = useState(filters.filter || 'semua');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('modules.index'), { search, filter }, { preserveState: true });
    };

    const handleFilterChange = (newFilter) => {
        setFilter(newFilter);
        router.get(route('modules.index'), { search, filter: newFilter }, { preserveState: true });
    };

    const getLevelBadge = (level) => {
        const badges = {
            'pemula': { bg: 'bg-blue-100', text: 'text-blue-700', label: 'Pemula' },
            'menengah': { bg: 'bg-yellow-100', text: 'text-yellow-700', label: 'Menengah' },
            'lanjutan': { bg: 'bg-red-100', text: 'text-red-700', label: 'Lanjutan' },
        };
        return badges[level] || badges['pemula'];
    };

    return (
        <LearningLayout>
            <Head title="Modul Pembelajaran - AgroWaste Academy" />
            
            {/* Header */}
            <div className="bg-gradient-to-br from-green-700 via-green-600 to-green-500 text-white px-8 py-12">
                <div className="max-w-6xl mx-auto">
                    <h1 className="text-4xl font-bold mb-3">Modul Pembelajaran</h1>
                    <p className="text-lg text-white/90">
                        Jelajahi berbagai modul tentang pengelolaan limbah pertanian
                    </p>
                </div>
            </div>

            {/* Search & Filter Bar */}
            <div className="bg-white border-b sticky top-0 z-10 shadow-sm">
                <div className="max-w-6xl mx-auto px-8 py-4">
                    <form onSubmit={handleSearch} className="flex items-center gap-4">
                        <div className="flex-1 relative">
                            <svg className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                placeholder="Cari modul pembelajaran..."
                                className="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            />
                        </div>
                        <button
                            type="button"
                            className="p-2.5 border border-gray-300 rounded-lg hover:bg-gray-50"
                        >
                            <svg className="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterChange('semua')}
                            className={`px-6 py-2.5 font-medium rounded-lg transition ${filter === 'semua' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'}`}
                        >
                            Semua
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterChange('pemula')}
                            className={`px-6 py-2.5 font-medium rounded-lg transition ${filter === 'pemula' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'}`}
                        >
                            Pemula
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterChange('menengah')}
                            className={`px-6 py-2.5 font-medium rounded-lg transition ${filter === 'menengah' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'}`}
                        >
                            Menengah
                        </button>
                        <button
                            type="button"
                            onClick={() => handleFilterChange('lanjutan')}
                            className={`px-6 py-2.5 font-medium rounded-lg transition ${filter === 'lanjutan' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'}`}
                        >
                            Lanjutan
                        </button>
                    </form>
                </div>
            </div>

            {/* Module Cards */}
            <div className="bg-gradient-to-b from-green-50/50 to-white min-h-screen">
                <div className="max-w-6xl mx-auto px-8 py-8">
                    <h2 className="text-xl font-bold text-gray-900 mb-6">
                        {modules.length} Modul Tersedia
                    </h2>

                    {modules.length > 0 ? (
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {modules.map((module) => {
                                const progress = userProgress[module.id];
                                const levelBadge = getLevelBadge(module.level);
                                const isCompleted = progress?.completed_at;

                                return (
                                    <div key={module.id} className="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 hover:shadow-lg transition group">
                                        {/* Thumbnail */}
                                        <div className="relative h-44 overflow-hidden">
                                            {module.thumbnail ? (
                                                <img
                                                    src={module.thumbnail}
                                                    alt={module.title}
                                                    className="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                                />
                                            ) : (
                                                <div className="w-full h-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                                    <svg className="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                            )}
                                            {/* Level Badge */}
                                            <div className={`absolute top-3 left-3 px-3 py-1 ${levelBadge.bg} ${levelBadge.text} text-xs font-semibold rounded-full`}>
                                                {levelBadge.label}
                                            </div>
                                            {/* Completion Badge */}
                                            {isCompleted && (
                                                <div className="absolute top-3 right-3 bg-green-500 text-white text-xs px-2.5 py-1 rounded-full flex items-center gap-1">
                                                    <svg className="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                    </svg>
                                                    Selesai
                                                </div>
                                            )}
                                        </div>

                                        {/* Content */}
                                        <div className="p-5">
                                            <h3 className="font-bold text-base mb-2 line-clamp-2 group-hover:text-green-600 transition">
                                                {module.title}
                                            </h3>
                                            <p className="text-xs text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                                {module.description}
                                            </p>

                                            {/* Meta Info */}
                                            <div className="flex items-center gap-4 mb-4 text-xs text-gray-500">
                                                <div className="flex items-center gap-1.5">
                                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{module.duration_minutes} menit</span>
                                                </div>
                                                <div className="flex items-center gap-1.5">
                                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span>Materi Lengkap</span>
                                                </div>
                                            </div>

                                            {/* Action Button */}
                                            <Link
                                                href={route('modules.show', module.slug)}
                                                className="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2.5 rounded-lg font-semibold text-sm transition"
                                            >
                                                {progress?.started ? 'Lanjutkan' : 'Mulai Belajar'}
                                            </Link>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="text-center py-16 bg-white rounded-lg border border-gray-200">
                            <svg className="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p className="text-gray-600 mb-4">Tidak ada modul yang sesuai dengan pencarian Anda</p>
                            <button
                                onClick={() => {
                                    setSearch('');
                                    setFilter('semua');
                                    router.get(route('modules.index'));
                                }}
                                className="text-green-600 hover:text-green-700 font-medium"
                            >
                                Reset Filter
                            </button>
                        </div>
                    )}
                </div>

                {/* CTA Section */}
                <div className="max-w-6xl mx-auto px-8 pb-12">
                    <div className="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 text-white text-center">
                        <h2 className="text-2xl font-bold mb-3">Butuh Panduan Belajar?</h2>
                        <p className="text-white/90 mb-5">
                            Hubungi mentor kami untuk bantuan pembelajaran yang lebih personal
                        </p>
                        <button className="bg-white text-orange-600 px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-50 transition">
                            Hubungi Mentor
                        </button>
                    </div>
                </div>
            </div>
        </LearningLayout>
    );
}
