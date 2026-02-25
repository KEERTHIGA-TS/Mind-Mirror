<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch full datetime (entry_date) and mood
$query = "SELECT entry_date, mood FROM mood_log WHERE user_id = ? ORDER BY entry_date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$timestamps = [];
$moods = [];

while ($row = $result->fetch_assoc()) {
    $timestamps[] = $row['entry_date']; // full datetime
    $moods[] = $row['mood'];
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Analytics</title>
    <link rel="icon" type="image/jpeg" href="images/mindmirror-logo.png">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{
            background-color: rgb(255, 232, 224);
            font-family: 'Montserrat', sans-serif;
            padding: 0;
            margin:0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            
        }
        h1 {
            color: #4E3D42;
        }
        canvas {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: block;
            margin: 50px auto;
            max-width: 870px;
            padding: 15px;
            width: 100%;
            
        }
        a{
            text-align:center; color: #4E3D42; text-decoration:none;
        }
        @media screen and (max-width: 426px){
            a{
                font-size: 15px;               
            }
        }
    </style>
</head>
<body>

<h2>Mood Evolution Chart</h2>
<canvas id="moodChart" height="500"></canvas>
<a href="dashboard.php" >← Back to Dashboard</a>

<script>
    const timestamps = <?php echo json_encode($timestamps); ?>;
    const moodLabels = <?php echo json_encode($moods); ?>;

    const moodMap = {
        "burnt out": 1,
        "overwhelmed": 2,
        "anxious": 3,
        "clouded": 4,
        "socially numb": 5,
        "emotionally archived": 6,
        "muted presence": 7,
        "withdrawing": 8,
        "cocooned": 9,
        "detaching": 10,
        "overstimulated": 11,
        "dispersed": 12,
        "unanchored": 13,
        "dimmed": 14,
        "quietly craving": 15,
        "lightly buoyant": 16,
        "wholehearted": 17,
        "still blooming": 18,
        "gently elated": 19,
        "quietly radiant": 20,
        "weightless joy": 21,
        "unfolding bright": 22,
        "serenely charged": 23
    };

    const normalize = str => str.trim().toLowerCase();

    const filteredTimestamps = [];
    const filteredMoodData = [];

    moodLabels.forEach((label, index) => {
        const norm = normalize(label);
        if (moodMap[norm]) {
            filteredTimestamps.push(timestamps[index]);
            filteredMoodData.push(moodMap[norm]);
        } else {
            console.warn("Unrecognized mood skipped:", label);
        }
    });

    const moodNamesByValue = Object.entries(moodMap)
        .sort((a, b) => a[1] - b[1])
        .reduce((acc, [name, value]) => {
            acc[value] = name.charAt(0).toUpperCase() + name.slice(1);
            return acc;
        }, {});

    new Chart(document.getElementById('moodChart'), {
        type: 'line',
        data: {
            labels: filteredTimestamps,
            datasets: [{
                label: 'Mood Over Time',
                data: filteredMoodData,
                fill: false,
                borderColor: '#f7c1b2',
                tension: 0.3,
                pointBackgroundColor: '#f4a997',
                pointRadius: 6,
            }]
        },
        options: {
            scales: {
                y: {
                    min: 1,
                    max: 23,
                    ticks: {
                        stepSize: 1,
                        autoSkip: false,
                        callback: function(value) {
                            return moodNamesByValue[value] || '';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Mood',
                        font: { size: 14 }
                    }
                },
                x: {
                    ticks: {
                        callback: function(value, index) {
                            const date = new Date(filteredTimestamps[index]);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            const hours = String(date.getHours()).padStart(2, '0');
                            const minutes = String(date.getMinutes()).padStart(2, '0');
                            const seconds = String(date.getSeconds()).padStart(2, '0');
                            return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                        }
                    },
                    title: {
                        display: true,
                        text: 'Date & Time',
                        font: { size: 14 }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const moodValue = context.parsed.y;
                            const moodLabel = moodNamesByValue[moodValue];
                            const time = filteredTimestamps[context.dataIndex];
                            return `Mood: ${moodLabel}`;
                        }
                    }
                },
                legend: {
                    labels: {
                        font: { family: 'Montserrat' }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
