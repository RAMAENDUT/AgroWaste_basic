@extends('layouts.app')

@section('title', $quiz->title . ' - AgroWaste Academy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('modules.show', $module->slug) }}" class="ml-1 text-gray-700 hover:text-primary-600">{{ $module->title }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-1 text-gray-500">Kuis</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">📝</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h1>
            @if($quiz->description)
                <p class="text-gray-600">{{ $quiz->description }}</p>
            @endif
        </div>

        <!-- Quiz Info -->
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <p class="text-sm text-blue-600 font-semibold">Jumlah Soal</p>
                <p class="text-2xl font-bold text-blue-900">{{ $quiz->getTotalQuestions() }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <p class="text-sm text-green-600 font-semibold">Nilai Lulus</p>
                <p class="text-2xl font-bold text-green-900">{{ $quiz->passing_score }}</p>
            </div>
            @if($quiz->duration_minutes)
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-yellow-600 font-semibold">Durasi</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $quiz->duration_minutes }} menit</p>
                </div>
            @endif
        </div>

        @if($bestScore !== null)
            <div class="bg-primary-50 border-l-4 border-primary-600 p-4 mb-6">
                <p class="text-sm font-semibold text-primary-900">Skor Terbaik Anda: <span class="text-2xl">{{ $bestScore }}</span></p>
            </div>
        @endif

        <!-- Previous Attempts -->
        @if($previousAttempts->count() > 0)
            <div class="mb-8">
                <h3 class="font-bold text-lg mb-4">Riwayat Percobaan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Percobaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($previousAttempts as $attempt)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        #{{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                        {{ $attempt->score }}/100
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attempt->is_passed)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Lulus
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Tidak Lulus
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $attempt->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Instructions -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <h4 class="font-bold text-yellow-900 mb-2">Instruksi:</h4>
            <ul class="list-disc list-inside text-sm text-yellow-800 space-y-1">
                <li>Baca setiap pertanyaan dengan teliti</li>
                <li>Pilih satu jawaban yang paling tepat</li>
                <li>Anda dapat mengulang kuis jika tidak lulus</li>
                <li>Nilai minimum kelulusan adalah {{ $quiz->passing_score }}</li>
            </ul>
        </div>

        <!-- Start Quiz Button -->
        <div class="text-center">
            <a href="{{ route('quizzes.start', $quiz->id) }}" 
               class="inline-block bg-primary-600 text-white px-8 py-3 rounded-lg hover:bg-primary-700 transition font-semibold text-lg">
                @if($previousAttempts->count() > 0)
                    Coba Lagi
                @else
                    Mulai Kuis
                @endif
            </a>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('modules.show', $module->slug) }}" class="text-gray-600 hover:text-gray-800">
                ← Kembali ke Modul
            </a>
        </div>
    </div>
</div>
@endsection
