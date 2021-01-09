<!--Created by: Ahmed Ali | 101383139
Description: This page lists the relevant login inputs to be used to gather info for authentication-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>CabOnline Login</title>
</head>
<body>
<?php include("includes/header.inc");?>
<div class="container">
<div class="row">
    <div class="col-lg-12 d-flex justify-content-center mt-4 mb-4">
<h1 class="display-2  "> Login</h1>
    </div>
</div>
</div>




<form method="POST" action="authenticate.php" novalidate > 
<div class="container">
<div class="form-group row">
<label for="email" class="col-lg-2 col-form-label-lg" >Email:</label>
<input type="email" class=" col-lg-10 form-control-lg" name="Email" id="Email" ><br>
</div>
<div class="form-group row">
<label for="password" class="col-lg-2 col-form-label col-form-label-lg">Password:</label>
<input type="password" class="form-control-lg col-lg-10" name="Password" id="Password" ><br>
</div>
<div class="form-group row ">
<input class="col-md-2 mt-5 btn btn-lg btn-success " type="submit" value="Login">
<p class="h6 text-muted col-md-10 mt-4 text-center">Not registered? <a href="register.php">Register Now!</a></p>
</div>
</form>

<?php include("includes/footer.inc");?>
</body>
</html>