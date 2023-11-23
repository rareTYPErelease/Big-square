<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "big lounge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $names = isset($_POST["names"]) ? $_POST["names"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $package = isset($_POST["package"]) ? $_POST["package"] : "";
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $date = isset($_POST["date"]) ? $_POST["date"] : "";
    $time = isset($_POST["time"]) ? $_POST["time"] : "";
    $payment = isset($_POST["payment"]) ? $_POST["payment"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";

    // Server-side validation for phone and email
    $phonePattern = "/^\d{10}$/"; // Matches a 10-digit number
    $emailPattern = "/^\S+@\S+\.\S+$/"; // Matches a basic email format

    if (!preg_match($phonePattern, $phone) || !preg_match($emailPattern, $email)) {
        // Data is not valid, display an error message and do not insert into the database
        echo "Invalid phone number or email address.";
    } else {
        // Data is valid, proceed with insertion
        $stmt = $conn->prepare("INSERT INTO packages (names, email, package, phone, date, time, payment, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $names, $email, $package, $phone, $date, $time, $payment, $message);

        if ($stmt->execute()) {
            // Data has been successfully inserted into the database.
            echo "Data has been successfully inserted into the database.";
            header("Location: index.html"); 

        } else {
            die("Error: " . $conn->error);
        }

        $stmt->close();
    }

    $conn->close();
}
?>
