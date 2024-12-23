<?php
// Connect to MySQL database
$con = new mysqli("localhost", "root", "", "simson");
echo "thanks unni headache";

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch data from the library_fines table
$sql = "SELECT * FROM library_fines";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Fine Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* CSS styles */
    </style>
</head>
<body>
    <div class="container">
        <h1>Library Fine Information</h1>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Register Number</th>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Department</th>
                    <th>Due Date <i class="fas fa-calendar-day"></i></th>
                    <th>Return Date <i class="fas fa-calendar-check"></i></th>
                    <th>Fine (in Rupees) <i class="fas fa-rupee-sign"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['student_name'] . "</td>";
                        echo "<td>" . $row['register_number'] . "</td>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['author'] . "</td>";
                        echo "<td>" . $row['department'] . "</td>";
                        echo "<td>" . $row['due_date'] . " <i class='fas fa-calendar-day'></i></td>";
                        echo "<td>" . $row['return_date'] . " <i class='fas fa-calendar-check'></i></td>";
                        echo "<td><i class='fas fa-rupee-sign'></i>" . $row['fine'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$con->close();
?>
