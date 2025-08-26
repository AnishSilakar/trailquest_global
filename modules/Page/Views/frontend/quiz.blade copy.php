@extends ('layouts.app')
@section ('content')

@push('css')
<style>
    #openQuizModal {
        padding: 8px 28px;
        font-weight: 600;
        font-size: 16px;
        border-radius: 12px;
        background: #cc2027;
        color: #fff;
        border: none;
        box-shadow: 0 2px 8px rgba(78, 84, 200, 0.15);
        cursor: pointer;
        text-transform: uppercase;
    }

    #quizModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999;
    }

    #quizModalOverlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
    }

    #quizModalContent {
        position: relative;
        z-index: 10000;
        max-width: 760px;
        margin: 60px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
        padding: 32px 24px;
    }

    #closeQuizModal {
        position: absolute;
        top: 16px;
        right: 16px;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #888;
        cursor: pointer;
    }

    #quizModal:focus {
        outline: none;
    }

    #quizModal [tabindex="-1"]:focus {
        outline: none;
    }

    #quizModal input[type="radio"]:disabled {
        accent-color: #4e54c8;
    }

    #quizModalOverlay {
        cursor: pointer;
    }

    @media screen and (max-width: 786px) {
        .mobile-half {
            width: 20%;
        }

        .mobile-full {
            width: 80%;
        }
    }
</style>
@endpush

<div id="quizModal" role="dialog" aria-modal="true" aria-labelledby="quizModalTitle" tabindex="-1">
    <div id="quizModalOverlay"></div>
    <div id="quizModalContent">
        <button id="closeQuizModal" aria-label="Close quiz modal">&times;</button>
        <div id="quizContent">
            <div style="text-align:center; color:#888;">Loading...</div>
        </div>
    </div>

    @push('js')
    <script>
        (function() {
            let quizData = [];
            let currentStep = 0;
            let answers = {};
            let quizSessionKey = 'trailquest_quiz_answers';

            function saveSession() {
                sessionStorage.setItem(quizSessionKey, JSON.stringify(answers));
            }

            function loadSession() {
                const data = sessionStorage.getItem(quizSessionKey);
                if (data) answers = JSON.parse(data);
            }

            function renderQuestion() {
                const container = document.getElementById('quizContent');
                if (currentStep < quizData.length) {
                    const q = quizData[currentStep];
                    console.log('Rendering question:', q);
                    let html = `
                                            <div style="
                                                background: #fff;
                                                border-radius: 16px;
                                                box-shadow: 0 6px 32px rgba(204,32,39,0.10), 0 1.5px 6px rgba(78,84,200,0.08);
                                                padding: 36px 28px 28px 28px;
                                                max-width: 820px;
                                                margin: 0 auto;
                                            ">
                                                <h2 id="quizModalTitle" style="
                                                    font-size: 1.5rem;
                                                    margin-bottom: 18px;
                                                    color: #cc2027;
                                                    text-align: center;
                                                    font-weight: 700;
                                                    letter-spacing: 0.5px;
                                                ">${q.title}</h2>
                                                <p style="
                                                    margin-bottom: 2px;
                                                    color: #222;
                                                    font-size: 1.08rem;
                                                    text-align: left;
                                                    font-weight: 500;
                                                ">${q.question}</p>`;
                    // Render by type
                    if (q.type === 'options' || !q.type) {
                        html += `<ul style="list-style:none; padding:0; margin-bottom: 24px;">`;
                        q.options.forEach((opt, idx) => {
                            const checked = answers[q.id] === idx ? 'checked' : '';
                            html += `
                                                    <li style="margin-bottom: 12px;">
                                                        <label style="
                                                            display: flex;
                                                            align-items: center;
                                                            background: #f7f7f7;
                                                            border-radius: 8px;
                                                            padding: 10px 14px;
                                                            cursor: pointer;
                                                            border: 1.5px solid #e0e0e0;
                                                            transition: border-color 0.2s;
                                                            font-size: 1rem;
                                                            color: #444;
                                                        ">
                                                            <input type="radio" name="quiz_option" value="${idx}" ${checked}
                                                                style="margin-right: 12px; accent-color: #cc2027; width: 18px; height: 18px;">
                                                            <span>${opt}</span>
                                                        </label>
                                                    </li>
                                                `;
                        });
                        html += `</ul>`;
                    } else if (q.type === 'range') {
                        // Assume only one answer object with range_min and range_max
                        const min = q.options[0].range_min;
                        const max = q.options[0].range_max;
                        const val = Math.floor((min + max) / 2);
                        html += `
                                                <div style="margin-bottom: 24px; text-align:center;">
                                                    <input 
                                                        type="range" 
                                                        id="quizRangeInput" 
                                                        name="quiz_range" 
                                                        min="${min}" 
                                                        max="${max}" 
                                                        value="${val}" 
                                                        step="1"
                                                        style="width: 80%; accent-color: #cc2027;"
                                                    >
                                                    <div style="margin-top: 10px; font-size: 1.1rem;">
                                                        <span id="quizRangeValue">${val}</span> / ${max}
                                                    </div>
                                                </div>
                                            `;
                    } else if (q.type === 'paragraph') {
                        html += `
                                                <div style="margin-bottom: 24px; color: #444; font-size: 1rem;">
                                                    ${q.options[0].paragraph}
                                                </div>
                                            `;
                    }

                    html += `
                                            <div style="display: flex; justify-content: space-between;">
                                                ${
                                                    currentStep > 0
                                                        ? `<button id="prevQuizBtn" class="btn btn-secondary" style="
                                                            background: #fff;
                                                            color: #cc2027;
                                                            border: 1.5px solid #cc2027;
                                                            border-radius: 8px;
                                                            padding: 10px 28px;
                                                            font-weight: 600;
                                                            font-size: 1rem;
                                                            cursor: pointer;
                                                            text-transform: uppercase;
                                                            letter-spacing: 0.5px;
                                                        ">Previous</button>`
                                                        : '<div></div>'
                                                }
                                                <button id="nextQuizBtn" class="btn btn-primary" style="
                                                    background: linear-gradient(90deg, #cc2027 0%, #ff6f61 100%);
                                                    color: #fff;
                                                    border: none;
                                                    border-radius: 8px;
                                                    padding: 10px 28px;
                                                    font-weight: 600;
                                                    font-size: 1rem;
                                                    box-shadow: 0 2px 8px rgba(78, 84, 200, 0.10);
                                                    cursor: pointer;
                                                    text-transform: uppercase;
                                                    letter-spacing: 0.5px;
                                                ">Next</button>
                                            </div>
                                        </div>
                                        `;
                    container.innerHTML = html;

                    // Event listeners for options
                    if (q.type === 'options' || !q.type) {
                        document.querySelectorAll('input[name="quiz_option"]').forEach(input => {
                            input.addEventListener('change', function() {
                                answers[q.id] = parseInt(this.value);
                                saveSession();
                            });
                        });
                    } else if (q.type === 'range') {
                        const rangeInput = document.getElementById('quizRangeInput');
                        const rangeValue = document.getElementById('quizRangeValue');
                        rangeInput.addEventListener('input', function() {
                            rangeValue.textContent = this.value;
                            answers[q.id] = parseInt(this.value);
                            saveSession();
                        });
                        // Set initial value
                        answers[q.id] = parseInt(rangeInput.value);
                        saveSession();
                    }

                    document.getElementById('nextQuizBtn').onclick = function() {
                        // Validation
                        if (q.type === 'options' || !q.type) {
                            if (answers[q.id] === undefined) {
                                alert('Please select an option.');
                                return;
                            }
                        } else if (q.type === 'range') {
                            if (answers[q.id] === undefined) {
                                alert('Please select a value.');
                                return;
                            }
                        }
                        // For paragraph, just proceed
                        currentStep++;
                        renderQuestion();
                    };
                    if (currentStep > 0) {
                        document.getElementById('prevQuizBtn').onclick = function() {
                            currentStep--;
                            renderQuestion();
                        };
                    }
                } else {
                    renderContactForm();
                }
            }

            function renderContactForm() {
                const container = document.getElementById('quizContent');
                let html = `<h2 style="font-size:1.1rem; margin-bottom:16px;">Thanks for completing the quiz!</h2>
                                    <form id="quizContactForm">
                                        <div style="margin-bottom:12px;">
                                        <p style="color:#888; font-size:0.95rem; margin-bottom:8px;">
                                            Share your contact info to unlock your exclusive trip discount!
                                        </p>
                                        <div style="margin-bottom:18px;">
                                            <input 
                                                type="text" 
                                                name="name" 
                                                placeholder="Your Full Name" 
                                                required 
                                                style="
                                                    width:100%;
                                                    padding:14px 16px;
                                                    border-radius:10px;
                                                    border:1.5px solid #e0e0e0;
                                                    background: #f7f7f7;
                                                    font-size:1.05rem;
                                                    color:#222;
                                                    margin-bottom:12px;
                                                    box-shadow: 0 1.5px 6px rgba(204,32,39,0.05);
                                                    transition: border-color 0.2s;
                                                "
                                                onfocus="this.style.borderColor='#cc2027';"
                                                onblur="this.style.borderColor='#e0e0e0';"
                                            >
                                        </div>
                                        <div style="margin-bottom:18px;">
                                            <input 
                                                type="email" 
                                                name="email" 
                                                placeholder="Your Email Address" 
                                                required 
                                                style="
                                                    width:100%;
                                                    padding:14px 16px;
                                                    border-radius:10px;
                                                    border:1.5px solid #e0e0e0;
                                                    background: #f7f7f7;
                                                    font-size:1.05rem;
                                                    color:#222;
                                                    margin-bottom:12px;
                                                    box-shadow: 0 1.5px 6px rgba(204,32,39,0.05);
                                                    transition: border-color 0.2s;
                                                "
                                                onfocus="this.style.borderColor='#cc2027';"
                                                onblur="this.style.borderColor='#e0e0e0';"
                                            >
                                        </div>
                                        <div style="margin-bottom:22px;">
                                            <input 
                                                type="text" 
                                                name="contact" 
                                                placeholder="Contact Number" 
                                                required 
                                                style="
                                                    width:100%;
                                                    padding:14px 16px;
                                                    border-radius:10px;
                                                    border:1.5px solid #e0e0e0;
                                                    background: #f7f7f7;
                                                    font-size:1.05rem;
                                                    color:#222;
                                                    box-shadow: 0 1.5px 6px rgba(204,32,39,0.05);
                                                    transition: border-color 0.2s;
                                                "
                                                onfocus="this.style.borderColor='#cc2027';"
                                                onblur="this.style.borderColor='#e0e0e0';"
                                            >
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="
                                        background: linear-gradient(90deg, #cc2027 0%, #ff6f61 100%);
                                                    color: #fff;
                                                    border: none;
                                                    border-radius: 8px;
                                                    padding: 10px 28px;
                                                    font-weight: 600;
                                                    font-size: 1rem;
                                                    box-shadow: 0 2px 8px rgba(78, 84, 200, 0.10);
                                                    cursor: pointer;
                                                    text-transform: uppercase;
                                                    letter-spacing: 0.5px;
                                        ">Submit</button>
                                    </form>
                                    <div id="quizFormMsg" style="margin-top:12px; color:#888; font-size:0.95rem;"></div>`;
                container.innerHTML = html;

                document.getElementById('quizContactForm').onsubmit = function(e) {
                    e.preventDefault();
                    const form = e.target;
                    const name = form.name.value.trim();
                    const email = form.email.value.trim();
                    const contact = form.contact.value.trim();
                    if (!email || !contact) return;
                    const payload = {
                        answers: answers,
                        name: name,
                        email: email,
                        contact: contact,
                    };
                    document.getElementById('quizFormMsg').innerText = 'Submitting...';
                    fetch('{{ route("core.quiz.submit") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('quizFormMsg').innerText = 'Thank you for submitting!';
                            sessionStorage.removeItem(quizSessionKey);
                            setTimeout(() => {
                                showQuizThankYou(container);
                            }, 1500);
                        })
                        .catch(() => {
                            document.getElementById('quizFormMsg').innerText = 'Submission failed. Please try again.';
                        });
                };
            }

            function showQuizThankYou(container) {
                container.innerHTML = `
                                        <div style="text-align:center; padding:40px 10px;">
                                            <h2 style="color:#cc2027; font-size:1.4rem; margin-bottom:18px;">You're a Daring Adventurer!</h2>
                                            <p style="font-size:1.08rem; color:#444; margin-bottom:18px;">
                                                We got your contact details. Our team will reach out soon to guide you and make your trip easier and more memorable!
                                            </p>
                                            <div style="font-size:1.05rem; color:#888;">
                                                Thank you for trusting TrailQuest. Get ready for an unforgettable journey!
                                            </div>
                                            <button id="closeQuizModalFinal" class="btn btn-primary" style="
                                                margin-top:28px;
                                                background: linear-gradient(90deg, #cc2027 0%, #ff6f61 100%);
                                                color: #fff;
                                                border: none;
                                                border-radius: 8px;
                                                padding: 10px 28px;
                                                font-weight: 600;
                                                font-size: 1rem;
                                                box-shadow: 0 2px 8px rgba(78, 84, 200, 0.10);
                                                cursor: pointer;
                                                text-transform: uppercase;
                                                letter-spacing: 0.5px;
                                            ">Close</button>
                                        </div>
                                    `;

                // Reset quiz state on close
                document.getElementById('closeQuizModalFinal').onclick = function() {
                    currentStep = 0;
                    answers = {};
                    sessionStorage.removeItem('trailquest_quiz_answers');
                    document.getElementById('closeQuizModal').click();
                };

                // Also reset quiz state if modal is closed by other means (X button or overlay)
                const quizModal = document.getElementById('quizModal');
                const closeQuizModalBtn = document.getElementById('closeQuizModal');
                const quizModalOverlay = document.getElementById('quizModalOverlay');

                function resetQuizStateOnClose() {
                    currentStep = 0;
                    answers = {};
                    sessionStorage.removeItem('trailquest_quiz_answers');
                    // Reset intro screen for next open
                    const quizContent = document.getElementById('quizContent');
                    quizContent.innerHTML = `
                                            <div style="text-align:center; padding:40px 10px;">
                                                <h2 style="color:#cc2027; font-size:1.4rem; margin-bottom:18px;">Reflect. Play. And find adventures that match with your calling</h2>
                                                <p style="font-size:1.08rem; color:#444; margin-bottom:18px;">
                                                    And, yes, don’t forget to discover your archetype on the result page. It’ll be fun.
                                                </p>
                                                <button id="startQuizBtn" class="btn btn-primary" style="
                                                    margin-top:18px;
                                                    background: linear-gradient(90deg, #cc2027 0%, #ff6f61 100%);
                                                    color: #fff;
                                                    border: none;
                                                    border-radius: 8px;
                                                    padding: 10px 28px;
                                                    font-weight: 600;
                                                    font-size: 1rem;
                                                    box-shadow: 0 2px 8px rgba(78, 84, 200, 0.10);
                                                    cursor: pointer;
                                                    text-transform: uppercase;
                                                    letter-spacing: 0.5px;
                                                ">Let’s Start the Quiz</button>
                                            </div>
                                        `;
                    quizContent.querySelector('#startQuizBtn').onclick = function() {
                        fetchQuiz();
                    };
                }
                closeQuizModalBtn.addEventListener('click', resetQuizStateOnClose);
                quizModalOverlay.addEventListener('click', resetQuizStateOnClose);
            }

            function fetchQuiz() {
                fetch('{{ route("core.admin.quiz.getFirst") }}')
                    .then(res => res.json())
                    .then(data => {
                        if (Array.isArray(data) && data.length > 0 && Array.isArray(data[0].questions)) {
                            quizData = data[0].questions.map(function(q) {
                                return {
                                    id: q.id,
                                    title: data[0].title,
                                    question: q.questions,
                                    type: q.type,
                                    options: q.answers.map(function(a) {
                                        if (q.type === 'paragraph' || q.type === 'range') {
                                            return a;
                                        }
                                        return a.answers;
                                    })
                                };
                            });
                            if (!quizData.length) {
                                document.getElementById('quizContent').innerHTML = '<div style="color:#888;">No quiz available.</div>';
                                return;
                            }
                            loadSession();
                            // If session has answers, continue from last unanswered
                            for (let i = 0; i < quizData.length; i++) {
                                if (answers[quizData[i].id] === undefined) {
                                    currentStep = i;
                                    break;
                                } else {
                                    currentStep = i + 1;
                                }
                            }
                            renderQuestion();
                        } else {
                            document.getElementById('quizContent').innerHTML = '<div style="color:#888;">No quiz available.</div>';
                        }
                    })
                    .catch(() => {
                        document.getElementById('quizContent').innerHTML = '<div style="color:#888;">Failed to load quiz.</div>';
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                let quizStarted = false;
                const quizContent = document.getElementById('quizContent');
                quizContent.innerHTML = `
                                        <div style="text-align:center; padding:40px 10px;">
                                            <img src="https://imgs.search.brave.com/aAoWrjXGfOmGO8xacBPjz0apRluRwhjcbldqOrORnEs/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly90aHVt/YnMuZHJlYW1zdGlt/ZS5jb20vYi9nb2xk/ZW4tY29tcGFzcy1z/dHJhdGVnaWMtcGxh/bm5pZy1jb25jZXB0/LTIxNjU3MDUzLmpw/Zw" width="80" height="80" style="padding:0 10px;" alt="compass" />
                                            <p>Tune Your Inner Compass</p>
                                            <h2 style="color:#cc2027; font-size:1.4rem; margin-bottom:18px;">More Than a Quiz- It's a Journey Towards Your True Self.</h2>
                                            <p style="font-size:1.08rem; color:#444; margin-bottom:18px;">
                                                Answer a few purposeful questions—and see where you truly belong. This isn’t about results. It’s about revelation.</p>
                                            <button id="startQuizBtn" class="btn btn-primary" style="
                                                margin-top:18px;
                                                background: linear-gradient(90deg, #cc2027 0%, #ff6f61 100%);
                                                color: #fff;
                                                border: none;
                                                border-radius: 8px;
                                                padding: 10px 28px;
                                                font-weight: 600;
                                                font-size: 1rem;
                                                box-shadow: 0 2px 8px rgba(78, 84, 200, 0.10);
                                                cursor: pointer;
                                                text-transform: uppercase;
                                                letter-spacing: 0.5px;
                                            ">Begin the Quiz</button>
                                        </div>
                                    `;
                quizContent.querySelector('#startQuizBtn').onclick = function() {
                    quizStarted = true;
                    fetchQuiz();
                };
                // document.getElementById('openQuizModal').addEventListener('click', fetchQuiz);
            });
        })();
    </script>
    @endpush
</div>



@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var openBtn = document.getElementById('openQuizModal');
        var modal = document.getElementById('quizModal');
        var closeBtn = document.getElementById('closeQuizModal');
        var overlay = document.getElementById('quizModalOverlay');

        function openModal() {
            modal.style.display = 'block';
            modal.setAttribute('tabindex', '-1');
            modal.focus();
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            openBtn.focus();
        }

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);

        // Accessibility: close on ESC
        modal.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    });
</script>
@endpush
@endsection