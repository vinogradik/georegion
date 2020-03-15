<?php
	include "Function.php";
	$sqlquery = GenerateQuery($_POST);
    $msc = microtime(true);
	if ($_POST['extractType'] == 0) {
		$sqlquery .= "\nLIMIT ".$_POST['TableSize'];
		
		if ($_POST['lang'] == "russian")
			echo("<h3> Ваш SQL запрос: </h3>");
		else
			 echo("<h3> Your query: </h3>");
		echo("<pre class = 'prettyprint linenums lang-sql'>".$sqlquery.";</pre>");	

   	    $conn = ConnectDB($_POST["db"]);
        ini_set("SQL_BIG_SELECTS", 1);
  		$result = $conn->query($sqlquery);
  		$msc = microtime(true)-$msc;
  		if ($result) {
 			if ($_POST['lang'] == "russian")
				echo("<h3> Ваши данные: </h3>");
			else
				echo("<h3> Your data: </h3>");
  			
    		$numrows = (int)$_POST['TableSize'];
    		$k = 0;
    		while($row = $result->fetch_assoc()) {
				$row_length = count($row);    			
    			if ($k == 0) {	
    				if ($_POST['lang'] == 'russian')
						echo('<p>Первые '.$numrows.' строк:</p>');
					else
						echo('<p>First '.$numrows.' lines:</p>');
					echo('<table><tr><th>#</th>');
					for ($i = 0; $i < $row_length; $i++)
						echo('<th>'.array_keys($row)[$i].'</th>');
					echo('</tr>');    			
    			}
    			echo('<tr><th class = "id">'.($k + 1).'</th>');
       		for ($i = 0; $i < $row_length; $i++) {
       			$newColumn = array_shift($row);
					if ($newColumn == "")
						echo("<td>NULL</td>");
					else					
						echo('<td>'.$newColumn."</td>");
				} 	
   			echo("</tr>");
   			$k++;
     			if ($k == $numrows)
  					break;
  			}
  			echo('</table>');
  			if ($_POST['lang'] == 'russian')
  				echo("<p>Примерное время обработки запроса: ".round($msc, 3)." cек. </p>");
  			else
  				echo("<p>Approximate running time ".round($msc, 3)." s. </p>");
		}
    	if(!$result)
  			echo('<br>Query '.$sqlquery.' error<br>');
		$conn->close();
	}
	else if ($_POST['extractType'] == 1) {
        $dir_address = "../MAPS/".$_POST["uid"];
        if (!is_dir($dir_name)) {
            mkdir($dir_address, 0755);
        }
        $myfile = fopen($dir_address."/DownloadCSV.php", "w");
		fwrite($myfile, '<?php
			include "../../PHP/Function.php";
			header("Content-Type: text/csv; charset=utf-8");
			header("Content-Disposition: attachment; filename = ');
		if (!empty($_POST['filename']))
			fwrite($myfile, $_POST['filename']);
		else
			fwrite($myfile, 'data".$_SERVER[\'REQUEST_TIME\'].".csv'); 
		fwrite($myfile, '");
			$conn = ConnectDB("'.$_POST["db"].'");
			ini_set("max_execution_time", 300);
   		ini_set("memory_limit", "-1");
			$result = $conn->query("'.$sqlquery.'");'.'
			$k = 0;
    		while($row = $result->fetch_assoc()) {
				$row_length = count($row);
    			if ($k == 0) {
					for ($i = 0; $i < $row_length; $i++)
						echo(array_keys($row)[$i]."	");
					echo("\n");
    			}
    			for ($i = 0; $i < $row_length; $i++) {
       			$newColumn = array_shift($row);
					if ($newColumn == "")
						echo("NULL	");
					else
						echo($newColumn."	");
				} 	
   			echo("\n");
   			$k++;

			}
			?>'
		);	
        fclose($myfile);
	}
    else {
        if ($_POST["existing_data"] != 1) {
            $dir_address = "../MAPS/".$_POST["uid"];
            if (!is_dir($dir_name)) {
                mkdir($dir_address, 0755);
            }
            $myfile = fopen($dir_address."/new.csv", "w");
            $conn = ConnectDB($_POST["db"]);
            ini_set("max_execution_time", 300);
            ini_set("memory_limit", "-1");
            ini_set("SQL_BIG_SELECTS", 1);
            $result = $conn->query($sqlquery);
            if ($result) {
                $k = 0;
                while($row = $result->fetch_assoc()) {
                    $row_length = count($row);
                    if ($k == 0) {
                        for ($i = 0; $i < $row_length; $i++)
                            fwrite($myfile, array_keys($row)[$i]." ");
                        fwrite($myfile, "\n");
                    }
                    for ($i = 0; $i < $row_length; $i++) {
                        $newColumn = array_shift($row);
                        if ($newColumn == "")
                            fwrite($myfile, "NULL  ");
                        else                    
                            fwrite($myfile, $newColumn."   ");
                    }
                    fwrite($myfile, "\n");
                    $k++;
                }
            }
            if(!$result)
                echo('<br>Query '.$sqlquery.' error<br>');
            $conn->close();
            fclose($myfile);
            $output = shell_exec('./prepare_data.sh '.$_POST['uid']);
            #echo('<p>'.$output.'</p>');
        }
        $output = shell_exec('./create_grid.sh '.$_POST["grid_density"]." ".$_POST["grid_density"]." ".$_POST["uid"]);
        $parfile = fopen("../MAPS/".$_POST["uid"]."/script.gs", "w");
        $use_grid = 0;
        $maps = "\ncount = 1".
            "\nwhile (count <= numtimes)".
            "\n    'clear norset'".
            "\n    'set t 'count";
        for ($i = 0; $i < count($_POST['MapType']); $i++) {
            $maps .= "\n    'set gxout ".$_POST['MapType'][$i]."'";
            if ($_POST['MapType'][$i] == "contour" && $_POST["CUSTOM_LINE_DENSITY"] == 'on')
                $maps .= "\n    'set cint ".$_POST["LINE_DENSITY"]."'";
            if ($MapOutputTypes[$_POST['MapType'][$i]]) {
                $maps .= "\n    'd oacres(x.2, v.1)'";
                $use_grid = 1;
            }
            else
                $maps .= "\n    'd v.1'";
        }
        $date_type = shell_exec("head -n1 ../MAPS/".$_POST["uid"]."/data.csv | awk '{print $1}'");
        $time_end = 20;
        switch ($date_type) {
            case 1:
                $time_start = 11;
                break;
            case 2:
                $time_start = 13;
                break;
            case 3:
                $time_start = 16;
                break;
            default:
                $time_start = -1;
        }
        $time_length = $time_end - $time_start;
        $maps .= "\n    'q time'";
        if ($time_start > 0)
            $maps .= "\n    'draw title 'substr(result, ".$time_start.", ".$time_length.")";
        $maps .= "\n    'printim ./gif/out'count'.png white'".
            "\n    count = count + 1".
            "\nendwhile";
        $num_times = shell_exec('./get_num_times.sh '.$_POST['uid']);
        $grids_script = "numtimes = ".$num_times.
            "\nminlat = ".$_POST["MAP_DOWN"].
            "\nmaxlat = ".$_POST["MAP_UP"].
            "\nminlon = ".$_POST["MAP_LEFT"].
            "\nmaxlon = ".$_POST["MAP_RIGHT"].
            "\n'open data.ctl'".
            "\n'set dignum 1'".
            "\n'set lat 'minlat' 'maxlat".
            "\n'set lon 'minlon' 'maxlon".
            "\n'set stid on'";
        if ($use_grid)
            $grids_script .= "\n'open grid.ctl'";
        $grids_script .= $maps;

        $grids_script .= "\n";
        fwrite($parfile, $grids_script);
        $output = shell_exec('./create_map.sh '.$_POST["FRAMERATE"]." ".$_POST['uid']);
        //echo('<p>'.$output.'</p>');
        $dum = rand(1, 100000);
        //for($i = 1; $i <= $num_times;$i++) {
        //    echo("<img src='../MAPS/gif/out".$i.".png?dummy=".$dum."'/>");
        //}
        $img_path = "../MAPS/".$_POST["uid"]."/gif/output.gif?dummy=".$dum;
        echo("<div id='map_handler'><img class=map src='".$img_path."'/></div>");
        $msc = microtime(true)-$msc;
        if ($_POST['lang'] == 'russian')
            echo("<p>Примерное время обработки запроса: ".round($msc, 3)." cек. </p>");
        else
            echo("<p>Approximate running time ".round($msc, 3)." s. </p>");
    }
?>
