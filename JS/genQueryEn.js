var fieldsets = [
	["columns", "Columns"],
	["filters", "Filters"],
	["functions", "Functions"],
	["groups", "Group by"]
]






var tables = [
		[
			"METEO_DATA_2015_WREGIONS",
			"meteodata", 
			["DAYS", "REGION", "IND", "LAT", "LON", "TMIN", "TMEAN", "TMAX", "R"],
			["date", "region number", "station index", "latitude", "longtitude", "t min", "t mean", "t max", "precipitation"]
		], 
		[
			"GRID_DATA",
			"grid data",
			["LAT", "LON", "UF", "POLARNIGHT", "SWAMPINESS", "PERMAFROSTDEC", "FLOOD", "EARTHQUAKE", "HEALTHIND", "SANECEST"],
			["latitude", "longtitude", "UV light intensity score", "polar day/night score", "swampiness %", "permafrost melting m", "floods score", "earthquakes score", "social health index", "environmental assessment of territory"]		
		], 
		[
			"REGIONS",
			"regions",
			["REGION", "VALUE"],
			["region number", "region name"]
		],
		[
			"STAT_MIGR_1997_2015",
			"migration (1997 - 2015)",
			["REGION", "TYPE", "YEAR", "VALUE"],
			["region number", "type of population", "year", "value"]
		],
		[
			"STAT_MIGR_COEF_1997_2015",
			"migration coefficient (1997 - 2015)",
			["REGION", "YEAR", "VALUE"],
			["region number", "year", "value"]
		],
		[
			"STAT_NAT_INC_1990_2014",
			"natural increase of population (1990 - 2014)",
			["REGION", "SEX", "TYPE", "YEAR", "VALUE"],
			["region number", "sex", "type of population", "year", "value"]
		],
		[
			"STAT_OVERALL_INC_1990_2014",
			"overall increase of population (1990 - 2014)",
			["REGION", "TYPE", "YEAR", "VALUE"],
			["region number", "type of population", "year", "value"]
		],
		[
			"STAT_LIFETIME_1990_2010",
			"life expectancy (1990-2010)",
			["REGION", "SEX", "TYPE", "YEAR", "VALUE"],
			["region number", "sex", "type of population", "year", "value"]
		],
		[
			"STAT_NEONAT_2012",
			"neonatal mortality 2012",
			["REGION", "VALUE"],
			["region number", "value"]
		],
		[
			"STAT_CHILD_MORT_2013_2015",
			"child mortality (2013 - 2015)",
			["REGION", "YEAR", "VALUE"],
			["region number", "year", "value"]
		],
		[
			"STAT_MORT_1990_2012",
			"disease mortality (1990 - 2012)",
			["DECEASE", "REGION", "TYPE", "YEAR", "VALUE"],
			["disease name", "region number", "type of population", "year", "value"]
		]
]

var names = [
	["DAYS", "date"],
	["REGION", "region number (in the alphabet order)"],
	["IND", "station index"],
	["LAT", "latitude"],
	["LON", "longtitude"],
	["TMIN", "t min"],
	["TMEAN", "t mean"],
	["TMAX","t max"],
	["R", "percipitation"]
]
var date = [
	["YEAR", 1800, 2100],
	["MONTH", 1, 12], 
	["DAY", 1, 31],
]

var functions = [
	["COUNT", "number of items"],
	["SUM", "sum of items"],
	["AVG", "average value"],
	["STD", "standard deviation"],
	["MIN", "minimum"],
	["MAX", "maximum"]
]

var groups = [
	["REGION", "regions", 
		["REGIONNAME",
			"MIGRATION",
			"MIGR_COEFF",
			"NATINCREASE",
			"OVERALLINCREASE",
			"LIFETIME",
			"NEONATMORTALITY",
			"CHILDMORTALITY",
			"DECEASEMORTALITY" 
		], 
		["region name", 
			"migration",
			"migration coefficient",
			"natural increase",
			"total increase",
			"lifetime",
			"neonatal mortality",
			"infant mortality",
			"mortality from disease"
		],
		[
			[0, 0],
			[1997, 2015],
			[1997, 2015],
			[1990, 2014],
			[1990, 2014],
			[1990, 2010],
			[0, 0],
			[2013, 2015],
			[1990, 2012]
		]
	],
	["IND", "stations",["LAT", "LON"], ["latitude", "longtitude"]],
	["YEAR(DAYS)", "years"],
	["MONTH(DAYS)", "months"]
] 

var EDataCols = [
	[[], []],
	[["TYPE", "YEAR"], [["в пределах России", "Внешняя (для региона) миграция", "внутрирегиональная", "международная всего", "международная всего по региону", "межрегиональная", "миграция всего", "с другими зарубежными странами", "со странами СНГ,  Балтии и Грузии"], "годы"]],
	[["YEAR"], ["годы"]],
	[["SEX", "TYPE", "YEAR"], [["оба пола", "женщины", "мужчины"], ["все население", "городское население", "сельское население"], "годы"]],
	[["TYPE", "YEAR"],[["общий", "город", "село"], "годы"]], 
	[["SEX", "TYPE", "YEAR"], [["оба пола", "женщины", "мужчины"], ["все население", "городское население", "сельское население"], "годы"]],
	[[], []],
	[["YEAR"], ["годы"]],
	[["DECEASE", "TYPE", "YEAR"], [["болезни органов дыхания", "болезни органов пищеварения", "внешние причины", "врожденные аномалии (пороки развития, деформации и хромосомные нарушения)", "всего умерших от всех причин", "некоторые инфекционные и паразитарные болезни", "отдельные состояния", "возникающие в перинатальном периоде"],["все население", "городское население", "сельское население"], "годы"]]
]


var FormSerialised = ["","","",""];
var AdFormData = [{}, {}, {}, {}];

function getFormDataArray(form) {
	var dataArray = $(form).serializeArray(),
    	len = dataArray.length,
    dataObj = {};

	for (i=0; i<len; i++) {
		if (isEmpty(dataObj[dataArray[i].name])) 
			dataObj[dataArray[i].name] = [];
  		dataObj[dataArray[i].name].push(dataArray[i].value);
  		//alert(dataArray[i].name + ": " + dataObj[dataArray[i].name]);
	}
	return dataObj;
}



function isEmpty(Value) {
	if (Value == null || Value == "")
		return 1;
	else 
		return 0;
}

function checkDate(method) {
	var lYEAR = isEmpty(document.getElementById("lYEARl").value);
	var rYEAR = isEmpty(document.getElementById("rYEARr").value);
	var lMONTH = isEmpty(document.getElementById("lMONTHl").value);
	var rMONTH = isEmpty(document.getElementById("rMONTHr").value);
	var lDAY = isEmpty(document.getElementById("lDAYl").value);
	var rDAY = isEmpty(document.getElementById("rDAYr").value);
	var lYEARValue = 0;
	if (!lYEAR)
		var lYEARValue = parseInt(document.getElementById("lYEARl").value);
	var rYEARValue = 1;
	if (!rYEAR)
		var rYEARValue = parseInt(document.getElementById("rYEARr").value);

	if (method == 0) 
		return !((lMONTH + lDAY == 1) || (rMONTH + rDAY == 1) || ((lYEAR + rYEAR == 0) && rYEARValue < lYEARValue))	
	else 
		 return !(((lYEAR + lMONTH + lDAY != 3) && (lYEAR + lMONTH + lDAY != 0))
			|| (rYEAR + rMONTH + rDAY != 3) && (rYEAR + rMONTH + rDAY != 0))
}

function ValidateFormJS(primaryTable) {
	var count = 0;
	var it = 0;
	while(primaryTable != tables[it][0])
		it++;
	
	for (i = 0; i < names.length; i++) 
		if ($("." + primaryTable + ".columns#"  + tables[it][2][i] + ":checked").length == 1) 
			count++;
	if (count == 0)
		return -2;
		
	if (it == 0 && !checkDate(document.getElementById("method").selectedIndex))
		return 0;
	for (i = 0; i < tables[it][2].length; i++) {
		if (!isEmpty($("." + primaryTable + ".filters#l"  + tables[it][2][i]).val()) && !isEmpty($("." + primaryTable + ".filters#r"  + tables[it][2][i]).val())){
			var x = parseFloat($("." + primaryTable + ".filters#r"  + tables[it][2][i]).val()) - parseFloat($("." + primaryTable + ".filters#l"  + tables[it][2][i]).val());
			if (x < 0)
				return i;
		}
	}
	return -1;	
}

function ValidateAdFormJS(i) {
	if (i != 0)
		return -1;
	for (j = 1; j < groups[0][2].length; j++){ 
		if (!isEmpty(AdFormData[i][groups[0][2][j] + "YEARL"])  
			&& !isEmpty(AdFormData[i][groups[0][2][j] + "YEARR"])
			&& +AdFormData[i][groups[0][2][j] + "YEARL"] > +AdFormData[i][groups[0][2][j] + "YEARR"]) 
				return j;
	}
	return -1;	
}

function resetHiddenPart() {
   $("input.Group:checked").each(function () {
		$(this).prop("checked", false);
	});
	$("input#LR").prop("checked", false);
	var x = document.getElementsByClassName("notLR");
	for (i = 0; i < x.length; i++) 
		x[i].style.opacity = 1;
	$("p.GroupLists").each(function () {
			$(this).empty();
	})
	FormSerialised = ["","","",""];
	if ($("#your-dialog").hasClass('ui-dialog-content')) 
		$("#your-dialog").dialog("close");
}
   
function customDialog(i) {
   if (groups[i].length > 2) {
 		var s = 0;
		var str = "<form  class = 'AdForm' id='" + groups[i][0] + "'>";
		for (j = 0; j < groups[i][2].length; j++){ 
			str += "<p><input type = 'checkbox' class = '" + groups[i][0] + "List' name = '" + groups[i][0] + "List[]' value= '" 
				+ groups[i][2][j] + "'";
			var hidden = " hidden ";
			if (!isEmpty(AdFormData[i][groups[i][0] + "List[]"]) && AdFormData[i][groups[i][0] + "List[]"][s] == groups[i][2][j]) {
				str += " checked ";
				hidden = "";
				s++;
			}
			str += "> " + groups[i][3][j] + "</p>"
			if (j > 0 && i == 0) {
				str += "<div id = '" + groups[i][2][j] + "'" + hidden +">";
				str += "<fieldset class = 'regionsGrouping'><legend>Функции</legend>";
				str += "<input type = 'radio' name = '" + groups[0][2][j] + "Function[]' class = 'REGIONFunctions' value = 'DEFAULT' id = 'DEFAULT'";
				if (isEmpty(AdFormData[0][groups[0][2][j] + "Function[]"]) 
					|| (!isEmpty(AdFormData[0][groups[0][2][j] + "Function[]"]) && AdFormData[0][groups[0][2][j] + "Function[]"][0] == "DEFAULT")) 
					str += " checked ";				
				str += ">значение</br>";					
				for (k = 0; k < functions.length; k++) {
					str += "<input type = 'radio' name = '" + groups[0][2][j] + "Function[]' class = 'REGIONFunctions' value = '" 
						+ functions[k][0] + "' id = '"+ functions[k][0] + "'";
					if (!isEmpty(AdFormData[0][groups[0][2][j] + "Function[]"]) && AdFormData[0][groups[0][2][j] + "Function[]"][0] == functions[k][0]) 
						str += " checked ";	
					str += ">" + functions[k][1] + "</br>";	
				}					
				if (EDataCols[j][0].length > 0) {
					str += "</fieldset><fieldset class = 'regionsGrouping'><legend>Фильтры</legend>";
					for (k = 0; k < EDataCols[j][0].length - 1; k++) {
						var selected = "";
						str += "<p><select  name = '" + groups[0][2][j] + EDataCols[j][0][k] + "'>";
						for (l = 0; l < EDataCols[j][1][k].length; l++) {
							if (!isEmpty(AdFormData[0][groups[0][2][j] + EDataCols[j][0][k]]) && AdFormData[0][groups[0][2][j] + EDataCols[j][0][k]] == EDataCols[j][1][k][l])
								selected  = " selected='selected' ";
							else 
								selected  = "";
   						str += "<option value='" + EDataCols[j][1][k][l] + "'" + selected +  ">" + EDataCols[j][1][k][l] + "</option>";
   					}
   					str += "</select></p>";
   				}
   				var yearValueL = "";
   				var yearValueR = "";
   				if (!isEmpty(AdFormData[0][groups[0][2][j] + "YEARL"])) 
   					yearValueL = " value = " + AdFormData[0][groups[0][2][j] + "YEARL"];
   				if (!isEmpty(AdFormData[0][groups[0][2][j] + "YEARR"])) 
						yearValueR = " value = " + AdFormData[0][groups[0][2][j] + "YEARR"];   				
   				str += "<p>";
					str += "от <input type='number'  step = '1' min = '" + groups[0][4][j][0] + "' max = '" + groups[0][4][j][1] + "' lang = 'eng' placeholder = 'min' name = '" + groups[0][2][j] + "YEARL' id = 'l" + groups[0][2][j] + "YEAR'" +  yearValueL + "> "; 
					str += "до <input type='number'  step = '1' min = '"+ groups[0][4][j][0] + "' max = '" + groups[0][4][j][1] + "' lang = 'eng' placeholder = 'max' name = '" + groups[0][2][j] + "YEARR' id = 'r" + groups[0][2][j] + "YEAR'" + yearValueR + "> ";
   				str += " годы</p></fieldset>";						
				}
				str += "</div>";
			}
		}
		str += '<input type="submit" name = "SubmitRegions" value="Оk" class = "SubmitRegions">';
		str += "</form>";

		$("#your-dialog").html(str);
		$("#your-dialog")
			.dialog({
				modal: true,
         	minWidth: 400,
        		maxHeight: 400,
           	autoOpen: false,
        		title: "Parameters which can be chosen together with 'group by' parameter\n",
           	dialogClass: 'custom-ui-dialog',
           	position: {
           		my: 'center',
           		at: 'center',
           		of: $(".centered_div"),
           	}
      });
      $("#your-dialog").dialog("open");
      
	}   	
}
