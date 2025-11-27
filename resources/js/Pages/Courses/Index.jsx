import { Head, Link } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function CoursesIndex({ courses }) {
    const [search, setSearch] = useState('');
    const [levelFilter, setLevelFilter] = useState('semua');

    // Filter courses
    const filteredCourses = courses.filter(course => {
        const matchSearch = search === '' || 
            course.title.toLowerCase().includes(search.toLowerCase()) ||
            course.description.toLowerCase().includes(search.toLowerCase());
        
        const matchLevel = levelFilter === 'semua' || course.level === levelFilter;

        return matchSearch && matchLevel;
    });

    const getLevelBadgeColor = (level) => {
        switch(level) {
            case 'pemula': return 'bg-green-100 text-green-700';
            case 'menengah': return 'bg-yellow-100 text-yellow-700';
            case 'lanjutan': return 'bg-red-100 text-red-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    };

    return (
        <LearningLayout>
            <Head title="Kursus - AgroWaste Academy" />
            
            {/* Header */}
            <div className="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 text-white px-8 py-12">
                <div className="max-w-6xl mx-auto">
                    <h1 className="text-4xl font-bold mb-3">Kursus Pembelajaran</h1>
                    <p className="text-lg text-white/90 mb-8">
                        Ikuti kursus lengkap dengan materi, video, dan kuis untuk meningkatkan kemampuan Anda
                    </p>
                    
                    {/* Search */}
                    <div className="max-w-xl">
                        <div className="relative">
                            <svg className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                placeholder="Cari kursus..."
                                className="w-full pl-12 pr-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div className="bg-gradient-to-b from-blue-50/30 to-white min-h-screen">
                <div className="max-w-6xl mx-auto px-8 py-8">
                    
                    {/* Filter Buttons */}
                    <div className="flex flex-wrap gap-3 mb-8">
                        <button
                            onClick={() => setLevelFilter('semua')}
                            className={`px-5 py-2.5 rounded-lg font-medium transition ${
                                levelFilter === 'semua'
                                    ? 'bg-blue-600 text-white shadow-md'
                                    : 'bg-white text-gray-700 border border-gray-300 hover:border-blue-400'
                            }`}
                        >
                            Semua Kursus
                        </button>
                        <button
                            onClick={() => setLevelFilter('pemula')}
                            className={`px-5 py-2.5 rounded-lg font-medium transition ${
                                levelFilter === 'pemula'
                                    ? 'bg-green-600 text-white shadow-md'
                                    : 'bg-white text-gray-700 border border-gray-300 hover:border-green-400'
                            }`}
                        >
                            Pemula
                        </button>
                        <button
                            onClick={() => setLevelFilter('menengah')}
                            className={`px-5 py-2.5 rounded-lg font-medium transition ${
                                levelFilter === 'menengah'
                                    ? 'bg-yellow-600 text-white shadow-md'
                                    : 'bg-white text-gray-700 border border-gray-300 hover:border-yellow-400'
                            }`}
                        >
                            Menengah
                        </button>
                        <button
                            onClick={() => setLevelFilter('lanjutan')}
                            className={`px-5 py-2.5 rounded-lg font-medium transition ${
                                levelFilter === 'lanjutan'
                                    ? 'bg-red-600 text-white shadow-md'
                                    : 'bg-white text-gray-700 border border-gray-300 hover:border-red-400'
                            }`}
                        >
                            Lanjutan
                        </button>
                    </div>

                    {/* Courses Grid */}
                    {filteredCourses.length > 0 ? (
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {filteredCourses.map((course) => (
                                <div key={course.id} className="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 hover:shadow-xl transition group">
                                    {/* Thumbnail */}
                                    <div className="relative h-48 overflow-hidden">
                                        {course.thumbnail ? (
                                            <img
                                                src={course.thumbnail}
                                                alt={course.title}
                                                className="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                            />
                                        ) : (
                                            <div className="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600"></div>
                                        )}
                                        <div className="absolute top-3 left-3">
                                            <span className={`${getLevelBadgeColor(course.level)} px-3 py-1 rounded-full text-xs font-semibold uppercase`}>
                                                {course.level}
                                            </span>
                                        </div>
                                        {course.is_enrolled && (
                                            <div className="absolute top-3 right-3 bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                                                <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                </svg>
                                                Terdaftar
                                            </div>
                                        )}
                                    </div>

                                    {/* Content */}
                                    <div className="p-5">
                                        <h3 className="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                            {course.title}
                                        </h3>
                                        <p className="text-sm text-gray-600 mb-4 line-clamp-2">
                                            {course.description}
                                        </p>

                                        {/* Stats */}
                                        <div className="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <div className="flex items-center gap-1">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                <span>{course.total_contents} konten</span>
                                            </div>
                                            <div className="flex items-center gap-1">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{course.duration_hours} jam</span>
                                            </div>
                                        </div>

                                        {/* Progress Bar (if enrolled) */}
                                        {course.is_enrolled && (
                                            <div className="mb-4">
                                                <div className="flex items-center justify-between text-xs text-gray-600 mb-1">
                                                    <span>Progress</span>
                                                    <span className="font-semibold">{course.progress_percentage}%</span>
                                                </div>
                                                <div className="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div 
                                                        className="h-full bg-blue-600 rounded-full transition-all duration-300"
                                                        style={{ width: `${course.progress_percentage}%` }}
                                                    ></div>
                                                </div>
                                            </div>
                                        )}

                                        {/* Action Button */}
                                        {course.is_enrolled ? (
                                            <Link
                                                href={route('courses.show', course.id)}
                                                className="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2.5 rounded-lg font-medium transition"
                                            >
                                                Lanjutkan Belajar
                                            </Link>
                                        ) : (
                                            <Link
                                                href={route('courses.enroll', course.id)}
                                                method="post"
                                                as="button"
                                                className="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2.5 rounded-lg font-medium transition"
                                            >
                                                Enroll Sekarang
                                            </Link>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-16 bg-white rounded-lg border border-gray-200">
                            <svg className="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p className="text-gray-600 mb-4">Tidak ada kursus yang sesuai dengan pencarian</p>
                        </div>
                    )}

                </div>
            </div>
        </LearningLayout>
    );
}
