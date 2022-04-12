<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
      left:50%;
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
    <title> Robot Data Monitoring System</title>
    <a href="https://ai.uni-bremen.de/">
        <img width = "300" length="300" align="right" src="/IAI_logos/IAIlogo.png">
    </a>
    <a href="https://ease-crc.org/">
        <img width = "300" length="300" align="left" src="/IAI_logos/Easelogo.png">
    </a>
    <meta http-equiv="refresh" content="30">
</head>
<body bgcolor="#D1EDF2">
<h1 style = "margin-bottom:3cm;" align="center"><?php echo "On-Board Sensor Data for Robots" ?></h1>

<form align="center" method="post">
    To receive critical updates of the robot, enter your Email address here:<br>
    <input type="email" name="textdata"><br>
    <input type="submit" name="submit">
    
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
    To unsubscribe from the mailing list, enter your Email address here:<br>
    <input type="email" name="unsubdata"><br>
    <input type="submit" name="submit">
    
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
    
<h1 align="center"><?php echo "This table shows the on-board sensor data of the connected robots" ?></h1>
<table align="center" width="850" border="1">
    <thread>
    <tr>
        <th rowspan="1",width="200">Computer</th>
        <th rowspan="1",width="300">Chip/Adapter</th>
        <th rowspan="1",width="50">Data1</th>
        <th rowspan="1",width="50">Data2</th>
        <th rowspan="1",width="50">Data3</th>
        <th rowspan="1",width="50">Data4</th>
        <th rowspan="1",width="50">Data5</th>
        <th rowspan="1",width="50">Data6</th>
        <th rowspan="1",width="50">Data7</th>
    </tr>
    </thread>
<?php
$dir = '/home/pi/Desktop/Server/Updatingdata/';
$files = array_slice(scandir($dir),2);
$nooffiles = count($files);

for ($i = 0; $i<$nooffiles; $i++){
    $dir = "/home/pi/Desktop/Server/Updatingdata/";
    $filespath = $dir.$files[$i];
    $file_handle = fopen($filespath, "rb");
    while (!feof($file_handle) ) 
    {
        $line_of_text = fgets($file_handle);
        $line_of_text = str_replace(array('[ ',']'),'',$line_of_text);
        $parts = explode('=,', $line_of_text);
        $tempdata = explode(',',$parts[1]);
        $noofdata=count($tempdata);
        $fulldata0 = explode(':',$tempdata[0]);
        $fulldata00 = explode(' ',$fulldata0[1]);
        echo "<tr><td rowspan =$noofdata,height='50'>$parts[0]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata0[0]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[0]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[1]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[2]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[3]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[4]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[5]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[6]</td></tr>";
        for ($j=1; $j<$noofdata; $j++)
        {
            $fulldata0 = explode(':',$tempdata[$j]);
            $fulldata00 = explode(' ',$fulldata0[1]);            
            echo "<tr><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata0[0]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[0]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[1]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[2]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[3]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[4]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[5]</td><td style='background-color:".(($row['quantity']>50) ? '#FF0000;' : '#FFFF00')."'>$fulldata00[6]</td></tr>";
        }
    }
    fclose($file_handle);
}
?>
</table>
<p style = "margin-bottom:1cm;"></p>

<h1 align="center"><?php echo "Select robot to download the logged data" ?></h1>
<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Select</button>
  <div id="myDropdown" class="dropdown-content">
    <a href="/Loggeddata/leela.txt" download="Leela.txt">Leela</a>
    <a href="/Loggeddata/amy.txt" download="Amy.txt">Amy</a>
    <a href="/Loggeddata/homer.txt" download="Homer.txt">Homer</a>
    <a href="/Loggeddata/pr2a.txt" download="Pr2a.txt">Pr2a</a>
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
