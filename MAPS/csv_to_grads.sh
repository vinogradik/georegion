echo $1
./convert.sh $1 new.csv || exit 1
echo "converted to data.csv"
./convert data.csv data.dat $1 || exit 1
echo "converted to data.dat"
stnmap -i $1'/'data.ctl    || exit 1
