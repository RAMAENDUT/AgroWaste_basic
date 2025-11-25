import { Head, Link } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function QuizzesIndex({ modules, userProgress, userAttempts, stats }) {
    const [activeTab, setActiveTab] = useState('semua');

    // Flatten all quizzes with module info
    const allQuizzes = modules.flatMap(module =>
        module.quizzes.map(quiz => ({
            ...quiz,
            module: {
                id: module.id,
                title: module.title,
            }
        }))
    );

    // Filter quizzes based on tab
    const filteredQuizzes = allQuizzes.filter(quiz => {
        const attempts = userAttempts[quiz.id] || [];
        const progress = userProgress[quiz.module.id];
        
        if (activeTab === 'tersedia') {
            return attempts.length === 0;
        } else if (activeTab === 'selesai') {
            return progress?.quiz_completed;
        }
        return true; // 'semua'
    });

    return (
        <LearningLayout>
            <Head title="Quiz & Evaluasi - AgroWaste Academy" />
            
            {/* Header */}
            <div className="bg-gradient-to-br from-orange-600 via-orange-500 to-orange-400 text-white px-8 py-12">
                <div className="max-w-6xl mx-auto">
                    <div className="flex items-center gap-2 mb-6">
                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fillRule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clipRule="evenodd" />
                        </svg>
                        <h1 className="text-4xl font-bold">Quiz & Evaluasi</h1>
                    </div>
                    <p className="text-lg text-white/90 mb-8">
                        Uji pemahaman Anda tentang pengelolaan limbah pertanian
                    </p>

                    {/* Stats Cards */}
                    <div className="grid grid-cols-3 gap-4">
                        <div className="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-lg bg-green-500 flex items-center justify-center">
                                    <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold">{stats.completed || 0}/{stats.total || 0}</p>
                                    <p className="text-xs text-white/80">Quiz Selesai</p>
                                </div>
                            </div>
                        </div>
                        <div className="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-lg bg-orange-500 flex items-center justify-center">
                                    <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                    </svg>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold">{stats.averageScore || 0}</p>
                                    <p className="text-xs text-white/80">Nilai Rata-rata</p>
                                </div>
                            </div>
                        </div>
                        <div className="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-lg bg-yellow-500 flex items-center justify-center">
                                    <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold">{stats.passed || 0}</p>
                                    <p className="text-xs text-white/80">Berhasil Lulus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="bg-gradient-to-b from-orange-50/30 to-white min-h-screen">
                <div className="max-w-6xl mx-auto px-8 py-8">
                    
                    {/* Progress Pembelajaran Header */}
                    <div className="mb-6">
                        <h2 className="text-xl font-bold text-gray-900 mb-4">Progress Pembelajaran</h2>
                        
                        {/* Tabs */}
                        <div className="flex gap-2">
                            <button
                                onClick={() => setActiveTab('semua')}
                                className={`px-4 py-2 rounded-lg font-medium text-sm transition ${
                                    activeTab === 'semua' 
                                        ? 'bg-orange-600 text-white' 
                                        : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
                                }`}
                            >
                                Semua Quiz
                            </button>
                            <button
                                onClick={() => setActiveTab('tersedia')}
                                className={`px-4 py-2 rounded-lg font-medium text-sm transition ${
                                    activeTab === 'tersedia' 
                                        ? 'bg-orange-600 text-white' 
                                        : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
                                }`}
                            >
                                Tersedia
                            </button>
                            <button
                                onClick={() => setActiveTab('selesai')}
                                className={`px-4 py-2 rounded-lg font-medium text-sm transition ${
                                    activeTab === 'selesai' 
                                        ? 'bg-orange-600 text-white' 
                                        : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
                                }`}
                            >
                                Selesai
                            </button>
                        </div>
                    </div>

                    {/* Quiz Cards */}
                    {filteredQuizzes.length > 0 ? (
                        <div className="grid md:grid-cols-2 gap-6">
                            {filteredQuizzes.map((quiz) => {
                                const progress = userProgress[quiz.module.id];
                                const attempts = userAttempts[quiz.id] || [];
                                const bestAttempt = attempts.length > 0 ? attempts.reduce((best, current) => 
                                    current.score > best.score ? current : best
                                ) : null;
                                const isPassed = progress?.quiz_completed;

                                return (
                                    <div key={quiz.id} className="bg-white rounded-lg border-2 border-gray-200 overflow-hidden hover:shadow-lg transition">
                                        {/* Header */}
                                        <div className="bg-gradient-to-r from-orange-50 to-white p-4 border-b">
                                            <div className="flex items-start justify-between mb-2">
                                                <span className={`text-xs font-semibold px-3 py-1 rounded-full ${
                                                    isPassed 
                                                        ? 'bg-green-100 text-green-700' 
                                                        : attempts.length > 0 
                                                            ? 'bg-blue-100 text-blue-700'
                                                            : 'bg-gray-100 text-gray-700'
                                                }`}>
                                                    {isPassed ? 'Lulus' : attempts.length > 0 ? 'Dalam Proses' : 'Pemula'}
                                                </span>
                                                <span className="text-xs text-gray-500">{quiz.module.title}</span>
                                            </div>
                                            <h3 className="font-bold text-lg text-gray-900">{quiz.title}</h3>
                                        </div>

                                        {/* Content */}
                                        <div className="p-5">
                                            {quiz.description && (
                                                <p className="text-sm text-gray-600 mb-4 line-clamp-2">
                                                    {quiz.description}
                                                </p>
                                            )}

                                            {/* Stats */}
                                            <div className="grid grid-cols-2 gap-3 mb-4">
                                                <div className="text-center">
                                                    <div className="flex items-center justify-center gap-1 text-gray-500 mb-1">
                                                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span className="text-xs">Durasi</span>
                                                    </div>
                                                    <p className="text-sm font-semibold text-gray-900">{quiz.duration_minutes} menit</p>
                                                </div>
                                                <div className="text-center">
                                                    <div className="flex items-center justify-center gap-1 text-gray-500 mb-1">
                                                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                        </svg>
                                                        <span className="text-xs">Nilai Lulus</span>
                                                    </div>
                                                    <p className="text-sm font-semibold text-gray-900">{quiz.passing_score}%</p>
                                                </div>
                                            </div>

                                            <div className="grid grid-cols-2 gap-3 mb-4">
                                                <div className="bg-gray-50 rounded-lg p-3 text-center">
                                                    <p className="text-xs text-gray-500 mb-1">Jumlah Soal</p>
                                                    <p className="text-base font-bold text-gray-900">{quiz.total_questions || 10} soal</p>
                                                </div>
                                                <div className="bg-gray-50 rounded-lg p-3 text-center">
                                                    <p className="text-xs text-gray-500 mb-1">Percobaan</p>
                                                    <p className="text-base font-bold text-gray-900">{attempts.length}x</p>
                                                </div>
                                            </div>

                                            {bestAttempt && (
                                                <div className="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                                                    <div className="flex items-center justify-between">
                                                        <span className="text-xs text-orange-700">Nilai Terbaik:</span>
                                                        <span className={`text-lg font-bold ${bestAttempt.is_passed ? 'text-green-600' : 'text-orange-600'}`}>
                                                            {bestAttempt.score}%
                                                        </span>
                                                    </div>
                                                </div>
                                            )}

                                            {/* Action Buttons */}
                                            <div className="space-y-2">
                                                <Link
                                                    href={route('quizzes.show', quiz.id)}
                                                    className={`block w-full text-center py-2.5 rounded-lg font-semibold text-sm transition ${
                                                        isPassed
                                                            ? 'bg-green-600 hover:bg-green-700 text-white'
                                                            : 'bg-orange-600 hover:bg-orange-700 text-white'
                                                    }`}
                                                >
                                                    {isPassed ? 'Lihat Hasil' : attempts.length > 0 ? 'Mulai Ulang' : 'Mulai Quiz'}
                                                </Link>
                                                {attempts.length > 0 && (
                                                    <button className="block w-full bg-white border border-gray-300 text-gray-700 text-center py-2 rounded-lg font-medium text-sm hover:bg-gray-50 transition">
                                                        Lihat Riwayat
                                                    </button>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="text-center py-16 bg-white rounded-lg border-2 border-gray-200">
                            <svg className="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p className="text-gray-600 mb-4">Tidak ada quiz di kategori ini</p>
                            <button
                                onClick={() => setActiveTab('semua')}
                                className="text-orange-600 hover:text-orange-700 font-medium"
                            >
                                Lihat Semua Quiz
                            </button>
                        </div>
                    )}


                    {/* Tips Section */}
                    <div className="mt-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                        <div className="flex items-start gap-4">
                            <div className="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 className="font-bold text-lg mb-3">Tips Mengerjakan Quiz</h3>
                                <ul className="space-y-2 text-sm text-white/90">
                                    <li className="flex items-start gap-2">
                                        <span className="text-yellow-300 mt-0.5">•</span>
                                        <span>Tinjau kembali materi yang telah dipelajari sebelum memulai</span>
                                    </li>
                                    <li className="flex items-start gap-2">
                                        <span className="text-yellow-300 mt-0.5">•</span>
                                        <span>Baca setiap pertanyaan dengan teliti</span>
                                    </li>
                                    <li className="flex items-start gap-2">
                                        <span className="text-yellow-300 mt-0.5">•</span>
                                        <span>Anda bisa mengulang quiz jika nilai tidak memuaskan</span>
                                    </li>
                                    <li className="flex items-start gap-2">
                                        <span className="text-yellow-300 mt-0.5">•</span>
                                        <span>Nilai terbaik yang akan tersimpan dalam progress Anda</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </LearningLayout>
    );
}
