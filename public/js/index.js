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

// Initialize form
function initForm() {
  if (questions.length === 0) {
    showMessage("No questions were found at this time.", "error");
    return;
  }

  totalStepsSpan.textContent = formStates.totalSteps;
  renderQuestion(formStates.currentStep);
  updateProgressBar();
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
  const questionId = question[COLUMNS.id];

  // Update progress
  currentStepSpan.textContent = index + 1;
  updateProgressBar();

  // Update question text
  questionText.textContent = question[COLUMNS.text];

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
    });

    scaleContainer.appendChild(btn);
  }

  updateNavigation();
}

// Handle score selection
function selectScore(questionId, score) {
  formStates.responses[questionId] = score;

  // Update visual feedback
  const buttons = scaleContainer.querySelectorAll(".scale-btn");
  buttons.forEach((btn) => {
    btn.classList.toggle("selected", parseInt(btn.dataset.score) === score);
  });

  // Enable next button
  btnNext.disabled = false;
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
  const currentQuestionId = currentQuestion[COLUMNS.id];
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
}

// Submit service evaluation
async function submitEvaluation() {
  btnSubmit.disabled = true;
  btnSubmit.textContent = "Submitting...";

  const evaluationData = {
    responses: formStates.responses,
    feedback: feedbackText.value.trim() || null,
    device_id: formStates.device_id,
    sector_id: formStates.sector_id,
  };

  try {
    const response = await fetch("submit.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(evaluationData),
    });

    const result = await response.json();

    if (result.success) {
      showMessage("Evaluation submitted successfully!", "success");
      window.location.href = "thank.php";
    } else {
      showMessage(
        "An error occurred while submitting the evaluation " +
          (result.message || "Unknown Error"),
        "error"
      );

      btnSubmit.disabled = false;
      btnSubmit.textContent = "Submit";
    }
  } catch (error) {
    showMessage(
      "An error occurred while communicating with the server.",
      "error"
    );
    btnSubmit.disabled = false;
    btnSubmit.textContent = "Submit";
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
  formStates.currentStep = 1;
  formStates.responses = {};
  feedbackText.value = "";

  questionContainer.style.display = "block";
  feedbackContainer.style.display = "none";
  btnNext.style.display = "inline-block";
  btnSubmit.style.display = "none";
  messageContainer.style.display = "none";

  progressBar.style.display = "block";

  renderQuestion(formStates.currentStep);
}

// Event listeners
btnPrev.addEventListener("click", goToPrevious);
btnNext.addEventListener("click", goToNext);
btnSubmit.addEventListener("click", submitEvaluation);

// Initialize form
initForm();
