<?php 
    require("connection.php")
?>

<!DOCTYPE html>
<html>
<head>
    <title>Host Health Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Host Health Dashboard</h1>

    <!-- Host Table -->
    <div class="card mb-4">
        <div class="card-header">Recent Host Snapshots</div>
        <div class="card-body">
            <table class="table table-bordered" id="host-table">
                <thead>
                    <tr>
                        <th>Hostname</th>
                        <th>OS</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Uptime (s)</th>
                        <th>Total RAM (MB)</th>
                        <th>Free RAM (MB)</th>
                        <th>% RAM Usage</th>
                        <th>Cores</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                $sql = "SELECT hostname, os_type, date, time, uptime, freeram, totalram, cores
                        FROM details
                        ORDER BY id DESC
                        LIMIT 20";

                $result = $conn->query($sql);

                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                        echo "<tr>
                                <td>{$row['hostname']}</td>
                                <td>{$row['os_type']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['time']}</td>
                                <td>{$row['uptime']}</td>
                                <td>{$row['totalram']}</td>
                                <td>{$row['freeram']}</td>
                                <td>"
                ?>
                <?php echo 100*($row['totalram'] - $row['freeram']) / $row['totalram']; ?>
                <?php
                        echo "
                                </td>
                                <td>{$row['cores']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>SQL Error: " . $conn->error . "</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- RAM Usage Chart -->
    <div class="card">
        <div class="card-header">RAM Usage (Last 10 Records)</div>
        <div class="card-body">
            <canvas id="ramChart"></canvas>
        </div>
    </div>
</div>

<script>
// Embed PHP data directly into JS
let data = <?php echo json_encode($data); ?>;

let labels = [];
let usedRam = [];
let freeRam = [];

data.forEach((row, idx) => {
    if (idx < 10) {
        labels.push(row.hostname + " (" + row.date + ")");
        usedRam.push(row.totalram - row.freeram);
        freeRam.push(row.freeram);
    }
});

// RAM Chart
new Chart(document.getElementById('ramChart'), {
    type: 'bar',
    data: {
        labels: labels.reverse(),
        datasets: [
            { label: 'Used RAM (MB)', data: usedRam.reverse(), backgroundColor: 'rgba(255,99,132,0.6)' },
            { label: 'Free RAM (MB)', data: freeRam.reverse(), backgroundColor: 'rgba(54,162,235,0.6)' }
        ]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
</body>
</html>
