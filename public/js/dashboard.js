// Dashboard view switcher functionality

// Get all switcher buttons and views
const switcherButtons = document.querySelectorAll(".switcher-btn");
const analyticsViews = document.querySelectorAll(".analytics-view");

// Add click event listeners to all switcher buttons
switcherButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const viewName = this.getAttribute("data-view");

    // Remove active class from all buttons
    switcherButtons.forEach((btn) => btn.classList.remove("active"));

    // Add active class to clicked button
    this.classList.add("active");

    // Hide all views
    analyticsViews.forEach((view) => view.classList.remove("active"));

    // Show the selected view
    const selectedView = document.getElementById(`view-${viewName}`);
    if (selectedView) {
      selectedView.classList.add("active");
    }
  });
});
