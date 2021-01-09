<!--Created by: Ahmed Ali | 101383139
Description: This page allows a user to register-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Register</title>
</head>
<body>
<?php include("includes/header.inc");?>


<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
            <h1 class="display-2 text-center">Registration</h1>
        </div>
</div>
</div>






<form method="POST" action="process_reg.php" novalidate> 
<div class="container">
    <div class="row form-group">
<label for="name" class=" col-lg-2 col-form-label-lg">Name</label>
<input class="form-control-lg col-lg-10" type="text" name="name" id="name"><br>
</div>
<div class="row form-group">
<label for="email" class="col-lg-2 col-form-label-lg">Email:</label>
<input class="form-control-lg col-lg-10" type="email" name="Email" id="Email">
</div>
<div class="row form-group">
<label for="password" class="col-lg-2 col-form-label-lg">Password:</label>
<input class="form-control-lg col-lg-10" type="password" name="Password" id="Password"><br>
</div>
<div class="row form-group">
<label class="col-lg-2 col-form-label-lg" for="confirm">Confirm Password:</label>
<input class="form-control-lg col-lg-10" type="password" name="Confirm_password" id="Confirm_password"><br>
</div>
<div class="row form-group">
<label class="col-lg-2 col-form-label-lg" for="phone">Phone:</label>
<input class="form-control-lg col-lg-10" type="text" name="Phone" id="Phone"><br>
</div>

<div class="row form-group">
<input class="btn btn-lg btn-success col-md-2 mt-5" type="submit" value="Register">
<p class="h6 text-muted col-md-10 text-center mt-4">Already registered? <a href="login.php">Login</a></p>
</div>
</div>
</form>

<?php include("includes/footer.inc");?> 
</body>
</html>