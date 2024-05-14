<?php
//index.php
require('db_connect.php');

//visits per day
$sql_daily = "SELECT day,sum(daily_visits) as 'daily_visits'
        from poispopulartimes group by day";

$result_daily = mysqli_query($conn, $sql_daily);

$daily_chartData = '';
while ($row = mysqli_fetch_array($result_daily)) {
    $daily_chartData .= "{ day:'" . $row["day"] . "', daily_visits:" . $row["daily_visits"] . "}, ";
}
$daily_chartData = substr($daily_chartData, 0, -2);

//visits per hour
$sql_hourly = "SELECT hour,sum(hourly_visits) as 'hourly_visits'
               from hourlypopulartimes group by hour";


$result_hourly = mysqli_query($conn, $sql_hourly);

$hourly_chartData = '';
while ($row = mysqli_fetch_array($result_hourly)) {
    $hourly_chartData .= "{ hour:'" . $row["hour"] . "', hourly_visits:" . $row["hourly_visits"] . "}, ";
}
$hourly_chartData = substr($hourly_chartData, 0, -2);



?>


<!DOCTYPE html>
<html>

<head>
    <title>Graphical Results</title>
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>

<body>
    <br /><br />
    <div class="container" style="width:900px;">
        <h2 class="text-center">Bar chart for the number of visits reported by users for each day</h2>
        <br /><br />
        <div id="daily_chart"></div>
        <br /><br /> <br /><br />
    </div>

    <div class="container" style="width:900px;">
        <h2 class="text-center">Bar chart for the number of visits reported by users for each hour of the day</h2>
        <br /><br />
        <div id="hourly_chart"></div>
    </div>

    <div class="container">
        <button class="btn btn-warning btn-sm"><a href="adminpage.php" style="text-align: none; color: #333;">Back to Results</a></button>
        <br /><br />
        <br /><br />
    </div>

</body>

</html>

<script>
    Morris.Bar({
        element: 'daily_chart',
        data: [<?php echo $daily_chartData; ?>],
        xkey: 'day',
        ykeys: ['daily_visits'],
        labels: ['Visits'],
        hideHover: 'auto',
        stacked: true
    });


    Morris.Bar({
        element: 'hourly_chart',
        data: [<?php echo $hourly_chartData; ?>],
        xkey: 'hour',
        ykeys: ['hourly_visits'],
        labels: ['Visits'],
        hideHover: 'auto',
        stacked: true
    });
</script>