import { Head, Link, useForm } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function ProfileEdit({ auth, stats, courseProgress, activities, achievements }) {
    const { data, setData, put, processing, errors } = useForm({
        name: auth.user.name,
        email: auth.user.email,
        phone: auth.user.phone || '',
        address: auth.user.address || '',
    });

    const [activeTab, setActiveTab] = useState('course');

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('profile.update'));
    };

    return (
        <LearningLayout>
            <Head title="Profil Saya - AgroWaste Academy" />
            
            <div className="bg-white min-h-screen">
                <div className="max-w-6xl mx-auto px-8 py-8">
                    <div className="flex items-center justify-between mb-6">
                        <h1 className="text-2xl font-bold text-gray-900">Profil Saya</h1>
                        <Link href={route('home')} className="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali Ke Beranda
                        </Link>
                    </div>

                    <div className="grid lg:grid-cols-3 gap-6">
                        {/* Left Column - Profile Info */}
                        <div className="lg:col-span-1">
                            <div className="bg-white border-2 border-gray-200 rounded-lg p-6">
                                {/* Avatar */}
                                <div className="flex flex-col items-center mb-6">
                                    <div className="w-24 h-24 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white text-3xl font-bold mb-3">
                                        {auth.user.name.substring(0, 2).toUpperCase()}
                                    </div>
                                    <h2 className="text-xl font-bold text-gray-900">{auth.user.name}</h2>
                                    <p className="text-sm text-gray-600">{auth.user.email}</p>
                                    <div className="flex items-center gap-1 text-xs text-gray-500 mt-2">
                                        <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Bergabung sejak {new Date(auth.user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                                    </div>
                                </div>

                                {/* Stats */}
                                <div className="space-y-3 mb-6">
                                    <div className="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                        <div className="flex items-center gap-2">
                                            <div className="w-8 h-8 rounded bg-green-600 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                                </svg>
                                            </div>
                                            <span className="text-sm font-medium text-gray-700">Course Selesai</span>
                                        </div>
                                        <span className="text-lg font-bold text-green-700">{stats.completedCourses}</span>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <div className="flex items-center gap-2">
                                            <div className="w-8 h-8 rounded bg-blue-600 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                                </svg>
                                            </div>
                                            <span className="text-sm font-medium text-gray-700">Nilai Rata-rata Quiz</span>
                                        </div>
                                        <span className="text-lg font-bold text-blue-700">{stats.averageQuizScore}%</span>
                                    </div>
                                </div>

                                {/* Pencapaian */}
                                <div className="border-t pt-4">
                                    <h3 className="text-sm font-semibold text-gray-900 mb-3">Pencapaian</h3>
                                    {achievements.length > 0 ? (
                                        <div className="space-y-2">
                                            {achievements.map((achievement, index) => (
                                                <div key={index} className="flex items-center gap-2 text-sm">
                                                    <svg className={`w-5 h-5 ${achievement.unlocked ? 'text-yellow-500' : 'text-gray-300'}`} fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <div>
                                                        <p className={`font-medium ${achievement.unlocked ? 'text-gray-900' : 'text-gray-500'}`}>
                                                            {achievement.title}
                                                        </p>
                                                        <p className={`text-xs ${achievement.unlocked ? 'text-gray-500' : 'text-gray-400'}`}>
                                                            {achievement.description}
                                                        </p>
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    ) : (
                                        <div className="text-center py-4 text-gray-500">
                                            <p className="text-sm">Belum ada pencapaian. Mulai belajar untuk mendapatkan badge!</p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Right Column - Progress & Activity */}
                        <div className="lg:col-span-2">
                            <div className="bg-white border-2 border-gray-200 rounded-lg">
                                {/* Tabs */}
                                <div className="border-b">
                                    <div className="flex">
                                        <button
                                            onClick={() => setActiveTab('course')}
                                            className={`px-6 py-3 font-medium text-sm border-b-2 transition ${
                                                activeTab === 'course'
                                                    ? 'border-green-600 text-green-600'
                                                    : 'border-transparent text-gray-600 hover:text-gray-900'
                                            }`}
                                        >
                                            Progress Course
                                        </button>
                                        <button
                                            onClick={() => setActiveTab('aktivitas')}
                                            className={`px-6 py-3 font-medium text-sm border-b-2 transition ${
                                                activeTab === 'aktivitas'
                                                    ? 'border-green-600 text-green-600'
                                                    : 'border-transparent text-gray-600 hover:text-gray-900'
                                            }`}
                                        >
                                            Aktivitas Terakhir
                                        </button>
                                    </div>
                                </div>

                                {/* Tab Content */}
                                <div className="p-6">
                                    {activeTab === 'course' && (
                                        <div className="space-y-4">
                                            {courseProgress.length > 0 ? (
                                                courseProgress.map((item) => (
                                                    <div key={item.id} className="border-b pb-4 last:border-0">
                                                        <div className="flex items-start justify-between mb-2">
                                                            <div className="flex-1">
                                                                <Link href={route('courses.show', item.id)} className="font-semibold text-gray-900 hover:text-green-600">
                                                                    {item.title}
                                                                </Link>
                                                                <div className="flex items-center gap-2 mt-1">
                                                                    <span className={`text-xs px-2 py-0.5 rounded-full ${
                                                                        item.progress === 100
                                                                            ? 'bg-green-100 text-green-700' 
                                                                            : item.progress > 0
                                                                                ? 'bg-orange-100 text-orange-700'
                                                                                : 'bg-gray-100 text-gray-700'
                                                                    }`}>
                                                                        {item.progress === 100 ? 'Selesai' : item.progress > 0 ? 'Sedang Berjalan' : 'Belum Dimulai'}
                                                                    </span>
                                                                    <span className="text-xs text-gray-500">
                                                                        {item.completedContents}/{item.totalContents} lessons
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <span className="text-sm font-bold text-gray-900">{Math.round(item.progress)}%</span>
                                                        </div>
                                                        <div className="w-full bg-gray-200 rounded-full h-2">
                                                            <div 
                                                                className={`h-2 rounded-full ${
                                                                    item.progress === 100
                                                                        ? 'bg-green-600' 
                                                                        : 'bg-orange-500'
                                                                }`}
                                                                style={{ width: `${item.progress}%` }}
                                                            ></div>
                                                        </div>
                                                    </div>
                                                ))
                                            ) : (
                                                <div className="text-center py-8 text-gray-500">
                                                    <svg className="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    <p className="font-medium">Belum ada course yang diambil</p>
                                                    <Link href={route('courses.index')} className="inline-block mt-3 text-green-600 hover:text-green-700 font-medium">
                                                        Jelajahi Course →
                                                    </Link>
                                                </div>
                                            )}
                                        </div>
                                    )}

                                    {activeTab === 'aktivitas' && (
                                        <div>
                                            <div className="flex items-center gap-2 mb-4">
                                                <svg className="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <h3 className="font-semibold text-gray-900">Aktivitas Terakhir</h3>
                                            </div>
                                            <div className="space-y-3">
                                                {activities.map((activity, index) => (
                                                    <div key={index} className="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                                        <div className="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                                            <svg className="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div className="flex-1">
                                                            <p className="text-sm font-medium text-gray-900">{activity.action}</p>
                                                            <p className="text-xs text-gray-600">{activity.description}</p>
                                                            <p className="text-xs text-gray-500 mt-1">{activity.time}</p>
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </LearningLayout>
    );
}
