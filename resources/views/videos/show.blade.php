@extends('layouts.app')

@section('title', $video->title . ' - AgroWaste Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
                    <span class="ml-1 text-gray-500">Video</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Video Player -->
                <div class="bg-black aspect-video flex items-center justify-center">
                    <div class="text-white text-center p-8">
                        <svg class="w-20 h-20 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                        </svg>
                        <p class="text-sm text-gray-300">Video Player</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $video->video_url }}</p>
                        <p class="text-xs text-gray-500 mt-4">
                            Note: Untuk production, integrasikan dengan video player seperti YouTube, Vimeo, atau upload video ke storage
                        </p>
                    </div>
                </div>

                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $video->title }}</h1>
                    @if($video->description)
                        <p class="text-gray-600 mb-4">{{ $video->description }}</p>
                    @endif

                    @if($video->duration_seconds)
                        <p class="text-sm text-gray-500 mb-4">
                            ⏱️ Durasi: {{ gmdate('i:s', $video->duration_seconds) }}
                        </p>
                    @endif

                    @if($progress && !$progress->video_completed)
                        <form method="POST" action="{{ route('videos.complete', $video->id) }}">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                                ✓ Tandai Video Selesai Ditonton
                            </button>
                        </form>
                    @elseif($progress && $progress->video_completed)
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            ✓ Anda telah menyelesaikan video ini
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="flex justify-between mt-6 pt-6 border-t">
                        @if($previousVideo)
                            <a href="{{ route('videos.show', $previousVideo->id) }}" class="flex items-center text-primary-600 hover:text-primary-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Video Sebelumnya
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextVideo)
                            <a href="{{ route('videos.show', $nextVideo->id) }}" class="flex items-center text-primary-600 hover:text-primary-700">
                                Video Selanjutnya
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @elseif($quiz)
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="flex items-center bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                                Lanjut ke Kuis
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                <h3 class="font-bold text-lg mb-4">Daftar Video</h3>
                
                <div class="space-y-2">
                    @foreach($videos as $v)
                        <a href="{{ route('videos.show', $v->id) }}" 
                           class="block p-3 rounded-lg {{ $v->id == $video->id ? 'bg-primary-100 border-2 border-primary-600' : 'bg-gray-50 hover:bg-gray-100' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    @if($v->id == $video->id)
                                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium {{ $v->id == $video->id ? 'text-primary-900' : 'text-gray-900' }}">
                                        {{ $v->title }}
                                    </p>
                                    @if($v->duration_seconds)
                                        <p class="text-xs {{ $v->id == $video->id ? 'text-primary-600' : 'text-gray-500' }}">
                                            {{ gmdate('i:s', $v->duration_seconds) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($quiz)
                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('quizzes.show', $quiz->id) }}" 
                           class="block bg-primary-600 text-white text-center py-3 rounded-lg hover:bg-primary-700 transition font-semibold">
                            📝 Kerjakan Kuis
                        </a>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('modules.show', $module->slug) }}" 
                       class="block bg-gray-200 text-gray-800 text-center py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                        ← Kembali ke Modul
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
