#swap columns in order, if exists: DATE, IND, LAT, LON. VALUE
curdir=$pwd
awk -f get_particular_columns.awk  $1'/'$2 > $1'/'temp.csv

#choose date type
cd $1
date_type=0
if grep -q "^DAYS" temp.csv; then
    date_type=1
    sort_flags="-k 1"
elif grep -q "MONTH(DAYS)" temp.csv; then
    date_type=2
    sort_flags="-g -k 1 -k 2"
elif grep -q "^YEAR(DAYS)" temp.csv; then
    date_type=3
    sort_flags="-g -k 1"
fi

#check index existence
index=0
if grep -q "[^A-Z]IND[^A-Z]" temp.csv; then
    index=1
fi

#count number of lines
num_lines=$(cat $2 | wc -l)
num_lines=$(( num_lines - 1 ))

#fill data.csv

#fill header date_type index_existence, number of lines
echo $date_type " " $index " " $num_lines > data.csv

#sort  data by date
sort $sort_flags temp.csv >> data.csv
rm temp.csv

#replace NULLs with particular undef
sed -i "s/\(.*\)NULL\(.*\)/\1-999\.0\2/" data.csv

#delete old header line
sed -i "/.*[A-Z].*/d" data.csv

cd $curdir