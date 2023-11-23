<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../static/header.php';?>
    <?php include __DIR__ . '/../templates/restrict_anon.php';?>
    <title>Welcome, <?php echo $_SESSION["username"];?></title>
</head>
<?php 
    $user_id = $_SESSION["user_id"];
    // Create a parameterized query
    $query = "SELECT user_id, info_id FROM users WHERE user_id = ? AND info_id IS NULL";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id); // "i" for integer, you can change it based on the data type of your primary_id
        $stmt->execute();
        $stmt->bind_result($selected_user_id, $selected_info_id);
        $stmt->fetch();
        if (!is_null($selected_user_id)) {
            echo "Secondary ID is NULL for user ID " . $selected_user_id;
            $stmt->close();
            header("Location: {$base}capstone/dashboard/profile.php");
            exit();
        } 
    }
?>
<body>
    <div class="background-container" style="display: flex; height: 80vh; justify-content: center; align-items: center;">
        <div class="row">
            <div style="justify-content: start; align-items: start;">
                <div class="column" style="padding: 50px; flex: 25%;">
                    <form action="<?php echo $base; ?>capstone/violations/search.php" method="get" style="text-align: center;">
                        <h1 style="font-weight: bold; color: #176bfd;">Search violations<i class="fa fa-search" style="padding-left: 20px;"></i></h1>
                        <input type="text" name="search" placeholder="Search for violations" style="border: 1px solid black; width: 500px;">
                        <br>
                        <input type="submit" value="Search" class="button">
                    </form>
                </div>
            </div>
            <div class="column">
                <?php 
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Replace 'your_specific_user_id' with the actual user ID you're querying for
                    $specificUserId = $_SESSION['user_id'];
                    $query = "SELECT violation_id, violation, date, status, fine FROM violations WHERE user_id = ?";

                    // Prepare and bind
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $specificUserId); // 'i' denotes the parameter type is integer

                    // Execute the query
                    $stmt->execute();

                    // Bind the results to variables
                    $result = $stmt->get_result();
                
                // Display results in a table if there are any matches.
                echo "<div class='table-container'>";
                echo "<table border='1'>";
                echo "<tr><th>Violation ID</th><th>Violation</th><th>Date</th><th>Status</th><th>Fine</th><th>Actions</th></tr>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['violation_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['violation']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>$" . htmlspecialchars($row['fine']) . "</td>";
                        echo "<td><a href='". $base ."capstone/violations/viewviolation.php?violation_id=" . $row['violation_id'] . "' target='_blank'>View</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<h1>No violations found.</h1>";
                }
                echo "</table>";
                echo "</div>";
                // Close the statement and connection if they were opened
                if (isset($stmt)) {
                    $stmt->close();
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
<?php include __DIR__ . '/../static/footer.php';?>
</html>




<style>
.table-container {
    margin-right: 10%;
}
</style>


<?php
// Check if info ID is null
/* 
    $user_id = $_SESSION["user_id"];
    // Create a parameterized query
    $query = "SELECT user_id, info_id FROM users WHERE user_id = ? AND info_id IS NULL";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id); // "i" for integer, you can change it based on the data type of your primary_id
        $stmt->execute();
        $stmt->bind_result($selected_user_id, $selected_info_id);
        $stmt->fetch();
        if (!is_null($selected_user_id)) {
            echo "Secondary ID is NULL for user ID " . $selected_user_id;
            header("Location: {$base}capstone/dashboard/profile.php");
            exit();
        } else {
            ;
        }
        $stmt->close();
    } else {
        echo "Query preparation failed: " . $conn->error;
    }
    // Close the connection
    $conn->close();
    */
?>