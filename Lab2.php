<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lab 2 IT 5235</title>
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
				</div>
			</form>
            
                     <?php
if (isset ($_POST['submit'])){

   if(!empty ($_POST['username']) && !empty ($_POST['password']) ){
    
        $usr = $_POST['username'];
        $pwd = $_POST['password'];
    }
    
    if($pwd == 'kevin' && $usr == 'kevin'){
    
        /** put header function here **/
		header('Location: /index.php');
    
    } else {echo 'Invalid credentials.';}
 
}

?>
			</div>
		
			
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</body>
</html>