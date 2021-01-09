<!--Created by: Ahmed Ali | 101383139
Description: This function performs input validation and also ensures the inputs are sanatised. Once all inputs are correct and sanatised they will be sent to the SQL booking database.-->
<?php
// ---- Begin Session ----
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Process Booking</title>
</head>
<body>
<?php include("includes/header.inc");?>
<div class="container mt-5">
    <div class="row">

<?php


// ---- Looks for session id which is the email -----
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); //redirect to the login page if no session id
}
else 
{

require_once ("sanatise_data.php");

if (isset($_POST['passenger_name'], $_POST['phone'], $_POST['unit'], $_POST['street_number'], $_POST['street'], $_POST['suburb'], $_POST['destination'], $_POST['pickup_date'], $_POST['pickup_time']))
    { // clean up inputs for safe entry into SQL. 
        $passenger_name = sanatise_input($_POST['passenger_name']);
        $phone =  sanatise_input($_POST['phone']);
        $unit =  sanatise_input($_POST['unit']);
        $street_number = sanatise_input($_POST['street_number']); 
        $street = sanatise_input($_POST['street']); 
        $suburb = sanatise_input($_POST['suburb']);
        $destination = sanatise_input($_POST['destination']);
        $pickup_date = sanatise_input($_POST['pickup_date']);
        $pickup_time = sanatise_input($_POST['pickup_time']);    


    }


$status = "unassigned";
$ref_num = uniqid(); // creates a unique id using built-in php function.
$email = $_SESSION['id'];
date_default_timezone_set("Australia/Melbourne"); // sets the time zone
$booking_date = date("d/m/y"); // passes the current date into the variable.
$booking_time = date("h:i:sa"); // this function passes the time into the variable. 

/*
This makes use of the built in strtotime function to convert the dates into UNIX format
The differnce is calculated by subtracting each other to get the seconds and then divded by 60 to get the minutes. 
*/
$start_time = strtotime($booking_time);
$end_time = strtotime($pickup_time);
$diff = abs($end_time - $start_time)/60;




/*
This bit of code checks for error messages 

*/

$errMsg = "";

//---- BEGIN Error Check----
if ($passenger_name == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter the passenger name!</p>";
    echo $errMsg;
}

else if (!preg_match("/^[a-zA-Z]{1,20}$/", $passenger_name)) // Checks if the value is 20 Alpha characters.
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Only alpha characters allowed!</p>";
    echo $errMsg;
}

if ($phone == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your phone number!</p>";
    echo $errMsg;   
}

else if (!preg_match("/[0-9]{1,10}/", $phone)) // regular expression match numerical digits max 10
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter numerical digit from 0-9. Max 10 digits.  e.g 123456789!</p>";
    echo $errMsg;
}

if ($street_number == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your street number!</p>";
    echo $errMsg;   
}

else if (!preg_match("/[0-9]{1,10}/", $street_number))
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter an integer for the street number form 1-10!</p>";
    echo $errMsg; 
}

if ($street == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your street !</p>";
    echo $errMsg;   
}

else if (!preg_match("/^[A-Za-z\s]+$/", $street))
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter alphabetical characters for your street !</p>";
    echo $errMsg;  
}

if ($suburb == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your suburb!</p>";
    echo $errMsg;   
}

else if (!preg_match("/^[a-zA-Z]{1,20}$/", $suburb))
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter alphabetical characters for your suburb !</p>";
    echo $errMsg;  
}

if ($destination == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your destination!</p>";
    echo $errMsg;   
}
else if (!preg_match("/^[a-zA-Z]{1,20}$/", $destination))
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter alphabetical characters for your destination !</p>";
    echo $errMsg; 
}

if ($pickup_date == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your pickup date!</p>";
    echo $errMsg;   
}

if ($pickup_time == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your pickup time!</p>";
    echo $errMsg;   
}

else if (!preg_match("/^([01][0-9]|2[0-3]):([0-5][0-9])$/", $pickup_time))
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter time in 24 hr format !</p>";
    echo $errMsg; 
}

else if ($diff < 40) // checks the differnce in minutes condition 
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3><strong>Pick-up time must be at least <u>40 minutes</u> after booking time</strong> !</p>";
    echo $errMsg; 
}

// ---- If no error's Begin SQL Opeartion ----
if ($errMsg == "")
{

    require_once ("settings.php");

    $connection = mysqli_connect($host,$user,$pwd,$sql_db);

    if (!$connection) 
    {
        echo " <p class='alert alert-danger col-sm-12 text-center' mt-3> Database connection error.</p>";
    }
    
    else 
    {
        $sql_table = "Booking";
    }

    $query = "INSERT INTO $sql_table (Booking_id, Email, Passenger_name, Passenger_phone, Unit_no, Street_Number, Street, Suburb, Destination_suburb, Pickup_date, Pickup_time, Booking_date, Booking_time, Booking_status) VALUES ('$ref_num', '$email', '$passenger_name', '$phone', '$unit', '$street_number', '$street', '$suburb', '$destination', '$pickup_date', '$pickup_time', '$booking_date', '$booking_time', '$status')";
    
    $result = mysqli_query($connection, $query);

    if (!$result)
    {
        echo " <p class='alert alert-danger col-sm-12 text-center' mt-3>Something wrong with SQL</p>";
    }

    else
    {
        mysqli_close($connection);

        // ---- End of SQL ----


        // ---- Mail to customer ---

        $to = $email;
        $subject = "CabOnline Booking Confirmation";
        $txt = "<html><body>Dear $passenger_name, Thanks for booking with CabOnline. Your booking reference number is <strong><u>$ref_num.</u></strong> We will pick up the passengers in front of your provided address at <strong><u>$pickup_time</u></strong> on <strong><u>$pickup_date</u></strong></body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n"; // ensureing that the message can be formatted using html tags 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .=  "From booking@cabsonline.com.au" . "\r\n";
        mail($to, $subject, $txt, $headers,  "-r 101383139@student.swin.edu.au");

        echo "<div class='alert alert-success ml-auto mr-auto mb-4' >
        <h4 class='alert-heading'>Confirmed!</h4>
         <p class='alert alert-success col-sm-12' mt-3>Thank you! Your booking reference number is <strong><u>$ref_num.</u></strong> We will pick up the passengers in front of your provided address at <strong><u>$pickup_time</u></strong> on <strong><u>$pickup_date</u></strong></p>
        <hr>
        <p class='mb-0'>A booking confirmation email has also been sent to your email at <strong><u>$email</u></strong> for reference.<br> <a class='btn btn-sm btn-success mt-3' href='login.php' >Home</a></p>
      </div>";
    }
}








}

?>
</div>
<hr>
</div>
    <?php include("includes/footer.inc");?>
</body>
</html>