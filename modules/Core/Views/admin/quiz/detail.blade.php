@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($quiz) ? 'Edit' : 'Create' }} Quiz</h2>

    <form id="quiz-form" action="{{ isset($quiz) ? route('core.admin.quiz.update', $quiz->id) : route('core.admin.quiz.store') }}" method="POST">
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
            <textarea name="description" class="form-control" id="quiz-description" required>{{ old('description', $quiz->description ?? '') }}</textarea>
        </div>

        <hr>
        <h4>Questions</h4>
        <div id="questions-container">
            @php
                // For edit, reconstruct $questions array from DB structure
                if (isset($quiz) && $quiz->questions && $quiz->questions->count()) {
                    $questions = [];
                    foreach ($quiz->questions as $q) {
                        $qArr = [
                            'question' => $q['questions'],
                            'type' => $q->type,
                        ];
                        // Paragraph
                        if ($q->type === 'paragraph') {
                            $qArr['paragraph'] = optional($q->answers->first())->paragraph ?? '';
                        }
                        // Range
                        elseif ($q->type === 'range') {
                            $qArr['range_min'] = optional($q->answers->first())->range_min ?? '';
                            $qArr['range_max'] = optional($q->answers->first())->range_max ?? '';
                        }
                        // Options
                        else {
                            $qArr['answers'] = $q->answers->pluck('answers')->toArray();
                        }
                        $questions[] = $qArr;
                    }
                } else {
                    $questions = old('questions', $quiz->questions ?? []);
                }
            @endphp
            @foreach($questions as $qIndex => $question)
                @php
                    // Determine type based on data
                    if (!empty($question['answers']) && is_array($question['answers'])) {
                        $type = 'options';
                    } elseif (!empty($question['paragraph'])) {
                        $type = 'paragraph';
                    } elseif (
                        (isset($question['range_min']) && $question['range_min'] !== null) ||
                        (isset($question['range_max']) && $question['range_max'] !== null)
                    ) {
                        $type = 'range';
                    } else {
                        $type = $question['type'] ?? 'options';
                    }
                @endphp
                <div class="question-block border p-3 mb-3">
                    <div class="mb-2">
                        <label>Question</label>
                        <input type="text" name="questions[{{ $loop->index }}][question]" class="form-control" value="{{ $question['question'] ?? '' }}" required>
                    </div>

                    <div class="mb-2">
                        <label>Type</label>
                        <select name="questions[{{ $loop->index }}][type]" class="form-select question-type">
                            <option value="options" {{ $type == 'options' ? 'selected' : '' }}>Options</option>
                            <option value="paragraph" {{ $type == 'paragraph' ? 'selected' : '' }}>Paragraph</option>
                            <option value="range" {{ $type == 'range' ? 'selected' : '' }}>Range</option>
                        </select>
                    </div>

                    <div class="mb-2 question-options{{ $type == 'options' ? '' : ' d-none' }}">
                        <label>Answers</label>
                        <div class="row">
                            @foreach(range(0,3) as $aIndex)
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="questions[{{ $loop->parent->index }}][answers][]" class="form-control"
                                           placeholder="Answer {{ $aIndex + 1 }}"
                                           value="{{ $question['answers'][$aIndex] ?? '' }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-2 question-paragraph{{ $type == 'paragraph' ? '' : ' d-none' }}">
                        <label>Paragraph Answer</label>
                        <textarea name="questions[{{ $loop->index }}][paragraph]" class="form-control ckeditor">{{ $question['paragraph'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-2 question-range{{ $type == 'range' ? '' : ' d-none' }}">
                        <label>Range</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="questions[{{ $loop->index }}][range_min]" class="form-control" placeholder="Min" value="{{ $question['range_min'] ?? '' }}">
                            </div>
                            <div class="col">
                                <input type="number" name="questions[{{ $loop->index }}][range_max]" class="form-control" placeholder="Max" value="{{ $question['range_max'] ?? '' }}">
                            </div>
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
            <label>Type</label>
            <select name="questions[__INDEX__][type]" class="form-select question-type">
                <option value="options" selected>Options</option>
                <option value="paragraph">Paragraph</option>
                <option value="range">Range</option>
            </select>
        </div>

        <div class="mb-2 question-options">
            <label>Answers</label>
            <div class="row">
                @foreach(range(0,3) as $aIndex)
                    <div class="col-md-6 mb-2">
                        <input type="text" name="questions[__INDEX__][answers][]" class="form-control" placeholder="Answer {{ $aIndex + 1 }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-2 question-paragraph" style="display:none;">
            <label>Paragraph Answer</label>
            <textarea name="questions[__INDEX__][paragraph]" class="form-control ckeditor"></textarea>
        </div>

        <div class="mb-2 question-range" style="display:none;">
            <label>Range</label>
            <div class="row">
                <div class="col">
                    <input type="number" name="questions[__INDEX__][range_min]" class="form-control" placeholder="Min" value="0">
                </div>
                <div class="col">
                    <input type="number" name="questions[__INDEX__][range_max]" class="form-control" placeholder="Max" value="0">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-danger btn-sm remove-question">Remove Question</button>
    </div>
</template>

<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    // Store CKEditor instances
    let ckeditors = {};

    function initCKEditors() {
        document.querySelectorAll('.ckeditor').forEach(function(el) {
            if (!el.classList.contains('ck-editor__editable') && !el.dataset.ckeditorInitialized) {
                ClassicEditor.create(el).then(editor => {
                    ckeditors[el.name] = editor;
                    el.dataset.ckeditorInitialized = "1";
                }).catch(error => {});
            }
        });
    }

    function destroyCKEditor(el) {
        if (el && el.name && ckeditors[el.name]) {
            ckeditors[el.name].destroy().then(() => {
                delete ckeditors[el.name];
                el.value = '';
                el.removeAttribute('data-ckeditor-initialized');
            });
        } else if (el) {
            el.value = '';
        }
    }

    function resetQuestionFields(block, type) {
        // Reset all fields except the selected type
        if (type !== 'options') {
            block.querySelectorAll('input[name*="[answers]"]').forEach(function(input) {
                input.value = '';
            });
        }
        if (type !== 'paragraph') {
            block.querySelectorAll('textarea[name*="[paragraph]"]').forEach(function(textarea) {
                destroyCKEditor(textarea);
            });
        }
        if (type !== 'range') {
            block.querySelectorAll('input[name*="[range_min]"], input[name*="[range_max]"]').forEach(function(input) {
                input.value = '';
            });
        }
        // Only keep value for current type
        if (type === 'paragraph') {
            // Reset options and range
            block.querySelectorAll('input[name*="[answers]"]').forEach(function(input) {
                input.value = '';
            });
            block.querySelectorAll('input[name*="[range_min]"], input[name*="[range_max]"]').forEach(function(input) {
                input.value = '';
            });
        } else if (type === 'options') {
            // Reset paragraph and range
            block.querySelectorAll('textarea[name*="[paragraph]"]').forEach(function(textarea) {
                destroyCKEditor(textarea);
            });
            block.querySelectorAll('input[name*="[range_min]"], input[name*="[range_max]"]').forEach(function(input) {
                input.value = '';
            });
        } else if (type === 'range') {
            // Reset options and paragraph
            block.querySelectorAll('input[name*="[answers]"]').forEach(function(input) {
                input.value = '';
            });
            block.querySelectorAll('textarea[name*="[paragraph]"]').forEach(function(textarea) {
                destroyCKEditor(textarea);
            });
        }
    }

    function handleQuestionTypeChange(block) {
        const type = block.querySelector('.question-type').value;
        block.querySelector('.question-options').style.display = type === 'options' ? '' : 'none';
        block.querySelector('.question-paragraph').style.display = type === 'paragraph' ? '' : 'none';
        block.querySelector('.question-range').style.display = type === 'range' ? '' : 'none';
        resetQuestionFields(block, type);
        if (type === 'paragraph') {
            setTimeout(initCKEditors, 100);
        }
    }

    // Range min/max validation
    function validateRanges() {
        let valid = true;
        let errorMsg = '';
        document.querySelectorAll('.question-block').forEach(function(block, idx) {
            const type = block.querySelector('.question-type')?.value;
            if (type === 'range') {
                const minInput = block.querySelector('input[name*="[range_min]"]');
                const maxInput = block.querySelector('input[name*="[range_max]"]');
                if (minInput && maxInput) {
                    const min = parseFloat(minInput.value);
                    const max = parseFloat(maxInput.value);
                    if (!isNaN(min) && !isNaN(max) && min >= max) {
                        valid = false;
                        errorMsg = `In question ${idx + 1}, Min must be smaller than Max.`;
                        minInput.classList.add('is-invalid');
                        maxInput.classList.add('is-invalid');
                    } else {
                        minInput.classList.remove('is-invalid');
                        maxInput.classList.remove('is-invalid');
                    }
                }
            }
        });
        if (!valid) {
            alert(errorMsg);
        }
        return valid;
    }

    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = {!! count($questions) !!};
        document.getElementById('add-question').addEventListener('click', function () {
            const template = document.getElementById('question-template').innerHTML;
            const html = template.replace(/__INDEX__/g, questionIndex);
            const container = document.createElement('div');
            container.innerHTML = html;
            document.getElementById('questions-container').appendChild(container.firstElementChild);
            handleQuestionTypeChange(document.getElementById('questions-container').lastElementChild);
            questionIndex++;
        });

        document.getElementById('questions-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-question')) {
                // Destroy CKEditor if exists
                const block = e.target.closest('.question-block');
                block.querySelectorAll('textarea[name*="[paragraph]"]').forEach(function(textarea) {
                    destroyCKEditor(textarea);
                });
                block.remove();
            }
        });

        document.getElementById('questions-container').addEventListener('change', function (e) {
            if (e.target.classList.contains('question-type')) {
                handleQuestionTypeChange(e.target.closest('.question-block'));
            }
        });

        // Validate range min/max on input change
        document.getElementById('questions-container').addEventListener('input', function (e) {
            if (e.target.name && (e.target.name.includes('[range_min]') || e.target.name.includes('[range_max]'))) {
                validateRanges();
            }
        });

        // Validate on submit
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            if (!validateRanges()) {
                e.preventDefault();
            }
        });

        // Initialize CKEditor for existing paragraph fields
        initCKEditors();

        // Handle type change for existing questions
        document.querySelectorAll('.question-block').forEach(function(block) {
            block.querySelector('.question-type')?.addEventListener('change', function() {
                handleQuestionTypeChange(block);
            });
            // Show/hide fields as per type on load
            handleQuestionTypeChange(block);
        });

        // Re-initialize CKEditor for all visible paragraph fields (fix for not rendering data)
        setTimeout(initCKEditors, 200);
    });
</script>
<style>
    .is-invalid {
        border-color: #dc3545;
    }
</style>

@endsection