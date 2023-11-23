<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <?php include __DIR__ . '/../../admin2023/static/header.php';?>
    <?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
    <?php
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to get count of violations by year, month, and day
        $sql = "SELECT YEAR(date) as year, MONTH(date) as month, DAY(date) as day, COUNT(*) as count 
                FROM violations 
                GROUP BY YEAR(date), MONTH(date), DAY(date)";
        $result = $conn->query($sql);

        $violationsData = array();
        while($row = $result->fetch_assoc()) {
            $violationsData[] = array(
                "year" => $row['year'],
                "month" => $row['month'],
                "day" => $row['day'],
                "count" => $row['count']
            );
        }

        $conn->close();
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');
            data.addColumn('number', 'Violations');
            
            <?php
            foreach ($violationsData as $row) {
                $date = $row['year'] . "-" . str_pad($row['month'], 2, "0", STR_PAD_LEFT) . "-" . str_pad($row['day'], 2, "0", STR_PAD_LEFT);
                echo "data.addRow(['".$date."', ".$row['count']."]);";
            }
            ?>

            var options = {
                title: 'Violations by Date',
                hAxis: {title: 'Date', titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
</script>
</head>
<body>
    <div style="display: flex; align-items: center; height: 80vh;">
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
    </div>
</body>
</html>