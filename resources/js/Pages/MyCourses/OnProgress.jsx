import { Head, Link } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';

export default function OnProgress({ auth, courses }) {
    return (
        <LearningLayout auth={auth}>
            <Head title="My Courses - On Progress" />

            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">My Courses</h1>
                        <p className="text-gray-600">Courses you're currently learning</p>
                    </div>

                    {/* Courses Grid or Empty State */}
                    {courses.length > 0 ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {courses.map((course) => (
                                <Link
                                    key={course.id}
                                    href={route('courses.show', course.id)}
                                    className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300"
                                >
                                    {/* Course Image */}
                                    <div className="h-48 bg-gradient-to-r from-green-400 to-orange-500 flex items-center justify-center">
                                        <svg className="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>

                                    {/* Course Info */}
                                    <div className="p-6">
                                        <h3 className="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                            {course.title}
                                        </h3>
                                        <p className="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {course.description}
                                        </p>

                                        {/* Progress Bar */}
                                        <div className="mb-3">
                                            <div className="flex justify-between items-center mb-1">
                                                <span className="text-xs font-medium text-gray-700">Progress</span>
                                                <span className="text-xs font-medium text-green-600">
                                                    {Math.round(course.progress_percentage)}%
                                                </span>
                                            </div>
                                            <div className="w-full bg-gray-200 rounded-full h-2">
                                                <div
                                                    className="bg-gradient-to-r from-green-500 to-orange-500 h-2 rounded-full transition-all duration-300"
                                                    style={{ width: `${course.progress_percentage}%` }}
                                                ></div>
                                            </div>
                                        </div>

                                        {/* Continue Button */}
                                        <div className="flex items-center justify-between text-sm">
                                            <span className="text-gray-500">
                                                {course.completed_contents}/{course.total_contents} lessons
                                            </span>
                                            <span className="text-green-600 font-medium flex items-center gap-1">
                                                Continue
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white rounded-lg shadow-md p-12 text-center">
                            <div className="max-w-md mx-auto">
                                {/* Empty State Icon */}
                                <div className="mb-6 flex justify-center">
                                    <div className="w-24 h-24 bg-gradient-to-br from-green-100 to-orange-100 rounded-full flex items-center justify-center">
                                        <span className="text-5xl">📚</span>
                                    </div>
                                </div>

                                {/* Empty State Message */}
                                <h3 className="text-2xl font-bold text-gray-800 mb-3">
                                    Oopsie~
                                </h3>
                                <p className="text-gray-600 text-lg mb-6">
                                    You haven't taken any courses yet, silly! ✨
                                </p>

                                {/* CTA Button */}
                                <Link
                                    href={route('courses.index')}
                                    className="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-orange-500 text-white px-6 py-3 rounded-lg font-medium hover:from-green-600 hover:to-orange-600 transition-all duration-300 shadow-md hover:shadow-lg"
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Browse Courses
                                </Link>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </LearningLayout>
    );
}
