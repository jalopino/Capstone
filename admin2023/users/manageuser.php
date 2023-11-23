<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <?php include __DIR__ . '/../../admin2023/static/header.php';?>
    <?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
</head>
<body>
    <div class="background-container">
        <div class="row" style="height: 80vh;">
            <div class="column" style="display: flex; justify-content: center; align-items: center;">
                <div style="padding: 100px;">
                    <h1 style="text-align: center;">Manage user accounts <i class="fa fa-cog"></i></h1>
                    <div style="margin-bottom: 20px;">
                        <form action="" method="post">
                            <label for="search">Search User:</label>
                            <input style="width: 200px;"type="text" id="search" name="search">
                            <input class="button" type="submit" value="Search">
                        </form>
                    </div>
                    <div>
                    <table border="1">
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>License Number</th>
                            <th></th>
                        </tr>

                        <?php
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to fetch officers
                        $search = isset($_POST['search']) ? "%{$_POST['search']}%" : '%';
                        $stmt = $conn->prepare("SELECT user_id, username, user_information.first_name, user_information.last_name, user_information.license_no 
                        FROM users
                        INNER JOIN user_information ON user_information.info_id = users.info_id
                        WHERE first_name LIKE ? 
                        OR last_name LIKE ?");
                        $stmt->bind_param("ss", $search, $search);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Display officers in table
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>".$row["user_id"]."</td>
                                        <td>".$row["username"]."</td>
                                        <td>".$row["first_name"]."</td>
                                        <td>".$row["last_name"]."</td>
                                        <td>".$row["license_no"]."</td>
                                        <td><a href='edituser.php?id=".$row["user_id"]."'>Edit</a></td>
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