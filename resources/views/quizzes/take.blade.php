@extends('layouts.app')

@section('title', 'Mengerjakan Kuis - AgroWaste Academy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h1>
            <p class="text-gray-600">Jawab semua pertanyaan di bawah ini</p>
        </div>

        <form method="POST" action="{{ route('quizzes.submit', $quiz->id) }}">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @foreach($quiz->questions as $index => $question)
                <div class="mb-8 pb-8 border-b border-gray-200 last:border-b-0">
                    <div class="flex items-start mb-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">{{ $question->question }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $question->points }} poin</p>
                        </div>
                    </div>

                    <div class="ml-11 space-y-2">
                        @foreach($question->options as $option)
                            <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary-300 hover:bg-primary-50 transition">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $option->id }}"
                                       class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                       required>
                                <span class="ml-3 text-gray-700">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between items-center pt-6 border-t">
                <a href="{{ route('quizzes.show', $quiz->id) }}" class="text-gray-600 hover:text-gray-800">
                    ← Batal
                </a>
                <button type="submit" 
                        class="bg-primary-600 text-white px-8 py-3 rounded-lg hover:bg-primary-700 transition font-semibold"
                        onclick="return confirm('Apakah Anda yakin ingin mengirim jawaban?')">
                    Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Warn user before leaving page
    let formSubmitted = false;
    document.querySelector('form').addEventListener('submit', function() {
        formSubmitted = true;
    });

    window.addEventListener('beforeunload', function (e) {
        if (!formSubmitted) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });
</script>
@endsection
