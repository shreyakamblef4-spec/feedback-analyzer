<?php 
include 'db.php';

// ✅ ADD THIS HERE (TOP)
$positive_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM feedback WHERE sentiment='Positive'"))['total'];

$negative_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM feedback WHERE sentiment='Negative'"))['total'];

$neutral_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM feedback WHERE sentiment='Neutral'"))['total'];
?>


<!DOCTYPE html>
<html>
<head>
    <title>Smart Feedback Analyzer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>🧠 Smart Feedback Analyzer</h1>
    <p class="subtitle">Analyze sentiment & extract keywords instantly</p>

    <div class="card">
        <form action="process.php" method="POST">
            <textarea name="text" placeholder="Write your feedback here..." required></textarea>
            <button type="submit">Analyze Feedback</button>
        </form>
    </div>



    <h2>📊 Previous Feedback</h2>

    <table>
        <tr>
            <th>Feedback</th>
            <th>Sentiment</th>
            <th>Keywords</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM feedback ORDER BY id DESC");

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['text']}</td>
                <td class='{$row['sentiment']}'>{$row['sentiment']}</td>
                <td>{$row['keywords']}</td>
            </tr>";
        }
        ?>
    </table>
    <br>
    <br>

    <!-- ✅ NOW SAFE TO USE -->
<div class="stats">
    <div class="box positive">Positive: <?php echo $positive_count; ?></div>
    <div class="box negative">Negative: <?php echo $negative_count; ?></div>
    <div class="box neutral">Neutral: <?php echo $neutral_count; ?></div>
</div>

</div>

</body>
</html>