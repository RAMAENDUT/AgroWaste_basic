@extends('layouts.app')

@section('title', 'Hasil Kuis - AgroWaste Academy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Result Header -->
        <div class="text-center mb-8">
            @if($attempt->is_passed)
                <div class="text-6xl mb-4">🎉</div>
                <h1 class="text-3xl font-bold text-green-600 mb-2">Selamat! Anda Lulus!</h1>
                <p class="text-gray-600">Anda telah berhasil menyelesaikan kuis ini</p>
            @else

                <div class="text-6xl mb-4">😔</div>
                <h1 class="text-3xl font-bold text-red-600 mb-2">Belum Lulus</h1>
                <p class="text-gray-600">Jangan menyerah, coba lagi!</p>
            @endif
        </div>

        <!-- Score Display -->
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg p-8 text-white text-center mb-8">
            <p class="text-lg mb-2">Skor Anda</p>
            <p class="text-6xl font-bold">{{ $attempt->score }}</p>
            <p class="text-sm mt-2 text-primary-100">dari 100</p>
        </div>

        <!-- Statistics -->
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <p class="text-sm text-blue-600 font-semibold">Total Soal</p>
                <p class="text-3xl font-bold text-blue-900">{{ $attempt->total_questions }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <p class="text-sm text-green-600 font-semibold">Jawaban Benar</p>
                <p class="text-3xl font-bold text-green-900">{{ $attempt->correct_answers }}</p>
            </div>
            <div class="bg-red-50 rounded-lg p-4 text-center">
                <p class="text-sm text-red-600 font-semibold">Jawaban Salah</p>
                <p class="text-3xl font-bold text-red-900">{{ $attempt->total_questions - $attempt->correct_answers }}</p>
            </div>
        </div>

        <!-- Passing Score Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-8">
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Nilai Minimum Kelulusan:</span>
                <span class="text-2xl font-bold text-gray-900">{{ $quiz->passing_score }}</span>
            </div>
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-primary-600 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ min(($attempt->score / $quiz->passing_score) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Module Completion -->
        @if($allCompleted)
            <div class="bg-green-50 border-2 border-green-400 rounded-lg p-6 mb-8 text-center">
                <div class="text-5xl mb-4">🎊</div>
                <h3 class="text-2xl font-bold text-green-900 mb-2">Modul Selesai!</h3>
                <p class="text-green-700">
                    Selamat! Anda telah menyelesaikan semua bagian dari modul 
                    <strong>{{ $module->title }}</strong>
                </p>
                <p class="text-green-600 mt-2">
                    Anda sekarang memahami cara {{ strtolower($module->title) }}
                </p>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            @if(!$attempt->is_passed)
                <a href="{{ route('quizzes.show', $quiz->id) }}" 
                   class="flex-1 bg-primary-600 text-white text-center py-3 rounded-lg hover:bg-primary-700 transition font-semibold">
                    🔄 Coba Lagi
                </a>
            @endif
            
            <a href="{{ route('modules.show', $module->slug) }}" 
               class="flex-1 bg-gray-200 text-gray-800 text-center py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                ← Kembali ke Modul
            </a>
            
            @if($allCompleted)
                <a href="{{ route('modules.index') }}" 
                   class="flex-1 bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                    Modul Lainnya →
                </a>
            @endif
        </div>

        <!-- Motivational Message -->
        <div class="mt-8 text-center text-gray-600 text-sm">
            @if($attempt->is_passed)
                <p>💪 Pertahankan semangat belajar Anda!</p>
            @else
                <p>💪 Pelajari kembali materinya dan coba lagi. Anda pasti bisa!</p>
            @endif
        </div>
    </div>
</div>
@endsection
