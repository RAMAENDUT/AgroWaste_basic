import { Head, Link, router } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';
import { useState, useEffect } from 'react';

export default function CourseContent({ course, currentContent, currentModuleCompleted, previousContent, nextContent, contents, enrollment, flash }) {
    const [isCompleted, setIsCompleted] = useState(currentModuleCompleted || false);
    const [answers, setAnswers] = useState({});
    const [quizResult, setQuizResult] = useState(null);
    const [showEasterEgg, setShowEasterEgg] = useState(false);

    useEffect(() => {
        if (flash?.quiz_result) {
            setQuizResult(flash.quiz_result);
        }
    }, [flash]);

    const handleVideoTutorialClick = (e, module) => {
        // Show easter egg if currently on Materi Pengantar and clicking Video Tutorial
        if (currentContent.title === 'Materi Pengantar' && 
            module.type === 'video' && 
            module.title === 'Video Tutorial') {
            e.preventDefault();
            setShowEasterEgg(true);
            
            // Navigate after 0.2 seconds
            setTimeout(() => {
                router.visit(route('courses.content.show', [course.id, module.id]));
            }, 200);
        }
    };

    const handleMarkComplete = () => {
        router.post(route('courses.content.complete', [course.id, currentContent.id]), {}, {
            preserveScroll: true,
            onSuccess: () => {
                setIsCompleted(true);
            }
        });
    };

    const handleAnswerChange = (questionId, optionId) => {
        setAnswers(prev => ({
            ...prev,
            [questionId]: optionId
        }));
    };

    const handleSubmitQuiz = () => {
        router.post(route('courses.content.submit-quiz', [course.id, currentContent.id]), {
            answers: answers
        }, {
            preserveScroll: true,
        });
    };

    const getTypeIcon = (type) => {
        switch(type) {
            case 'content':
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
            case 'exercise':
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
            case 'content': return 'bg-green-100 text-green-600';
            case 'video': return 'bg-orange-100 text-orange-600';
            case 'exercise': return 'bg-blue-100 text-blue-600';
            default: return 'bg-gray-100 text-gray-600';
        }
    };

    const renderContent = () => {
        // Show quiz result if available
        if (quizResult) {
            return (
                <div className="space-y-6">
                    <div className={`rounded-lg p-6 ${quizResult.passed ? 'bg-green-50 border-2 border-green-200' : 'bg-red-50 border-2 border-red-200'}`}>
                        <div className="text-center">
                            <div className={`w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 ${
                                quizResult.passed ? 'bg-green-100' : 'bg-red-100'
                            }`}>
                                {quizResult.passed ? (
                                    <svg className="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                    </svg>
                                ) : (
                                    <svg className="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                )}
                            </div>
                            <h2 className={`text-2xl font-bold mb-2 ${quizResult.passed ? 'text-green-800' : 'text-red-800'}`}>
                                {quizResult.passed ? 'Quiz Berhasil!' : 'Quiz Belum Berhasil'}
                            </h2>
                            <p className={`text-lg mb-4 ${quizResult.passed ? 'text-green-700' : 'text-red-700'}`}>
                                Nilai Anda: {Math.round(quizResult.score)}%
                            </p>
                            <p className={quizResult.passed ? 'text-green-600' : 'text-red-600'}>
                                Jawaban benar: {quizResult.correct_answers} dari {quizResult.total_questions}
                            </p>
                            <p className="text-sm text-gray-600 mt-2">
                                Passing score: {quizResult.passing_score}%
                            </p>
                        </div>
                    </div>
                    
                    {quizResult.passed && nextContent && (
                        <Link
                            href={route('courses.content.show', [course.id, nextContent.id])}
                            className="block w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-center transition"
                        >
                            Lanjut ke: {nextContent.title} →
                        </Link>
                    )}
                    
                    {!quizResult.passed && (
                        <button
                            onClick={() => {
                                setQuizResult(null);
                                setAnswers({});
                            }}
                            className="block w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg text-center transition"
                        >
                            Coba Lagi
                        </button>
                    )}
                </div>
            );
        }

        // Render HTML Content
        if (currentContent.type === 'content' && currentContent.content_text) {
            // Show easter egg on Materi Pengantar when clicking Video Tutorial
            if (showEasterEgg && currentContent.title === 'Materi Pengantar') {
                return (
                    <div className="prose max-w-none">
                        <h2 className="text-3xl font-bold mb-6">3. Ternak Mulyono</h2>
                        <div style={{ margin: '20px 0' }}>
                            <img 
                                src="/images/mulyono.jpg" 
                                alt="Mulyono" 
                                style={{ width: '100%', maxWidth: '600px', borderRadius: '8px', margin: '10px 0' }}
                            />
                        </div>
                    </div>
                );
            }
            
            return (
                <div className="prose max-w-none">
                    <div dangerouslySetInnerHTML={{ __html: currentContent.content_text }} />
                </div>
            );
        }

        // Render Video
        if (currentContent.type === 'video' && currentContent.video_path) {
            return (
                <div>
                    <div className="bg-black rounded-lg overflow-hidden mb-6">
                        <video 
                            controls 
                            className="w-full aspect-video"
                            src={currentContent.video_path}
                        >
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    {currentContent.description && (
                        <div className="prose max-w-none mt-4">
                            <p className="text-gray-600">{currentContent.description}</p>
                        </div>
                    )}
                </div>
            );
        }

        // Render Exercise/Quiz
        if (currentContent.type === 'exercise' && currentContent.exercise) {
            return (
                <div className="space-y-6">
                    {currentContent.exercise.questions && currentContent.exercise.questions.map((question, qIndex) => (
                        <div key={question.id} className="bg-gray-50 rounded-lg p-6">
                            <p className="font-medium mb-4 text-lg">
                                {qIndex + 1}. {question.question_text}
                            </p>
                            <div className="space-y-3">
                                {question.options && question.options.map((option) => (
                                    <label 
                                        key={option.id} 
                                        className={`flex items-center p-4 bg-white rounded-lg border-2 cursor-pointer transition ${
                                            answers[question.id] === option.id 
                                                ? 'border-blue-500 bg-blue-50' 
                                                : 'border-gray-200 hover:border-blue-300'
                                        }`}
                                    >
                                        <input 
                                            type="radio" 
                                            name={`question_${question.id}`}
                                            value={option.id}
                                            checked={answers[question.id] === option.id}
                                            onChange={() => handleAnswerChange(question.id, option.id)}
                                            className="mr-3 w-4 h-4"
                                        />
                                        <span className="text-gray-800">{option.option_text}</span>
                                    </label>
                                ))}
                            </div>
                        </div>
                    ))}
                    
                    <button 
                        onClick={handleSubmitQuiz}
                        disabled={Object.keys(answers).length < (currentContent.exercise.questions?.length || 0)}
                        className={`w-full font-semibold py-4 px-6 rounded-lg transition ${
                            Object.keys(answers).length < (currentContent.exercise.questions?.length || 0)
                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                : 'bg-blue-600 hover:bg-blue-700 text-white'
                        }`}
                    >
                        Submit Jawaban
                    </button>
                </div>
            );
        }

        return (
            <div className="text-center py-12 text-gray-500">
                <p>Konten tidak tersedia</p>
            </div>
        );
    };

    return (
        <LearningLayout>
            <Head title={`${currentContent.title} - ${course.title}`} />
            
            <div className="min-h-screen bg-gradient-to-b from-blue-50/30 to-white">
                {/* Breadcrumb */}
                <div className="bg-white border-b">
                    <div className="max-w-7xl mx-auto px-6 py-3">
                        <div className="flex items-center gap-2 text-sm text-gray-600">
                            <Link href={route('home')} className="hover:text-gray-900">Home</Link>
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                            </svg>
                            <Link href={route('courses.index')} className="hover:text-gray-900">Kursus</Link>
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                            </svg>
                            <span className="text-gray-900 font-medium">{course.title}</span>
                        </div>
                    </div>
                </div>

                <div className="max-w-7xl mx-auto px-6 py-6">
                    <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        {/* Main Content Area */}
                        <div className="lg:col-span-3">
                            {/* Module Header */}
                            <div className="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-lg shadow-lg p-6">
                                <div className="flex items-start justify-between mb-3">
                                    <div className="flex items-center gap-3 flex-wrap">
                                        <div className="bg-white/20 backdrop-blur-sm rounded-md px-3 py-1.5 flex items-center gap-2 text-sm font-medium">
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            MODULE
                                        </div>
                                        {currentContent.duration_seconds && (
                                            <div className="flex items-center gap-1.5 text-sm bg-white/10 backdrop-blur-sm rounded-md px-3 py-1.5">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {Math.floor(currentContent.duration_seconds / 60)}:00
                                            </div>
                                        )}
                                    </div>
                                    {currentContent.type !== 'exercise' && isCompleted && (
                                        <div className="px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold bg-white text-green-600 shadow-md">
                                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                            </svg>
                                            Selesai
                                        </div>
                                    )}
                                </div>
                                <h1 className="text-2xl font-bold mb-1">{currentContent.title}</h1>
                                {currentContent.description && (
                                    <p className="text-blue-100 text-sm">{currentContent.description}</p>
                                )}
                            </div>

                            {/* Module Content */}
                            <div className="bg-white rounded-b-lg shadow-lg p-8">
                                {renderContent()}
                            </div>

                            {/* Navigation */}
                            {!quizResult && (
                                <div className="bg-white rounded-lg shadow-lg p-6 mt-6">
                                    <h3 className="font-bold text-base mb-4 text-gray-800">Navigasi Konten</h3>
                                    <div className="flex gap-4">
                                        {previousContent ? (
                                            <Link
                                                href={route('courses.content.show', [course.id, previousContent.id])}
                                                className="flex-1 px-4 py-3 rounded-lg border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 transition"
                                            >
                                                <div className="text-xs text-gray-500 mb-1">Sebelumnya</div>
                                                <div className="font-medium text-sm truncate">{previousContent.title}</div>
                                            </Link>
                                        ) : (
                                            <div className="flex-1 px-4 py-3 rounded-lg border-2 border-gray-200 text-gray-400 cursor-not-allowed">
                                                <div className="text-xs mb-1">Sebelumnya</div>
                                                <div className="font-medium text-sm">-</div>
                                            </div>
                                        )}
                                        
                                        {nextContent ? (
                                            <Link
                                                href={route('courses.content.show', [course.id, nextContent.id])}
                                                className="flex-1 px-4 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition text-right shadow-md hover:shadow-lg"
                                            >
                                                <div className="text-xs opacity-80 mb-1">Selanjutnya</div>
                                                <div className="font-medium text-sm truncate">{nextContent.title}</div>
                                            </Link>
                                        ) : (
                                            <div className="flex-1 px-4 py-3 rounded-lg bg-gray-100 text-gray-400 text-right cursor-not-allowed">
                                                <div className="text-xs mb-1">Selanjutnya</div>
                                                <div className="font-medium text-sm">-</div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* Sidebar - Course Modules */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-lg shadow-lg p-5 sticky top-6">
                                <div className="flex items-center gap-2 mb-4">
                                    <svg className="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 className="font-bold text-lg text-gray-900">Konten Kursus</h3>
                                </div>
                                
                                <div className="mb-5">
                                    <div className="flex items-center justify-between text-sm mb-2">
                                        <span className="text-gray-600 font-medium">{contents.length} konten</span>
                                        <span className="font-bold text-blue-600">{Math.round(enrollment?.progress_percent || 0)}%</span>
                                    </div>
                                    <div className="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div 
                                            className="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" 
                                            style={{ width: `${enrollment?.progress_percent || 0}%` }}
                                        ></div>
                                    </div>
                                </div>

                                <div className="space-y-2 max-h-[550px] overflow-y-auto pr-1">
                                    {contents && contents.length > 0 ? (
                                        contents.map((module) => (
                                            <Link
                                                key={module.id}
                                                href={route('courses.content.show', [course.id, module.id])}
                                                onClick={(e) => handleVideoTutorialClick(e, module)}
                                                className={`block w-full text-left p-3 rounded-lg transition-all relative ${
                                                    currentContent.id === module.id
                                                        ? 'bg-blue-50 border-2 border-blue-500 shadow-sm'
                                                        : 'bg-gray-50 hover:bg-gray-100 border-2 border-transparent hover:border-gray-300'
                                                }`}
                                            >
                                                <div className="flex items-start gap-3">
                                                    <div className={`flex-shrink-0 w-9 h-9 rounded-md flex items-center justify-center ${
                                                        module.is_completed ? 'bg-green-100 text-green-600' : getTypeBadgeColor(module.type)
                                                    }`}>
                                                        {module.is_completed ? (
                                                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        ) : (
                                                            getTypeIcon(module.type)
                                                        )}
                                                    </div>
                                                    <div className="flex-1 min-w-0">
                                                        <p className={`text-xs uppercase font-bold mb-1 tracking-wide ${
                                                            module.type === 'content' ? 'text-green-600' :
                                                            module.type === 'video' ? 'text-orange-600' :
                                                            module.type === 'exercise' ? 'text-blue-600' : 'text-gray-600'
                                                        }`}>
                                                            {module.type === 'content' ? 'MODULE' : module.type === 'video' ? 'MODULE' : 'QUIZ'}
                                                        </p>
                                                        <p className="font-semibold text-sm text-gray-900 mb-1 leading-tight">{module.title}</p>
                                                        {module.duration_seconds && (
                                                            <p className="text-xs text-gray-500 flex items-center gap-1">
                                                                <svg className="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                {Math.floor(module.duration_seconds / 60)}:00
                                                            </p>
                                                        )}
                                                    </div>
                                                </div>
                                            </Link>
                                        ))
                                    ) : (
                                        <p className="text-gray-500 text-sm text-center py-8">Belum ada konten</p>
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
