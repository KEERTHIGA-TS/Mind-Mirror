<?php
session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id'] ?? 1;

// Fetch mood data

$stmt = $conn->prepare("SELECT entry_date, mood FROM mood_log WHERE user_id = ? ORDER BY entry_date ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}



// Prepare data for the chart
$mood_labels = [];
$mood_values = [];
$mood_map = [
    'happy' => 'Euphoric',
    'sad' => 'Melancholic',
    'angry' => 'Indignant',
    'excited' => 'Exhilarated',
    'anxious' => 'Perturbed',
    'calm' => 'Serene',
    'tired' => 'Lethargic',
    'lonely' => 'Solitary'
];

// Assign numeric values to moods for charting
$mood_scores = [
    'Euphoric' => 8,
    'Exhilarated' => 7,
    'Serene' => 6,
    'Solitary' => 5,
    'Lethargic' => 4,
    'Melancholic' => 3,
    'Perturbed' => 2,
    'Indignant' => 1
];

foreach ($data as $row) {
    $mood = $mood_map[$row['mood']] ?? ucfirst($row['mood']);
    $mood_labels[] = $row['entry_date'];
    $mood_values[] = $mood_scores[$mood] ?? 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mood Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Montserrat, sans-serif;
            background-color: #f7c1b2;
            padding: 40px;
            text-align: center;
        }
        canvas {
            background-color: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        h1 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h1>Your Mood Over Time</h1>
    <canvas id="moodChart" width="800" height="400"></canvas>

    <script>
        const ctx = document.getElementById('moodChart').getContext('2d');
        const moodChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($mood_labels) ?>,
                datasets: [{
                    label: 'Mood Trend',
                    data: <?= json_encode($mood_values) ?>,
                    fill: false,
                    borderColor: '#ff7f50',
                    backgroundColor: '#ff7f50',
                    tension: 0.3,
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                const map = {
                                    8: 'Euphoric',
                                    7: 'Exhilarated',
                                    6: 'Serene',
                                    5: 'Solitary',
                                    4: 'Lethargic',
                                    3: 'Melancholic',
                                    2: 'Perturbed',
                                    1: 'Indignant'
                                };
                                return map[value] || value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
