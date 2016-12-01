var names = [
	["DAYS", "дата"],
	["REGION", "номер региона (в алфавитном порядке)"],
	["IND", "индекс станции"],
	["LAT", "широта"],
	["LON", "долгота"],
	["TMIN", "t минимальная"],
	["TMEAN", "t средняя"],
	["TMAX","t максимальная"],
	["R", "осадки"],
]
var date = [
	["YEAR", 1800, 2100],
	["MONTH", 1, 12], 
	["DAY", 1, 31],
]

var functions = [
	["COUNT", "количество"],
	["SUM", "сумма"],
	["AVG", "среднее"],
	["STD", "стандартное отклонение"],
	["MIN", "минимум"],
	["MAX", "максимум"]
]

var groups = [
	["REGION", "регионы", 
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
		["название региона", 
			"миграция",
			"коэффициент миграции",
			"естественный прирост",
			"общий прирост",
			"продолжительность жизни",
			"неонатальная смертность",
			"детская смертность",
			"смертность от болезней"
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
	["IND", "станции",["LAT", "LON"], ["широта", "долгота"]],
	["YEAR(DAYS)", "годы"],
	["MONTH(DAYS)", "месяцы"]
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
		return true;
	else 
		return false;
}

function checkDate(method) {
	var lYEAR = isEmpty(document.getElementById("lYEAR").value);
	var rYEAR = isEmpty(document.getElementById("rYEAR").value);
	var lMONTH = isEmpty(document.getElementById("lMONTH").value);
	var rMONTH = isEmpty(document.getElementById("rMONTH").value);
	var lDAY = isEmpty(document.getElementById("lDAY").value);
	var rDAY = isEmpty(document.getElementById("rDAY").value);	
	if (method == 0) 
		return !((lMONTH + lDAY == 1) || (rMONTH + rDAY == 1) || ((lYEAR + rYEAR == 2) 
			&& (+document.getElementById("lYEAR").value > +document.getElementById("rYEAR").value)))	
	else 
		 return !(((lYEAR + lMONTH + lDAY != 3) && (lYEAR + lMONTH + lDAY != 0))
			|| (rYEAR + rMONTH + rDAY != 3) && (rYEAR + rMONTH + rDAY != 0))
}

function checkFilter(i) {
	return (isEmpty(document.getElementById("l" + names[i][0]).value)
		|| isEmpty(document.getElementById("r" + names[i][0]).value)
		|| +document.getElementById("l" + names[i][0]).value <= +document.getElementById("r" + names[i][0]).value);
}

function ValidateFormJS() {
	var count = 0;
	for (i = 0; i < names.length; i++) 
		if (document.getElementById(names[i][0]).checked) 
			count++;
	if (count == 0)
		return -2;
		
	if (!checkDate(document.getElementById("method").selectedIndex))
		return 0;
	for (i = 1; i < names.length; i++) 
		if (!checkFilter(i)) 
				return i;
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
				str += "<fieldset class = 'regions'><legend>Функции</legend>";
				str += "<input type = 'radio' name = '" + groups[0][2][j] + "Function[]' class = 'Functions' value = 'DEFAULT' id = 'DEFAULT'";
				if (isEmpty(AdFormData[0][groups[0][2][j] + "Function[]"]) 
					|| (!isEmpty(AdFormData[0][groups[0][2][j] + "Function[]"]) && AdFormData[0][groups[0][2][j] + "Function[]"][0] == "DEFAULT")) 
					str += " checked ";				
				str += ">значение</br>";					
				for (k = 0; k < functions.length; k++) {
					str += "<input type = 'radio' name = '" + groups[0][2][j] + "Function[]' class = 'Functions' value = '" 
						+ functions[k][0] + "' id = '"+ functions[k][0] + "'";
					if (!isEmpty(AdFormData[0][groups[0][2][j] + "Function[]"]) && AdFormData[0][groups[0][2][j] + "Function[]"][0] == functions[k][0]) 
						str += " checked ";	
					str += ">" + functions[k][1] + "</br>";	
				}					
				if (EDataCols[j][0].length > 0) {
					str += "</fieldset><fieldset class = 'regions'><legend>Фильтры</legend>";
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
   					yearValueL = " value = " + AdFormData[groups[0][2][j] + "YEARL"];
   				if (!isEmpty(AdFormData[0][groups[0][2][j] + "YEARR"])) 
						yearValueR = " value = " + AdFormData[0][groups[0][2][j] + "YEARR"];   				
   				str += "<p>";
					str += "от <input type='number'  step = '1' min = '" + groups[0][4][j][0] + "' max = '" + groups[0][4][j][1] + "' lang = 'eng' placeholder = 'min' name = '" + groups[0][2][j] + "YEARL'id = 'l" + groups[0][2][j] + "YEAR'" +  yearValueL + "> "; 
					str += "до <input type='number'  step = '1' min = '"+ groups[0][4][j][0] + "' max = '" + groups[0][4][j][1] + "' lang = 'eng' placeholder = 'max' name = '" + groups[0][2][j] + "YEARR'id = 'r" + groups[0][2][j] + "YEAR'" + yearValueR + "> ";
   				str += " годы</p></fieldset>";						
				}
				str += "</div>";
			}
		}
		str += '<input type="submit" name = "SubmitRegions" value="Ок" class = "SubmitRegions">';
		str += "</form>";

		$("#your-dialog").html(str);
		$("#your-dialog")
			.dialog({
				modal: true,
         	minWidth: 400,
        		maxHeight: 400,
           	autoOpen: false,
        		title: "Параметры, которые могут быть выведены вместе с параметром группировки\n",
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
