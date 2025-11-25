import { Head, Link, useForm } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function ProfileEdit({ auth, stats, moduleProgress, videoProgress, quizProgress, activities }) {
    const { data, setData, put, processing, errors } = useForm({
        name: auth.user.name,
        email: auth.user.email,
        phone: auth.user.phone || '',
        address: auth.user.address || '',
    });

    const [activeTab, setActiveTab] = useState('modul');

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
                                            <span className="text-sm font-medium text-gray-700">Modul Selesai</span>
                                        </div>
                                        <span className="text-lg font-bold text-green-700">{stats.completedModules}</span>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                                        <div className="flex items-center gap-2">
                                            <div className="w-8 h-8 rounded bg-orange-600 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                </svg>
                                            </div>
                                            <span className="text-sm font-medium text-gray-700">Video Ditonton</span>
                                        </div>
                                        <span className="text-lg font-bold text-orange-700">{stats.completedVideos}</span>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                        <div className="flex items-center gap-2">
                                            <div className="w-8 h-8 rounded bg-yellow-600 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fillRule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                </svg>
                                            </div>
                                            <span className="text-sm font-medium text-gray-700">Quiz Lulus</span>
                                        </div>
                                        <span className="text-lg font-bold text-yellow-700">{stats.passedQuizzes}</span>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <div className="flex items-center gap-2">
                                            <div className="w-8 h-8 rounded bg-blue-600 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                                </svg>
                                            </div>
                                            <span className="text-sm font-medium text-gray-700">Nilai Rata-rata</span>
                                        </div>
                                        <span className="text-lg font-bold text-blue-700">{stats.averageScore}%</span>
                                    </div>
                                </div>

                                {/* Pencapaian */}
                                <div className="border-t pt-4">
                                    <h3 className="text-sm font-semibold text-gray-900 mb-3">Pencapaian</h3>
                                    <div className="space-y-2">
                                        <div className="flex items-center gap-2 text-sm">
                                            <svg className="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <div>
                                                <p className="font-medium text-gray-900">Pemula Aktif</p>
                                                <p className="text-xs text-gray-500">Selesaikan 3 modul pertama</p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-2 text-sm">
                                            <svg className="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <div>
                                                <p className="font-medium text-gray-500">Pemenang Sertif</p>
                                                <p className="text-xs text-gray-400">Dapatkan 3 sertifikat (0/3 saat ini)</p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-2 text-sm">
                                            <svg className="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <div>
                                                <p className="font-medium text-gray-500">Master Quiz</p>
                                                <p className="text-xs text-gray-400">Selesaikan semua quiz dengan nilai 100%</p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-2 text-sm">
                                            <svg className="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <div>
                                                <p className="font-medium text-gray-500">Learner Konsisten</p>
                                                <p className="text-xs text-gray-400">Login 7 hari berturut-turut</p>
                                            </div>
                                        </div>
                                    </div>
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
                                            onClick={() => setActiveTab('modul')}
                                            className={`px-6 py-3 font-medium text-sm border-b-2 transition ${
                                                activeTab === 'modul'
                                                    ? 'border-green-600 text-green-600'
                                                    : 'border-transparent text-gray-600 hover:text-gray-900'
                                            }`}
                                        >
                                            Progress Modul
                                        </button>
                                        <button
                                            onClick={() => setActiveTab('video')}
                                            className={`px-6 py-3 font-medium text-sm border-b-2 transition ${
                                                activeTab === 'video'
                                                    ? 'border-green-600 text-green-600'
                                                    : 'border-transparent text-gray-600 hover:text-gray-900'
                                            }`}
                                        >
                                            Progress Video
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
                                    {activeTab === 'modul' && (
                                        <div className="space-y-4">
                                            {moduleProgress.map((item) => (
                                                <div key={item.id} className="border-b pb-4 last:border-0">
                                                    <div className="flex items-start justify-between mb-2">
                                                        <div className="flex-1">
                                                            <Link href={route('modules.show', item.slug)} className="font-semibold text-gray-900 hover:text-green-600">
                                                                {item.title}
                                                            </Link>
                                                            <div className="flex items-center gap-2 mt-1">
                                                                <span className={`text-xs px-2 py-0.5 rounded-full ${
                                                                    item.status === 'Selesai' 
                                                                        ? 'bg-green-100 text-green-700' 
                                                                        : item.status === 'Sedang Berjalan'
                                                                            ? 'bg-orange-100 text-orange-700'
                                                                            : 'bg-gray-100 text-gray-700'
                                                                }`}>
                                                                    {item.status}
                                                                </span>
                                                                <span className="text-xs text-gray-500">
                                                                    Terakhir diakses {item.lastAccessed}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <span className="text-sm font-bold text-gray-900">{item.progress}%</span>
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
                                            ))}
                                        </div>
                                    )}

                                    {activeTab === 'video' && (
                                        <div className="space-y-4">
                                            {videoProgress.map((item) => (
                                                <div key={item.id} className="border-b pb-4 last:border-0">
                                                    <div className="flex items-start justify-between mb-2">
                                                        <div className="flex-1">
                                                            <Link href={route('videos.show', item.id)} className="font-semibold text-gray-900 hover:text-orange-600">
                                                                {item.title}
                                                            </Link>
                                                            <div className="flex items-center gap-2 mt-1">
                                                                <span className={`text-xs px-2 py-0.5 rounded-full ${
                                                                    item.status === 'Selesai' 
                                                                        ? 'bg-green-100 text-green-700' 
                                                                        : item.status === 'Sedang Ditonton'
                                                                            ? 'bg-blue-100 text-blue-700'
                                                                            : 'bg-gray-100 text-gray-700'
                                                                }`}>
                                                                    {item.status}
                                                                </span>
                                                                <span className="text-xs text-gray-500">
                                                                    {item.date}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <span className="text-sm font-bold text-gray-900">{item.progress}%</span>
                                                    </div>
                                                    <div className="w-full bg-gray-200 rounded-full h-2">
                                                        <div 
                                                            className={`h-2 rounded-full ${
                                                                item.progress === 100 
                                                                    ? 'bg-green-600' 
                                                                    : 'bg-blue-500'
                                                            }`}
                                                            style={{ width: `${item.progress}%` }}
                                                        ></div>
                                                    </div>
                                                </div>
                                            ))}
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
