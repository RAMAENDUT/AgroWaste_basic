import { Head, Link, router } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState } from 'react';

export default function CourseShow({ course, contents, currentContent, nextContent, previousContent, enrollment, flash }) {
    const [answers, setAnswers] = useState({});
    const [showResult, setShowResult] = useState(false);

    const formatDuration = (seconds) => {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    };

    const getTypeIcon = (type) => {
        switch(type) {
            case 'module':
                return (
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                );
            case 'video':
                return (
                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                    </svg>
                );
            case 'quiz':
                return (
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                );
            default:
                return null;
        }
    };

    const getTypeBadgeColor = (type) => {
        switch(type) {
            case 'module': return 'bg-green-100 text-green-700';
            case 'video': return 'bg-orange-100 text-orange-700';
            case 'quiz': return 'bg-blue-100 text-blue-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    };

    const handleMarkComplete = () => {
        if (currentContent.is_completed) return;
        
        router.post(route('course-contents.complete', [course.id, currentContent.id]), {}, {
            preserveScroll: true,
        });
    };

    const handleQuizSubmit = () => {
        router.post(route('course-contents.submit-quiz', [course.id, currentContent.id]), {
            answers: answers
        }, {
            preserveScroll: true,
            onSuccess: () => {
                setShowResult(true);
            }
        });
    };

    const handleAnswerChange = (questionId, optionId) => {
        setAnswers(prev => ({
            ...prev,
            [questionId]: optionId
        }));
    };

    // Show quiz result if available
    if (showResult && flash?.quiz_result) {
        const result = flash.quiz_result;
        
        return (
            <LearningLayout>
                <Head title={`${currentContent.title} - ${course.title}`} />
                
                <div className="bg-gradient-to-b from-blue-50/30 to-white min-h-screen">
                    <div className="max-w-4xl mx-auto px-8 py-12">
                        <div className="bg-white rounded-lg shadow-lg border border-gray-200 p-8">
                            <div className="text-center mb-8">
                                <div className={`w-24 h-24 mx-auto rounded-full flex items-center justify-center mb-4 ${
                                    result.passed ? 'bg-green-100' : 'bg-red-100'
                                }`}>
                                    {result.passed ? (
                                        <svg className="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                        </svg>
                                    ) : (
                                        <svg className="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd" />
                                        </svg>
                                    )}
                                </div>
                                <h2 className="text-3xl font-bold text-gray-900 mb-2">
                                    {result.passed ? 'Selamat! Anda Lulus' : 'Belum Lulus'}
                                </h2>
                                <p className="text-gray-600">
                                    {result.passed 
                                        ? 'Anda berhasil menyelesaikan kuis ini dengan baik' 
                                        : 'Jangan menyerah! Coba lagi untuk mendapatkan hasil yang lebih baik'}
                                </p>
                            </div>

                            <div className="grid grid-cols-3 gap-4 mb-8">
                                <div className="bg-blue-50 rounded-lg p-4 text-center">
                                    <div className="text-3xl font-bold text-blue-600 mb-1">{result.score}%</div>
                                    <div className="text-sm text-gray-600">Nilai Anda</div>
                                </div>
                                <div className="bg-green-50 rounded-lg p-4 text-center">
                                    <div className="text-3xl font-bold text-green-600 mb-1">{result.correct_answers}</div>
                                    <div className="text-sm text-gray-600">Jawaban Benar</div>
                                </div>
                                <div className="bg-gray-50 rounded-lg p-4 text-center">
                                    <div className="text-3xl font-bold text-gray-600 mb-1">{result.total_questions}</div>
                                    <div className="text-sm text-gray-600">Total Soal</div>
                                </div>
                            </div>

                            <div className="flex gap-3">
                                <button
                                    onClick={() => {
                                        setShowResult(false);
                                        setAnswers({});
                                    }}
                                    className="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition"
                                >
                                    Coba Lagi
                                </button>
                                {nextContent && (
                                    <Link
                                        href={route('course-contents.show', [course.id, nextContent.id])}
                                        className="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition text-center"
                                    >
                                        Konten Selanjutnya
                                    </Link>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </LearningLayout>
        );
    }

    return (
        <LearningLayout>
            <Head title={`${currentContent.title} - ${course.title}`} />
            
            <div className="bg-gradient-to-b from-blue-50/30 to-white min-h-screen">
                <div className="max-w-7xl mx-auto px-8 py-8">
                    
                    {/* Breadcrumb */}
                    <div className="flex items-center gap-2 text-sm mb-6">
                        <Link href={route('home')} className="text-gray-600 hover:text-blue-600">
                            Home
                        </Link>
                        <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                        <Link href={route('courses.index')} className="text-gray-600 hover:text-blue-600">
                            Kursus
                        </Link>
                        <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                        <span className="text-gray-900 font-medium">{course.title}</span>
                    </div>

                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Main Content */}
                        <div className="lg:col-span-2">
                            {/* Content Area */}
                            <div className="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                                {/* Header */}
                                <div className="bg-gradient-to-r from-blue-600 to-blue-500 text-white p-6">
                                    <div className="flex items-start justify-between mb-3">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-2 mb-3">
                                                <span className={`${getTypeBadgeColor(currentContent.type)} px-3 py-1 rounded-full text-xs font-semibold uppercase flex items-center gap-1.5`}>
                                                    {getTypeIcon(currentContent.type)}
                                                    {currentContent.type}
                                                </span>
                                                {currentContent.duration_seconds > 0 && (
                                                    <span className="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                                                        <svg className="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        {formatDuration(currentContent.duration_seconds)}
                                                    </span>
                                                )}
                                            </div>
                                            <h1 className="text-2xl font-bold">
                                                {currentContent.title}
                                            </h1>
                                        </div>
                                        
                                        {currentContent.is_completed && (
                                            <div className="flex items-center gap-2 bg-green-500 px-4 py-2 rounded-lg ml-4">
                                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                </svg>
                                                <span className="font-medium">Selesai</span>
                                            </div>
                                        )}
                                    </div>
                                    {currentContent.description && (
                                        <p className="text-white/90">
                                            {currentContent.description}
                                        </p>
                                    )}
                                </div>

                                {/* Content Body */}
                                <div className="p-6">
                                    {/* Module Content */}
                                    {currentContent.type === 'module' && (
                                        <div className="prose max-w-none">
                                            <div 
                                                className="text-gray-700 leading-relaxed"
                                                dangerouslySetInnerHTML={{ __html: currentContent.content || '<p>Konten sedang dalam proses...</p>' }}
                                            />
                                        </div>
                                    )}

                                    {/* Video Content */}
                                    {currentContent.type === 'video' && (
                                        <div>
                                            <div className="aspect-video bg-black rounded-lg overflow-hidden flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900 mb-4">
                                                <div className="text-center">
                                                    <div className="w-20 h-20 rounded-full bg-orange-600/20 flex items-center justify-center mx-auto mb-4">
                                                        <svg className="w-10 h-10 text-orange-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                                        </svg>
                                                    </div>
                                                    <p className="text-white/80 text-sm">Video Player Placeholder</p>
                                                    {currentContent.video_url && (
                                                        <p className="text-white/60 text-xs mt-2">{currentContent.video_url}</p>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    )}

                                    {/* Quiz Content */}
                                    {currentContent.type === 'quiz' && currentContent.questions && (
                                        <div>
                                            {currentContent.best_attempt && (
                                                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                                    <div className="flex items-center justify-between">
                                                        <div>
                                                            <h4 className="font-semibold text-blue-900">Nilai Terbaik Anda</h4>
                                                            <p className="text-sm text-blue-700">
                                                                {currentContent.best_attempt.score}% ({currentContent.best_attempt.score * currentContent.best_attempt.total_questions / 100} dari {currentContent.best_attempt.total_questions} soal benar)
                                                            </p>
                                                        </div>
                                                        <div className="text-3xl font-bold text-blue-600">
                                                            {currentContent.best_attempt.score}%
                                                        </div>
                                                    </div>
                                                </div>
                                            )}

                                            <div className="space-y-6">
                                                {currentContent.questions.map((question, index) => (
                                                    <div key={question.id} className="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                                        <h4 className="font-semibold text-gray-900 mb-4">
                                                            {index + 1}. {question.question}
                                                        </h4>
                                                        <div className="space-y-2">
                                                            {question.options.map((option) => (
                                                                <label
                                                                    key={option.id}
                                                                    className="flex items-start gap-3 p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition"
                                                                >
                                                                    <input
                                                                        type="radio"
                                                                        name={`question-${question.id}`}
                                                                        value={option.id}
                                                                        checked={answers[question.id] === option.id}
                                                                        onChange={() => handleAnswerChange(question.id, option.id)}
                                                                        className="mt-1 text-blue-600 focus:ring-blue-500"
                                                                    />
                                                                    <span className="flex-1 text-gray-700">
                                                                        {option.option_text}
                                                                    </span>
                                                                </label>
                                                            ))}
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>

                                            <div className="mt-6">
                                                <button
                                                    onClick={handleQuizSubmit}
                                                    disabled={Object.keys(answers).length !== currentContent.questions.length}
                                                    className="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white py-3 rounded-lg font-medium transition"
                                                >
                                                    Submit Jawaban
                                                </button>
                                                {Object.keys(answers).length !== currentContent.questions.length && (
                                                    <p className="text-sm text-gray-500 text-center mt-2">
                                                        Jawab semua pertanyaan untuk submit
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Navigation */}
                            {(currentContent.type !== 'quiz') && (
                                <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                    <div className="flex items-center justify-between mb-4">
                                        <h3 className="font-semibold text-gray-900">Navigasi Konten</h3>
                                    </div>

                                    <div className="grid md:grid-cols-2 gap-4">
                                        {previousContent ? (
                                            <Link
                                                href={route('course-contents.show', [course.id, previousContent.id])}
                                                className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition group"
                                            >
                                                <div className="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition">
                                                    <svg className="w-5 h-5 text-gray-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                </div>
                                                <div className="flex-1">
                                                    <div className="text-xs text-gray-500 mb-1">Sebelumnya</div>
                                                    <div className="text-sm font-medium text-gray-900 line-clamp-1">
                                                        {previousContent.title}
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
                                                    <div className="text-xs text-gray-400 mb-1">Sebelumnya</div>
                                                    <div className="text-sm font-medium text-gray-400">Tidak ada</div>
                                                </div>
                                            </div>
                                        )}

                                        {nextContent ? (
                                            <Link
                                                href={route('course-contents.show', [course.id, nextContent.id])}
                                                className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition group"
                                            >
                                                <div className="flex-1 text-right">
                                                    <div className="text-xs text-gray-500 mb-1">Selanjutnya</div>
                                                    <div className="text-sm font-medium text-gray-900 line-clamp-1">
                                                        {nextContent.title}
                                                    </div>
                                                </div>
                                                <div className="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition">
                                                    <svg className="w-5 h-5 text-gray-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </Link>
                                        ) : (
                                            <div className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 opacity-50">
                                                <div className="flex-1 text-right">
                                                    <div className="text-xs text-gray-400 mb-1">Selanjutnya</div>
                                                    <div className="text-sm font-medium text-gray-400">Tidak ada</div>
                                                </div>
                                                <div className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* Sidebar - Content List */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden sticky top-8">
                                <div className="bg-gradient-to-r from-blue-600 to-blue-500 text-white p-4">
                                    <h3 className="font-bold flex items-center gap-2">
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Konten Kursus
                                    </h3>
                                    <div className="flex items-center justify-between mt-2">
                                        <p className="text-sm text-white/90">{contents.length} konten</p>
                                        <div className="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                                            {enrollment.progress_percentage}%
                                        </div>
                                    </div>
                                </div>

                                <div className="max-h-[600px] overflow-y-auto">
                                    {contents.map((content, index) => (
                                        <Link
                                            key={content.id}
                                            href={route('course-contents.show', [course.id, content.id])}
                                            className={`block p-4 border-b border-gray-100 transition ${
                                                content.id === currentContent.id 
                                                    ? 'bg-blue-50 border-l-4 border-l-blue-600' 
                                                    : 'hover:bg-gray-50'
                                            }`}
                                        >
                                            <div className="flex items-start gap-3">
                                                <div className={`w-8 h-8 rounded flex items-center justify-center flex-shrink-0 ${
                                                    content.id === currentContent.id 
                                                        ? getTypeBadgeColor(content.type).replace('100', '600').replace('700', 'white')
                                                        : content.is_completed 
                                                            ? 'bg-green-100 text-green-600'
                                                            : 'bg-gray-100 text-gray-600'
                                                }`}>
                                                    {content.is_completed ? (
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                        </svg>
                                                    ) : (
                                                        getTypeIcon(content.type)
                                                    )}
                                                </div>
                                                <div className="flex-1 min-w-0">
                                                    <div className="flex items-center gap-2 mb-1">
                                                        <span className={`text-xs font-semibold uppercase ${
                                                            content.id === currentContent.id ? 'text-blue-700' : 'text-gray-500'
                                                        }`}>
                                                            {content.type}
                                                        </span>
                                                    </div>
                                                    <h4 className={`text-sm font-medium mb-1 line-clamp-2 ${
                                                        content.id === currentContent.id ? 'text-blue-900' : 'text-gray-900'
                                                    }`}>
                                                        {content.title}
                                                    </h4>
                                                    {content.duration_seconds > 0 && (
                                                        <span className="text-xs text-gray-500">
                                                            {formatDuration(content.duration_seconds)}
                                                        </span>
                                                    )}
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
