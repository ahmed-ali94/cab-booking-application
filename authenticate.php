<!--Created by: Ahmed Ali | 101383139
Description: This function autenticates the login info provided by the user and checks the database for a match-->
<?php

session_start(); // Creates a new session 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Document</title>
</head>
<body>
<?php include("includes/header.inc");?>

<div class="container mt-5">
    <div class="row">
        <div class="alert alert-warning ml-auto mr-auto mb-4 " >
            <h4 class="alert-heading">Wait!</h4>
             <p class='alert alert-danger col-sm-12 text-center' mt-3>Aww so close! We've come across some errors that are listed below.</p>
            <hr>
            <p class="mb-0">Please carefully read the errors below and try again.<br> <a class="btn btn-sm btn-danger mt-3 " href="login.php" >Go Back</a></p>
          </div>

<?php 

require_once ("sanatise_data.php");


if (isset($_POST['Email'], $_POST['Password']))
{
    $email= sanatise_input($_POST['Email']);
    $pw = sanatise_input($_POST['Password']);
}

$errMsg = "";

if ($email ==  "")

{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3> Please enter your Email</p>";

    echo $errMsg;
}

if ($pw == "")
{
    $errMsg = " <p class='alert alert-danger col-sm-12 text-center' mt-3>Please enter your password</p>";

    echo $errMsg;
}

if ($errMsg == "")
{
    require_once ("settings.php");

    $connection = mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$connection)
    {
        echo " <p class='alert alert-danger col-sm-12 text-center' mt-3>Database connection error</p>";
    }
    else 
    {
        $sql_table = "Customer";
    }

    $query = "SELECT Email, Customer_Password FROM $sql_table WHERE Email = '$email' AND Customer_Password = '$pw'";

    $result = mysqli_query($connection,$query);

    $rows = mysqli_num_rows($result);

    if (!$result)
    {
        echo " <p class='alert alert-danger col-sm-12 text-center' mt-3>SQL Error</p>";
    }

    else if ($rows == 1)
    {
        mysqli_free_result($result);
        mysqli_close($connection);
        $_SESSION['id'] = $email;
        header("location: booking.php?Email=" .$email);
    }
    
    else 
    {
        echo " <p class='alert alert-danger col-sm-12 text-center' mt-3>Invalid login details</p>";
    }

}
?>
</div>
<hr>
</div>
<?php include("includes/footer.inc");?>
</body>
</html>