@extends('layouts.app')

@section('title', $module->title . ' - AgroWaste Academy')

@section('content')
<div class="px-8 py-8">
    <div class="space-y-4 max-w-4xl">
        <div class="p-4 bg-white shadow rounded">
            <h1 class="text-2xl font-semibold mb-2">{{ $module->title }}</h1>
            <p class="text-gray-700 mb-4">{{ $module->description }}</p>
            
            <div class="prose max-w-none mb-6">
                {!! $module->content !!}
            </div>
            
            <div class="flex gap-3">
                @if($firstVideo)
                    <a href="{{ route('videos.show', $firstVideo->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Tonton Video</a>
                @endif
                @if($firstQuiz)
                    <a href="{{ route('quizzes.show', $firstQuiz->id) }}" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Kerjakan Kuis</a>
                @endif
            </div>
        </div>
        
        @if($videos->count() > 0)
        <div>
            <h3 class="font-semibold mb-2">Video ({{ $videos->count() }})</h3>
            <ul class="list-disc ml-5 text-sm">
                @foreach($videos as $v)
                    <li>
                        <a class="text-blue-600 hover:underline" href="{{ route('videos.show', $v->id) }}">{{ $v->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        
        @if($firstQuiz)
        <div>
            <h3 class="font-semibold mb-2">Kuis</h3>
            <p class="text-sm">Passing score: {{ $firstQuiz->passing_score }}%</p>
            <p class="text-sm text-gray-600 mt-1">{{ $firstQuiz->questions->count() }} pertanyaan tersedia</p>
            @if($progress && $progress->quiz_completed)
                <div class="mt-2 inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">
                    ✓ Selesai (Skor: {{ $progress->quiz_score }})
                </div>
            @endif
        </div>
        @else
        <div>
            <h3 class="font-semibold mb-2">Kuis</h3>
            <p class="text-sm text-gray-500">Belum ada kuis.</p>
        </div>
        @endif

        @if($progress)
            <div class="bg-gray-100 rounded p-4">
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-medium">Progress Modul</span>
                    <span class="text-green-600 font-semibold">{{ $progress->getProgressPercentage() }}%</span>
                </div>
                <div class="w-full bg-gray-300 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress->getProgressPercentage() }}%"></div>
                </div>
                @if($progress->isFullyCompleted())
                    <div class="mt-3 text-center text-sm text-green-700 font-semibold">
                        🎉 Modul selesai!
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
