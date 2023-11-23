<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Officers</title>
    <?php include __DIR__ . '/../../admin2023/static/header.php';?>
    <?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
</head>
<body>
    <div class="background-container">
        <div class="row" style="height: 80vh;">
            <div class="column">
            <h1 style="text-align: center;">Create new officer account <i class="fa fa-user" aria-hidden="true"></i></h1>
                <div style="display: flex; justify-content: center; align-items: center;">
                        <div class="loginform">
                            <form action="addofficer.php" method="post">
                                <label for="username">Username:</label><br>
                                <input type="text" id="username" name="username"><br>

                                <label for="password">Password:</label><br>
                                <input type="password" id="password" name="password"><br>

                                <label for="fname">First Name:</label><br>
                                <input type="text" id="fname" name="fname"><br>

                                <label for="lname">Last Name:</label><br>
                                <input type="text" id="lname" name="lname"><br>

                                <label for="badge_num">Badge Number:</label><br>
                                <input type="text" id="badge_num" name="badge_num"><br>

                                <input class="button" type="submit" value="Create Officer">
                            </form>
                        </div>
                </div>
            </div>
            <div class="column" style="display: flex; justify-content: center; align-items: center; ">
                <div style="margin-right: 200px;">
                    <h1 style="text-align: center;">Manage officer accounts <i class="fa fa-cog"></i></h1>
                    <div style="margin-bottom: 20px;">
                        <form action="" method="post">
                            <label for="search">Search Officer:</label>
                            <input style="width: 200px;"type="text" id="search" name="search">
                            <input class="button" type="submit" value="Search">
                        </form>
                    </div>
                    <div>
                    <table border="1">
                        <tr>
                            <th>Officer ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Badge Number</th>
                            <th></th>
                            <th></th>
                        </tr>

                        <?php
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to fetch officers
                        $search = isset($_POST['search']) ? "%{$_POST['search']}%" : '%';
                        $stmt = $conn->prepare("SELECT officer_id, username, fname, lname, badge_num FROM officer WHERE fname LIKE ? OR lname LIKE ?");
                        $stmt->bind_param("ss", $search, $search);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Display officers in table
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>".$row["officer_id"]."</td>
                                        <td>".$row["username"]."</td>
                                        <td>".$row["fname"]."</td>
                                        <td>".$row["lname"]."</td>
                                        <td>".$row["badge_num"]."</td>
                                        <td><a href='editofficer.php?id=".$row["officer_id"]."'>Edit</a></td>
                                        <td><a href='deleteofficer.php?id=".$row["officer_id"]."' onclick='return confirm(\"Are you sure you want to delete this officer?\")'>Delete</a></td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No results found</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    label {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
    }

    input {
        border-color: black;
    }
</style>