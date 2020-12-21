<?php
if (isset($_POST['city'])) {
    $name=$_POST['cn'];
    $apiKey = "e7eb22bb75f3ca322aba24782763f3fe";
    $cityname = $name;
    $googleApiUrl = 'api.openweathermap.org/data/2.5/weather/?q='.$cityname.'&appid='.$apiKey.'';
    //$googleApiUrl='api.openweathermap.org/data/2.5/forecast/daily?q='.$cityname.'&mode=xml&units=metric&cnt=7&appid='.$apiKey.'';

    $ch = curl_init();

    //curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //curl_setopt($ch, CURLOPT_VERBOSE, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    // print_r($response);

    curl_close($ch);
    $data = json_decode($response);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    $lon=$data->coord->lon;
    $lat=$data->coord->lat;
    // echo $lat;
    // echo $lon;
    $currentTime = time();

    $url2= "https://api.openweathermap.org/data/2.5/onecall?lat=" . $lat . "&lon=" . $lon . "&exclude=minutely,hourly&units=metric&appid=" . $apiKey . "";
    
    $ch2 = curl_init();

    //curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_URL, $url2);
    $response2 = curl_exec($ch2);
   

    curl_close($ch2);
    $data2 = json_decode($response2);
    // echo '<pre>';
    // print_r($data2);
    // echo '</pre>';

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body>
<form action="" method="POST">
<input type="text" placeholder="Enter City Name" name='cn' class='mt-3'>
<input type="submit" name="city" value="Submit">
</form> 
<div>
<h1 class="text-center">Weather Daily data</h1>
<table class="table table-striped" id="myTable">
<thead>
<?php if (isset($data)) {?>
<tr>
<th>Latitude</th>
<th>Longitude</th>
<th>Date</th>
<th>Max Temp</th>
<th>Pressure</th>
<th>Humidity</th>
<th>visiblity</th>
<th>City Name</th>
<th>Country</th>

</tr>
</thead>
<tbody>
<?php } ?>
<?php 
if (isset($data2)) {
    foreach ($data2->daily as $key=>$value2) {
        echo '<tr>';
        echo '<td>'.$data2->lat.'</td>';
        echo '<td>'.$data2->lon.'</td>';
        echo '<td>'.date('l F\'y, d', $value2->dt).'</td>'; 
        echo '<td>'.$value2->temp->max.'</td>';
        echo '<td>'.$value2->pressure.'</td>';
        echo '<td>'.$value2->humidity.'</td>';
        echo '<td>'.$data2->current->visibility.'</td>';
        echo '<td>'.$data->name.'</td>';
        echo '<td>'.$data->sys->country.'</td>';
        echo '</tr>';
    }
}

?>
</tr>
</tbody>
</table>
</div>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
</body>
</html>