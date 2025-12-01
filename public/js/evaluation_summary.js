// Evaluation Summary page functionality

// Toggle feedback text expansion
function toggleFeedbackExpand(row) {
  const feedbackCell = row.querySelector(".feedback-cell");
  const feedbackFull = feedbackCell.querySelector(".feedback-full");
  const feedbackPreview = feedbackCell.querySelector(".feedback-preview");

  // Determine if the current row is expanded
  const isExpanded = row.classList.contains("expanded");

  // Close any other expanded feedback rows before proceeding
  document.querySelectorAll(".feedback-row.expanded").forEach((expandedRow) => {
    if (expandedRow !== row) {
      const otherFeedbackCell = expandedRow.querySelector(".feedback-cell");
      const otherFeedbackFull =
        otherFeedbackCell.querySelector(".feedback-full");
      const otherFeedbackPreview =
        otherFeedbackCell.querySelector(".feedback-preview");

      // Hide preview, show full, remove expanded class
      otherFeedbackPreview.style.display = "block";
      otherFeedbackFull.style.display = "none";
      expandedRow.classList.remove("expanded");

      // Reset positioning for other expanded items
      otherFeedbackFull.style.top = "100%";
      otherFeedbackFull.style.bottom = "auto";
      otherFeedbackFull.style.marginTop = "0.5rem";
      otherFeedbackFull.style.marginBottom = "0";
    }
  });

  if (!isExpanded) {
    // Show full feedback
    feedbackPreview.style.display = "none";
    feedbackFull.style.display = "block";

    // Calculate position based on available space
    const rowRect = row.getBoundingClientRect();
    const feedbackFullRect = feedbackFull.getBoundingClientRect();

    const spaceBelow = window.innerHeight - rowRect.bottom;
    const feedbackMargin =
      parseFloat(getComputedStyle(feedbackFull).marginTop || "0") +
      parseFloat(getComputedStyle(feedbackFull).marginBottom || "0");
    const requiredHeight = feedbackFullRect.height + feedbackMargin;

    // Check if there's enough space below AND if there's enough space above to flip the position
    if (requiredHeight > spaceBelow && rowRect.top > requiredHeight) {
      // Not enough space below, and enough space above, so position it above
      feedbackFull.style.bottom = "100%";
      feedbackFull.style.top = "auto";
      feedbackFull.style.marginTop = "0";
      feedbackFull.style.marginBottom = "0.5rem";
    } else {
      // Enough space below, or not enough space above to flip, so position it below
      feedbackFull.style.top = "100%";
      feedbackFull.style.bottom = "auto";
      feedbackFull.style.marginTop = "0.5rem";
      feedbackFull.style.marginBottom = "0";
    }
    row.classList.add("expanded");
  } else {
    // If it's already expanded, hide it
    feedbackPreview.style.display = "block";
    feedbackFull.style.display = "none";
    row.classList.remove("expanded");

    // Reset positioning to default for when it's next expanded
    feedbackFull.style.top = "100%";
    feedbackFull.style.bottom = "auto";
    feedbackFull.style.marginTop = "0.5rem";
    feedbackFull.style.marginBottom = "0";
  }
}

// Close expanded feedback when clicking outside
document.addEventListener("click", function (event) {
  const target = event.target;
  // Check if the click is outside any feedback row OR within an already expanded feedback-full div.
  const clickedFeedbackRow = target.closest(".feedback-row");
  const clickedFeedbackFull = target.closest(".feedback-full");

  if (!clickedFeedbackRow && !clickedFeedbackFull) {
    document.querySelectorAll(".feedback-row.expanded").forEach((row) => {
      const feedbackCell = row.querySelector(".feedback-cell");
      const feedbackFull = feedbackCell.querySelector(".feedback-full");
      const feedbackPreview = feedbackCell.querySelector(".feedback-preview");

      feedbackPreview.style.display = "block";
      feedbackFull.style.display = "none";
      row.classList.remove("expanded");

      // Reset positioning
      feedbackFull.style.top = "100%";
      feedbackFull.style.bottom = "auto";
      feedbackFull.style.marginTop = "0.5rem";
      feedbackFull.style.marginBottom = "0";
    });
  }
});
