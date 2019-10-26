NR==1 {
    for (i=1; i<=NF; i++) {
        ix[$i] = i
    }
}
NR>=1 {
    if ("DAYS" in ix) {
        printf  $ix["DAYS"] "\t"
    }
    else {
        if ("YEAR(DAYS)" in ix) {
            printf $ix["YEAR(DAYS)"] "\t"
        }
        if ("MONTH(DAYS)" in ix) {
            printf $ix["MONTH(DAYS)"] "\t"
        }
    }
    if ("IND" in ix) {
        printf $ix["IND"] "\t"
    }
    print $ix["LAT"] "\t" $ix["LON"] "\t" $NF
}