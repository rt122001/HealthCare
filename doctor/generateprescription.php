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
    <script src="js/bootstrap3-typeahead.js"></script>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <script>


    $.post('symptom.php',function(data){
        $('#disease1').attr('data-source',data);
        $('#disease2').attr('data-source',data);
        $('#disease3').attr('data-source',data);
    });

    </script>
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

        <div class="sidebar" data-color="green" data-image="../assets/img/sidebar-1.jpg">
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
                    <li class="active">
                        <a href="prescription.html">
                            <i class="material-icons">person</i>
                            <p>Create Prescription</p>
                        </a>
                    </li>
                    <li>
                        <a href="database.html">
                            <i class="material-icons">content_paste</i>
                            <p>Disease Database</p>
                        </a>
                    </li>
                  
                    <li>
                        <a href="logout.php">
                            <i class="material-icons">bubble_chart</i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
                <div style="display: table-cell;vertical-align: bottom;text-align:center;height: 400px;width: 400px;font-size:40px;">
                <font color="white>"><div id="txt"></div></font>
            </div>
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
                        <a class="navbar-brand" href="#">Welcome <?php echo $_SESSION['user'];?></a>
                    </div>
                    
                </div>
            </nav>
<div style = "padding-top: 100px">
<div class="content">
<div class="container-fluid">
<div class="row">
                    

                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="green">
                                    <h4 class="title">Disease</h4>
                                    <p class="category">Analysis according to the symptoms entered</p>
                                </div>
                            <div class="card-content">
<?php


$username=$_GET['id'];
$medicine=$_GET['medicine'];
$disease=$_GET['disease'];
$diagnosis=$_GET['diagnosis'];
$instructions=$_GET['instructions'];
$doc_name=$_GET['doc_name'];
$status=$_GET['status'];
$user=$_SESSION['user'];
date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d H:i:s');

$con=@mysql_connect("localhost","root","password") or die(mysql_error());
$db=@mysql_select_db("hms",$con)or die(mysql_error());
$str="insert into prescription(medicine,diagnosis,instructions,doc_name,disease,username,time,status) values('$medicine','$diagnosis','$instructions','$doc_name','$disease','$username','$date','$status')";
$res=@mysql_query($str)or die(mysql_error());
$str2="update users set status='$status' WHERE username='$username'";
$res2=@mysql_query($str2)or die(mysql_error());
echo "<h4>The prescription has been sent.</h4>";
?>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
