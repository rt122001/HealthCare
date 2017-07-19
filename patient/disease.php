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

        <div class="sidebar" data-color="green" data-image="img/sidebar-1.jpg">
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
                    <li class="active">
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
                    <li>
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
                                    <h4 class="title">Select the related symptom</h4>
                                    <p class="category">Analysis according to the symptoms entered</p>
                                </div>
                            <div class="card-content">
<center>
<?php
$disease1 = $_GET['disease1'];
$disease2 = $_GET['disease2'];
$disease3 = $_GET['disease3'];
$s = array();
$i=0;
$string = "python /Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/apriori.py $disease1 $disease2 $disease3";
$command = escapeshellcmd($string);
exec($command,$output,$code);
echo "<h3>Symptoms : $disease1 , $disease2 , $disease3</h3><br>";
$f = fopen("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/mutually_exclusive.csv", "r");
echo "<h4>Do you feel like : </h4><br>\n";
while(($line = fgetcsv($f)) !== false)
{
    // print out the given column of the line
    $s[$i++]=$line[1];

}
fclose($f);
echo htmlspecialchars($s[1]);;
echo "<br><br>";
echo htmlspecialchars($s[2]);;
echo "<br><br>";
echo htmlspecialchars($s[3]);;
echo "<br><br>";
?>

<form class ="form-horizontal" action = "submitdisease.php" method = "get">
                
                            <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><h4>Select option:</h4></label>
                                                    <span style="display:inline-block; width:40px;"></span>
                                                     <select name = "d1" id="one" style="width:150px;">
                                                        <option value="<?php echo htmlspecialchars($s[1]); ?>"><?php echo htmlspecialchars($s[1]); ?></option>
                                                        <option value="<?php echo htmlspecialchars($s[2]); ?>"><?php echo htmlspecialchars($s[2]); ?></option>
                                                        <option value="<?php echo htmlspecialchars($s[3]); ?>"><?php echo htmlspecialchars($s[3]); ?></option>
                                                        <option value="none">None</option>
                                                      </select>
                                                </div>
                                            </div>
                            </div>
                            
                           
                            
                
                <div class = "form-group">
                        <input type="hidden" name="disease1" value="<?php echo htmlspecialchars($disease1); ?>"/>
                        <input type="hidden" name="disease2" value="<?php echo htmlspecialchars($disease2); ?>"/>
                        <input type="hidden" name="disease3" value="<?php echo htmlspecialchars($disease3); ?>"/>
                        <div class = "col-md-offset-1 col-md-10">
                        <button class = "btn btn-success"><font size = "4px">Submit</font></button><br><br><br>
                    </div>
                </div>
        </form>
</center>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>



