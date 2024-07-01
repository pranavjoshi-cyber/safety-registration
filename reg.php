<?php
$servername = "localhost";
$username = "root";
$password = "Pranav@6565";
$dbname = "registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed :" . $conn->connect_error);
// }

if ($conn) {
    // echo "connection successful";
} else {
    echo "connection failed " . mysqli_connect_error();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pictureData = $_POST['pictureData'];
    // $thumb = $_FILES['thumb'];


    // Get the image data
    $pictureData = $_POST['pictureData'];
    list($type, $pictureData) = explode(';', $pictureData);
    list(, $pictureData) = explode(',', $pictureData);
    $pictureData = base64_decode($pictureData);

    // Save the picture to a file
    // $picturePath = 'uploads/' . uniqid() . '.png';
    // file_put_contents($picturePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $pictureData)));

    // Save the thumbprint to a file
    // $thumbPath = 'uploads/' . basename($thumb['name']);
    // move_uploaded_file($thumb['tmp_name'], $thumbPath);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $pictureData);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
