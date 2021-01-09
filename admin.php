<!--Created by: Ahmed Ali | 101383139
Description: This function allows the user to list all booking requests and assign taxi to refernce number using MYSQL commands-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Admin Page of CabsOnline</title>
</head>
<body>
<?php include("includes/header.inc");?>

<div class="container">
    <div class="row">
        <div class="col">
<h1 class="display-1 text-center">Admin</h1>
</div>
</div>
</div>

<form method="GET" novalidate>
    <div class="container">
    <fieldset class="border border-dark border-rounded p-4">
        <legend class="w-auto">List All</legend>
        <div class="form-group row">
    <label class="col-12 text-center">List all unassigned booking requests within 3 hrs of pickup time </label><br>
    

    <div class="col text-center mt-4">
    <input class="btn btn-success btn-md"  type="submit" value="Search" name="list">
    </div>
    </div>
    </fieldset>
</div>
</form>
<hr>
<?php

if (isset($_GET['list']))
{
   require_once ('settings.php');

   $connection = mysqli_connect($host, $user, $pwd, $sql_db);

   if (!$connection)
   {
       echo "SQL Database connection error";
   }


   $query = "SELECT * FROM Booking INNER JOIN Customer ON Booking.Email = Customer.Email WHERE Booking.Booking_status = 'unassigned' AND (Booking.Pickup_time <= CURTIME() + INTERVAL 3 HOUR AND Booking.Pickup_date = CURDATE())";

   $result = mysqli_query($connection,$query);

   if (!$result) 
   {
    echo "<p> Something is wrong with", $query, "</p>";
    }

else {
    echo "<div class='container'>\n"
    ."<table class='table'>\n"
    ."<thead class='thead-dark'>\n"
    . "<tr>\n"
    ."<th scope=\"col\">Reference Number</th>\n"
    ."<th scope=\"col\">Customer Name</th>\n"
    ."<th scope=\"col\">Passenger Name</th>\n"
    ."<th scope=\"col\">Passenger Contact</th>\n"
    ."<th scope=\"col\">Pickup Address</th>\n"
    ."<th scope=\"col\">Destination</th>\n"
    ."<th scope=\"col\">Pickup Date/Time</th>\n"
    ."</tr>\n"
    ."</thead>";
    }

    while ($row = mysqli_fetch_assoc($result)) 
    {
        echo "<tr>\n";
        echo "<td>", $row["Booking_id"], "</td>\n";
        echo "<td>", $row["Customer_Name"], "</td>\n";
        echo "<td>", $row["Passenger_name"], "</td>\n";
        echo "<td>", $row["Passenger_phone"], "</td>\n";
        if ($row['Unit_no'] == 0)
        {
            echo "<td>", $row['Street_Number']," ", $row['Street'], " ", $row['Suburb'], "</td>\n";

        }

        else
        {
            echo "<td>", $row['Unit_no'],"/", $row['Street_Number']," ", $row['Street'], " ", $row['Suburb'], "</td>\n";
        }
        echo "<td>", $row["Destination_suburb"], "</td>\n";
        echo "<td>", $row["Pickup_date"]," ",$row["Pickup_time"], "</td>\n";
        echo "</tr>\n";
    }

    echo "</table>";
    
   

    $rowcount=mysqli_num_rows($result);

    echo "<p class='alert alert-primary w-25 h-25 text-center'>Retrieved"," ", "<u>",$rowcount,"</u>", " ", "row/s.</p>\n"
    . "</div>";

    mysqli_free_result($result);
    mysqli_close($connection);

}
?>
<hr>

<form method="GET" novalidate>
    <div class="container">
    <fieldset class="border border-dark border-rounded p-4" >
        <legend class="w-auto">Assign Taxi to Reference Number</legend>
        <div class="form-group row no-gutters">
            <div class="col-sm-4">
                 <label class="col-form-label col-form-label-lg">Reference Number:</label>
            </div>
            <div class="col-xs-8">
                 <input class="form-control form-control-lg" type="text" name="ref_num" id="ref_num" placeholder="Enter the ref number">
            </div>
            <div class="col-12 mt-4">
                 <input class="btn btn-success btn-md" type="submit" value="Update">
            </div>     
    </div>
    </fieldset>
</div>
</form>

<?php 

require_once ('settings.php');
require_once ('sanatise_data.php');



if (isset($_GET['ref_num']))
{
    
    $ref_num = sanatise_input($_GET['ref_num']);

    $connection = mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$connection)
    {
        echo "SQL Database connection error";
    }

    else 
    {
        $sql_table = "Booking";
    }
 
 
    $query = "UPDATE $sql_table SET Booking_status = 'assigned' WHERE Booking_id = '$ref_num'";


    $result = mysqli_query($connection,$query);

    $affected_rows = mysqli_affected_rows($connection);

    

    if (!$result)
    {
        echo "<p>Query Error.</p>";
    }

    else if ($affected_rows == 0) 
    {
        echo "<div class='container mt-4'>\n"
        ."<p class='alert alert-danger w-50 h-50 text-center'>Could not find any booking requests with given reference number</p>\n"
        ."</div>";
    }

    else {
        echo "<div class='container mt-4'>\n"
        ."<div class='alert alert-success ml-auto mr-auto mb-4'>\n"
        ."<h4 class='alert-heading'>Assigned!</h4>\n"
        ."<p class='alert alert-success col-sm-12' mt-3>The booking request <strong><u>$ref_num</u></strong> has been properly assigned!</p>\n"
        ."<hr>\n"
        ."<p class='mb-0 alert alert-primary w-25 h-25'>","Affected Rows: ",mysqli_affected_rows($connection),"</p>\n"
        ."</div>\n"
        ."</div>";
        mysqli_close($connection);
    }
    
}

?>
<?php include("includes/footer.inc");?>
</body>
</html>