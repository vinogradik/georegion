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
	var tables = databases[1].slice();
	if (localStorage.getItem("db") == "stations_regions")
		tables = databases[0].slice();
	var count = 0;
	var it = 0;
	while(primaryTable != tables[it].Name)
		it++;
	
	for (i = 0; i < tables[it].Cols.length; i++) 
		if ($("." + primaryTable + ".columns#"  + tables[it].Cols[i].Name + ":checked").length == 1) 
			count++;
	if (count == 0)
		return -2;
		
	if (it == 0 && !checkDate(document.getElementById("method").selectedIndex))
		return 0;
	for (i = 0; i < tables[it].Cols.length; i++) {
		if (!isEmpty($("." + primaryTable + ".filters#l"  + tables[it].Cols[i].Name).val()) && !isEmpty($("." + primaryTable + ".filters#r"  + tables[it].Cols[i].Name).val())){
			var x = parseFloat($("." + primaryTable + ".filters#r"  + tables[it].Cols[i].Name).val()) - parseFloat($("." + primaryTable + ".filters#l"  + tables[it].Cols[i].Name).val());
			if (x < 0)
				return i;
		}
	}
	return -1;	
}

function ValidateAdFormJS(i) {
	if (i != 0)
		return -1;
	for (j = 1; j < groups[0].TbCoParams.length; j++){ 
		if (!isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "YEARL"])  
			&& !isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "YEARR"])
			&& +AdFormData[0][groups[0].TbCoParams[j] + "YEARL"] > +AdFormData[0][groups[0].TbCoParams[j] + "YEARR"]) 
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
	var tables = databases[1].slice();
	if (localStorage.getItem("db") == "stations_regions")
		tables = databases[0].slice();
   if (i < 2) {
 		var s = 0;
		var str = "<form  class = 'AdForm' id='" + groups[i].TbName + "'>";
		for (j = 0; j < groups[i].TbCoParams.length; j++){ 
			str += "<p><input type = 'checkbox' class = '" + groups[i].TbName + "List' name = '" + groups[i].TbName + "List[]' value= '" 
				+ groups[i].TbCoParams[j] + "'";
			var hidden = " hidden ";
			if (!isEmpty(AdFormData[i][groups[i].TbName + "List[]"]) && AdFormData[i][groups[i].TbName + "List[]"][s] == groups[i].TbCoParams[j]) {
				str += " checked ";
				hidden = "";
				s++;
			}
			str += ">"
			str +=  "<label for = '' id = 'GroupLists'></label></p>"
			if (j > 0 && i == 0) {
				str += "<div id = '" + groups[0].TbCoParams[j] + "'" + hidden +">";
				str += "<fieldset class = 'regionsGrouping'><legend id = 'Functions'></legend>";
				str += "<input type = 'radio' name = '" + groups[0].TbCoParams[j] + "Function[]' class = 'REGIONFunctions' value = 'DEFAULT' id = 'DEFAULT'";
				if (isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "Function[]"]) 
					|| (!isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "Function[]"]) && AdFormData[0][groups[0].TbCoParams[j] + "Function[]"][0] == "DEFAULT")) 
					str += " checked ";				
				str += ">"
				str += "<label for = 'DEFAULT' id = 'DEFAULT'></label></br>";					
				for (k = 0; k < functions.length; k++) {
					str += "<input type = 'radio' name = '" + groups[0].TbCoParams[j] + "Function[]' class = 'REGIONFunctions' value = '" 
						+ functions[k][0] + "' id = '"+ functions[k][0] + "'";
					if (!isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "Function[]"]) && AdFormData[0][groups[0].TbCoParams[j] + "Function[]"][0] == functions[k][0]) 
						str += " checked ";	
					str += ">"
					str += "<label for = '" + functions[k][0] + "' id = 'functions'></label></br>";	
				}		
				for ( k = 2; k < tables.length; k++){
				
				}				
				
				//filters
				if (EDataCols[j][0].length > 0) {
					str += "</fieldset><fieldset class = 'regionsGrouping'><legend id = 'FiltersShort'></legend>";
					for (k = 0; k < EDataCols[j][0].length - 1; k++) {
						var selected = "";
						str += "<p><select  class = 'CustomDialogSelect' name = '" + groups[0].TbCoParams[j] + EDataCols[j][0][k] + "'>";
						for (l = 0; l < EDataCols[j][1][k].length; l++) {
							if (!isEmpty(AdFormData[0][groups[0].TbCoParams[j] + EDataCols[j][0][k]]) && AdFormData[0][groups[0].TbCoParams[j] + EDataCols[j][0][k]] == EDataCols[j][1][k][l])
								selected  = " selected='selected' ";
							else 
								selected  = "";
   						str += "<option value='" + EDataCols[j][1][k][l] + "'" + selected +  "></option>";
   					}
   					str += "</select></p>";
   				}
   				var yearValueL = "";
   				var yearValueR = "";
   				if (!isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "YEARL"])) 
   					yearValueL = " value = " + AdFormData[0][groups[0].TbCoParams[j] + "YEARL"];
   				if (!isEmpty(AdFormData[0][groups[0].TbCoParams[j] + "YEARR"])) 
						yearValueR = " value = " + AdFormData[0][groups[0].TbCoParams[j] + "YEARR"];   				
   				str += "<p>";
   				str += "<label  for = 'l" + groups[0].TbCoParams[j] + "YEAR'  class = 'from'></label>"
					str += "<input type='number'  step = '1' min = '" + groups[0].Limits[j][0] + "' max = '" + groups[0].Limits[j][1] + "' lang = 'eng' placeholder = 'min' name = '" + groups[0].TbCoParams[j] + "YEARL' id = 'l" + groups[0].TbCoParams[j] + "YEAR'" +  yearValueL + "> "; 
					str += "<label  for = 'r" + groups[0].TbCoParams[j] + "YEAR'  class = 'to'></label>"
					str += "<input type='number'  step = '1' min = '"+ groups[0].Limits[j][0] + "' max = '" + groups[0].Limits[j][1] + "' lang = 'eng' placeholder = 'max' name = '" + groups[0].TbCoParams[j] + "YEARR' id = 'r" + groups[0].TbCoParams[j] + "YEAR'" + yearValueR + "> ";
   				str += "<label id = 'CustomDialogYears'></label></p></fieldset>";						
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
      translateForm();
	}   	
}
function translateForm(){
	if (lang == "english") { 
		$("#russian").show();
		$("#english").hide();
		$("#back").html("back");
	}
	else{
		$("#english").show();
		$("#russian").hide();
		$("#back").html("назад");
	}
	document.getElementById("dbname").innerHTML = localStorage.getItem("db");
	
	var tables = databases[1].slice();
	if (localStorage.getItem("db") == "stations_regions")
		tables = databases[0].slice();
	//translate legends
	var legends = document.getElementsByTagName("legend");
	for(i = 0; i < legends.length; i++){
		var legendType = legends[i].id;
		var patch = legendText[legendType][0];
		if (lang == "english")
			patch = legendText[legendType][1];
		legends[i].innerHTML = patch;
	}
		
	//translate names of tables
	if (tables.length > 1) {
		for (i = 0; i < tables.length; i++){
			var tableName = tables[i].RuName;
			if (lang == "english")
				tableName = tables[i].EnName;
			document.getElementById("chooseTable").options[i].text = tableName;
		}
	}
	
	//from
	var fromCol = $("label.from");
	for (i = 0; i < fromCol.length; i++){
		var patch = "от ";
		if (lang == "english")
			patch = "from ";
		fromCol[i].innerHTML = patch;
	}
	
	//to
	var toCol = $("label.to");
	for (i = 0; i < toCol.length; i++){
		var patch = "до ";
		if (lang == "english")
			patch = "to ";
		toCol[i].innerHTML = patch;
	}
	
	//variants for date	
	for (i = 0; i < 2; i++){
		var patch = "способ " + (i + 1);
		if (lang == "english")
			patch = "method " + (i + 1);
		document.getElementById("method").options[i].text = patch;
	}
	
	//columns
	var columnsCol = $("label.tableColumns");
	var CustomDialogSelects = document.getElementsByClassName("CustomDialogSelect");
	var pos = 0;
	var pos1 = 0
	for (i = 0; i < tables.length; i++)
		for (j = 0; j < tables[i].Cols.length; j++){
			var patch = tables[i].Cols[j].RuName;
			if (lang == "english")
				patch = tables[i].Cols[j].EnName;
			columnsCol[pos].innerHTML = patch;
			if (tables[i].Cols[j].RuOptions){
				for (k = 0; k < tables[i].Cols[j].RuOptions.length; k++){
					patch = 	tables[i].Cols[j].RuOptions[k];
					if (lang == "english")
						patch = tables[i].Cols[j].EnOptions[k];
					indicator = tables[i].Name + tables[i].Cols[j].Name;
					document.getElementById(indicator).options[k].text = patch;
					if (CustomDialogSelects.length > 0) {
						CustomDialogSelects[pos1].options[k].text = patch;
					}

				}
				pos1++
			}
			
				
			pos++;
		}
		
	
	//functions
	var functionsCol = $("label#functions");
	for (i = 0; i < functionsCol.length; i++){
		var patch = functions[i % functions.length][1];
		if (lang == "english")
			patch = functions[i % functions.length][2];
		functionsCol[i].innerHTML = patch;
	}
	
	var functionsCol = $("label#DEFAULT");
	for (i = 0; i < functionsCol.length; i++){
		var patch = "значение";
		if (lang == "english")
			patch = "value";
		functionsCol[i].innerHTML = patch;
	}
	
	//groups
	var groupsCol = $("label.groups");
	for (i = 0; i < groups.length; i++) {
		var patch = groups[i].RuName;
		if (lang == "english")
			patch = groups[i].EnName;
		groupsCol[i].innerHTML = patch;
	}
	
	//group lists in custom dialog
	var groupLists = $("label#GroupLists")
	if (groupLists.length == 9)
		for (j = 0; j < 9; j++){
			patch = groups[0].RuCoParams[j]
			if (lang == "english")
				patch = groups[0].EnCoParams[j]
			groupLists[j].innerHTML = patch
		}
	else if (groupLists.length == 2)
		for (j = 0; j < 2; j++){
			patch = groups[1].RuCoParams[j]
			if (lang == "english")
				patch = groups[1].EnCoParams[j]
			groupLists[j].innerHTML = patch
		}
	
	var customDialogYears = $("label#CustomDialogYears")
	patch = "годы"
	if (lang == "english")
		patch = "years"
	for (i = 0; i < customDialogYears.length; i++) 
		customDialogYears[i].innerHTML = patch
		

	for (i = 0; i < 2; i++) {
		if ($("input#Group" + groups[i].TbName).is(':checked')) {
			s = 0
			str = ""
			for (j = 0; j < groups[i].TbCoParams.length; j++){
				if (!isEmpty(AdFormData[i][groups[i].TbName + "List[]"]) && AdFormData[i][groups[i].TbName + "List[]"][s] == groups[i].TbCoParams[j]) {
					if(str.length == 0)
						str += "+ ";
					else 
						str += ", ";
					if (lang == "russian")
          			str += groups[i].RuCoParams[j];
         		else 
           			str += groups[i].EnCoParams[j];
           		s++
				}
			}
			if (str.length != 0) 
				str += ";"
      	patch = " изменить"
      	if (lang == "english")
      	patch = " change"
   		str += "<a class = 'AdFormChange' id = '" + groups[i].TbName + "ListChange'>" + patch + "</a>"
   		document.getElementById("Group" + groups[i].TbName + "List").innerHTML = str;
		}   
   	else
   		document.getElementById("Group" + groups[i].TbName + "List").innerHTML = ""; 		
	}
	
	
	// regression output parameters and submit button
	if (lang == "english"){
		document.title = "Database"
		$("label#LR").text("count angular coefficient of the trend line");
		$("label#preview").text("preview");
		$("label#output").text("output into file");
		$("label#numLines").text("number of lines in the page");
		$("label#fileName").text("filename");		
		
		$("input#submitAll").val("Submit");
      if ($("#your-dialog").text() != ""){
			$("#your-dialog").dialog({
        			title: "Parameters that can be shown together with group by parameter\n",
      	});
      	$('input.SubmitRegions').val('Ok')
      }
	}	
	else{
		document.title = "База данных"
		$("label#LR").text("посчитать коэффициент наклона линии тренда");
		$("label#preview").text("предпросмотр");
		$("label#output").text("вывод в файл");
		$("label#numLines").text("количество строк на странице");
		$("label#filename").text("имя файла");
		
		$("input#submitAll").val("Применить");
		if ($("#your-dialog").text() != ""){
			$("#your-dialog").dialog({
        			title: "Параметры, которые могут быть выведены вместе с параметром группировки\n",
      	});
      	$('input.SubmitRegions').val('Ок')
      }
	}	
}

function fillForm(){
	var tables = databases[1].slice();
	if (localStorage.getItem("db") == "stations_regions")
		tables = databases[0].slice();
	//TABLES
	if (tables.length > 1) {
		var text = "<legend id = 'Tables'></legend>";
	
		text += "<select class = 'short' id = 'chooseTable' name = 'primaryTabl' autocomplete = 'off'>";	
		for (i = 0; i < tables.length; i++){
			text += "<option value = '" + tables[i].Name + "'>" + tables[i].RuName + "</option>";
		}	
		text += "</select>";
	
		$("fieldset.main#tables").html(text);
	}
	else 
		$("fieldset.main#tables").hide();
	
	//MAIN TABLE
	//FILTERS
	text = "<legend id = 'Filters'></legend>";

	//date
	text += "<p>"
	
	text += "<label  for = 'lYEARl'  class = 'from'></label>"
	text += "<input  type='number'                          id = 'lYEARl'   name = 'YEAR[]'    min = '1800'   max = '2100'  placeholder = 'year1' >"
	text += "<input  type='number'                          id = 'lMONTHl'  name = 'MONTH[]'   min = '1'      max = '12'    placeholder = 'month1'>"
	text += "<input  type='number'                          id = 'lDAYl'    name = 'DAY[]'     min = '1'      max = '31'    placeholder = 'day1'  >"
	
	text += "<label  for = 'rYEARr'  class = 'to'></label>"; 
	text += "<input  type='number'                          id = 'rYEARr'   name = 'YEAR[]'    min = '1800'   max = '2100'  placeholder = 'year2'  >";
	text += "<input  type='number'                          id = 'rMONTHr'  name = 'MONTH[]'   min = '1'      max = '12'    placeholder = 'month2' >";
	text += "<input  type='number'                          id = 'rDAYr'    name = 'DAY[]'     min = '1'      max = '31'    placeholder = 'day2'   >";

	text += "<input  type='checkbox' class = '" + tables[0].Name + " columns cols'         id = 'DAYS'     name = 'Columns[]' value = 'DAYS'>";
	text += "<label  for = 'DAYS'    class = 'tableColumns'></label>"
	text += "</p>"
	 
	//date methods
	text += "<select                 class = 'short'        id = 'method'   name = 'DateType'>"
   text += "<option                                                                           value='method1'></option>"
   text += "<option                                                                           value='method2'></option>"
	text += "</select>"
	
	text += "<a href = '/INFO/info.html'>*</a>"

	//other filters
	for (i = 1; i < tables[0].Cols.length; i++) {
		var curFilter = tables[0].Cols[i].Name;
		text += "<p>"
		
		text += "<label for = 'l" + curFilter + "'  class = 'from'        ></label>"
		text += "<input type = 'number'             class = '" + tables[0].Name + " filters'      id = 'l" + curFilter + "'  name = '" + curFilter + "[]' step = '0.1' lang = 'eng' placeholder = 'min'> "
		
		text += "<label for = 'r" + curFilter + "'  class = 'to'          ></label>"
		text += "<input type = 'number'             class = '" + tables[0].Name + " filters'      id = 'r" + curFilter + "'  name = '" + curFilter + "[]' step = '0.1' lang = 'eng' placeholder = 'max'> "
		
		text += "<input type = 'checkbox'           class = '" + tables[0].Name + " columns cols' id = '"  + curFilter + "'  name = 'Columns[]'           value = '"  + curFilter + "'>"
		text += "<label for = '" + curFilter + "'   class = 'tableColumns'></label>"
		
		text += "</p>"
	}
	
	//print into filters fieldset
	$("fieldset.main#filters").html(text);
	
	
	//FUNCTIONS
	text = "<legend id = 'Functions'></legend>";
	
	for (i = 0; i < functions.length; i++) {
		var curFnc = functions[i][0];
		text += "<input type = 'checkbox'           class = 'METEO_DATA_2015_WREGIONS functions'    id = '"  + curFnc +    "'  name = 'Functions[]'         value = '" + curFnc + "'>"
		text += "<label for = '" + curFnc + "'                                                      id = 'functions' ></label>"
		text += "<br>"
	}
	
	//print into functions fieldset
	$("fieldset.main#functions").html(text);
	
	
	//GROUP BY
	text = "<legend id = 'GroupBy'></legend>";
	
	for (i = 0; i < groups.length; i++) {
		var curGrp = groups[i].TbName
		
		//groups without lists
		notLR = "";
		if (i > 1)
			notLR = "notLR";
		
		text += "<p                                 class = '" + notLR + "'>"
		text += "<input type = 'checkbox'           class = 'Group " + notLR + "'                   id = 'Group" + curGrp + "'name = 'Groups[]'             value = '" + curGrp + "' autocomplete = 'off'>"
		text += "<label for = 'Group" + curGrp + "' class = 'groups'></label>"
		text += "</p>";
		
		//list of params output together with curGrp
		text += "<p                                 class = 'GroupLists'                            id = Group" + curGrp + "List></p>";
	}
	
	//print into groups fieldset
	$("fieldset.main#groups").html(text);
	
	
	//OTHER TABLES
	for (i = 1; i < tables.length; i++) {	
		var currTable = tables[i];	
		text = "<div class = 'forTable' id = '" + currTable.Name + "' hidden></div>";
		$("div#otherTables").append(text);
		
		//columns		
		text = "<fieldset id = 'columns' class = 'main " + currTable.Name + "'></fieldset>";
		$("div#" + currTable.Name).append(text);
			
		text = "<legend id = 'Filters'></legend><table class = 'columns_filters'>";
		var k = 0;
		for (p = 0; p < currTable.Cols.length; p++) {
			text += "<tr><td class = 'left'>";
			if (currTable.Cols[p].RuOptions) {
				text += "<select class = '" + currTable.Name + " filters' id = '" + currTable.Name + currTable.Cols[p].Name + "' name = '" + currTable.Name + currTable.Cols[p].Name + "'>";
				for (l = 0; l < currTable.Cols[p].RuOptions.length; l++) {
   				text += "<option value = '" + currTable.Cols[p].RuOptions[l] + "'></option>";
   			}
   			text += "</select>";		
			}
	   	else if (i != 2 || p != 1){
   			text += "<label for = 'l" + currTable.Cols[p].Name + "' class = 'from'></label>";
				text += "<input type='number' class = '" + currTable.Name +" filters' id = 'l" + currTable.Cols[p].Name + "' name = '" + currTable.Name + currTable.Cols[p].Name + "L' step = '1' min = '' max = '' lang = 'eng' placeholder = 'min'> "; 
				text += "<label for = 'r" + currTable.Cols[p].Name + "' class = 'to'></label>";					
				text += "<input type='number' class = '" + currTable.Name +" filters' id = 'r" + currTable.Cols[p].Name + "' name = '" + currTable.Name + currTable.Cols[p].Name + "R' step = '1' min = '' max = '' lang = 'eng' placeholder = 'max'>";				
			}
			text += "</td><td><input type = checkbox class = '" + currTable.Name +" columns' id = '" + currTable.Cols[p].Name + "' name = '" + currTable.Name + "Columns[]' value = '" + currTable.Cols[p].Name + "'><label for = '"
			 + currTable.Cols[p].Name + "' class = 'tableColumns'></label></td></tr>";
		}		
		text += "</table>";
		$("fieldset#columns." + currTable.Name).html(text);
		
		//functions
		if (i != 2) {
			text = "<fieldset id = 'functions' class = 'main " + currTable.Name + "'></fieldset>";
			$("div#" + currTable.Name).append(text);
			text = "<legend id = 'Functions'></legend>";
			for (k = 0; k < functions.length; k++)
				text += "<input type = checkbox class = '" + currTable.Name +" functions' id = '" + functions[k][0] +"' name = '" + currTable.Name + "Functions[]' value = '" + functions[k][0] + "'><label id = 'functions' for = '" 
					+ functions[k][0] + "'></label><br>";
			$("fieldset#functions." + currTable.Name).html(text);
		}
	}	
	
	translateForm();



}
