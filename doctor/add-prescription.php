<?php
    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }
    }else{
        header("location: ../login.php");
    }
    
    //import database
    include("../connection.php");
    
    // Get logged-in doctor's ID
    $userrow = $database->query("select docid from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $docid= $userfetch["docid"];

    if($_POST){
        // Get data from form
        $pid = $_POST['pid'];
        $details = $_POST['details'];
        $presc_date = $_POST['presc_date'];

        // SQL to insert
        $sql="INSERT INTO prescription (docid, pid, presc_date, details) VALUES (?, ?, ?, ?)";
        
        $stmt = $database->prepare($sql);
        $stmt->bind_param("iiss", $docid, $pid, $presc_date, $details);
        $stmt->execute();
        
        // Redirect back to the patient list with a success message (optional)
        header("location: patient.php?action=prescription-added");
    }
?>