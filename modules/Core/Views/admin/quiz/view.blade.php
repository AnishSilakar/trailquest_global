@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ $quiz->title ?? 'Quiz Details' }}</h2>
    <p>{{ $quiz->description ?? 'No description available.' }}</p>

    <hr>
    <h4>Questions</h4>
    <div id="questions-container">
        @if(!empty($quiz->questions))
            @foreach($quiz->questions as $key => $question)
                <div class="question-block border p-3 mb-3">
                    <div class="mb-2">
                        <strong>Question {{$key + 1}}:</strong> {{ $question->questions }}
                    </div>
                    <div class="mb-2">
                        <strong>Options:</strong>
                        <ul>
                            @foreach($question->answers as $answer)
                                <li>{{ $answer->answers }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @else
            <p>No questions available for this quiz.</p>
        @endif
    </div>
@endsection

