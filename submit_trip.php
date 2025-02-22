<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "car_rental";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the form is submitted via POST and fields are set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use isset() to check if keys exist before accessing them
    $pickup_location = isset($_POST['pickup_location']) ? trim($_POST['pickup_location']) : '';
    $dropoff_location = isset($_POST['dropoff_location']) ? trim($_POST['dropoff_location']) : '';
    $pickup_date = isset($_POST['pickup_date']) ? trim($_POST['pickup_date']) : '';
    $dropoff_date = isset($_POST['dropoff_date']) ? trim($_POST['dropoff_date']) : '';
    $pickup_time = isset($_POST['pickup_time']) ? trim($_POST['pickup_time']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';

    // Validate inputs
    if (empty($pickup_location) || empty($dropoff_location) || empty($pickup_date) || empty($dropoff_date) || empty($pickup_time) || empty($phone_number)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO trips (pickup_location, dropoff_location, pickup_date, dropoff_date, pickup_time, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $pickup_location, $dropoff_location, $pickup_date, $dropoff_date, $pickup_time, $phone_number);

    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
