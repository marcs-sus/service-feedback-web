// Js script used to manage the form

// Form state management
const formStates = {
  currentStep: 0,
  totalSteps: questions.length + 1,
  responses: {},
  device_id: device_id,
  sector_id: sector_id,
};

// DOM elements
const progressBar = document.getElementById("progress-bar");
const progressBarFill = document.getElementById("progress-bar-fill");
const questionText = document.getElementById("question-text");
const scaleContainer = document.getElementById("scale-container");
const questionContainer = document.getElementById("question-container");
const feedbackContainer = document.getElementById("feedback-container");
const feedbackText = document.getElementById("feedback-text");
const currentStepSpan = document.getElementById("current-step");
const totalStepsSpan = document.getElementById("total-steps");
const btnPrev = document.getElementById("btn-prev");
const btnNext = document.getElementById("btn-next");
const btnSubmit = document.getElementById("btn-submit");
const messageContainer = document.getElementById("message-container");

// Timer variables
let inactivityTimer;
const INACTIVITY_TIMEOUT_SECONDS = 300; // 5 minutes
let timerStarted = false;

// Function to start the inactivity timer
function startInactivityTimer() {
  if (timerStarted) return;
  timerStarted = true;
  resetInactivityTimer();
}

// Function to reset the inactivity timer
function resetInactivityTimer() {
  clearTimeout(inactivityTimer);
  inactivityTimer = setTimeout(() => {
    window.location.reload();
  }, INACTIVITY_TIMEOUT_SECONDS * 1000);
}

// Initialize form
function initForm() {
  if (questions.length === 0) {
    showMessage(t("no_questions_found"), "error");
    return;
  }

  totalStepsSpan.textContent = formStates.totalSteps;
  renderQuestion(formStates.currentStep);
  updateProgressBar();

  // Add event listener for feedback text input
  feedbackText.addEventListener("input", resetInactivityTimer);
}

// Update progress bar
function updateProgressBar() {
  const progress = (formStates.currentStep + 1) / formStates.totalSteps;
  progressBarFill.style.width = `${progress * 100}%`;
}

// Show question on form
function renderQuestion(index) {
  questionContainer.style.display = "block";
  feedbackContainer.style.display = "none";
  btnNext.style.display = "inline-block";
  btnSubmit.style.display = "none";

  const question = questions[index];
  const questionId = question[questionColumns.id];

  // Update progress
  currentStepSpan.textContent = index + 1;
  updateProgressBar();

  // Update question text
  questionText.textContent = question[questionColumns.text];

  // Clear and re-render scale
  scaleContainer.innerHTML = "";
  for (let i = 0; i <= 10; i++) {
    const btn = document.createElement("button");
    btn.className = "scale-btn";
    btn.textContent = i;
    btn.dataset.score = i;

    // Highlight if already answered
    if (formStates.responses[questionId] === i) {
      btn.classList.add("selected");
    }

    btn.addEventListener("click", () => {
      selectScore(questionId, i);
      resetInactivityTimer();
    });

    scaleContainer.appendChild(btn);
  }

  updateNavigation();
  resetInactivityTimer();
}

// Handle score selection
function selectScore(questionId, score) {
  formStates.responses[questionId] = score;

  // Start timer if this is the first interaction with an answer
  if (!timerStarted) {
    startInactivityTimer();
  }

  // Update visual feedback
  const buttons = scaleContainer.querySelectorAll(".scale-btn");
  buttons.forEach((btn) => {
    btn.classList.toggle("selected", parseInt(btn.dataset.score) === score);
  });

  // Enable next button
  btnNext.disabled = false;
  resetInactivityTimer();
}

// Update navigation button states
function updateNavigation() {
  // Previous button, hide on first question
  btnPrev.style.display = formStates.currentStep > 0 ? "inline-block" : "none";

  if (formStates.currentStep >= questions.length) {
    return;
  }

  // Check if current question has an answer
  const currentQuestion = questions[formStates.currentStep];
  const currentQuestionId = currentQuestion[questionColumns.id];
  const hasAnswer = formStates.responses[currentQuestionId] !== undefined;

  // Next button
  btnNext.disabled = !hasAnswer;
}

// Navigate to previous question
function goToPrevious() {
  if (formStates.currentStep > 0) {
    formStates.currentStep--;

    renderQuestion(formStates.currentStep);
  }
  resetInactivityTimer();
}

// Navigate to next question
function goToNext() {
  if (formStates.currentStep < formStates.totalSteps - 2) {
    formStates.currentStep++;

    renderQuestion(formStates.currentStep);
  } else {
    formStates.currentStep++;

    // Show final feedback screen
    showFeedbackScreen();
  }
  resetInactivityTimer();
}

// Display the feedback screen
function showFeedbackScreen() {
  questionContainer.style.display = "none";
  feedbackContainer.style.display = "block";

  btnNext.style.display = "none";
  btnSubmit.style.display = "inline-block";

  currentStepSpan.textContent = formStates.totalSteps;
  totalStepsSpan.textContent = formStates.totalSteps;
  updateProgressBar();
  updateNavigation();
  resetInactivityTimer();
}

// Submit service evaluation
async function submitEvaluation() {
  btnSubmit.disabled = true;
  btnSubmit.textContent = t("submitting");

  // Clear timer on submit
  clearTimeout(inactivityTimer);

  const evaluationData = {
    responses: formStates.responses,
    feedback: feedbackText.value.trim() || null,
    device_id: formStates.device_id,
    sector_id: formStates.sector_id,
  };

  try {
    const response = await fetch("../src/form_submit.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(evaluationData),
    });

    const result = await response.json();

    if (result.success) {
      showMessage(t("evaluation_submitted"), "success");
      window.location.href =
        "thank.php?locale=" +
        currentLocale +
        "&device=" +
        formStates.device_id +
        "&sector=" +
        formStates.sector_id;
    } else {
      showMessage(
        t("error_submitting_evaluation") +
          " " +
          (result.message || t("unknown_error")),
        "error"
      );

      btnSubmit.disabled = false;
      btnSubmit.textContent = t("submit");
      resetInactivityTimer();
    }
  } catch (error) {
    showMessage(t("server_communication_error"), "error");
    btnSubmit.disabled = false;
    btnSubmit.textContent = t("submit");
    resetInactivityTimer();
  }
}

// Show message
function showMessage(message, type) {
  messageContainer.textContent = message;
  messageContainer.className = type;
  messageContainer.style.display = "block";
}

// Reset form to initial state
function resetForm() {
  formStates.currentStep = 0;
  formStates.responses = {};
  feedbackText.value = "";

  questionContainer.style.display = "block";
  feedbackContainer.style.display = "none";
  btnNext.style.display = "inline-block";
  btnSubmit.style.display = "none";
  messageContainer.style.display = "none";

  progressBar.style.display = "block";

  renderQuestion(formStates.currentStep);
  clearTimeout(inactivityTimer);
  timerStarted = false;
}

// Event listeners
btnPrev.addEventListener("click", goToPrevious);
btnNext.addEventListener("click", goToNext);
btnSubmit.addEventListener("click", submitEvaluation);

// Initialize form
initForm();
