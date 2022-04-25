<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    table {
        border-collapse: collapse;
        width:80%;
    }
    th, td{
        text-align:left;
        padding: 8px;
    }
    tr:nth-child(even) {background-color: #f9f9f9;}
    tr:nth-child(odd) {background-color: #f0f0f0;}
    </style>
    <style>
    .dropbtn {
      background-color: #3498DB;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .dropbtn:hover, .dropbtn:focus {
      background-color: #2980B9;
    }

    .dropdown {
      left:48%;
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      overflow: auto;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {background-color: #ddd;}

    .show {display: block;}
    </style>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        form{
            border: 3px solid #f1f1f1;
            font-family: Arial;
        }
        
        .container {
            padding: 20px;
            background-color: #f1f1f1;
        }
        input[type=email]{
            width:50%;
            padding:12px;
            margin:8px 0;
            display:inline-block;
            border:1px solid #ccc;
            box-sizing: border-box;
        }
            
        input[type=submit]{
            width:20%;
            background-color: #04AA6D;
            color: white;
            border:none;
        }
        input[type=submit]:hover {
            opacity: 0.8;
        
    
    </style>
    
    <title> Robot Data Monitoring System</title>
    <a href="https://ai.uni-bremen.de/">
        <img width = "300" length="300" align="right" src="/IAI_logos/IAIlogo.png">
    </a>
    <a href="https://ease-crc.org/">
        <img width = "300" length="300" align="left" src="/IAI_logos/Easelogo.png">
    </a>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js">
    </script>
    <script>
        $(document).ready(function(){
            $(".slide-toggle").click(function(){
                $(this).nextAll(".box:first").slideToggle();
            });
        });
    </script>
    <style>
        .box{
            width: 100%;
            margin:auto;
        }
        .box-inner{
            padding: 10px;
        }
        .button{
            background-color:#4CAF50;
            border:none;
            color:white;
            padding:15px 32px;
            text-align:center;
            text-decoration:none;
            display: inline-block;
            font-size:16px;
            margin:4px 2px;
            cursor:pointer;
            width:250px;
            position:relative;
        }
        
    </style>
    
    
    <meta http-equiv="refresh" content="30">
    
    
</head>


<body bgcolor="#D1EDF2">
    
<h1 style = "margin-bottom:3cm;" align="center"><?php echo "On-Board Sensor Data for Robots" ?></h1>
<h2 align="center"><?php echo "This table shows the on-board sensor data of the connected robots" ?></h2>
<div align='center'>
<?php
$dir = '/home/pi/Desktop/Server/Updatingdata/';
$files = array_slice(scandir($dir),2);
$nooffiles = count($files);

for ($i = 1; $i<$nooffiles; $i++){
    $dir = "/home/pi/Desktop/Server/Updatingdata/";
    $filespath = $dir.$files[$i];
    $file_handle = fopen($filespath, "rb");
    while (!feof($file_handle) ) 
    {
        $line_of_text = fgets($file_handle);
        $line_of_text = str_replace(array('[ ',']'),'',$line_of_text);
        $parts = explode('=,', $line_of_text);
        $partsip = explode('(',$parts[0]);
        $tempdata = explode(',',$parts[1]);
        $noofdata=count($tempdata);
        $fulldata0 = explode(':',$tempdata[0]);
        $fulldata00 = explode(' ',$fulldata0[1]);
        echo "<button type='button' class='button slide-toggle'>$partsip[0]</button>";
        echo "<hr>";
        echo "<div class='box' style='display:none'>";
        echo "<table align='center' width='850' border='1'>";
        echo "<thread>";
            echo "<tr>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='200'>Computer</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='300'>Chip/Adapter</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data1</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data2</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data3</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data4</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data5</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data6</th>";
                echo "<th style='background-color:#FFF000' rowspan='1',width='50'>Data7</th>";
            echo "</tr>";
            echo "</thread>";

                echo "<tr><td rowspan =$noofdata,height='50'>$parts[0]</td><td>$fulldata0[0]</td><td>$fulldata00[0]</td><td>$fulldata00[1]</td><td>$fulldata00[2]</td><td>$fulldata00[3]</td><td>$fulldata00[4]</td><td>$fulldata00[5]</td><td>$fulldata00[6]</td></tr>";
                for ($j=1; $j<$noofdata; $j++)
                {
                    $fulldata0 = explode(':',$tempdata[$j]);
                    $fulldata00 = explode(' ',$fulldata0[1]);            
                    echo "<tr><td>$fulldata0[0]</td><td>$fulldata00[0]</td><td>$fulldata00[1]</td><td>$fulldata00[2]</td><td>$fulldata00[3]</td><td>$fulldata00[4]</td><td>$fulldata00[5]</td><td>$fulldata00[6]</td></tr>";
                }
                echo "<tr style='background-color:#FF0000'></tr>";
                
        echo "</table>";
        echo "</div>";
    }
    fclose($file_handle);
}
?>
</div>
<p style = "margin-bottom:1cm;"></p>


<form align="center" method="post">
    <div class = "container">
    <h3>To receive critical updates of the robot, enter your Email address here:</h3><br>
    
    <input type="email" placeholder="Email address" name="textdata"><br>
    <input type="submit" class='button' name="submit">
    </div>
</form>

<?php
if(isset($_POST['textdata']))
{
$data=$_POST['textdata'];
$fp = fopen('emaildata.csv', 'a');
$fpdata = file_get_contents('emaildata.csv');
$fparray = explode("\n", $fpdata);
    if(in_array($data,$fparray)) {
        echo "<p align='center'><font color=red>Already subscribed! Please enter a different Email address.</font></p>";
    }
    else {
        fwrite($fp, $data ."\n");
        fclose($fp);
    }
}
?>


<form align="center" method="post">
    <div class = "container">
    <h3>To unsubscribe from the mailing list, enter your Email address here:</h3><br>
    <input type="email" placeholder="Email address" name="unsubdata"><br>
    <input type="submit" class='button' name="submit">
    </div>
</form>

<?php
if(isset($_POST['unsubdata']))
{
    $unsub=$_POST['unsubdata'];
    $ftpdata = file_get_contents('emaildata.csv');
    $ftparray = explode("\n", $ftpdata);
    if(in_array($unsub,$ftparray)) {
        $elementindex = array_search($unsub,$ftparray);
        array_splice($ftparray,$elementindex,1);
        $ftparray = implode("\n",$ftparray);
        $ftpdata = file_put_contents('emaildata.csv',$ftparray);
    }
}
?>

<h1 align="center"><?php echo "Select robot to download the logged data" ?></h1>
<div align="center" class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Select</button>
  <div id="myDropdown" class="dropdown-content">
    <?php
        $logdir='/home/pi/Desktop/Server/Loggeddata/';
        $logfiles = array_slice(scandir($logdir),2);
        $nooffiles=count($logfiles);
        for ($i=0;$i<$nooffiles;$i++){
        $logdir='/Loggeddata/';
        $logfilespath = $logdir.$logfiles[$i];
        echo "<a href=$logfilespath download=$logfiles[$i]>$logfiles[$i]</a>";
    }
    ?>
  </div>
</div>
<p style = "margin-bottom:5cm;"></p>
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

</a>
</body>
</html>
