import LearningLayout from '@/Layouts/LearningLayout';
import { Head, Link } from '@inertiajs/react';

export default function Home({ totalCourses, completedCourses, activeCourses, courses, auth }) {
    return (
        <LearningLayout>
            <Head title="Home - AgroWaste Academy" />
            <Hero auth={auth} totalCourses={totalCourses} completedCourses={completedCourses} />
            <MetricsBar />
            <Reasons />
            <Features />
            <RecentCourses courses={courses} />
            <Cta />
        </LearningLayout>
    );
}

function Hero({ auth, totalCourses, completedCourses }) {
    const greetingTime = () => {
        const hour = new Date().getHours();
        if (hour < 12) return 'Selamat Pagi';
        if (hour < 15) return 'Selamat Siang';
        if (hour < 18) return 'Selamat Sore';
        return 'Selamat Malam';
    };

    return (
        <section className="relative isolate overflow-hidden">
            <div className="bg-gradient-to-br from-green-700 via-green-600 to-yellow-600 text-white px-8 pt-16 pb-24">
                <div className="max-w-6xl mx-auto">
                    <div className="flex items-center gap-2 text-yellow-300 text-sm mb-6">
                        🌱 <span className="text-white/90">AgroWaste Academy</span>
                    </div>
                    <h1 className="text-5xl md:text-6xl font-bold leading-tight mb-4">
                        Kelola Limbah Pertanian, <span className="text-yellow-400">Tingkatkan Nilai Ekonomi</span>
                    </h1>
                    <p className="text-lg text-white/90 max-w-2xl mb-8">
                        Platform edukasi untuk petani modern. Pelajari cara mengolah limbah pertanian menjadi produk bernilai ekonomi tinggi.
                    </p>
                    
                    <div className="flex gap-3">
                        <Link href={route('courses.index')} className="px-6 py-3 bg-yellow-500 hover:bg-yellow-400 text-neutral-900 font-bold text-sm rounded-lg shadow-lg">
                            Mulai Belajar →
                        </Link>
                        <Link href={route('courses.index')} className="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white font-medium text-sm rounded-lg border border-white/30">
                            Lihat Courses
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    );
}

function MetricsBar() {
    return (
        <div className="bg-white">
            <div className="max-w-6xl mx-auto px-8 py-12">
                <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <p className="text-4xl font-bold text-green-900 mb-2">500+</p>
                        <p className="text-sm text-gray-600">Petani Tergabung</p>
                    </div>
                    <div>
                        <p className="text-4xl font-bold text-green-900 mb-2">50+</p>
                        <p className="text-sm text-gray-600">Modul Pembelajaran</p>
                    </div>
                    <div>
                        <p className="text-4xl font-bold text-green-900 mb-2">100+</p>
                        <p className="text-sm text-gray-600">Video Tutorial</p>
                    </div>
                    <div>
                        <p className="text-4xl font-bold text-green-900 mb-2">95%</p>
                        <p className="text-sm text-gray-600">Kepuasan Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    );
}



function RecentCourses({ courses }) {
    if (!courses || courses.length === 0) return null;

    return (
        <section className="px-8 py-16 bg-white">
            <div className="max-w-6xl mx-auto">
                <div className="flex items-center justify-between mb-8">
                    <div>
                        <h2 className="text-2xl font-bold text-gray-900">Course Populer</h2>
                        <p className="text-sm text-gray-600 mt-1">Mulai belajar dari course terpopuler</p>
                    </div>
                    <Link href={route('courses.index')} className="text-sm font-medium text-green-600 hover:text-green-700">
                        Lihat Semua →
                    </Link>
                </div>
                <div className="grid md:grid-cols-3 gap-6">
                    {courses.map((course, index) => {
                        return (
                            <div key={course.id} className="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow overflow-hidden group">
                                <div className="relative h-40 bg-gradient-to-br from-green-400 to-blue-500">
                                    {course.thumbnail ? (
                                        <img src={course.thumbnail} alt={course.title} className="w-full h-full object-cover" />
                                    ) : (
                                        <div className="absolute inset-0 flex items-center justify-center text-white text-5xl font-bold opacity-20">
                                            {course.title.charAt(0)}
                                        </div>
                                    )}
                                    <div className="absolute top-3 right-3 bg-white px-3 py-1 rounded-full text-xs font-medium capitalize shadow">
                                        {course.level}
                                    </div>
                                </div>
                                <div className="p-5">
                                    <h3 className="font-bold text-base text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                        {course.title}
                                    </h3>
                                    <p className="text-xs text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                        {course.description}
                                    </p>
                                    <div className="flex items-center justify-between text-xs text-gray-500 mb-4">
                                        <span className="flex items-center gap-1">
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {course.total_contents} modul
                                        </span>
                                        <span className="flex items-center gap-1">
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {course.duration_minutes} menit
                                        </span>
                                    </div>
                                    
                                    <Link href={route('courses.show', course.id)} className="block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        Lihat Detail
                                    </Link>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}

function Features() {
    const items = [
        { icon: '📚', iconBg: 'bg-green-600', title: 'Modul Pembelajaran', desc: 'Materi lengkap tentang pengelolaan limbah pertanian dari ahli' },
        { icon: '🎬', iconBg: 'bg-orange-600', title: 'Video Tutorial', desc: 'Tutorial praktis dan mudah dipahami untuk petani' },
        { icon: '🏆', iconBg: 'bg-red-600', title: 'Quiz Interaktif', desc: 'Uji pemahaman dengan kuis dan dapatkan sertifikat' },
    ];
    
    return (
        <section className="px-8 py-20 bg-white">
            <div className="max-w-6xl mx-auto">
                <div className="text-center mb-12">
                    <h2 className="text-3xl font-bold mb-3">Fitur Pembelajaran</h2>
                    <p className="text-sm text-gray-600">Berbagai metode pembelajaran yang dirancang khusus untuk petani Indonesia</p>
                </div>
                <div className="grid md:grid-cols-3 gap-8">
                    {items.map(item => (
                        <div key={item.title} className="text-center">
                            <div className={`w-16 h-16 ${item.iconBg} rounded-xl mx-auto mb-4 flex items-center justify-center text-3xl text-white shadow-lg`}>{item.icon}</div>
                            <h3 className="font-bold text-lg mb-2">{item.title}</h3>
                            <p className="text-sm text-gray-600 leading-relaxed">{item.desc}</p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

function Reasons() {
    const reasons = [
        { icon: '✅', iconBg: 'bg-green-600', title: 'Meningkatkan Pendapatan', desc: 'Ubah limbah menjadi produk bernilai seperti kompos, pupuk organik, dan biogas' },
        { icon: '♻️', iconBg: 'bg-orange-600', title: 'Ramah Lingkungan', desc: 'Kurangi pencemaran dan jaga kesuburan tanah untuk generasi mendatang' },
        { icon: '🌿', iconBg: 'bg-orange-500', title: 'Pertanian Berkelanjutan', desc: 'Terapkan praktik pertanian modern yang efisien dan berkelanjutan' },
    ];
    
    return (
        <section className="px-8 py-20 bg-gradient-to-b from-green-50/50 to-white">
            <div className="max-w-6xl mx-auto">
                <div className="text-center mb-12">
                    <h2 className="text-3xl font-bold mb-3">Mengapa Mengelola Limbah Pertanian?</h2>
                </div>
                <div className="grid md:grid-cols-2 gap-12 items-center">
                    <div className="rounded-2xl overflow-hidden shadow-xl">
                        <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=700&h=500&fit=crop" alt="Pertanian Jagung" className="w-full h-80 object-cover" />
                    </div>
                    <div className="space-y-6">
                        {reasons.map(reason => (
                            <div key={reason.title} className="flex items-start gap-4">
                                <div className={`w-12 h-12 rounded-lg ${reason.iconBg} text-white flex items-center justify-center text-xl flex-shrink-0`}>{reason.icon}</div>
                                <div>
                                    <p className="font-bold text-base mb-2">{reason.title}</p>
                                    <p className="text-sm text-gray-600 leading-relaxed">{reason.desc}</p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}

function Cta() {
    return (
        <section className="py-24 bg-gradient-to-br from-green-700 via-green-600 to-yellow-600 text-white text-center relative overflow-hidden">
            <div className="absolute inset-0 bg-black/10"></div>
            <div className="relative z-10 max-w-3xl mx-auto px-8">
                <h2 className="text-4xl font-bold mb-4">Siap Meningkatkan Nilai Pertanian Anda?</h2>
                <p className="text-base max-w-2xl mx-auto mb-8 leading-relaxed text-white/90">
                    Bergabunglah dengan ratusan petani yang telah merasakan manfaat pengelolaan limbah pertanian
                </p>
                <Link href={route('courses.index')} className="inline-block bg-white text-green-700 px-8 py-3 rounded-lg text-sm font-bold shadow-xl hover:bg-green-50 transform hover:scale-105 transition">
                    Mulai Sekarang Gratis
                </Link>
            </div>
        </section>
    );
}
