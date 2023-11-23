<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../static/header.php';?>
    <?php include __DIR__ . '/../templates/restrict_anon.php';?>
    <title>Welcome, <?php echo $_SESSION["username"];?></title>
</head>
<body>
    <div class="background-container" style="display: flex; height: 80vh; justify-content: center; align-items: center;">
        <div class="row">
            <div style="justify-content: start; align-items: start;">
                <div class="column" style="justify-content: start; align-items: center; padding: 50px; flex: 25%;">
                    <form method="get" action="<?php echo $base; ?>capstone/violations/search.php" style="text-align: center;">
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
                // Get the current logged-in user's ID from the session.
                $loggedInUserId = $_SESSION['user_id'];

                // Define search term
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                // SQL with LIKE operator if the search term exists
                if ($searchTerm) {
                    $query = "SELECT violation_id, user_id, violation, date, status, fine FROM violations WHERE user_id = ? AND violation LIKE ?";
                    $stmt = $conn->prepare($query);
                    $searchTermWithWildcards = '%' . $searchTerm . '%';
                    $stmt->bind_param("is", $loggedInUserId, $searchTermWithWildcards);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    // If there's no search term, fetch all violations for the logged-in user.
                    $query = "SELECT violation_id, user_id, violation, date, status, fine FROM violations WHERE user_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $loggedInUserId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                }

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
                        echo "<td>₱" . htmlspecialchars($row['fine']) . "</td>";
                        echo "<td><a href='". $base ."capstone/violations/viewviolation.php?violation_id=" . $row['violation_id'] . "' target='_blank'>View</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<h1>No related violations found from search.</h1>";
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
<style>
.table-container {
    margin-right: 10%;
}
</style>
<?php include __DIR__ . '/../static/footer.php';?>
</html>
