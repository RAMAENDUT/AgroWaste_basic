import { Head, Link, router } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function VideosIndex({ modules, userProgress }) {
    const [search, setSearch] = useState('');

    // Get all videos from modules
    const allVideos = modules.flatMap(module => 
        module.videos.map(video => ({
            ...video,
            module: {
                id: module.id,
                title: module.title,
                thumbnail: module.thumbnail,
            }
        }))
    );

    // Popular videos (first 3)
    const popularVideos = allVideos.slice(0, 3);

    // Filter videos by search
    const filteredVideos = search 
        ? allVideos.filter(video => 
            video.title.toLowerCase().includes(search.toLowerCase()) ||
            video.module.title.toLowerCase().includes(search.toLowerCase())
        )
        : allVideos;

    const formatDuration = (seconds) => {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    };

    return (
        <LearningLayout>
            <Head title="Video Pembelajaran - AgroWaste Academy" />
            
            {/* Header */}
            <div className="bg-gradient-to-br from-orange-600 via-orange-500 to-orange-400 text-white px-8 py-12">
                <div className="max-w-6xl mx-auto">
                    <h1 className="text-4xl font-bold mb-3">Video Pembelajaran</h1>
                    <p className="text-lg text-white/90 mb-8">
                        Tutorial step-by-step video tentang pengelolaan limbah pertanian
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
                                placeholder="Cari video pembelajaran..."
                                className="w-full pl-12 pr-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-300 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div className="bg-gradient-to-b from-orange-50/30 to-white min-h-screen">
                <div className="max-w-6xl mx-auto px-8 py-8">
                    
                    {/* Video Populer Section */}
                    {popularVideos.length > 0 && !search && (
                        <div className="mb-10">
                            <div className="flex items-center gap-2 mb-4">
                                <svg className="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <h2 className="text-xl font-bold text-gray-900">Video Populer</h2>
                            </div>
                            <div className="grid md:grid-cols-3 gap-4">
                                {popularVideos.map((video) => (
                                    <Link
                                        key={video.id}
                                        href={route('videos.show', video.id)}
                                        className="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 hover:shadow-lg transition group"
                                    >
                                        <div className="relative h-40 overflow-hidden">
                                            {video.module.thumbnail ? (
                                                <img
                                                    src={video.module.thumbnail}
                                                    alt={video.title}
                                                    className="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                                />
                                            ) : (
                                                <div className="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600"></div>
                                            )}
                                            <div className="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition flex items-center justify-center">
                                                <div className="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center group-hover:scale-110 transition">
                                                    <svg className="w-6 h-6 text-orange-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div className="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                                {formatDuration(video.duration_seconds)}
                                            </div>
                                        </div>
                                        <div className="p-4">
                                            <h3 className="font-semibold text-sm mb-2 line-clamp-2 group-hover:text-orange-600 transition">
                                                {video.title}
                                            </h3>
                                            <div className="flex items-center justify-between text-xs text-gray-500">
                                                <span>{video.module.title}</span>
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </div>
                    )}

                    {/* All Videos Section */}
                    <div>
                        <h2 className="text-xl font-bold text-gray-900 mb-4">
                            Semua Video ({filteredVideos.length})
                        </h2>
                        {filteredVideos.length > 0 ? (
                            <div className="grid md:grid-cols-3 gap-4">
                                {filteredVideos.map((video) => {
                                    const progress = userProgress[video.module.id];
                                    const isCompleted = progress?.video_completed;

                                    return (
                                        <div key={video.id} className="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 hover:shadow-lg transition">
                                            <Link
                                                href={route('videos.show', video.id)}
                                                className="block group"
                                            >
                                                <div className="relative h-40 overflow-hidden">
                                                    {video.module.thumbnail ? (
                                                        <img
                                                            src={video.module.thumbnail}
                                                            alt={video.title}
                                                            className="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                                        />
                                                    ) : (
                                                        <div className="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600"></div>
                                                    )}
                                                    <div className="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition flex items-center justify-center">
                                                        <div className="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center group-hover:scale-110 transition">
                                                            <svg className="w-6 h-6 text-orange-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div className="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                                        {formatDuration(video.duration_seconds)}
                                                    </div>
                                                    {isCompleted && (
                                                        <div className="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded flex items-center gap-1">
                                                            <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    )}
                                                </div>
                                                <div className="p-4">
                                                    <h3 className="font-semibold text-sm mb-2 line-clamp-2 group-hover:text-orange-600 transition">
                                                        {video.title}
                                                    </h3>
                                                    {video.description && (
                                                        <p className="text-xs text-gray-600 mb-3 line-clamp-1">
                                                            {video.description}
                                                        </p>
                                                    )}
                                                    <div className="flex items-center justify-between text-xs text-gray-500">
                                                        <div className="flex items-center gap-1">
                                                            <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span>{formatDate(video.created_at)}</span>
                                                        </div>
                                                        <div className="flex items-center gap-1">
                                                            <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            <span>1.2k</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Link>
                                            <div className="px-4 pb-4">
                                                <button className="w-full bg-orange-600 hover:bg-orange-700 text-white text-xs py-2 rounded-lg font-medium transition flex items-center justify-center gap-2">
                                                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                    </svg>
                                                    Tonton Sekarang
                                                </button>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        ) : (
                            <div className="text-center py-16 bg-white rounded-lg border border-gray-200">
                                <svg className="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p className="text-gray-600 mb-4">Tidak ada video yang sesuai dengan pencarian</p>
                            </div>
                        )}
                    </div>

                </div>
            </div>
        </LearningLayout>
    );
}
