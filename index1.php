<?php
# Define an error flag
$wsError = false;

# Specify the url of the web service and initialize
$url='https://w3k8rq6ygj.execute-api.us-east-1.amazonaws.com/prod/GetAllBucketListItems';
$handle = curl_init($url);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

# Get the response from the web service
$response = curl_exec($handle);

# Check the HTTP response code
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode == 200) {
        # A good response code means we can parse the JSON
        $items = json_decode($response, true);
} else {
        # A bad response code means we should display an error message
        $wsError = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
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
      <a class="navbar-brand" href="index1.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="additem.php">Add Item</a></li>
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
		
			
			<h1 class = "center text-center">Your current bucket items</h1>
			<hr>
			
			<?php if($wsError) { ?>
                        Error connecting to web service
                <?php } else { ?>
                        
                        <?php
                        # This web service returns a list, so...
                        # Loop thru each item in the list
                        foreach($items as $item) {
                                echo "<div>";
                                echo "<!--". $item['ItemID'] ."-->";
                                echo '<br>';
                                echo $item['Description'];
                                echo '<br>';
                                echo $item['DueDate'];
                                echo '<br>';
                                echo $item['Priority'];
                                echo '<br>';
                                echo $item['IsComplete'];?><br><br><form action ='deleteitem.php' method='POST'><input type="hidden" value="<?php echo $item['ItemID'];?>" name = "ItemID"/><button type="submit" class="btn btn-danger">Delete</button></form>
                                <button type="button" class="btn btn-info">Edit</button><?php
                                echo '</div>';
                                echo '<hr>';
                        }
                }
                ?>
			
		</div><!--End container-->
		
		
		
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</body>
</html>