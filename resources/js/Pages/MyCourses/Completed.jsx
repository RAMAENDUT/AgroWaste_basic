import { Head, Link } from '@inertiajs/react';
import LearningLayout from '@/Layouts/LearningLayout';

export default function Completed({ auth, courses }) {
    return (
        <LearningLayout auth={auth}>
            <Head title="My Courses - Completed" />

            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">Completed Courses</h1>
                        <p className="text-gray-600">Courses you've successfully completed</p>
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
                                    <div className="h-48 bg-gradient-to-r from-green-400 to-orange-500 flex items-center justify-center relative">
                                        <svg className="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        {/* Completed Badge */}
                                        <div className="absolute top-3 right-3 bg-white rounded-full p-2 shadow-lg">
                                            <svg className="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>

                                    {/* Course Info */}
                                    <div className="p-6">
                                        <h3 className="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                            {course.title}
                                        </h3>
                                        <p className="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {course.description}
                                        </p>

                                        {/* Completion Badge */}
                                        <div className="mb-3">
                                            <div className="flex items-center gap-2 text-green-600 font-medium">
                                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                </svg>
                                                <span className="text-sm">100% Completed</span>
                                            </div>
                                        </div>

                                        {/* Review Button */}
                                        <div className="flex items-center justify-between text-sm">
                                            <span className="text-gray-500">
                                                {course.total_contents} lessons
                                            </span>
                                            <span className="text-green-600 font-medium flex items-center gap-1">
                                                Review
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
                                        <span className="text-5xl">🎓</span>
                                    </div>
                                </div>

                                {/* Empty State Message */}
                                <h3 className="text-2xl font-bold text-gray-800 mb-3">
                                    Oopsie~
                                </h3>
                                <p className="text-gray-600 text-lg mb-6">
                                    Finish your courses first, silly! 🎓
                                </p>

                                {/* CTA Button */}
                                <Link
                                    href={route('my-courses.on-progress')}
                                    className="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-orange-500 text-white px-6 py-3 rounded-lg font-medium hover:from-green-600 hover:to-orange-600 transition-all duration-300 shadow-md hover:shadow-lg"
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Continue Learning
                                </Link>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </LearningLayout>
    );
}
