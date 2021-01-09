<!--Created by: Ahmed Ali | 101383139
Description: This function performs input santisation and input validation for all registration inputs. Once the inputs are all checked thry are sent to the SQL user table-->
<?php
session_start(); // create new session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Registration Confirmation</title>
</head>
<body>
<?php include("includes/header.inc");?>

<div class="container mt-5">
    <div class="row">
        <div class="alert alert-warning ml-auto mr-auto mb-4 " >
            <h4 class="alert-heading">Wait!</h4>
             <p class='alert alert-warning col-sm-12' mt-3>Aww so close! We've come across some errors that are listed below.</p>
            <hr>
            <p class="mb-0">Please carefully read the errors below and try again.<br> <a class="btn btn-sm btn-danger mt-3 " href="register.php" >Go Back</a></p>
          </div>

<?php 
/*
The purpose of this PHP is to process the inputs from rego page and send to the sql server 
*/

require_once ("sanatise_data.php");


if (isset($_POST["name"], $_POST["Password"], $_POST["Confirm_password"], $_POST["Email"], $_POST["Phone"])) // checks to see if all registration variables are set and then sanatised. 
{

    $name= sanatise_input($_POST["name"]);
    $pw= sanatise_input($_POST["Password"]);
    $confirm_pw= sanatise_input($_POST["Confirm_password"]);
    $email= sanatise_input($_POST["Email"]);
    $phone= sanatise_input($_POST["Phone"]);   
}

 
/*
This bit of code checks for error messages 

*/

$errMsg = "";

if ($name == "")
{
    $errMsg = "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
Please Enter your name</p>";

    echo $errMsg;
}

else if (!preg_match("/^[a-zA-Z]{1,20}$/", $name)) // Checks if the value is 20 Alpha characters.
{
    $errMsg = "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
Only alpha numeric characters allowed </p>";
    echo $errMsg;
}

if ($email=="") 
{
    $errMsg = "    <p class='alert alert-danger col-sm-12 text-center' mt-3>
Please Enter your email</p>";

    echo $errMsg;
}

else if (!preg_match("/.+\@.+\..+/", $email)) // regex email that includes @
{
    $errMsg = "    <p class='alert alert-danger col-sm-12 text-center' mt-3>
Please Enter a valid e-mail- including the @ character</p>";

    echo $errMsg;
}

if ($pw && $confirm_pw == "")
{
    $errMsg = "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
Please Enter your password</p>";

    echo $errMsg;
}

else if ($pw != $confirm_pw) // If password values are not equal error will occur. 
{
    $errMsg = "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
Passwords dont match</p>";

    echo $errMsg;
}

if ( $phone == "")
{
    $errMsg = "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
Please enter phone number</p>";

    echo $errMsg;
}

else if (!preg_match("/[0-9]{1,10}/", $phone)) // regular expression match numerical digits max 10
{
    $errMsg = "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
Please enter numerical digit from 0-9. Max 10 digits.  e.g 123456789</p>";

    echo $errMsg;

}

if ($errMsg == "") // If there is no errors proceed to SQL operation.
{
    require_once ("settings.php");

    $connection = mysqli_connect($host,$user,$pwd,$sql_db);

    if (!$connection) 
    {
        echo "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
 Database connection error.</p>";
    }
    
    else 
    {
        $sql_table = "Customer";
    }

    $query = "INSERT INTO $sql_table (Customer_Name, Customer_Password, Email, Phone) VALUES ('$name', '$pw', '$email', '$phone')";
    
    $result = mysqli_query($connection, $query);

    if (!$result) 
    {
        echo "      <p class='alert alert-danger col-sm-12 text-center' mt-3>
 Something is wrong with", $result, "</p>";
    }
    
    else
    {
        mysqli_close($connection); // close SQL connection. 
        $_SESSION['id']= $email;
        header("location: booking.php?email=".$email);
    }


}















?>
</div>
<hr>
</div>

    <?php include("includes/footer.inc");?> 
</body>
</html>