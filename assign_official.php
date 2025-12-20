<?php
session_start();
include('db_connect.php');

// ✅ Ensure the user is an organizer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizer') {
    echo "<script>alert('Access denied!'); window.location.href='dashboard.php';</script>";
    exit();
}

// ✅ Fetch all matches
$matches_query = "SELECT id, sport, teams, date, assigned_officials FROM schedules";
$matches_result = $conn->query($matches_query);

// ✅ Fetch all match officials
$officials_query = "SELECT official_id, name, role FROM officials";
$officials_result = $conn->query($officials_query);

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['match_id'], $_POST['officials']) && is_array($_POST['officials'])) {
        $match_id = intval($_POST['match_id']);
        $official_ids = array_map('intval', $_POST['officials']); // Ensure valid integer values

        // ✅ Insert each official into the assignments table
        foreach ($official_ids as $official_id) {
            $insert_query = "INSERT INTO assignments (match_id, official_id) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            if ($stmt) {
                $stmt->bind_param("ii", $match_id, $official_id);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "<script>alert('Error assigning officials. Please try again.');</script>";
                exit();
            }
        }

        // ✅ Fetch assigned officials' names securely
        if (!empty($official_ids)) {
            $placeholders = implode(',', array_fill(0, count($official_ids), '?'));
            $officials_query = "SELECT name FROM officials WHERE official_id IN ($placeholders)";
            $stmt = $conn->prepare($officials_query);
            $stmt->bind_param(str_repeat("i", count($official_ids)), ...$official_ids);
            $stmt->execute();
            $result = $stmt->get_result();

            $official_names = [];
            while ($official = $result->fetch_assoc()) {
                $official_names[] = $official['name'];
            }
            $stmt->close();

            // ✅ Update schedules table with assigned officials
            $assigned_officials = implode(', ', $official_names);
            $update_schedule_query = "UPDATE schedules SET assigned_officials=? WHERE id=?";
            $stmt = $conn->prepare($update_schedule_query);
            if ($stmt) {
                $stmt->bind_param("si", $assigned_officials, $match_id);
                $stmt->execute();
                $stmt->close();
            }
        }

        echo "<script>alert('Officials assigned successfully!'); window.location.href='assign_official.php';</script>";
        exit();
    } else {
        echo "<script>alert('Please select a match and at least one official.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Match Officials</title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            font-size: 16px;
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #ffffff;
            font-size: 14px;
        }

        select:focus {
            outline: 2px solid #007bff;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Assign Match Officials</h2>
        <form method="POST">
            <label>Select Match:</label>
            <select name="match_id" required>
                <option value="">-- Select Match --</option>
                <?php while ($match = $matches_result->fetch_assoc()) { ?>
                    <option value="<?= $match['id'] ?>">
                        <?= htmlspecialchars($match['sport']) ?>: <?= htmlspecialchars($match['teams']) ?> (<?= htmlspecialchars($match['date']) ?>) 
                        - Assigned: <?= htmlspecialchars($match['assigned_officials']) ?? 'None' ?>
                    </option>
                <?php } ?>
            </select>

            <label>Select Officials:</label>
            <select name="officials[]" multiple required>
                <?php while ($official = $officials_result->fetch_assoc()) { ?>
                    <option value="<?= $official['official_id'] ?>">
                        <?= htmlspecialchars($official['name']) ?> (<?= htmlspecialchars($official['role']) ?>)
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Assign Officials</button>
            <a href="dashboard_organizer.html" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
