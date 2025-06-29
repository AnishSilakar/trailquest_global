@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ $quiz->title ?? 'Quiz Details' }}</h2>
    <p>{{ $quiz->description ?? 'No description available.' }}</p>

    <hr>
    <h4>Questions</h4>
    <div id="questions-container">
        <!-- <pre>{{ json_encode($quiz->questions, JSON_PRETTY_PRINT) }}</pre> -->
        @if(!empty($quiz->questions) && count($quiz->questions))
            @foreach($quiz->questions as $key => $question)
            <div class="question-block card mb-4 border-0 shadow-sm" style="background: var(--bs-body-bg);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="rounded-circle d-flex justify-content-center align-items-center me-3"
                             style="width: 38px; height: 38px; background: var(--bs-primary-bg-subtle, #e7f1ff); color: var(--bs-primary, #0d6efd); font-weight: bold;">
                            Q{{ $key + 1 }}
                        </div>
                        <h5 class="mb-0" style="color: var(--bs-body-color);">
                            {{ $question->questions ?? $question->question ?? '' }}
                        </h5>
                    </div>
                    <div class="mt-3">
                        <span class="fw-semibold" style="color: var(--bs-secondary-color);">Options:</span>
                        <ul class="list-group list-group-flush mt-2">
                            @if(!empty($question->answers) && count($question->answers))
                                @foreach($question->answers as $answer)
                                    @if(isset($question->type) && $question->type === 'paragraph')
                                        <li class="list-group-item" style="background: var(--bs-tertiary-bg); color: var(--bs-body-color);">
                                            <span>{!! $answer->paragraph !!}</span>
                                        </li>
                                    @elseif(isset($question->type) && $question->type === 'range')
                                        <li class="list-group-item" style="background: var(--bs-tertiary-bg); color: var(--bs-body-color);">
                                            <span class="badge bg-info text-dark">Range:</span>
                                            <span class="ms-2">{{ $answer->range_min }} - {{ $answer->range_max }}</span>
                                        </li>
                                    @else
                                        <li class="list-group-item" style="background: var(--bs-tertiary-bg); color: var(--bs-body-color);">
                                            {{ $answer->answers ?? '' }}
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li class="list-group-item text-muted" style="background: var(--bs-tertiary-bg);">No options available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p>No questions available for this quiz.</p>
        @endif
    </div>
</div>
@endsection

