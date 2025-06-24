@extends('admin.layouts.app')

@section('content')
<div class="container">
    <form id="quizForm" method="POST" action="{{ route('core.admin.quiz.store') }}">
        @csrf
        <div class="mb-3">
            <label for="quizTitle" class="form-label">Quiz Title</label>
            <input type="text" class="form-control" id="quizTitle" name="title" required>
        </div>
        <div class="mb-3">
            <label for="quizDescription" class="form-label">Description</label>
            <textarea class="form-control" id="quizDescription" name="description" rows="3" required></textarea>
        </div>
        <hr>
        <div id="questionsWrapper">
            <!-- Questions will be added here -->
        </div>
        <button type="button" class="btn btn-sm btn-primary mb-3" onclick="addQuestion()">{{__('Add Question')}}</button>
        <br>
        <button type="submit" class="btn btn-success">{{__("Create Quiz")}}</button>
    </form>
</div>

<template id="questionTemplate">
    <div class="card mb-3 question-block">
        <div class="card-body">
            <button type="button" class="btn btn-danger btn-sm float-right d-flex align-items-center my-2 " aria-label="Remove" onclick="removeQuestion(this)">
                <i class="bi bi-trash-fill text-white"></i> <span class="text-white"><i class="fa fa-trash-o"></i></span>
            </button>
            <div class="mb-2">
                <label class="form-label">Question</label>
                <input type="text" class="form-control" name="questions[__INDEX__][question]" required>
            </div>
            <div class="answersWrapper">
                <!-- Answers will be added here -->
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addAnswer(this)">Add Answer</button>
        </div>
    </div>
</template>

<template id="answerTemplate">
    <div class="input-group mb-2 answer-block">
        <div class="input-group-text">
            <input type="checkbox" name="questions[__QINDEX__][answers][__AINDEX__][is_correct]" value="1">
        </div>
        <input type="text" class="form-control" name="questions[__QINDEX__][answers][__AINDEX__][answer]" required>
        <button type="button" class="btn btn-outline-danger" onclick="removeAnswer(this)">Remove</button>
    </div>
</template>


<script>
    let questionCount = 0;

    function addQuestion() {
        const qTemplate = document.getElementById('questionTemplate').content.cloneNode(true);
        const qHtml = qTemplate.querySelector('.question-block');
        const qIndex = questionCount++;
        // Update question input name
        qHtml.querySelector('input[name^="questions"]').name = `questions[${qIndex}][question]`;
        // Add first two answers by default
        const answersWrapper = qHtml.querySelector('.answersWrapper');
        for (let i = 0; i < 4; i++) {
            answersWrapper.appendChild(createAnswer(qIndex, i));
        }
        qHtml.querySelector('button[onclick^="addAnswer"]').setAttribute('data-qindex', qIndex);
        document.getElementById('questionsWrapper').appendChild(qHtml);
    }

    function removeQuestion(btn) {
        btn.closest('.question-block').remove();
    }

    function addAnswer(btn) {
        const qBlock = btn.closest('.question-block');
        const qIndex = Array.from(document.getElementById('questionsWrapper').children).indexOf(qBlock);
        const answersWrapper = qBlock.querySelector('.answersWrapper');
        const aIndex = answersWrapper.children.length;
        answersWrapper.appendChild(createAnswer(qIndex, aIndex));
    }

    function removeAnswer(btn) {
        btn.closest('.answer-block').remove();
    }

    function createAnswer(qIndex, aIndex) {
        const aTemplate = document.getElementById('answerTemplate').content.cloneNode(true);
        const checkbox = aTemplate.querySelector('input[type="checkbox"]');
        const input = aTemplate.querySelector('input[type="text"]');
        checkbox.name = `questions[${qIndex}][answers][${aIndex}][is_correct]`;
        input.name = `questions[${qIndex}][answers][${aIndex}][answer]`;
        return aTemplate;
    }

    // Add first question on page load
    document.addEventListener('DOMContentLoaded', function() {
        addQuestion();
    });
</script>
@endsection