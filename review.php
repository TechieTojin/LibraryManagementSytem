<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <style>
        body {
            background-image: url('back.jpg'); /* Replace 'back.jpg' with the path to your background image */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            // Retrieve form data
            $studentname = $_POST["studentname"];
            $registernumber = $_POST["registernumber"];
            $bookid = $_POST["bookid"];
            $operation = $_POST["operation"];

            // Connect to the database
            $con = new mysqli("localhost", "root", "", "simson");

            // Check connection
            if ($con->connect_error) {
                die("Failed to connect: " . $con->connect_error);
            } else {
                if ($operation === "return") {
                    // Update the book availability to 'available' in the database
                    $stmt_return_book = $con->prepare("UPDATE book SET availability = 'available', studentname = NULL, registernumber = NULL WHERE bookid = ?");
                    $stmt_return_book->bind_param("s", $bookid);
                    $stmt_return_book->execute();

                    // Increase availability count
                    $stmt_increase_availability = $con->prepare("UPDATE book SET availability_count = availability_count + 1 WHERE bookid = ?");
                    $stmt_increase_availability->bind_param("s", $bookid);
                    $stmt_increase_availability->execute();

                    // Calculate fine if the return date is overdue
                    $returnDate = strtotime("+7 days"); // Assuming the return period is 7 days
                    $currentDate = time();
                    if ($currentDate > $returnDate) {
                        $daysOverdue = floor(($currentDate - $returnDate) / (60 * 60 * 24)); // Calculate days overdue
                        $fineAmount = $daysOverdue * 2; // Fine of 2 rupees for each overdue day
                        // Display fine message
                        echo "<p class='error'>You have exceeded the return date. Fine amount: Rs. $fineAmount</p>";
                        // You may want to store this fine in the database or process it further
                    }

                    // Check for errors
                    if ($stmt_return_book->error || $stmt_increase_availability->error) {
                        echo "Error: " . $stmt_return_book->error . " " . $stmt_increase_availability->error;
                    } else {
                        // Display success message
                        echo "<h2 class='success'>Book Returned Successfully!</h2>";

                        // Display available count
                        $stmt_available_count = $con->prepare("SELECT availability_count FROM book WHERE bookid = ?");
                        $stmt_available_count->bind_param("s", $bookid);
                        $stmt_available_count->execute();
                        $result = $stmt_available_count->get_result();
                        $row = $result->fetch_assoc();
                        $availability_count = $row['availability_count'];
                        echo "<p>Number of Books Available: $availability_count</p>";

                        // Display submitted data
                        echo "<h3>Submitted Data:</h3>";
                        echo "<p>Returned By: $studentname</p>";
                        echo "<p>Register Number: $registernumber</p>";
                        echo "<p>Book Id: $bookid</p>";
                        echo "<p>Operation: $operation</p>";

                        // Add an interesting message
                        echo "<p class='success'>Thank you for using our library system! We hope you enjoyed the book.</p>";
                    }
                } elseif ($operation === "borrow") {
                    // Check if the book is available for borrowing
                    $stmt_check_availability = $con->prepare("SELECT * FROM book WHERE bookid = ? AND availability = 'available' AND availability_count > 0");
                    $stmt_check_availability->bind_param("s", $bookid);
                    $stmt_check_availability->execute();
                    $stmt_result_availability = $stmt_check_availability->get_result();

                    if ($stmt_result_availability->num_rows > 0) {
                        // Update the book availability and borrower details in the database
                        $stmt_borrow_book = $con->prepare("UPDATE book SET availability = 'unavailable', studentname = ?, registernumber = ? WHERE bookid = ?");
                        $stmt_borrow_book->bind_param("sss", $studentname, $registernumber, $bookid);
                        $stmt_borrow_book->execute();

                        // Decrease availability count
                        $stmt_decrease_availability = $con->prepare("UPDATE book SET availability_count = availability_count - 1 WHERE bookid = ?");
                        $stmt_decrease_availability->bind_param("s", $bookid);
                        $stmt_decrease_availability->execute();

                        // Check for errors
                        if ($stmt_borrow_book->error || $stmt_decrease_availability->error) {
                            echo "Error: " . $stmt_borrow_book->error . " " . $stmt_decrease_availability->error;
                        } else {
                            // Display success message
                            echo "<h2 class='success'>Book Borrowed Successfully!</h2>";

                            // Display return date
                            $returnDate = strtotime("+7 days"); // Assuming the return period is 7 days
                            $returnDateFormatted = date("jS F Y", $returnDate);
                            echo "<p>Return Date: $returnDateFormatted</p>";

                            // Display available count
                            $stmt_available_count = $con->prepare("SELECT availability_count FROM book WHERE bookid = ?");
                            $stmt_available_count->bind_param("s", $bookid);
                            $stmt_available_count->execute();
                            $result = $stmt_available_count->get_result();
                            $row = $result->fetch_assoc();
                            $availability_count = $row['availability_count'];
                            echo "<p>Number of Books Available: $availability_count</p>";

                            // Display detailed book information
                            $borrowed_book_info = $stmt_result_availability->fetch_assoc();
                            echo "<h3>Book Information:</h3>";
                            echo "<p>Title: " . $borrowed_book_info['title'] . "</p>";
                            echo "<p>Author: " . $borrowed_book_info['author'] . "</p>";
                            echo "<p>Genre: " . $borrowed_book_info['genre'] . "</p>";
                            echo "<p>Published Year: " . $borrowed_book_info['published_year'] . "</p>";

                            // Display submitted data
                            echo "<h3>Submitted Data:</h3>";
                            echo "<p>Borrowed By: $studentname</p>";
                            echo "<p>Register Number: $registernumber</p>";
                            echo "<p>Book Id: $bookid</p>";
                            echo "<p>Operation: $operation</p>";

                            // Add an interesting message
                            echo "<p class='success'>Thank you for using our library system! Enjoy your reading journey!</p>";
                        }
                    } else {
                        // Display error message for unavailable book
                        echo "<h2 class='error'>The book is not available for borrowing at the moment.</h2>";
                        // Add link to reference.html
                        echo "<p class='error'>Please check the <a href='reference.html'>reference section</a> for similar books.</p>";
                    }
                } else {
                    // Display error message for invalid operation
                    echo "<h2 class='error'>Invalid operation!</h2>";
                }
            }
        ?>
    </div>
</body>
</html>