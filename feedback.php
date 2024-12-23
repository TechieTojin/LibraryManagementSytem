<?php
    // Variable assignment: getting variable data from post method in HTML
    // PHP variable = POST method [HTML variable]
    $Name = $_POST['Name'];
    $Mail = $_POST['Email']; // Changed to match HTML form
    $Comments = $_POST['Comments'];

    // Create database (create it in phpMyAdmin)
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'simson');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO feedback (Name, Mail, Comments) VALUES (?, ?, ?)");
        // Binding data types
        $stmt->bind_param("sss", $Name, $Mail, $Comments);
        $stmt->execute();
        echo "Thanks for your Valuable Feedback...";
        $stmt->close();
        $conn->close();
    }
?>
