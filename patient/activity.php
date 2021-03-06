<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>HEALTHCARE ASSISTANCE</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="css/material-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<script>
	function startTime()
	{
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();
	// add a zero in front of numbers<10
	h=checkTime(h);
	m=checkTime(m);
	s=checkTime(s);
	document.getElementById('txt').innerHTML=h+":"+m+":"+s;
	t=setTimeout(function(){startTime()},500);
	}

	function checkTime(i)
	{
	if (i<10)
	  {
	  i="0" + i;
	  }
	return i;
	}
	</script>

</head>

<body onload="startTime()">

	<div class="wrapper">
	    <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
			<!--
	        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
		    Tip 2: you can also add an image using data-image tag

			-->

			<div class="logo">
				<a href="http://www.creative-tim.com" class="simple-text">
					HEALTHCARE ASSISTANCE
				</a>
			</div>


	    	<div class="sidebar-wrapper">
				<ul class="nav">
	                <li>
	                    <a href="dashboard.php">
	                        <i class="material-icons">dashboard</i>
	                        <p>Home</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="user.html">
	                        <i class="material-icons">person</i>
	                        <p>Update Profile</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="viewprescription.php">
	                        <i class="material-icons">content_paste</i>
	                        <p>Prescription</p>
	                    </a>
	                </li>
	                <li class="active">
	                    <a href="activity.php">
	                        <i class="material-icons">library_books</i>
	                        <p>Activity Monitor</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="logout.php">
	                        <i class="material-icons">bubble_chart</i>
	                        <p>Logout</p>
	                    </a>
	                </li>
	            </ul>
	    	</div>
		</div>

	    <div class="main-panel">
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Activity Monitor</a>
					</div>
					
				</div>
			</nav>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    
	                          
	                    <div class="col-md-12">
	                    	<div class="card card-plain">
	                    		<div class="card-header" data-background-color="green">
	                                <h4 class="title">Activity Monitor</h4>
	                                <p class="category">List of all symptoms entered by patients</p>
	                    		</div>
	                    		<div class="card-content table-responsive">
				                <?php
									$dbhost = 'localhost';
									$dbuser = 'root';
									$dbpass = 'password';
									$username=$_SESSION['user'];
									$conn = mysql_connect($dbhost, $dbuser, $dbpass);
									if(! $conn )
									{
									  die('Could not connect: ' . mysql_error());
									}
									$sql = 'SELECT * from logs';

									mysql_select_db('hms');
									$retval = mysql_query( $sql, $conn );
									if(! $retval )
									{
									  die('Could not get data: ' . mysql_error());
									}
									echo '<table class="table table-hover"><thead class="text-primary"><th>SYMPTOMS</th><th>DATE</th></thead>';
									while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
									{
									    echo "<tr>";
									    echo "<td>{$row['symptoms']}</td>";
									    echo "<td>{$row['date']}</td>";
									    echo "</tr>";
									} 
									echo "</table>";
									mysql_close($conn);
								?>
								</div>
	                        </div>
	                    </div>
	                    
	                                       
	                     
	                </div>
	            </div>
	        </div>


	    </div>
	</div>

</body>

	<!--   Core JS Files   -->
	<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="js/bootstrap-notify.js"></script>

	<!--  Google Maps Plugin    -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

	<!-- Material Dashboard javascript methods -->
	<script src="js/material-dashboard.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="js/demo.js"></script>

</html>
