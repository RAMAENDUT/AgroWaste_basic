import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';

export default function CourseShowSimple({ course, contents, enrollment }) {
    const [selectedModuleIndex, setSelectedModuleIndex] = useState(0);
    const [isCompleted, setIsCompleted] = useState(false);
    const currentModule = contents[selectedModuleIndex] || {};

    const handleModuleClick = (index) => {
        setSelectedModuleIndex(index);
        setIsCompleted(false);
    };

    const handleMarkComplete = () => {
        setIsCompleted(true);
        // TODO: Send to backend to update progress
    };

    const handlePrevious = () => {
        if (selectedModuleIndex > 0) {
            handleModuleClick(selectedModuleIndex - 1);
        }
    };

    const handleNext = () => {
        if (selectedModuleIndex < contents.length - 1) {
            handleModuleClick(selectedModuleIndex + 1);
        }
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
            case 'content': return 'bg-green-100 text-green-700';
            case 'video': return 'bg-orange-100 text-orange-700';
            case 'exercise': return 'bg-blue-100 text-blue-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    };

    const renderModuleContent = () => {
        if (!currentModule || !currentModule.type) {
            return (
                <div className="text-center py-12 text-gray-500">
                    <p>Tidak ada modul yang dipilih</p>
                </div>
            );
        }

        // Render HTML Content
        if (currentModule.type === 'content' && currentModule.content_text) {
            return (
                <div className="prose max-w-none">
                    <h2 className="text-2xl font-bold mb-4">{currentModule.title}</h2>
                    {currentModule.description && (
                        <p className="text-gray-600 mb-6">{currentModule.description}</p>
                    )}
                    <div dangerouslySetInnerHTML={{ __html: currentModule.content_text }} />
                </div>
            );
        }

        // Render Video
        if (currentModule.type === 'video' && currentModule.video_path) {
            return (
                <div>
                    <h2 className="text-2xl font-bold mb-4">{currentModule.title}</h2>
                    {currentModule.description && (
                        <p className="text-gray-600 mb-6">{currentModule.description}</p>
                    )}
                    <div className="bg-black rounded-lg overflow-hidden">
                        <video 
                            controls 
                            className="w-full"
                            src={currentModule.video_path}
                        >
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            );
        }

        // Render Exercise
        if (currentModule.type === 'exercise' && currentModule.exercise) {
            return (
                <div>
                    <h2 className="text-2xl font-bold mb-4">{currentModule.title}</h2>
                    {currentModule.description && (
                        <p className="text-gray-600 mb-6">{currentModule.description}</p>
                    )}
                    
                    <div className="space-y-6">
                        {currentModule.exercise.questions && currentModule.exercise.questions.map((question, qIndex) => (
                            <div key={question.id} className="bg-gray-50 rounded-lg p-6">
                                <p className="font-medium mb-4">
                                    {qIndex + 1}. {question.question_text}
                                </p>
                                <div className="space-y-2">
                                    {question.options && question.options.map((option) => (
                                        <label 
                                            key={option.id} 
                                            className="flex items-center p-3 bg-white rounded border hover:border-blue-500 cursor-pointer"
                                        >
                                            <input 
                                                type="radio" 
                                                name={`question_${question.id}`}
                                                value={option.id}
                                                className="mr-3"
                                            />
                                            <span>{option.option_text}</span>
                                        </label>
                                    ))}
                                </div>
                            </div>
                        ))}
                        
                        <button 
                            className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition"
                        >
                            Submit Jawaban
                        </button>
                    </div>
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
        <>
            <Head title={`${currentModule.title || course.title} - AgroWaste`} />
            
            <div className="min-h-screen bg-gradient-to-b from-blue-50/30 to-white">
                {/* Header with Back Button */}
                <div className="bg-white border-b">
                    <div className="max-w-7xl mx-auto px-6 py-4">
                        <div className="flex items-center gap-4">
                            <Link 
                                href={route('courses.index')}
                                className="flex items-center justify-center w-10 h-10 bg-green-600 hover:bg-green-700 text-white rounded transition"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                </svg>
                            </Link>
                            <div className="flex-1">
                                <div className="text-sm text-gray-500 mb-1">
                                    <Link href={route('home')} className="hover:text-gray-700">Home</Link>
                                    <span className="mx-2">›</span>
                                    <Link href={route('courses.index')} className="hover:text-gray-700">Kursus</Link>
                                    <span className="mx-2">›</span>
                                    <span>{course.title}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="max-w-7xl mx-auto px-6 py-6">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {/* Main Content Area */}
                        <div className="lg:col-span-2">
                            {/* Module Header */}
                            <div className="bg-blue-600 text-white rounded-t-xl p-6">
                                <div className="flex items-start justify-between mb-3">
                                    <div className="flex items-center gap-3">
                                        <div className="bg-white/20 rounded px-3 py-1 flex items-center gap-2 text-sm">
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            MODULE
                                        </div>
                                        {currentModule.duration_seconds && (
                                            <div className="flex items-center gap-1 text-sm">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {Math.floor(currentModule.duration_seconds / 60)}:00
                                            </div>
                                        )}
                                    </div>
                                    <button 
                                        onClick={handleMarkComplete}
                                        className={`px-4 py-2 rounded-lg flex items-center gap-2 transition ${
                                            isCompleted 
                                                ? 'bg-white text-green-600' 
                                                : 'bg-green-500 hover:bg-green-600 text-white'
                                        }`}
                                    >
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                        </svg>
                                        Selesai
                                    </button>
                                </div>
                                <h1 className="text-2xl font-bold">{currentModule.title || 'Untitled Module'}</h1>
                                {currentModule.description && (
                                    <p className="mt-2 text-blue-100">{currentModule.description}</p>
                                )}
                            </div>

                            {/* Module Content */}
                            <div className="bg-white rounded-b-xl shadow-sm p-8">
                                {renderModuleContent()}
                            </div>

                            {/* Navigation */}
                            <div className="bg-white rounded-xl shadow-sm p-6 mt-6">
                                <h3 className="font-semibold mb-4">Navigasi Konten</h3>
                                <div className="flex justify-between gap-4">
                                    <button
                                        onClick={handlePrevious}
                                        disabled={selectedModuleIndex === 0}
                                        className={`flex-1 px-4 py-3 rounded-lg border-2 transition ${
                                            selectedModuleIndex === 0
                                                ? 'border-gray-200 text-gray-400 cursor-not-allowed'
                                                : 'border-gray-300 hover:border-gray-400 text-gray-700'
                                        }`}
                                    >
                                        <div className="text-xs text-gray-500 mb-1">Sebelumnya</div>
                                        <div className="font-medium text-sm">
                                            {selectedModuleIndex > 0 ? contents[selectedModuleIndex - 1].title : '-'}
                                        </div>
                                    </button>
                                    
                                    <button
                                        onClick={handleNext}
                                        disabled={selectedModuleIndex === contents.length - 1}
                                        className={`flex-1 px-4 py-3 rounded-lg transition text-right ${
                                            selectedModuleIndex === contents.length - 1
                                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                                : 'bg-blue-600 hover:bg-blue-700 text-white'
                                        }`}
                                    >
                                        <div className="text-xs opacity-75 mb-1">Selanjutnya</div>
                                        <div className="font-medium text-sm">
                                            {selectedModuleIndex < contents.length - 1 ? contents[selectedModuleIndex + 1].title : '-'}
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* Sidebar - Course Modules */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-xl shadow-sm p-5 sticky top-6">
                                <div className="flex items-center justify-between mb-4">
                                    <div className="flex items-center gap-2">
                                        <svg className="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 className="font-bold text-lg">Konten Kursus</h3>
                                    </div>
                                </div>
                                
                                <div className="mb-4">
                                    <div className="flex items-center justify-between text-sm mb-2">
                                        <span className="text-gray-600">{contents.length} konten</span>
                                        <span className="font-semibold text-blue-600">{enrollment?.progress_percent || 0}%</span>
                                    </div>
                                    <div className="w-full bg-gray-200 rounded-full h-2">
                                        <div 
                                            className="bg-blue-600 h-2 rounded-full transition-all" 
                                            style={{ width: `${enrollment?.progress_percent || 0}%` }}
                                        ></div>
                                    </div>
                                </div>

                                <div className="space-y-2 max-h-[600px] overflow-y-auto">
                                    {contents && contents.length > 0 ? (
                                        contents.map((module, index) => (
                                            <button
                                                key={module.id}
                                                onClick={() => handleModuleClick(index)}
                                                className={`w-full text-left p-3 rounded-lg transition border ${
                                                    selectedModuleIndex === index
                                                        ? 'bg-blue-50 border-blue-500'
                                                        : 'bg-gray-50 hover:bg-gray-100 border-transparent'
                                                }`}
                                            >
                                                <div className="flex items-start gap-3">
                                                    <div className={`flex-shrink-0 w-8 h-8 rounded flex items-center justify-center ${
                                                        isCompleted && selectedModuleIndex === index
                                                            ? 'bg-green-100 text-green-600'
                                                            : getTypeBadgeColor(module.type)
                                                    }`}>
                                                        {isCompleted && selectedModuleIndex === index ? (
                                                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        ) : (
                                                            getTypeIcon(module.type)
                                                        )}
                                                    </div>
                                                    <div className="flex-1 min-w-0">
                                                        <p className={`text-xs uppercase font-semibold mb-1 ${
                                                            module.type === 'content' ? 'text-green-600' :
                                                            module.type === 'video' ? 'text-orange-600' :
                                                            module.type === 'exercise' ? 'text-blue-600' : 'text-gray-600'
                                                        }`}>
                                                            {module.type === 'content' ? 'MODULE' : module.type === 'video' ? 'MODULE' : 'QUIZ'}
                                                        </p>
                                                        <p className="font-medium text-sm text-gray-900 mb-1">{module.title}</p>
                                                        {module.duration_seconds && (
                                                            <p className="text-xs text-gray-500">
                                                                {Math.floor(module.duration_seconds / 60)}:00
                                                            </p>
                                                        )}
                                                    </div>
                                                </div>
                                            </button>
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
        </>
    );
}
