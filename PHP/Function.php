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
        array("CLOUDS", "общее количество облачности, баллы"),
        array("WINDAV", "средняя скорость ветра, м/с"),
        array("WINDMAX", "максимальная скорость ветра, м/с"),
        array("TGROUND", "температура поверхности почвы"),
        array("PVAPOR", "парциальное давление водяного пара, гПа"),
        array("RELHUM", "относительная влажность воздуха, %"),
        array("TDEWPOINT", "температура точки росы"),
        array("PSTNLVL",  "атмосферное давление на уровне станции, гПа"),
                array("SNOW_DEPTH",  "высота снега, см"),
    );
    
$Date = array(
        array("DAY", "день", 1, 31),
        array("MONTH", "месяц", 1, 12),
        array("YEAR", "год", 1800, 2100) 
);

$Tables = array(
        array ("REGIONNAME", "REGIONS"),
        array ("MIGRATION", "STAT_MIGR_1997_2015"),
        array ("MIGR_COEFF", "STAT_MIGR_COEF_1997_2017"),
        array ("NATINCREASE", "STAT_NAT_INC_1990_2017"),
        array ("OVERALLINCREASE", "STAT_OVERALL_INC_1990_2014"),
        array ("LIFETIME", "STAT_LIFETIME_1990_2017"),
        array ("NEONATMORTALITY", "STAT_NEONAT_2012"),
        array ("CHILDMORTALITY", "STAT_CHILD_MORT_2013_2015"),
        array ("DECEASEMORTALITY", "STAT_MORT_1990_2012")
);

$EDataCols = array(
    array(),
    array(array("TYPE", "YEAR"), array(array("в пределах России", "Внешняя (для региона) миграция", "внутрирегиональная", "международная всего", "международная всего по региону", "межрегиональная", "миграция всего", "с другими зарубежными странами", "со странами СНГ,  Балтии и Грузии"), "годы")),
    array(array("YEAR"), array("годы")),
    array(array("SEX", "TYPE", "YEAR"), array(array("оба пола", "женщины", "мужчины"), array("общее", "город", "село"), "годы")),
    array(array("TYPE", "YEAR"), array(array("общий", "город", "село"), "годы")), 
    array(array("SEX", "TYPE", "YEAR"), array(array("оба пола", "женщины", "мужчины"), array("все население", "городское население", "сельское население"), "годы")),
    array(),
    array(array("YEAR"), array("годы")),
    array(array("DECEASE", "TYPE", "YEAR"), array(array("болезни органов дыхания", "болезни органов пищеварения", "внешние причины", "врожденные аномалии (пороки развития, деформации и хромосомные нарушения)", "всего умерших от всех причин", "некоторые инфекционные и паразитарные болезни", "отдельные состояния", "возникающие в перинатальном периоде"),array("все население", "городское население", "сельское население"), "годы"))
);

$FullTables = array(
        array(
            "METEO_DATA_2017_WSNOW",
            "метеоданные", 
            array("DAYS", "REGION", "IND", "LAT", "LON", "TMIN", "TMEAN", "TMAX", "R"),
            array("дата", "номер региона", "индекс станции", "широта", "долгота", "t минимальная", "t средняя", "t максимальная", "осадки")
        ), 
        array(
            "GRID_DATA",
            "данные по сетке",
            array("LAT", "LON", "UF", "POLARNIGHT", "SWAMPINESS", "PERMAFROSTDEC", "FLOOD", "EARTHQUAKE", "HEALTHIND", "SANECEST"),
            array("широта", "долгота", "ультрафиолет, баллы", "полярные день/ночь, баллы", "заболоченность территории, %", "протаивание вечной мерзлоты, м", "наводнения, баллы", "землятрясения, баллы", "индекс общественного здоровья", "санитарно-экологическая оценка территории")     
        ), 
        array(
            "REGIONS",
            "регионы",
            array("REGION", "VALUE"),
            array("номер региона", "название региона")
        ),
        array(
            "STAT_MIGR_1997_2015",
            "миграция (1997 - 2015)",
            array("REGION", "TYPE", "YEAR", "VALUE"),
            array("номер региона", "тип населения", "год", "значение")
        ),
        array(
            "STAT_MIGR_COEF_1997_2017",
            "коэффициенты миграции (1997 - 2017)",
            array("REGION", "YEAR", "VALUE"),
            array("номер региона", "год", "значение")
        ),
        array(
            "STAT_NAT_INC_1990_2017",
            "естественный прирост населения (1990 - 2017)",
            array("REGION", "SEX", "TYPE", "YEAR", "VALUE"),
            array("номер региона", "пол", "тип населения", "год", "значение")
        ),
        array(
            "STAT_OVERALL_INC_1990_2014",
            "общий прирост населения (1990 - 2014)",
            array("REGION", "TYPE", "YEAR", "VALUE"),
            array("номер региона", "тип населения", "год", "значение")
        ),
        array(
            "STAT_LIFETIME_1990_2017",
            "продолжительность жизни (1990-2017)",
            array("REGION", "SEX", "TYPE", "YEAR", "VALUE"),
            array("номер региона", "пол", "тип населения", "год", "значение")
        ),
        array(
            "STAT_NEONAT_2012",
            "неонатальная смертность 2012",
            array("REGION", "VALUE"),
            array("номер региона", "значение")
        ),
        array(
            "STAT_CHILD_MORT_2013_2015",
            "детская смертность (2013 - 2015)",
            array("REGION", "YEAR", "VALUE"),
            array("номер региона", "год", "значение")
        ),
        array(
            "STAT_MORT_1990_2012",
            "смертность от болезней (1990 - 2012)",
            array("DECEASE", "REGION", "TYPE", "YEAR", "VALUE"),
            array("название болезни", "номер региона", "тип населения", "год", "значение")
        ),
        array(
            "MODEL_DATA",
            "модельные данные",
            array("DAYS, LAT, LON, VALUE"),
            array("дата", "широта", "долгота", "значение")
        )
);

$MapOutputTypes = array(
    "shaded"=>1,
    "contour"=>1,
    "value"=>0
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


function GenerateQuery($Data){
    if ($Data['primaryTabl'] == "METEO_DATA_2015_WREGIONS") 
        return GenerateMeteoQuery($Data);
    if ($Data['primaryTabl'] == "GRID_DATA")
        return GenerateGridQuery($Data);
    if ($Data['primaryTabl'] == "MODEL_DATA")
        return GenerateModelQuery($Data);
    return GenerateEcoQuery($Data);

}

function GenerateMeteoQuery($Data) {
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
                $sqlquery .= ",\n\t(B.n * B.sumXY".$i." - B.sumX * B.sumY".$i.") / (B.n * B.sumXX - B.sumX * B.sumX) AS \"";
                $sqlquery .= $Data['Functions'][0].'('.$Data['Columns'][$i].").LRCOEFF\"";      
        
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
            $sqlquery .= $nl."WHERE A.Y0 IS NOT NULL";
            for ($i = 1; $i < count($Data['Columns']); $i++) 
                $sqlquery .= $nl."\tAND A.Y".$i." IS NOT NULL";
            if(!empty($Data['Groups'])) {
                $sqlquery .= $nl."GROUP BY ";
                for ($i = 0; $i < count($Data['Groups']); $i++)
                    $sqlquery .= "A.G".$i.",\n\t";
                $sqlquery = substr($sqlquery, 0, -3);
            }
            $sqlquery .= "\n) AS B";
        }
   }
    
    return $sqlquery;
}

function GenerateGridQuery($Data) {
    global $FullTables;
    $query = "";
    if (empty($Data["GRID_DATAFunctions"])) {
        $query = "SELECT ".$Data["GRID_DATAColumns"][0];
        for ($i = 1; $i < count($Data["GRID_DATAColumns"]); $i++)
            $query .= ",\n\t".$Data["GRID_DATAColumns"][$i];
    }
    else { 
        $query = "SELECT ".$Data["GRID_DATAFunctions"][0]."(".$Data["GRID_DATAColumns"][0].")";
        for ($i = 1; $i < count($Data["GRID_DATAColumns"]); $i++)
            $query .= ",\n\t".$Data["GRID_DATAFunctions"][0]."(".$Data["GRID_DATAColumns"][$i].")";
    }
    $query .= "\nFROM GRID_DATA";
    
    $subquery = "";
    for ($l = 0; $l < count($FullTables[1][2]); $l++) { 
        if (!empty($Data["GRID_DATA".$FullTables[1][2][$l]."L"]))
            $subquery .= $FullTables[1][2][$l]." >= ".$Data["GRID_DATA".$FullTables[1][2][$l]."L"]."\n\tAND ";
        if (!empty($Data["GRID_DATA".$FullTables[1][2][$l]."R"]))
            $subquery .=$FullTables[1][2][$l]." <= ".$Data["GRID_DATA".$FullTables[1][2][$l]."R"]."\n\tAND ";
    }
    if (!empty($subquery)) {
        $subquery  = "\nWHERE ".$subquery;
        $subquery = substr($subquery, 0, -6);
    }   
    $query .= $subquery;
    
    return $query;
}



function GenerateEcoQuery($Data) {
    global $FullTables;
    $query = "";
    if (empty($Data[$Data["primaryTabl"]."Functions"])) {
        $query = "SELECT ".$Data[$Data["primaryTabl"]."Columns"][0];
        for ($i = 1; $i < count($Data[$Data["primaryTabl"]."Columns"]); $i++)
            $query .= ",\n\t".$Data[$Data["primaryTabl"]."Columns"][$i];
    }
    else { 
        $query = "SELECT ".$Data[$Data["primaryTabl"]."Functions"][0]."(".$Data[$Data["primaryTabl"]."Columns"][0].")";
        for ($i = 1; $i < count($Data[$Data["primaryTabl"]."Columns"]); $i++)
            $query .= ",\n\t".$Data[$Data["primaryTabl"]."Functions"][0]."(".$Data[$Data["primaryTabl"]."Columns"][$i].")";
    }
    $query .= "\nFROM ".$Data['primaryTabl'];

    $j = 0;
    while ($FullTables[$j][0] != $Data['primaryTabl'])
        $j++;
    
    $subquery = "";
    for ($l = 0; $l < count($FullTables[$j][2]); $l++) {    
        if (!empty($Data[$Data['primaryTabl'].$FullTables[$j][2][$l]."L"]))
            $subquery .= $FullTables[$j][2][$l]." >= ".$Data[$Data["primaryTabl"].$FullTables[$j][2][$l]."L"]."\n\tAND ";
        if (!empty($Data[$Data['primaryTabl'].$FullTables[$j][2][$l]."R"]))
            $subquery .=$FullTables[$j][2][$l]." <= ".$Data[$Data["primaryTabl"].$FullTables[$j][2][$l]."R"]."\n\tAND ";
        if (!empty($Data[$Data['primaryTabl'].$FullTables[$j][2][$l]])) 
            $subquery .= $FullTables[$j][2][$l].' = "'.$Data[$Data["primaryTabl"].$FullTables[$j][2][$l]].'"'."\n\tAND ";
    }
    if (!empty($subquery)) {
        $subquery  = "\nWHERE ".$subquery;
        $subquery = substr($subquery, 0, -6);
    }   
    $query .= $subquery;

    if (!empty($Data[$Data["primaryTabl"]."Functions"])) 
        $query .= "\nGROUP BY REGION";
    return $query;
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
        
    $sqlquery .= $nl."FROM METEO_DATA_2017_WSNOW";
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
    
function ConnectDB($DB) {
    $servername = "localhost";
    $json_string = file_get_contents("/var/www/193-124-206-5.cloudvps.regruhosting.ru/mysql.json");
    $credentials = json_decode($json_string, true);
    $username = $credentials["username"];
    $password = $credentials["password"];
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);
    if (!$conn->query('USE '.$DB)) 
        echo ("Error using DB".$DB.": ". $conn->error);
            if (!$conn->query('SET SQL_BIG_SELECTS =1;'))
                    echo ("Error enabling big selects");
    return $conn;
}   

function GenerateModelQuery($Data) {
    Global $Names;
     Global $Date;
    
    $nl = "\n";
        
    //Columns
    $sqlquery = $nl."SELECT ";

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
        
    $sqlquery .= $nl."FROM MODEL_DATA";
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
            
        
    return $sqlquery;           
}


function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
