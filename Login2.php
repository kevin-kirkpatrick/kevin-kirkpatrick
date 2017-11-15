<?php
# Start a PHP session
session_start();

# Set the error flag to false
$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Define an error flag
    $wsError = false;

    # Grab the user credentials from the $_POST array
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($password) || empty($username)) {
        $error = true;
    } else {

        # Build your JSON string
        $data = array("Username" => $username, "Password" => $password);
        $data_string = json_encode($data);

        # Specify the url of the web service and initialize
        $url = 'https://w3k8rq6ygj.execute-api.us-east-1.amazonaws.com/prod/UserLoginFunction';
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        # Get the response from the web service
        $response = curl_exec($handle);

        # Check the HTTP response code
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 200) {
            # A good response code means we can parse the JSON
            $login_data = json_decode($response, true);
            # Store the login token as a cookie with the 30 day expiration date
            setcookie('token', $login_data['Token'], time() + (86400 * 30), "/");
            $_SESSION["token"] = $login_data['Token'];
        } else if ($httpCode == 404) {
            # A 404 means the user was not found
            $error = true;
        } else {
            # A bad response code means we should display an error message
            $wsError = true;
        }
    }
    if (!$error) {
        header('Location: index1.php');
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!--<link href = "styles.css" rel="stylesheet">-->
    
    <!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style>
	
	.stylin{
	
		border: 1px solid black; 
		background-color: #B8B8B8;
		box-shadow: 10px 10px 5px grey;
		margin: 0 auto;
		padding: 25px;
		border-radius: 25px;
		max-width: 800px;
	
	}
	
	body{
	
		background-image: url('chris.jpg');
			
	}
	
	input:focus {
    background-color: lightblue;
}
	

	</style>
	

    
</head>

	<body>

		<div class="container stylin">
            
   
		
	
		<h1 style="text-align: center;">Login</h1>
		
			 <?php if ($wsError) { ?>
        <p class="err">Web Service Error</p>
    <?php } else if ($error) { ?>
        <p class="err">Login Error</p>
    <?php } ?>
		
	
			<form class="form col-lg-6 col-sm-12 col-md-6 col-xs-12 col-md-offset-3" data-toggle="validator" method="POST">
				<div class="form-group">
					<label for="nameField">UserName*</label>
					<input type="text" class="form-control" id="unf" name="username" placeholder="Your UserName" required="true" autofocus />
				</div>
				<div class="form-group">
					<label for="emailField">Password*</label>
					<input type="password" class="form-control" id="pwf" name="password" placeholder="Password" required="true"/>
				</div>
				
				<div class="text-center">
					<button type="submit" class="btn btn-success" name="submit">Submit</button>
					<button type="reset" class="btn btn-danger">Reset</button>
					<a href='signup.php' type="button" class="btn btn-info">Sign Up</a>
				</div>
			</form>
            
                     			</div>
		
			
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</body>
</html>