<!DOCTYPE html>
<html>
<head>
    
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
<div align="center">This table shows temperature of different cores in the processor.</div>
<table width="850" border="1">
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
$dir = '/home/pi/Desktop/test/Updatingdata/';
$files = array_slice(scandir($dir),2);
$nooffiles = count($files);

for ($i = 0; $i<$nooffiles; $i++){
    $dir = "/home/pi/Desktop/test/Updatingdata/";
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
</body>
</html>
