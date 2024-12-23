<?php
$conn = mysqli_connect("localhost", "root", "", "tojin");
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}

if(isset($_GET['subject'])) {
    $subject = $_GET['subject'];
    $sql = "SELECT bookid, bookname, authorname FROM physics";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        echo json_encode($books);
    } else {
        echo json_encode([]);
    }
}
$conn->close();
?>
