@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($quiz) ? 'Edit' : 'Create' }} Quiz</h2>

    <form action="{{ isset($quiz) ? route('core.admin.quiz.update', $quiz->id) : route('core.admin.quiz.store') }}" method="POST">
        @csrf
        @if(isset($quiz))
            @method('PUT')
        @endif

        <!-- Quiz Title -->
        <div class="mb-3">
            <label class="form-label">Quiz Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $quiz->title ?? '') }}" required>
        </div>

        <!-- Quiz Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $quiz->description ?? '') }}</textarea>
        </div>

        <hr>
        <h4>Questions</h4>
        <div id="questions-container">
            @php
                $questions = old('questions', $quiz->questions ?? []);
            @endphp

            <!-- Display existing questions if available -->
            @foreach($questions as $qIndex => $question)
                <div class="question-block border p-3 mb-3">
                    <div class="mb-2">
                        <label>Question</label>
                        <input type="text" name="questions[{{ $loop->index }}][question]" class="form-control" value="{{ $questions[$qIndex]->questions }}" required>
                    </div>

                    <div class="mb-2">
                        <label>Answers</label>
                        <div class="row">
                            @foreach(range(0,3) as $aIndex)
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="questions[{{ $loop->parent->index }}][answers][]" class="form-control"
                                           placeholder="Answer {{ $aIndex + 1 }}"
                                           value="{{ $question['answers'][$aIndex]->answers ?? '' }}" required>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" class="btn btn-danger btn-sm remove-question">Remove Question</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
        <br><br>
        <button type="submit" class="btn btn-primary">{{ isset($quiz) ? 'Update' : 'Create' }} Quiz</button>
    </form>
</div>

<!-- Template for new questions -->
<template id="question-template">
    <div class="question-block border p-3 mb-3">
        <div class="mb-2">
            <label>Question</label>
            <input type="text" name="questions[__INDEX__][question]" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Answers</label>
            <div class="row">
                @foreach(range(0,3) as $aIndex)
                    <div class="col-md-6 mb-2">
                        <input type="text" name="questions[__INDEX__][answers][]" class="form-control" placeholder="Answer {{ $aIndex + 1 }}" required>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="button" class="btn btn-danger btn-sm remove-question">Remove Question</button>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = {{ count($questions) }};
        document.getElementById('add-question').addEventListener('click', function () {
            const template = document.getElementById('question-template').innerHTML;
            const html = template.replace(/__INDEX__/g, questionIndex);
            document.getElementById('questions-container').insertAdjacentHTML('beforeend', html);
            questionIndex++;
        });

        document.getElementById('questions-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.closest('.question-block').remove();
            }
        });
    });
</script>

@endsection