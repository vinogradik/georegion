var lang = "russian";

var legendText = {
	Tables         :["Выберите основную таблицу", "Choose the main table"],
	Filters        :["Выберите нужные колонки базы данных и фильтры для них", "Choose columns from the database and filters for them"],
	FiltersShort   :["Фильтры", "Filters"],
	Functions      :["Функции", "Functions"],
	Regression     :["Линейная регрессия", "Linear regression"],
	GroupBy        :["Группировка данных", "Group data by"],
	Output         :["Параметры вывода", "Output parameters"] 
}


var date           = { Name: "DAYS",          RuName: "дата",                                      EnName: "date"}
var region         = { Name: "REGION",        RuName: "номер региона",                             EnName: "region number"}
var station        = { Name: "IND",           RuName: "индекс станции",                            EnName: "station index"}
var lat            = { Name: "LAT",           RuName: "широта",                                    EnName: "latitude"}
var lon            = { Name: "LON",           RuName: "долгота",                                   EnName: "longitude"}
var tmin           = { Name: "TMIN",          RuName: "минимальная температура",                   EnName: "minimal temperature"}
var tmean          = { Name: "TMEAN",         RuName: "средняя температура",                       EnName: "mean temperature"}
var tmax           = { Name: "TMAX",          RuName: "максимальная температура",                  EnName: "maximal temperature"}
var rain           = { Name: "R",             RuName: "осадки",                                    EnName: "precipitation"}

var uf             = { Name: "UF",            RuName: "ультрафиолет, баллы",                       EnName: "UV light intensity score"}
var polar          = { Name: "POLARNIGHT",    RuName: "полярные день/ночь, баллы",                 EnName: "polar day/night score"}
var swamps         = { Name: "SWAMPINESS",    RuName: "заболоченность территории, %",              EnName: "swampiness %"}
var permafrost     = { Name: "PERMAFROSTDEC", RuName: "протаивание вечной мерзлоты, м",            EnName: "permafrost melting m"}
var floods         = { Name: "FLOOD",         RuName: "наводнения, баллы",                         EnName: "floods score"}
var earthquake     = { Name: "EARTHQUAKE",    RuName: "землетрясения, баллы",                      EnName: "earthquakes score"}
var healthind      = { Name: "HEALTHIND",     RuName: "индекс общественного здоровья",             EnName: "social health index"}
var sanecest       = { Name: "SANECEST",      RuName: "санитарно-экологическая оценка территории", EnName: "environmental assessment of territory"}

var regionname     = { Name: "VALUE",         RuName: "название региона",                          EnName: "region name"}
var val            = { Name: "VALUE",         RuName: "значение",                                  EnName: "value"}

var year           = { Name: "YEAR",          RuName: "год",                                       EnName: "year"}





var sex = {
	Name      : "SEX",
	RuName    : "пол",
	EnName    : "sex",
	RuOptions : ["оба пола", "женщины", "мужчины"],
	EnOptions : ["all population", "male", "female"]
}

var population = {
	Name      : "TYPE",
	RuName    : "тип населения",
	EnName    : "type of population",
	RuOptions : ["все население", "городское население", "сельское население"],
	EnOptions : ["all population", "urban population", "rural population"]
}

var disease = {
	Name      : "DECEASE",
	RuName    : "болезни",
	EnName    : "diseases",
	RuOptions : [
		"болезни органов дыхания",
		"болезни органов пищеварения",
		"внешние причины", "врожденные аномалии (пороки развития, деформации и хромосомные нарушения)",
		"всего умерших от всех причин",
		"некоторые инфекционные и паразитарные болезни",
		"отдельные состояния",
		"возникающие в перинатальном периоде"
	],
	EnOptions : [
		"1",
		"2",
		"3",
		"4",
		"5",
		"6",
		"7"
	]
	
}

var migration = {
	Name      : "TYPE",
	RuName    : "миграция",
	EnName    : "migration",
	RuOptions : [
		"в пределах России",
		"внешняя (для региона) миграция",
		"внутрирегиональная",
		"международная всего",
		"международная всего по региону",
		"межрегиональная",
		"миграция всего",
		"с другими зарубежными странами",
		"со странами СНГ, Балтии и Грузии"
	],
	EnOptions : [
		"1",
		"2",
		"3",
		"4",
		"5",
		"6",
		"7",
		"8",
		"9"
	]
}

var tables = [
		{
			Name   : "METEO_DATA_2015_WREGIONS",
			RuName : "метеоданные",
			EnName : "meteodata", 
			Cols   : [date, region, station, lat, lon, tmin, tmean, tmax, rain]
		}, 
		{
			Name   : "GRID_DATA",
			RuName : "данные по сетке",
			EnName : "grid data",
			Cols   : [lat, lon, uf, polar, swamps, permafrost, floods, earthquake, healthind, sanecest]		
		}, 
		{
			Name   : "REGIONS",
			RuName : "регионы",
			EnName : "regions",
			Cols   : [region, regionname]
		},
		{
			Name   : "STAT_MIGR_1997_2015",
			RuName : "миграция (1997 - 2015)",
			EnName : "migration (1997 - 2015)",
			Cols   : [region, migration, year, val]
		},
		{
			Name   : "STAT_MIGR_COEF_1997_2015",
			RuName : "коэффициенты миграции (1997 - 2015)",
			EnName : "migration coefficient (1997 - 2015)",
			Cols   : [region, year, val]	
		},
		{
			Name   : "STAT_NAT_INC_1990_2014",
			RuName : "естественный прирост населения (1990 - 2014)",
			EnName : "natural increase of population (1990 - 2014)",
			Cols   : [region, sex, population, year, val]
		},
		{
			Name   : "STAT_OVERALL_INC_1990_2014",
			RuName : "общий прирост населения (1990 - 2014)",
			EnName : "overall increase of population (1990 - 2014)",
			Cols   : [region, population, year, val]		
		},
		{
			Name   : "STAT_LIFETIME_1990_2010",
			RuName : "продолжительность жизни (1990-2010)",
			EnName : "life expectancy (1990-2010)",
			Cols   : [region, sex, population, year, val]
		},
		{
			Name   : "STAT_NEONAT_2012",
			RuName : "неонатальная смертность 2012",
			EnName : "neonatal mortality 2012",
			Cols   : [region, val]
		},
		{
			Name   : "STAT_CHILD_MORT_2013_2015",
			RuName : "детская смертность (2013 - 2015)",
			EnName : "child mortality (2013 - 2015)",
			Cols   : [region, year, val]
		},
		{
			Name   : "STAT_MORT_1990_2012",
			RuName : "смертность от болезней (1990 - 2012)",
			EnName : "disease mortality (1990 - 2012)",
			Cols   : [disease, region, population, year, val]
		}
]


var date = [
	["YEAR", 1800, 2100],
	["MONTH", 1, 12], 
	["DAY", 1, 31],
]

var functions = [
	["COUNT", "количество", "number"],
	["SUM", "сумма", "sum"],
	["AVG", "среднее", "average value"],
	["STD", "стандартное отклонение", "standard deviation"],
	["MIN", "минимум", "minimum"],
	["MAX", "максимум", "maximum"]
]

var groups = [
	{
		TbName:"REGION",
		RuName:"регионы",
		EnName:"regions",
		TbCoParams:
		[
			"REGIONNAME",
			"MIGRATION",
			"MIGR_COEFF",
			"NATINCREASE",
			"OVERALLINCREASE",
			"LIFETIME",
			"NEONATMORTALITY",
			"CHILDMORTALITY",
			"DECEASEMORTALITY" 
		], 
		RuCoParams:
		[
			"название региона", 
			"миграция",
			"коэффициент миграции",
			"естественный прирост",
			"общий прирост",
			"продолжительность жизни",
			"неонатальная смертность",
			"детская смертность",
			"смертность от болезней"
		],
		EnCoParams:
		[
			"region name", 
			"migration",
			"migration coefficient",
			"natural increase",
			"total increase",
			"lifetime",
			"neonatal mortality",
			"infant mortality",
			"mortality from disease"
		],
		Limits:
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
	},
	{
		TbName:"IND",
		RuName: "станции",
		EnName: "stations",
		TbCoParams:["LAT", "LON"],
		RuCoParams: ["широта", "долгота"],
		EnCoParams: ["latitude", "longitude"]
	},
	{
		TbName:"YEAR(DAYS)",
		RuName:"годы",
		EnName:"years"
	},
	{
		TbName:"MONTH(DAYS)",
		RuName:"месяцы",
		EnName:"months"
	}
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
