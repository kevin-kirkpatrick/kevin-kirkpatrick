 <?php
# Start a PHP session
session_start();

# Set the error flag to false
$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Define an error flag
    $wsError = false;

    # Grab the user credentials from the $_POST array
    $name = $_POST['name'];
    $date = $_POST['date'];
	$complete = $_POST['complete'];
	$priority = $_POST['priority'];

    if (empty($name)) {
        $error = true;
    } else {

        # Build your JSON string
        $data = array("Description" => $name, "DueDate" => $date, "IsComplete" => $complete, "Priority" => $priority);
        $data_string = json_encode($data);

        # Specify the url of the web service and initialize
        $url = 'https://w3k8rq6ygj.execute-api.us-east-1.amazonaws.com/prod/AddBucketItem';
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
    <title>Add Item</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    
    <!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
</head>

	<body>
	
	
	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index1.php">Go Home</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Add Item</a></li>
        <li><a href="insights.html">Delete Item</a></li>
        <li><a href="portfolio.html">Update Item</a></li>
         	<form class="navbar-form navbar-right">
        		<div class="form-group">
          			<input type="text" class="form-control" placeholder="Search">
        		</div>
        		<button type="submit" class="btn btn-info">Search</button>
    		</form>
      </ul>
    </div>
  </div>
</nav>

		<div class="container">
		
			
			<h1 class = "center text-center">Add Item</h1>
			<hr>
			
			<div class="row">
			
			<form class="form col-lg-12 col-sm-12 col-md-12 col-xs-12" data-toggle="validator" method="POST">
				<div class="form-group">
					<label for="nameField">Name of Item</label>
					<input type="text" class="form-control" id="nameField" name="name" placeholder="Name of Item" required="true" autofocus autocomplete="on"/>
				</div>
				<div class="form-group">
  					<label for="sel1">Have You Completed This Task?</label>
  					<select class="form-control" id="sel1" name = 'complete'>
   						<option>False</option>
    					<option>True</option>
  					</select>
				</div>
				
				<div class="form-group">
    				<label for="dateField">Date Added</label>
    					<div class="form-inline row">
      						<div class="form-group col-sm-6">
        						<input type="date" class="form-control" id="dateField" name="date" placeholder="MM/DD/YYYY"/>
      						</div>
    					</div>
  				</div>
				
				<div class="form-group">
  					<label for="priority">Priority</label>
  					<select class="form-control" id="priority" name='priority'>
   						<option>1</option>
    					<option>2</option>
    					<option>3</option>
    					<option>4</option>
    					<option>5</option>
    					<option>6</option>
    					<option>7</option>
    					<option>8</option>
    					<option>9</option>
    					<option>10</option>
  					</select>
				</div>
				
				 
				<div class="text-center">
					<button type="submit" class="btn btn-success">Submit</button>
					<button type="reset" class="btn btn-danger">Reset</button>
				</div>
			</form>
			</div>
			
		</div><!--End container-->
		
		
		
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</body>
</html>