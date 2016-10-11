<?php
	include "Function.php";
	$Columns = $_POST['Columns'];
	if (true) {
 		$sqlquery = GenerateQuery($_POST);
		echo("<h3> Ваш SQL запрос: </h3>");
   	echo("<p>".$sqlquery."</p>");	
   
   	$conn = ConnectDB();

  		$result = $conn->query($sqlquery);
  		if ($result) {
 			echo('<h3> Ваши данные: </h3>');
  			//$row_cnt = $result->num_rows;
  			//echo('<p>Количество строк: '.$row_cnt.'</p>');
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
						echo("<th>NULL</th>");
					else					
						echo('<th>'.$newColumn."</th>");
				} 	
   			echo("</tr>");
   			$k++;
     			if ($k == $numrows)
  					break;
  			}
  			echo('</table>');  			
		}
    	if(!$result)
  			echo('<br>Query '.$sqlquery.' error<br>');
		$conn->close();
	}	 
?>