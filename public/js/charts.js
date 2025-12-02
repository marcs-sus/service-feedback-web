// Implementation of charts using Chart.js

// Check if Chart.js is loaded
if (typeof Chart === "undefined") {
  displayChartError();
} else {
  initializeCharts();
}

// Function to display error message if Chart.js failed to load
function displayChartError() {
  const chartsContainer = document.querySelector(".charts-container");
  if (chartsContainer) {
    chartsContainer.innerHTML = `
      <div class="chart-error" style="grid-column: 1 / -1;">
        Unable to load Charts library. Please check your internet connection and refresh the page.
      </div>
    `;
  }
}

// Function to initialize all charts
function initializeCharts() {
  // Color palettes
  const colors = {
    primary: "#007bff",
    success: "#28a745",
    danger: "#dc3545",
    warning: "#ffc107",
    info: "#17a2b8",
    gradient: [
      "#FF6B6B",
      "#FFA06B",
      "#FFD93D",
      "#6BCB77",
      "#4D96FF",
      "#9D84B7",
      "#FF85A1",
      "#8EC5FC",
    ],
  };

  // Score Distribution Histogram
  initScoreDistribution(colors);

  // Sector Comparison Bar Chart
  initSectorComparison(colors);

  // Question Performance Ranking
  initQuestionPerformance(colors);

  // Device Activity
  initDeviceActivity(colors);
}

// Score Distribution Histogram
function initScoreDistribution(colors) {
  const canvas = document.getElementById("scoreDistribution");
  if (!canvas) return;

  const scores = evaluations.map(
    (evaluation) => evaluation[evaluationColumns.score]
  );

  // Count occurrences of each score
  const scoreCount = Array(11).fill(0);
  scores.forEach((score) => {
    scoreCount[score]++;
  });

  new Chart(canvas, {
    type: "bar",
    data: {
      labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
      datasets: [
        {
          label: "Number of Evaluations",
          data: scoreCount,
          backgroundColor: [
            "#FF6B6B",
            "#FF816B",
            "#FF966B",
            "#FFAB6B",
            "#FFC16B",
            "#FFD66B",
            "#E6DE6B",
            "#CCDE6B",
            "#B3DE6B",
            "#99DE6B",
            "#80DE6B",
          ],
          borderColor: "#333",
          borderWidth: 1,
          borderRadius: 4,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        title: {
          display: true,
          text: "Score Distribution",
          font: { size: 14, weight: "bold" },
          color: "#333",
        },
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            color: "#666",
          },
          grid: {
            color: "#e0e0e0",
          },
        },
        x: {
          ticks: {
            color: "#666",
          },
          grid: {
            display: false,
          },
        },
      },
    },
  });
}

// Sector Comparison Bar Chart
function initSectorComparison(colors) {
  const canvas = document.getElementById("sectorComparison");
  if (!canvas) return;

  const sectorNames = sectorAverages.map(
    (avg) => avg.sector[sectorColumns.name]
  );
  const sectorAveragesValues = sectorAverages.map((avg) => avg.average);

  // Generate colors based on score
  const barColors = sectorAveragesValues.map((score) => {
    if (score >= 7) return "#28a745";
    if (score >= 5) return "#ffc107";
    return "#dc3545";
  });

  new Chart(canvas, {
    type: "bar",
    data: {
      labels: sectorNames,
      datasets: [
        {
          label: "Average Score",
          data: sectorAveragesValues,
          backgroundColor: barColors,
          borderColor: "#333",
          borderWidth: 1,
          borderRadius: 4,
        },
      ],
    },
    options: {
      indexAxis: "y",
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        title: {
          display: true,
          text: "Sector Comparison",
          font: { size: 14, weight: "bold" },
          color: "#333",
        },
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          beginAtZero: true,
          max: 10,
          ticks: {
            color: "#666",
          },
          grid: {
            color: "#e0e0e0",
          },
        },
        y: {
          ticks: {
            color: "#666",
          },
          grid: {
            display: false,
          },
        },
      },
    },
  });
}

// Question Performance Horizontal Bar Chart
function initQuestionPerformance(colors) {
  const canvas = document.getElementById("questionPerformance");
  if (!canvas) return;

  const questionNames = questionAverages.map(
    (avg) => avg.question[questionColumns.text].substring(0, 50) + "..."
  );
  const questionAveragesValues = questionAverages.map((avg) => avg.average);

  // Generate colors based on score
  const barColors = questionAveragesValues.map((score) => {
    if (score >= 7) return "#4D96FF";
    if (score >= 5) return "#FFD93D";
    return "#FF6B6B";
  });

  new Chart(canvas, {
    type: "bar",
    data: {
      labels: questionNames,
      datasets: [
        {
          label: "Average Score",
          data: questionAveragesValues,
          backgroundColor: barColors,
          borderColor: "#333",
          borderWidth: 1,
          borderRadius: 4,
        },
      ],
    },
    options: {
      indexAxis: "y",
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        title: {
          display: true,
          text: "Question Performance",
          font: { size: 14, weight: "bold" },
          color: "#333",
        },
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          beginAtZero: true,
          max: 10,
          ticks: {
            color: "#666",
          },
          grid: {
            color: "#e0e0e0",
          },
        },
        y: {
          ticks: {
            color: "#666",
          },
          grid: {
            display: false,
          },
        },
      },
    },
  });
}

// Device Activity Doughnut Chart
function initDeviceActivity(colors) {
  const canvas = document.getElementById("deviceActivity");
  if (!canvas) return;

  const deviceNames = devices.map((device) => device[deviceColumns.name]);
  const deviceIds = devices.map((device) => device[deviceColumns.id]);
  const evaluationDevices = evaluations.map(
    (evaluation) => evaluation[evaluationColumns.device_id]
  );
  const deviceEvaluations = deviceIds.map(
    (id) => evaluationDevices.filter((evaluation) => evaluation === id).length
  );

  // Color palette for doughnut chart
  const doughnutColors = [
    "#FF6B6B",
    "#4D96FF",
    "#28a745",
    "#ffc107",
    "#FF85A1",
    "#6BCB77",
    "#8EC5FC",
    "#9D84B7",
  ];

  new Chart(canvas, {
    type: "doughnut",
    data: {
      labels: deviceNames,
      datasets: [
        {
          label: "Number of Evaluations",
          data: deviceEvaluations,
          backgroundColor: doughnutColors.slice(0, deviceNames.length),
          borderColor: "#fff",
          borderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        title: {
          display: true,
          text: "Device Activity",
          font: { size: 14, weight: "bold" },
          color: "#333",
        },
        legend: {
          position: "bottom",
          labels: {
            color: "#666",
            padding: 15,
          },
        },
      },
    },
  });
}
