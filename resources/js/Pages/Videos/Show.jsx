import { Head, Link, router } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function VideoShow({ video, module, videos, nextVideo, previousVideo, quiz, progress }) {
    const [isCompleted, setIsCompleted] = useState(progress?.video_completed || false);

    const handleMarkComplete = () => {
        if (isCompleted) return;
        
        router.post(route('videos.complete', video.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                setIsCompleted(true);
            }
        });
    };

    const formatDuration = (seconds) => {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    };

    return (
        <LearningLayout>
            <Head title={`${video.title} - AgroWaste Academy`} />
            
            <div className="bg-gradient-to-b from-orange-50/30 to-white min-h-screen">
                <div className="max-w-7xl mx-auto px-8 py-8">
                    
                    {/* Breadcrumb */}
                    <div className="flex items-center gap-2 text-sm mb-6">
                        <Link href={route('home')} className="text-gray-600 hover:text-orange-600">
                            Home
                        </Link>
                        <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                        <Link href={route('videos.index')} className="text-gray-600 hover:text-orange-600">
                            Video
                        </Link>
                        <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                        <span className="text-gray-900 font-medium">{video.title}</span>
                    </div>

                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Main Content */}
                        <div className="lg:col-span-2">
                            {/* Video Player Placeholder */}
                            <div className="bg-black rounded-lg overflow-hidden shadow-lg mb-6">
                                <div className="aspect-video relative flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
                                    <div className="text-center">
                                        <div className="w-20 h-20 rounded-full bg-orange-600/20 flex items-center justify-center mx-auto mb-4">
                                            <svg className="w-10 h-10 text-orange-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                            </svg>
                                        </div>
                                        <p className="text-white/80 text-sm">Video Player Placeholder</p>
                                        <p className="text-white/60 text-xs mt-2">Durasi: {formatDuration(video.duration_seconds)}</p>
                                    </div>
                                </div>
                            </div>

                            {/* Video Info */}
                            <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                                <div className="flex items-start justify-between mb-4">
                                    <div className="flex-1">
                                        <h1 className="text-2xl font-bold text-gray-900 mb-2">
                                            {video.title}
                                        </h1>
                                        <div className="flex items-center gap-4 text-sm text-gray-600">
                                            <Link 
                                                href={route('modules.show', module.id)} 
                                                className="flex items-center gap-1 hover:text-orange-600"
                                            >
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                {module.title}
                                            </Link>
                                            <span className="flex items-center gap-1">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {formatDuration(video.duration_seconds)}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    {isCompleted && (
                                        <div className="flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-lg">
                                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                            </svg>
                                            <span className="font-medium">Selesai</span>
                                        </div>
                                    )}
                                </div>

                                {video.description && (
                                    <div className="border-t pt-4">
                                        <h3 className="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                                        <p className="text-gray-700 leading-relaxed whitespace-pre-line">
                                            {video.description}
                                        </p>
                                    </div>
                                )}
                            </div>

                            {/* Navigation & Actions */}
                            <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div className="flex items-center justify-between mb-4">
                                    <h3 className="font-semibold text-gray-900">Navigasi Video</h3>
                                    {!isCompleted && (
                                        <button
                                            onClick={handleMarkComplete}
                                            className="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2"
                                        >
                                            <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                            </svg>
                                            Tandai Selesai
                                        </button>
                                    )}
                                </div>

                                <div className="grid md:grid-cols-2 gap-4">
                                    {previousVideo ? (
                                        <Link
                                            href={route('videos.show', previousVideo.id)}
                                            className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition group"
                                        >
                                            <div className="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-orange-100 flex items-center justify-center transition">
                                                <svg className="w-5 h-5 text-gray-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </div>
                                            <div className="flex-1">
                                                <div className="text-xs text-gray-500 mb-1">Video Sebelumnya</div>
                                                <div className="text-sm font-medium text-gray-900 line-clamp-1">
                                                    {previousVideo.title}
                                                </div>
                                            </div>
                                        </Link>
                                    ) : (
                                        <div className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 opacity-50">
                                            <div className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </div>
                                            <div className="flex-1">
                                                <div className="text-xs text-gray-400 mb-1">Video Sebelumnya</div>
                                                <div className="text-sm font-medium text-gray-400">
                                                    Tidak ada
                                                </div>
                                            </div>
                                        </div>
                                    )}

                                    {nextVideo ? (
                                        <Link
                                            href={route('videos.show', nextVideo.id)}
                                            className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition group"
                                        >
                                            <div className="flex-1 text-right">
                                                <div className="text-xs text-gray-500 mb-1">Video Selanjutnya</div>
                                                <div className="text-sm font-medium text-gray-900 line-clamp-1">
                                                    {nextVideo.title}
                                                </div>
                                            </div>
                                            <div className="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-orange-100 flex items-center justify-center transition">
                                                <svg className="w-5 h-5 text-gray-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                        </Link>
                                    ) : (
                                        <div className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 opacity-50">
                                            <div className="flex-1 text-right">
                                                <div className="text-xs text-gray-400 mb-1">Video Selanjutnya</div>
                                                <div className="text-sm font-medium text-gray-400">
                                                    Tidak ada
                                                </div>
                                            </div>
                                            <div className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                {quiz && isCompleted && (
                                    <div className="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                        <div className="flex items-center justify-between">
                                            <div>
                                                <h4 className="font-semibold text-blue-900 mb-1">
                                                    Siap untuk mengambil kuis?
                                                </h4>
                                                <p className="text-sm text-blue-700">
                                                    Uji pemahaman Anda tentang materi yang telah dipelajari
                                                </p>
                                            </div>
                                            <Link
                                                href={route('quizzes.show', quiz.id)}
                                                className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition"
                                            >
                                                Mulai Kuis
                                            </Link>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Sidebar - Playlist */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden sticky top-8">
                                <div className="bg-gradient-to-r from-orange-600 to-orange-500 text-white p-4">
                                    <h3 className="font-bold flex items-center gap-2">
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Daftar Video
                                    </h3>
                                    <p className="text-sm text-white/90 mt-1">{videos.length} video dalam modul ini</p>
                                </div>

                                <div className="max-h-[600px] overflow-y-auto">
                                    {videos.map((v, index) => (
                                        <Link
                                            key={v.id}
                                            href={route('videos.show', v.id)}
                                            className={`block p-4 border-b border-gray-100 transition ${
                                                v.id === video.id 
                                                    ? 'bg-orange-50 border-l-4 border-l-orange-600' 
                                                    : 'hover:bg-gray-50'
                                            }`}
                                        >
                                            <div className="flex items-start gap-3">
                                                <div className={`w-8 h-8 rounded flex items-center justify-center flex-shrink-0 ${
                                                    v.id === video.id 
                                                        ? 'bg-orange-600 text-white' 
                                                        : 'bg-gray-100 text-gray-600'
                                                }`}>
                                                    {v.id === video.id ? (
                                                        <svg className="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                        </svg>
                                                    ) : (
                                                        <span className="text-xs font-medium">{index + 1}</span>
                                                    )}
                                                </div>
                                                <div className="flex-1 min-w-0">
                                                    <h4 className={`text-sm font-medium mb-1 line-clamp-2 ${
                                                        v.id === video.id ? 'text-orange-900' : 'text-gray-900'
                                                    }`}>
                                                        {v.title}
                                                    </h4>
                                                    <div className="flex items-center gap-2">
                                                        <span className="text-xs text-gray-500">
                                                            {formatDuration(v.duration_seconds)}
                                                        </span>
                                                        {progress?.video_completed && v.id <= video.id && (
                                                            <span className="inline-flex items-center gap-1 text-xs text-green-600">
                                                                <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                                </svg>
                                                                Selesai
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                        </Link>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </LearningLayout>
    );
}
