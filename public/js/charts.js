// Implementation of charts using Chart.js

// DOM elements
const scoreDistribution = document.getElementById("scoreDistribution");
const sectorComparison = document.getElementById("sectorComparison");
const questionPerformance = document.getElementById("questionPerformance");
const deviceActivity = document.getElementById("deviceActivity");

// Score Distribution Histogram
const scores = evaluations.map(
  (evaluation) => evaluation[evaluationColumns.score]
);

new Chart(scoreDistribution, {
  type: "line",
  data: {
    labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
    datasets: [
      {
        label: "Number of Evaluations",
        data: scores,
        backgroundColor: "#4CAF50",
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: "Score Distribution",
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Number of Evaluations",
        },
        ticks: {
          stepSize: 1,
        },
      },
      x: {
        title: {
          display: true,
          text: "Score",
        },
      },
    },
  },
});

// Sector Comparison Bar Chart
const sectorNames = sectors.map((sector) => sector[sectorColumns.name]);
const sectorAveragesValues = sectorAverages.map((average) => average.average);

new Chart(sectorComparison, {
  type: "bar",
  data: {
    labels: sectorNames,
    datasets: [
      {
        label: "Average Score",
        data: sectorAveragesValues,
        backgroundColor: "#4CAF50",
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: "Sector Comparison",
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Average Score",
        },
      },
      x: {
        title: {
          display: true,
          text: "Sector",
        },
      },
    },
  },
});

// Question Performance Ranking
const questionNames = questions.map(
  (question) => question[questionColumns.text]
);
const questionAveragesValues = questionAverages.map(
  (average) => average.average
);

new Chart(questionPerformance, {
  type: "bar",
  data: {
    labels: questionNames,
    datasets: [
      {
        label: "Average Score",
        data: questionAveragesValues,
        backgroundColor: "#4CAF50",
      },
    ],
  },
  options: {
    indexAxis: "y",
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: "Question Performance",
      },
    },
    scales: {
      x: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Average Score",
        },
      },
      y: {
        title: {
          display: true,
          text: "Question",
        },
      },
    },
  },
});

// Device Activity
const deviceNames = devices.map((devices) => devices[deviceColumns.name]);
const deviceIds = devices.map((device) => device[deviceColumns.id]);
const evaluationDevices = evaluations.map(
  (evaluation) => evaluation[evaluationColumns.device_id]
);
const deviceEvaluations = deviceIds.map(
  (id) => evaluationDevices.filter((evaluation) => evaluation === id).length
);

new Chart(deviceActivity, {
  type: "doughnut",
  data: {
    labels: deviceNames,
    datasets: [
      {
        label: "Number of Evaluations",
        data: deviceEvaluations,
        backgroundColor: "#4CAF50",
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: "Device Activity",
      },
    },
  },
});
