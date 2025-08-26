@extends('layouts.app')
@section('content')

@push('css')
<style>
    .quiz-container {
        max-width: 760px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.06);
        padding: 28px 24px;
        animation: fadeIn 0.3s ease-in-out;
        position: relative;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .quiz-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .quiz-header img {
        height: 120px;
        margin-bottom: 12px;
    }

    .quiz-header .oneliner {
        font-size: 18px !important;
        font-family: 'poppins', sans-serif !important;
        color: #888;
        margin-bottom: 30px;
    }

    .quiz-header .quiz-question-title {
        font-size: 1.8rem !important;
        font-family: 'Pacifico', cursive !important;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .quiz-header .description {
        font-size: 1.1rem !important;
        font-family: 'Arial', sans-serif !important;
        color: #444;
        margin-bottom: 30px;
        text-align: center;
    }

    .question-img {
        height: 60px;
        margin-bottom: 12px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .question-title {
        margin-bottom: 12px;
        text-align: center;
        color: #888 !important;
        font-weight: 500;
    }

    .quiz-question-text {
        font-weight: 800;
        color: #888;
        margin: 18px 0;
        text-align: center;
        font-style: italic;
        font-size: 16px;
    }

    .quiz-question-text::before {
        content: '"';
        /* opening double quote */
    }

    .quiz-question-text::after {
        content: '"';
        /* closing double quote */
    }

    .quiz-question-style {
        font-family: Arial, sans-serif !important;
        font-style: normal;
        font-size: 1.1rem !important;
        font-weight: 500;
        margin-bottom: 18px;
        text-align: center;
    }

    .quiz-option label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafafa;
        border: 1.5px solid #e0e0e0;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 14px;
        font-size: 1rem;
        color: #444;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.03);
    }

    .quiz-option label:hover {
        border-color: #cc2027;
        background: #fff;
    }

    .quiz-option input[type="radio"] {
        display: none;
    }

    .emoji-love {
        position: absolute;
        right: 16px;
        font-size: 1.4rem;
        pointer-events: none;
        opacity: 0;
        transform: scale(0.5);
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .selected .emoji-love {
        opacity: 1;
        transform: scale(1);
    }

    .floating {
        animation: floatHeart 1.2s ease forwards;
    }

    .show-heart .emoji-love {
        opacity: 1;
        transform: scale(1);
    }

    @keyframes floatHeart {
        0% {
            opacity: 0;
            transform: scale(0.6) translateY(0);
        }

        30% {
            opacity: 1;
            transform: scale(1.1) translateY(-10px);
        }

        60% {
            opacity: 1;
            transform: scale(1) translateY(-30px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(-50px);
        }

        /* keep visible and scaled */
    }

    .quiz-btn {
        background: linear-gradient(90deg, #cc2027 0%, #ff6f61 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 28px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 3px 8px rgba(78, 84, 200, 0.10);
    }

    .quiz-btn.secondary {
        background: #fff;
        color: #cc2027;
        border: 1.5px solid #cc2027;
    }

    .quiz-progress {
        margin-bottom: 24px;
        display: none;
    }

    .quiz-progress-info {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 6px;
        text-align: right;
    }

    .quiz-progress-bar {
        background: #eee;
        border-radius: 6px;
        height: 10px;
        overflow: hidden;
    }

    #quizProgressFill {
        height: 100%;
        background: #881175;
        width: 0%;
        transition: width 0.4s ease;
        border-radius: 6px;
    }

    input[type="range"] {
        width: 100%;
        accent-color: #cc2027;
    }

    .quiz-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 28px;
    }

    .quiz-contact-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #cc2027;
        margin-bottom: 18px;
        text-align: center;
    }

    /* Smooth form container animation */
    #contactForm {
        padding: 32px 28px;
        animation: fadeSlideIn 0.6s ease forwards;
    }

    @keyframes fadeSlideIn {
        0% {
            opacity: 0;
            transform: translateY(25px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stylish inputs */
    #contactForm .form-control {
        width: 100%;
        padding: 16px 18px;
        margin-bottom: 16px;
        border-radius: 8px;
        border: 1.8px solid #ddd;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    #contactForm .form-control:focus {
        border-color: #cc2027;
        box-shadow: 0 0 8px rgba(204, 32, 39, 0.3);
        outline: none;
    }

    /* Buttons container */
    #contactForm .quiz-actions {
        text-align: center;
    }

    /* Modern button with subtle hover animation */
    #contactForm .quiz-btn {
        cursor: pointer;
        background: #cc2027;
        border: none;
        padding: 14px 36px;
        font-size: 1.1rem;
        color: #fff;
        border-radius: 50px;
        box-shadow: 0 6px 16px rgba(204, 32, 39, 0.4);
        transition: background-color 0.3s ease, transform 0.2s ease;
        font-weight: 600;
        user-select: none;
    }

    #contactForm .quiz-btn:hover {
        background-color: #a1191a;
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(161, 25, 26, 0.7);
    }

    #contactForm .quiz-btn:active {
        transform: scale(0.98);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .result-date, .brand{
        font-weight: 800;
    }

    .result-date .date-normal{
        font-weight: 400;
    }

    @media(max-width: 600px) {
        .quiz-container {
            padding: 24px 16px;
        }

        .quiz-actions {
            flex-direction: column;
            gap: 12px;
        }
    }

    /* Quiz Result Styles */
    .result-container {
        position: relative;
        text-align: center;
        z-index: 1;
    }

    .result-container::before {
        content: "trailQuest";
        font-weight: 900;
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-47deg);
        font-size: 5rem;
        color: rgba(0, 0, 0, 0.07);
        pointer-events: none;
        user-select: none;
        z-index: 10;
        white-space: nowrap;
        letter-spacing: 30px;
    }

    header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        font-size: 14px;
        color: #555;
    }

    .compass-container {
        margin-bottom: 20px;
    }

    .compass-container img{
        height: 120px;
    }

    .compass-icon {
        width: 100px;
        /* Adjust size as needed */
        height: 100px !important;
        /* Adjust size as needed */
        /* Replace 'https://i.imgur.com/your-compass-image.png' with the actual path to your compass image */
    }

    .logo {
        font-family: serif;
        /* This will depend on the exact font you have */
        font-size: 48px;
        color: #333;
        font-weight: normal;
    }

    .logo-tagline {
        margin-top: -10px;
        margin-bottom: 20px;
        font-size: 16px !important;
    }

    .red-q {
        color: #e74c3c;
        /* Red color for the 'Q' */
    }

    .ready-message {
        font-size: 18px !important;
        margin-bottom: 10px;
    }

    .daring-message {
        font-size: 32px !important;
        margin-bottom: 20px;
    }

    .daring-message span {
        font-weight: 800;
    }

    .element-section {
        display: flex;
        /* justify-content: center;
    align-items: center; */
        margin-bottom: 20px;
    }

    .element-text {
        font-size: 24px;
        margin-right: 10px;
    }

    .fire-emoji {
        margin-top: -12px;
        font-size: 36px;
    }

    .description {
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 30px;
        text-align: left;
    }

    .discover-journey {
        font-family: 'Pacifico', cursive !important;
        font-size: 24px !important;
        margin-bottom: 20px;
        font-weight: normal;
    }

    .journeys {
        display: flex;
        justify-content: space-around;
        margin-bottom: 40px;
    }

    .journey-item {
        font-size: 18px;
        color: #007bff;
        /* Blue color for links, adjust as needed */
        text-decoration: underline;
        cursor: pointer;
    }

    footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .website-link {
        font-size: 14px;
        color: #007bff;
        text-decoration: none;
    }

    .website-link .globe-icon{
        color: #000008;
    }

    .share-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    /* Result card Css  */
    .journeys {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 20px;
        max-width: 960px;
        /* limits the total width */
        margin: 0 auto;
        /* centers the grid container horizontally */
        padding: 20px;
    }

    .journey-card {
    position: relative;
    border: 1px solid #eee;
    padding: 16px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.journey-image {
    width: 100%;
    border-radius: 6px;
    object-fit: cover;
}

.journey-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin: 0;
    text-align: center;
}

/* Ribbon Styles */
/* Ribbon Styles */
.ribbon {
    position: absolute;
    top: 16px;
    padding: 6px 12px;
    color: #fff;
    font-size: 0.85rem;
    font-weight: bold;
    z-index: 2;
    background: linear-gradient(to right, #e53935, #b71c1c); /* Red gradient */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    line-height: 1;
}

/* Left Ribbon with V-Cut on Right */
.ribbon-left {
    left: 0;
    clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 50%, calc(100% - 10px) 100%, 0 100%);
    border-radius: 0 4px 4px 0;
}

/* Right Ribbon with V-Cut on Left */
.ribbon-right {
    right: 0;
    background: linear-gradient(to left, #28a745, #1e7e34); /* Green gradient */
    clip-path: polygon(10px 0, 100% 0, 100% 100%, 10px 100%, 0 50%);
    border-radius: 4px 0 0 4px;
}


/* Read More Button as Footer */
.read-more-button {
    text-align: center;
    padding: 12px;
    background-color: #343a40;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: background 0.2s ease-in-out;
    margin-top: auto;
}

.read-more-button:hover {
    background-color: #212529;
}

.full-width {
    width: 100%;
    display: block;
}


    /* .journey-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 12px;
        background: #fff;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        display: flex;
        flex-direction: column;
        /* Optional: set a minimum height or consistent card height */
    }


    .journey-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .journey-title {
        font-size: 1.1rem;
        color: #333;
        margin: 0 0 8px;
    }

    .journey-content {
        font-size: 0.9rem;
        color: #555;
        flex-grow: 1;
        margin-bottom: 10px;
    }

    .read-more-button {
        align-self: flex-end;
        background-color: #E53E3E;
        /* example fire-red */
        color: white;
        padding: 6px 12px;
        font-size: 0.9rem;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .read-more-button:hover {
        background-color: #c53030;
        color: #FFFFFF;
    } */
</style>
@endpush

<div class="quiz-container">
    <div class="quiz-progress" id="quizProgressBar">
        <div class="quiz-progress-info">
            <span id="quizProgressText">Question 1 of {{ count($quiz['questions']) }}</span>
        </div>
        <div class="quiz-progress-bar">
            <div id="quizProgressFill"></div>
        </div>
    </div>

    <div id="quizContent">
        <div class="quiz-header">
            @if($quiz['icon'])
            <img src="{{ url('uploads/' . $quiz['icon']) }}" alt="quiz icon" />
            @endif
            <p class="oneliner">{{ $quiz['oneliner'] }}</p>
            @php
                $titleParts = explode(',', $quiz['title'], 2);
            @endphp
            <h2 class="quiz-question-title">
                {{ $titleParts[0] }}
                @if (isset($titleParts[1]))
                    <br>{{ ltrim($titleParts[1]) }}
                @endif
            </h2>
            <!-- <h2 class="quiz-question-title">{{ $quiz['title'] }}</h2> -->
            <p class="description">{{ $quiz['description'] }}</p>
            <button class="quiz-btn" onclick="startQuiz()">Begin The Quiz</button>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous"></script>
<script>
    const quiz = @json($quiz);
    const questions = quiz.questions;
    let currentStep = 0;
    let answers = {};
    let isTransitioning = false;

    function startQuiz() {
        currentStep = 0;
        answers = {};
        document.getElementById('quizProgressBar').style.display = 'block';
        renderQuestion();
    }

    function renderQuestion() {
        const q = questions[currentStep];
        const imgPath = window.location.origin + "/uploads/" + q.icon;
        let html = `
            <img class="question-img" src="${imgPath}" alt="question images" />
            ${q.oneliner ? `<p class="quiz-question-style">${q.oneliner}</p>` : ''}
            <h5 class="question-title">${q.questions}</h5>
        `;

        if (q.type === 'options' || !q.type) {
            html += `<div class="quiz-option">`;
            q.answers.forEach((a, idx) => {
                const isSelected = answers[q.id] === idx;
                html += `
                    <label data-value="${idx}" class="${isSelected ? 'selected show-heart' : ''}">
                        <span>${a.answers}</span>
                        <span class="emoji-love">❤️</span>
                        <input type="radio" name="quiz_option" value="${idx}" ${isSelected ? 'checked' : ''}>
                    </label>
                `;
            });
            html += `</div>`;
            html += `${q.onelinerFooter ? `<div class="quiz-question-text">${q.onelinerFooter}</div>` : ''}`;
            html += renderNavButtons();
        } else if (q.type === 'range') {
            const min = q.answers[0].range_min;
            const max = q.answers[0].range_max;
            const val = answers[q.id] ?? Math.floor((min + max) / 2);
            answers[q.id] = val;
            html += `
                <input type="range" id="rangeInput" min="${min}" max="${max}" value="${val}">
                <div style="text-align:center; margin-top:10px;"><span id="rangeValue">${val}</span> / ${max}</div>
                ${renderNavButtons()}
            `;
        } else if (q.type === 'paragraph') {
            html += `
                <div style="margin-top: 16px; color:#444;">${q.answers[0].paragraph}</div>
                ${renderNavButtons()}
            `;
        }
        

        document.getElementById('quizContent').innerHTML = html;
        updateProgressBar();

        // Range handler
        if (q.type === 'range') {
            const input = document.getElementById('rangeInput');
            const output = document.getElementById('rangeValue');
            input.addEventListener('input', function() {
                output.textContent = this.value;
                answers[q.id] = parseInt(this.value);
            });
        }

        // Option click handler
        if (q.type === 'options' || !q.type) {
            isTransitioning = false;
            document.querySelectorAll('.quiz-option label').forEach(label => {
                label.onclick = function() {
                    if (isTransitioning) return;
                    isTransitioning = true;

                    const idx = parseInt(this.getAttribute('data-value'));
                    answers[q.id] = idx;

                    document.querySelectorAll('.quiz-option label').forEach(l => {
                        l.classList.remove('selected', 'show-heart');
                        l.querySelector('.emoji-love').classList.remove('floating');
                    });

                    this.classList.add('selected', 'show-heart');

                    const emoji = this.querySelector('.emoji-love');
                    emoji.classList.remove('floating');
                    void emoji.offsetWidth; // trigger reflow
                    emoji.classList.add('floating');

                    setTimeout(() => {
                        // Remove floating after animation, keep show-heart so emoji stays visible
                        emoji.classList.remove('floating');
                        isTransitioning = false;
                        nextQuestion();
                    }, 1200);
                };
            });
        }
    }

    function renderNavButtons() {
        const q = questions[currentStep];
        const showPrev = currentStep > 0;

        if (q.type === 'options' || !q.type) {
            return `
                <div class="quiz-actions">
                    ${showPrev ? `<button class="quiz-btn secondary" onclick="previousQuestion()">Previous</button>` : '<div></div>'}
                </div>
            `;
        }

        return `
            <div class="quiz-actions">
                ${showPrev ? `<button class="quiz-btn secondary" onclick="previousQuestion()">Previous</button>` : '<div></div>'}
                <button class="quiz-btn" onclick="nextQuestion()">Next</button>
            </div>
        `;
    }

    function nextQuestion() {
        if (currentStep < questions.length - 1) {
            currentStep++;
            renderQuestion();
        } else {
            renderContactForm();
        }
    }

    function previousQuestion() {
        if (currentStep > 0) {
            currentStep--;
            renderQuestion();
        }
    }

    function updateProgressBar() {
        const total = questions.length;
        const percent = ((currentStep + 1) / total) * 100;
        document.getElementById('quizProgressFill').style.width = `${percent}%`;
        document.getElementById('quizProgressText').innerText = `Question ${Math.min(currentStep + 1, total)} of ${total}`;
    }

    function renderContactForm() {
        const imgPathContact = window.location.origin + "/uploads/0000/static/Quiz-Icon-Handshake.png";
        document.getElementById('quizProgressBar').style.display = 'none';
        document.getElementById('quizContent').innerHTML = `
            <img class="question-img" src="${imgPathContact}" alt="Contact Information" />
            <h2 class="quiz-contact-title">Let’s craft your perfect holiday package.</h2>
            <p style="text-align:center; color:#444;">Just enter your name, email and contact number to get started.</p>
            <form id="contactForm">
                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
                <div class="quiz-actions">
                    <button type="hidden"></button>
                    <button type="submit" class="quiz-btn">Submit</button>
                </div>
            </form>
            <div id="formMsg" style="margin-top:12px; color:#888;"></div>
        `;

        document.getElementById('contactForm').onsubmit = function(e) {
            e.preventDefault();
            const form = e.target;
            const payload = {
                name: form.name.value.trim(),
                email: form.email.value.trim(),
                contact: form.contact.value.trim(),
                answers: answers,
                quiz_id: quiz.id
            };
            document.getElementById('formMsg').innerText = 'Submitting...';
            fetch('{{ route("core.quiz.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                })
                // .then(res => res.json())
                .then(async (res) => {
                    const response = await res.json();
                    await showThankYouMessage(response);
                })
                .catch(() => {
                    document.getElementById('formMsg').innerText = 'Submission failed. Please try again.';
                });
        };
    }

    function showThankYouMessage(data) {
        // Get current date formatted like "Wednesday, July 23, 2025, 11:19 PM +0545"
        /* const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const formattedDate = now.toLocaleString('en-US', options); */
        const now = new Date();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // getMonth() is zero-based
        const day = String(now.getDate()).padStart(2, '0');
        const year = now.getFullYear();

        const formattedDate = `${month}/${day}/${year}`;
        const imgPath = window.location.origin + "/uploads/0000/static/compass.png";

        // Helper function to truncate to 20 words
        function truncateContent(contentHtml, wordLimit = 20) {
            // Strip HTML tags to count words correctly
            const tmp = document.createElement('div');
            tmp.innerHTML = contentHtml;
            const text = tmp.textContent || tmp.innerText || "";

            const words = text.split(/\s+/).filter(w => w.length > 0);
            if (words.length > wordLimit) {
                return words.slice(0, wordLimit).join(' ') + '...';
            }
            return text;
        }

        // Now generate the HTML for these cards:
        const renderedJourneys = (data.result.tours).map(journey => {
            const shortContent = truncateContent(journey.content, 16);

            // Create a URL-safe slug (example simple slugify)
            const slug = journey.slug ?? journey.title.toLowerCase().replace(/[^\w]+/g, '-').replace(/(^-|-$)/g, '');

            // return `
            //     <div class="journey-card">
            //         <img src="${journey.image}" loading="lazy" alt="${journey.title}" class="journey-image" />
            //         <h4 class="journey-title">${journey.title}</h4>
            //         <p class="journey-content">${shortContent}</p>
            //         <a href="/tour/${slug}" target="_blank" class="read-more-button">Read More</a>
            //     </div>
            // `;

            return `
                <div class="journey-card">
                    <!-- Ribbon containers -->
                    <div class="ribbon ribbon-left">$ ${Math.floor(journey.sale_price)}</div>
                    <div class="ribbon ribbon-right">${journey.duration} days </div>

                    <img src="${journey.image}" loading="lazy" alt="${journey.title}" class="journey-image" />

                    <h4 class="journey-title">${journey.title}</h4>

                    <!-- Read More Button as Card Footer -->
                    <a href="/tour/${slug}" target="_blank" class="read-more-button full-width">Read More</a>
                </div>
            `;
        }).join('');

        // $companyLogo window.location.origin + "/uploads/0000/static/"
        document.getElementById('quizContent').innerHTML = `
        <div class="result-container">
            <header class="page-header">
                <span class="result-date"> Date:<span class="date-normal"> ${formattedDate}</span></span>
                <span class="brand">©</span>
            </header>
            <div class="compass-container">
                <img src="${imgPath}" alt="Compass" class="compass-icon">
            </div>
            <h1 class="logo">trail<span class="red-q">Q</span>uest</h1>
             <p class="logo-tagline">Where Alignment Begins</p>
            <p class="ready-message">Your <b>Divine Blueprint </b> is Ready!</p>
            <p class="daring-message">Your Are: <span> ${data.result.type} </span> </p>
            <div class="element-section">
                <span class="element-text">Your Element is:</span>
                <span class="fire-emoji">${data.result.element} </span>
            </div>
            <p class="description"><b>${data.result.focus}</b> ${data.result.message} </p>
            <h3 class="discover-journey">Experiences that keep you rooted amid the chaos</h3>
            <div class="journeys">
                ${renderedJourneys}
            </div>
            <footer>
                <a href="https://www.trailquest.global" class="website-link"><span class="globe-icon"><i class="fa-solid fa-globe"></i></span><span class="fire-emoji" style="font-size: 20px;"></span>: www.trailquest.global</a>
                <button class="share-button" id="shareStoryButton">Share Your Story</button>
            </footer>
        </div>
        `;

        //share and upload 
        document.getElementById('shareStoryButton').addEventListener('click', async function() {
            const element = document.querySelector('.result-container');

            try {
                // Capture the HTML element as canvas
                const canvas = await html2canvas(element, {
                    scale: 2
                });

                // Convert canvas to blob (PNG)
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));

                // Prepare the form data
                const formData = new FormData();
                formData.append('image', blob, 'story.png');

                // Upload image to your backend API
                const response = await fetch('{{ route("quiz.share_stories") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });
                if (!response.ok) {
                    throw new Error('Upload failed');
                }

                const data = await response.json();

                if (!data.url) {
                    throw new Error('No URL returned from server');
                }

                const fullPath = window.location.origin + "/uploads/" + data.url;
                // Prepare LinkedIn sharing URL with the uploaded image URL
                const linkedInShareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(fullPath)}`;

                // Open LinkedIn share dialog in a new window
                window.open(linkedInShareUrl, '_blank', 'width=600,height=600');

            } catch (err) {
                alert('Sorry, sharing failed: ' + err.message);
                console.error(err);
            }
        });
    }
</script>
@endpush

@endsection