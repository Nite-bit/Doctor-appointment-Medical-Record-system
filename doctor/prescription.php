<?php
include '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $prescription = $_POST['prescription'];

    $sql = "UPDATE patients SET prescription = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $prescription, $email);

    if ($stmt->execute()) {
        header("Location: my-patients.php?msg=Prescription updated successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
