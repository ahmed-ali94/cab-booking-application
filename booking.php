<!--Created by: Ahmed Ali | 101383139
Description: This page display the inputs that will be used to gather booking info-->
<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Booking Page</title>
</head>
<body>
<?php include("includes/header.inc");?>


<?php

if (isset($_SESSION['id'])) {
    echo "<div class='container-fluid '>\n"
    ."<div class='row'>\n"
    ."<div class='col-sm-2 mt-3 ml-3'>\n"
    ."<p class='h6'> <strong>Username:</strong>"," ", "<u>",$_SESSION['id'],"</u>", " ", "</p>\n"
    ."</div>\n"
    ."</div>\n"
    ."</div>";
}
else {
header("Location: login.php"); //redirect to the login page
}

?>


<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
            <h1 class="display-2 text-center">CabsOnline Booking </h1>
        </div>
</div>
</div>



<form method="POST" action="process_booking.php" novalidate>
    <div class="container">
    <fieldset class="border border-dark border-rounded p-4">
        <legend class="w-auto">Passenger Details</legend>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label  for="name"> Passenger Name</label><br>
        <input class="form-control-lg" type="text" name="passenger_name" id="passenger_name">
        </div>
        <div class="form-group col-md-6">
        <label for="Phone">Phone</label><br>
        <input class="form-control-lg" type="text" name="phone" id="phone">
        </div>
        </div>
    </fieldset>


    <fieldset class="border border-dark border-rounded p-4">
        <legend class="w-auto">Pickup Address</legend>
        
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="unit">Unit No</label><br>
        <input class="form-control-lg" type="text" name="unit" id="unit">
        </div>
        <div class="form-group col-md-6">
        <label for="street_number">Street No</label><br>
        <input class="form-control-lg" type="text" name="street_number" id="street_number">
        </div>
        </div>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="street">Street</label><br>
        <input class="form-control-lg" type="text" name="street" id="street">
        </div>
        <div class="form-group col-md-6">
        <label for="suburb">Suburb</label><br>
        <input class="form-control-lg" type="text" name="suburb" id="suburb">
        </div>
        </div>
    </fieldset>
    <fieldset class="border border-dark border-rounded p-4">
        <legend class="w-auto">Destination Details</legend>
        <div class="form-row">
        <div class="form-group col-md-4">
        <label for="destination">Destination Suburb</label><br>
        <input class="form-control-lg" type="text" name="destination" id="destination">
        </div>
        <div class="form-group col-md-4">
        <label for="pickup_date">Pickup Date</label><br>
        <input class="form-control-lg" type="date" name="pickup_date" id="pickup_date" placeholder="dd/mm/yyyy">
        </div>
        <div class="form-group col-md-4">
        <label for="pickup_time">Pickup Time</label><br>
        <input class="form-control-lg" type="time" name="pickup_time" id="pickup_time">
        </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col mt-4">
    <input class="btn btn-success btn-md" type="submit" value="Book">
    </div>
    </div>

</div>

</form>
</div>
<?php include("includes/footer.inc");?> 
</body>
</html>