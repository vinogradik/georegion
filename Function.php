<?php
$Names = array(
		array("DAYS", "дата"),
		array("REGION", "номер региона (в алфавитном порядке)"),
		array("IND", "индекс станции"),
		array("LAT", "широта"),
		array("LON", "долгота"),
		array("TMIN", "t минимальная"),
		array("TMEAN", "t средняя"),
		array("TMAX","t максимальная"),
		array("R", "осадки"),
	);
	
$Date = array(
		array("DAY", "день", 1, 31),
		array("MONTH", "месяц", 1, 12),
		array("YEAR", "год", 1800, 2100) 
);

$Tables = array(
		array ("REGIONNAME", "REGIONS"),
		array ("MIGRATION", "STAT_MIGR_1997_2015"),
		array ("MIGR_COEFF", "STAT_MIGR_COEF_1997_2015"),
		array ("NATINCREASE", "STAT_NAT_INC_1990_2014"),
		array ("OVERALLINCREASE", "STAT_OVERALL_INC_1990_2014"),
		array ("LIFETIME", "STAT_LIFETIME_1990_2010"),
		array ("NEONATMORTALITY", "STAT_NEONAT_2012"),
		array ("CHILDMORTALITY", "STAT_CHILD_MORT_2013_2015"),
		array ("DECEASEMORTALITY", "STAT_MORT_1990_2012")
);

$EDataCols = array(
	array(),
	array(array("TYPE", "YEAR"), array(array("в пределах России", "Внешняя (для региона) миграция", "внутрирегиональная", "международная всего", "международная всего по региону", "межрегиональная", "миграция всего", "с другими зарубежными странами", "со странами СНГ,  Балтии и Грузии"), "годы")),
	array(array("YEAR"), array("годы")),
	array(array("SEX", "TYPE", "YEAR"), array(array("оба пола", "женщины", "мужчины"), array("все население", "городское население", "сельское население"), "годы")),
	array(array("TYPE", "YEAR"), array(array("общий", "город", "село"), "годы")), 
	array(array("SEX", "TYPE", "YEAR"), array(array("оба пола", "женщины", "мужчины"), array("все население", "городское население", "сельское население"), "годы")),
	array(),
	array(array("YEAR"), array("годы")),
	array(array("DECEASE", "TYPE", "YEAR"), array(array("болезни органов дыхания", "болезни органов пищеварения", "внешние причины", "врожденные аномалии (пороки развития, деформации и хромосомные нарушения)", "всего умерших от всех причин", "некоторые инфекционные и паразитарные болезни", "отдельные состояния", "возникающие в перинатальном периоде"),array("все население", "городское население", "сельское население"), "годы"))
);


function error_default($place){
	echo('<p class = "error">Ошибка. Проверьте фильтр "'. $place.'"');
}
function error($side, $place) {
	echo('<p class = "error">Ошибка. Проверьте ');
	if($side)
		echo('нижнюю');
	else 
		echo('верхнюю');
	echo(' границу фильтра "'.$place.'".</p>');
	return false;	
}
function error_echo($message) {
	echo('<p class = "error">Ошибка. '. $message);
}


function day_of_year($day, $month) {
	$a = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$result = $day;
	for ($i = 1; $i < $month; $i++) {
		$result += $a[$i];
	}
	return $result;
}

function ValidateForm($Data) {
	global $Names;
	global $Date;
	
	//не нажата кнопка submit
	if (empty($Data['SubmitAll'])) 
		return false;
	
	//проверка существования столбцов	
	if (!isset($Data['Columns'])) {
		echo('Вы ничего не выбрали');
		return false;		
	}
		
	//проверка даты
	$l = 0;
	$r = 0;
	for ($i = 0; $i < count($Date); $i++) {
		//проверка на то, что дата - набор чисел
		if (!empty($Data[$Date[$i][0]][0]))  {
			$l++;
			if (!is_numeric($Data[$Date[$i][0]][0]) || $Data[$Date[$i][0]][0] < $Date[$i][2] || $Data[$Date[$i][0]][0] > $Date[$i][3])
			 	return error(true, $Names[0][1].': '.$Date[$i][1]); 
		}
		if (!empty($Data[$Date[$i][0]][1]))  {
			$r++;		
			if (!is_numeric($Data[$Date[$i][0]][1]) || $Data[$Date[$i][0]][1] < $Date[$i][2] || $Data[$Date[$i][0]][1] > $Date[$i][3])
				return error(false, $Names[0][1].': '.$Date[$i][1]);
		}
	}		
	
	if ($Data['DateType'] == "method1"){ 
		//проверка даты в первом случае
		if(empty($Data['DAY'][0]) && !empty($Data['MONTH'][0])) return error(true, $Names[0][1].': '.$Date[0][1]);
		if(!empty($Data['DAY'][0]) && empty($Data['MONTH'][0])) return error(true, $Names[0][1].': '.$Date[1][1]);
		if(empty($Data['DAY'][1]) && !empty($Data['MONTH'][1])) return error(false, $Names[0][1].': '.$Date[0][1]);
		if(!empty($Data['DAY'][1]) && empty($Data['MONTH'][1])) return error(false, $Names[0][1].': '.$Date[1][1]);
	}
	else 
		//проверка даты во втором случае
		if (($l > 0 && $l < 3)||($r > 0 && $r < 3)) return error_default($Names[0][1]);
	
	
	
	
	
	for ($i = 1; $i < count($Names); $i++) {			
		if (!empty($Data[$Names[$i][0]][0])  && !is_numeric($Data[$Names[$i][0]][0])) return error(true, $Names[$i][1]);
		if (!empty($Data[$Names[$i][0]][1]) && !is_numeric($Data[$Names[$i][0]][1])) return error(false, $Names[$i][1]);
		if (!empty($Data[$Names[$i][0]][0]) 
			&& !empty($Data[$Names[$i][0]][1]) 
			&& $Data[$Names[$i][0]][0] > $Data[$Names[$i][0]][1])
			return error_echo('Левая граница фильтра "'.$Names[$i][1].'" больше правой.');	
	}
		
	//проверка параметра количество строк на странице
	if (!empty($Data['TableSize']) && !is_numeric($Data['TableSize'])) {
		return error_echo('Проверьте значение параметра "количество строк на странице".');	
	}
		
	return true;
}


function GenerateQuery($Data) {
	Global $Tables;
	$nl = "\n";
	$sqlquery = "";
	$innerquery = GenerateCoreQuery($Data);
	if (empty($Data["LR"]) && empty($Data["REGIONList"]))
		$sqlquery = $innerquery;
	else {
		if (!empty($Data["LR"])) {
			$nl = "\n\t";
			$sqlquery = "SELECT B.n"; 
			if(!empty($Data['Groups']))
				for ($i = 0; $i < count($Data['Groups']); $i++) {
					$sqlquery .= ",\n\tB.".$Data["Groups"][$i];
					if (!empty($Data[$Data["Groups"][$i]."List"]))
						for ($j = 0; $j < count($Data[$Data["Groups"][$i].'List']); $j++)
							$sqlquery .= ",\n\tB.".$Data[$Data["Groups"][$i]."List"][$j];
				}
			for ($i = 0; $i < count($Data['Columns']); $i++) {
				$sqlquery .= ",\n\t(B.n * B.sumXY".$i." - B.sumX * B.sumY".$i.") / (B.n * B.sumXX - B.sumX * B.sumX) AS '";
				$sqlquery .= $Data['Functions'][0].'('.$Data['Columns'][$i].").LRCOEFF'";		
		
			}	
			$sqlquery .= "\nFROM (";
		}
		$sqlquery .= $nl."SELECT";
		
		if(!empty($Data['Groups']))
			$k = 0;
			for ($i = 0; $i < count($Data['Groups']); $i++) {
				$sqlquery .= $nl."\tA.G".$i.' AS "'.$Data["Groups"][$i].'",';
				if (!empty($Data[$Data["Groups"][$i]."List"]))
					for ($j = 0; $j < count($Data[$Data["Groups"][$i].'List']); $j++) {
						if ($Data["Groups"][$i] == "REGION") {
							while ($Data[$Data["Groups"][$i].'List'][$j] != $Tables[$k][0] && $k < 10)
								$k++;
							$sqlquery .= $nl."\tE".$j.'.VALUE AS "'.$Tables[$k][0].'",';
						}
						else if ($Data["Groups"][$i] == "IND")
							$sqlquery .= $nl."\tA.".$Data['INDList'][$j].' AS "'.$Data['INDList'][$j].'",';
					}			
			}
			
		if (!empty($Data["LR"])) {
			$sqlquery .= "\n\t\tCOUNT(A.X) AS ".'"n"'.",\n\t\tSUM(A.X) AS ".'"sumX"'.",\n\t\tSUM(A.X * A.X) AS ".'"sumXX"';
    		for ($i = 0; $i < count($Data['Columns']); $i++) {
    			$sqlquery .= ",\n\t\tSUM(A.Y".$i.') AS "sumY'.$i.'"';
    			$sqlquery .= ",\n\t\tSUM(A.Y".$i." * A.Y".$i.")  AS ".'"sumYY'.$i.'"';
    			$sqlquery .= ",\n\t\tSUM(A.X * A.Y".$i.") AS ".'"sumXY'.$i.'"';
    		}
    	}
    	else {
    		$sqlquery = substr($sqlquery, 0, -1);
    		for ($i = 0; $i < count($Data['Columns']); $i++) {
    			$sqlquery .= ",".$nl."\tA.Y".$i." AS ";
    			if (!empty($Data["Functions"][0]))
    				$sqlquery .= '"'.$Data['Functions'][0].'('.$Data['Columns'][$i].')"';
    			else 
    				$sqlquery .= $Data['Columns'][$i];
    		}
		}
    	$sqlquery .= $nl."FROM (".$innerquery.$nl.") AS A";
    	
    	if (!empty($Data['REGIONList'])) {
			$j = 0;    	
    		for ($i = 0; $i < count($Data['REGIONList']); $i++) {
    			while ($Data['REGIONList'][$i] != $Tables[$j][0])
    				$j++;
    			if ($j > 0)
					$sqlquery .= $nl."JOIN (".GenerateEconomicQuery($Data, $j, $nl."\t").$nl.") AS E".$i;
				else 
					$sqlquery .= $nl."JOIN REGIONS AS E0";
				$sqlquery .= $nl."ON E".$i.".REGION = A.G0"; 	
    		}
    	}
    	
    	
    			
		if (!empty($Data["LR"])) {
			if(!empty($Data['Groups'])) {
				$sqlquery .= $nl."GROUP BY ";
				for ($i = 0; $i < count($Data['Groups']); $i++)
					$sqlquery .= "A.G".$i.",\n\t";
				$sqlquery = substr($sqlquery, 0, -3);
			}
			$sqlquery .= "\n) AS B";
		}
   }
   
	if ($Data['extractType'] == 0)
		$sqlquery .= "\nLIMIT ".$Data['TableSize'];
	
	return $sqlquery;
}









function GenerateEconomicQuery($Data, $j, $nl) {
	global $Tables;
	global $EDataCols;
	$query = $nl."SELECT REGION,".$nl."\t";
	if ($Data[$Tables[$j][0]."Function"][0] == "DEFAULT")
		$query .= "VALUE";
	else 
		$query .= $Data[$Tables[$j][0]."Function"][0]."(VALUE) AS VALUE";
	$query .= $nl."FROM ".$Tables[$j][1].$nl;
	if (!empty($EDataCols[$j])) {
		$subquery = "";
		for ($k = 0; $k < count($EDataCols[$j][0]) - 1; $k++) 
			if (!empty($Data[$Tables[$j][0].$EDataCols[$j][0][$k]]))
				$subquery .= $EDataCols[$j][0][$k].' = "'.$Data[$Tables[$j][0].$EDataCols[$j][0][$k]].'"'.$nl."\tAND ";
		if(!empty($Data[$Tables[$j][0]."YEARL"]))
			$subquery .= "YEAR >= ".$Data[$Tables[$j][0]."YEARL"].$nl."\tAND ";
		if(!empty($Data[$Tables[$j][0]."YEARR"]))
			$subquery .= "YEAR <= ".$Data[$Tables[$j][0]."YEARR"].$nl."\tAND ";
		if (!empty($subquery)) {
			$subquery  = "WHERE ".$subquery;
			$subquery = substr($subquery, 0, -5);
		}	
		$query .= $subquery;
	}
	$query .= "GROUP BY REGION";
	return $query;
}







function GenerateCoreQuery($Data) {
	Global $Names;
 	Global $Date;
	
	$nl = "\n";
	if (!empty($Data["LR"]))
		$nl = "\n\t\t";
	else if (!empty($Data["REGIONList"]))
		$nl = "\n\t";
		
	//Columns
	$sqlquery = $nl."SELECT ";
	if (!empty($Data['Groups']))
		for ($i = 0; $i < count($Data['Groups']); $i++)
			if(!empty($Data["LR"]) || !empty($Data["REGIONList"]))
				$sqlquery .= $Data["Groups"][$i].' AS "G'.$i.'",'.$nl."\t";
			else 
				$sqlquery .= $Data["Groups"][$i].",".$nl."\t";
	if (!empty($Data["INDList"]))
		for ($i = 0; $i < count($Data['INDList']); $i++)
			$sqlquery .= $Data["INDList"][$i].",".$nl."\t";
	if (!empty($Data['LR']))
			$sqlquery .= 'YEAR(DAYS) AS "X",'.$nl."\t";
	for ($i = 0; $i < count($Data['Columns']); $i++) {
		if (!empty($Data['Functions']))
			$sqlquery .= $Data['Functions'][0].'('.$Data['Columns'][$i].')';
		else 
			$sqlquery .= $Data['Columns'][$i];
		if (!empty($Data["LR"]) || !empty($Data["REGIONList"])) 
			$sqlquery .= ' AS "Y'.$i.'",';
		else 
			$sqlquery .= ",";
		$sqlquery .= $nl."\t";
	}
	
	$sqlquery = substr($sqlquery, 0, -3);	
	if (!empty($Data["LR"]))
		$sqlquery = substr($sqlquery, 0, -2);
	else if (!empty($Data["REGIONList"]))
		$sqlquery = substr($sqlquery, 0, -1);
		
	$sqlquery .= $nl."FROM METEO_DATA_2015_WREGIONS";
	$Limits = array();
	$k = 0;
	if ($Data['DateType'] == "method1") {
		if ($Data["YEAR"][0] != "") {
			$Limits[$k] = "YEAR(DAYS) >= ".$Data["YEAR"][0];
				$k++;
		}
		if ($Data["YEAR"][1] != "") {
			$Limits[$k] = "YEAR(DAYS) <= ".$Data["YEAR"][1];
			$k++;
		}
		if ($Data["DAY"][0] != "" && $Data["DAY"][1] != "" 
			&& day_of_year($Data['DAY'][0], $Data['MONTH'][0]) > day_of_year($Data['DAY'][1], $Data['MONTH'][1])) {
			$Limits[$k]  = "(".$nl."\t\t(".$nl."\t\t\tMONTH(DAYS) > ".$Data['MONTH'][0];
			$Limits[$k] .= $nl."\t\t\tOR (".$nl."\t\t\t\tMONTH(DAYS) = ".$Data['MONTH'][0];
			$Limits[$k] .= $nl."\t\t\t\tAND DAY(DAYS) >= ".$Data['DAY'][0].$nl."\t\t\t)".$nl."\t\t)";
			$Limits[$k] .= $nl."\t\tOR (";
			$Limits[$k] .= $nl."\t\t\tMONTH(DAYS) < ".$Data['MONTH'][1];
			$Limits[$k] .= $nl."\t\t\tOR (".$nl."\t\t\t\tMONTH(DAYS) = ".$Data['MONTH'][1];
			$Limits[$k] .= $nl."\t\t\t\tAND DAY(DAYS) <= ".$Data['DAY'][1].$nl."\t\t\t)".$nl."\t\t)".$nl."\t)";
			$k++;
		}
		else {
			if ($Data["DAY"][0] != "") {
				$Limits[$k] = "("
					.$nl."\t\tMONTH(DAYS) > ".$Data["MONTH"][0]
					.$nl."\t\tOR ("
					.$nl."\t\t\tMONTH(DAYS) = ".$Data["MONTH"][0]
					.$nl."\t\t\tAND DAY(DAYS) >= ".$Data["DAY"][0]
					.$nl."\t\t)"
					.$nl."\t)";
					$k++;
			}
			if ($Data["DAY"][1] != "") {
				$Limits[$k] = "("
					.$nl."\t\tMONTH(DAYS) < ".$Data["MONTH"][1]
					.$nl."\t\tOR ("
					.$nl."\t\t\tMONTH(DAYS) = ".$Data["MONTH"][1]
					.$nl."\t\t\tAND DAY(DAYS) <= ".$Data["DAY"][1]
					.$nl."\t\t)"
					.$nl."\t)";
					$k++;
			}
		}
	}
	else { 
		if ($Data["DAY"][0] != "") {
			$Limits[$k] = "DAYS >= '".$Data["YEAR"][0]."-".$Data["MONTH"][0]."-".$Data["DAY"][0]."'";
			$k++;
		}
		if ($Data["DAY"][1] != "") {
			$Limits[$k] = "DAYS <= '".$Data["YEAR"][1]."-".$Data["MONTH"][1]."-".$Data["DAY"][1]."'";
			$k++;
		}
	}
	for ($i = 1; $i < count($Names); $i++) {
		if ($Data[$Names[$i][0]][0] != "") {
			$Limits[$k] = $Names[$i][0]." >= ".$Data[$Names[$i][0]][0];
			$k++;
		}
		if ($Data[$Names[$i][0]][1] != "") {
			$Limits[$k] = $Names[$i][0]." <= ".$Data[$Names[$i][0]][1];
			$k++;
		}
	}
	
	
	//LIMITS
	if (count($Limits) > 0) {
		$sqlquery .= $nl."WHERE ".$Limits[0];
		for ($i = 1; $i < count($Limits); $i++)
			$sqlquery .= $nl."\tAND ".$Limits[$i];
	}
	
	
	//GROUPING
	if (!empty($Data["Groups"]) || !empty($Data["LR"])) {
		$sqlquery .= $nl."GROUP BY ";
		$c = 1;
		if (!empty($Data['LR'])) {
			$sqlquery .= "YEAR(DAYS)";
			$c = 0;
		}
		else 
			$sqlquery .= $Data['Groups'][0];
		if (!empty($Data["Groups"]))
			for ($i = $c; $i < count($Data['Groups']); $i++)
				$sqlquery .= ",".$nl."\t".$Data['Groups'][$i];
	}			
		
	return $sqlquery;			
}
	
	function ConnectDB() {
		$servername = "localhost";
		$username = "root";
		$password = "trololo";
		$conn = new mysqli($servername, $username, $password);
		if ($conn->connect_error) 
   		die("Connection failed: " . $conn->connect_error);
		$DB = "DATA_STATION_2015";
		if (!$conn->query('USE '.$DB)) 
  			echo ("Error using DB".$DB.": ". $conn->error);
  		return $conn;
	}	
?>
