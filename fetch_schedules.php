<?php
// Include database connection
include('db_connect.php');

// Prepare an array for the response
$response = array();

try {
    // Fetch all schedule records
    $sql = "SELECT * FROM schedules";
    $result = $conn->query($sql);

    // Check if rows exist
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = array(
                'match_id' => $row['match_id'],
                'sport' => $row['sport'],
                'teams' => $row['teams'],
                'date' => $row['date'],
                'time' => $row['time'],
                'venue' => $row['venue']
            );
        }
    }
} catch (Exception $e) {
    $response['error'] = "Error: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
