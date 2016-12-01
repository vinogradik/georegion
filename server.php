<?php
	include "Function.php";
	$sqlquery = GenerateQuery($_POST);
	if ($_POST['extractType'] == 0) {
		$Columns = $_POST['Columns'];
		echo("<h3> Ваш SQL запрос: </h3>");
   	echo("<pre class = 'prettyprint linenums lang-sql'>".$sqlquery.";</pre>");	
   
   	$conn = ConnectDB();
		$msc = microtime(true);
  		$result = $conn->query($sqlquery);
  		$msc = microtime(true)-$msc;
  		if ($result) {
 			echo('<h3> Ваши данные: </h3>');
  			
    		$numrows = (int)$_POST['TableSize'];
    		$k = 0;
    		while($row = $result->fetch_assoc()) {
				$row_length = count($row);    			
    			if ($k == 0) {	
					echo('<p>Первые '.$numrows.' строк:</p>');
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
  			echo("<p>Примерное время обработки запроса: ".round($msc, 3)." cек. </p>");
		}
    	if(!$result)
  			echo('<br>Query '.$sqlquery.' error<br>');
		$conn->close();
	}
	else 	{
		$myfile = fopen("DownloadCSV.php", "w");
		fwrite($myfile, '<?php
			include "Function.php";
			header("Content-Type: text/csv; charset=utf-8");
			header("Content-Disposition: attachment; filename = ');
		if (!empty($_POST['filename']))
			fwrite($myfile, $_POST['filename']);		
		else
			fwrite($myfile, 'data".$_SERVER[\'REQUEST_TIME\'].".csv'); 
		fwrite($myfile, '");
			$conn = ConnectDB();
			ini_set("max_execution_time", 300);
   		ini_set("memory_limit", "-1");
			$result = $conn->query("'.$sqlquery.'");'.
			'$k = 0;
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
	}
?>