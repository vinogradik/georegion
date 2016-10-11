var names = [
	["DAYS", "дата"],
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


function isEmpty(Value) {
	if (Value == null || Value == "")
		return 0;
	else 
		return 1;
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
	return ((isEmpty(document.getElementById("l" + names[i][0]).value) == 0)
		|| (isEmpty(document.getElementById("r" + names[i][0]).value) == 0)
		|| (+document.getElementById("l" + names[i][0]).value <= +document.getElementById("r" + names[i][0]).value));
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











function sendQuery() {
	query = genQuery();
	$.post("server.php", {query: query});
}

function genQuery() {
	var query = "SELECT ";
	var filters = "WHERE "
	if (document.getElementById("DAYS").checked) {
		query += "DAYS, ";
		var check = {left: true, right:true};
		if (document.getElementById("method").selectedIndex == 0) {
			filters += "YEAR(DAYS) >=" + document.getElementById("lyear").value + " AND ";
			filters += "YEAR(DAYS) <=" + document.getElementById("ryear").value + " AND ";
			filters += "(MONTH(DAYS) >" + document.getElementById("lmonth").value 
				+ " OR (MONTH(DAYS) = " + document.getElementById("lmonth").value 
				+ " AND " + "DAY(DAYS) >= " + document.getElementById("lday").value + ")) AND ";
			filters += "(MONTH(DAYS) <" + document.getElementById("rmonth").value 
				+ " OR (MONTH(DAYS) = " + document.getElementById("rmonth").value 
				+ " AND " + "DAY(DAYS) <= " + document.getElementById("rday").value + ")) AND ";			 
		}			
		else { 
			if (check.left) {
				filters += "DAYS >= '" + document.getElementById("lyear").value + "-" 
					+ document.getElementById("lmonth").value + "-" 
					+ document.getElementById("lday").value + "' AND ";
			}			
			if (check.right) {
				filters += "DAYS <= '" + document.getElementById("ryear").value + "-" 
					+ document.getElementById("rmonth").value + "-" 
					+ document.getElementById("rday").value + "' AND ";
			}	  
		} 			
	}
		
	for (i = 1; i < names.length; i++) {
		if (document.getElementById(names[i][0]).checked) {
			query += names[i][0] + ", ";
			var check = checkFilter(names[i][0]);
			if (check.error)
				alert("Error");
			if (check.Left)
				filters += names[i][0] + " >= " + document.getElementById("l" + names[i][0]).value + " AND ";
			if (check.Right) 
				filters += names[i][0] + " <= " + document.getElementById("r" + names[i][0]).value + " AND ";
		}
	}
	if (query.endsWith(", "))
		query = query.slice(-query.length, -2) + " ";
	query += "FROM STATION_EXT ";
	if (filters.endsWith("AND ")) 
		filters = filters.slice(-filters.length, -4); 	
	if (!(filters.endsWith("WHERE ")))	
		query += filters;
	return query;
}

