#include <cstdio>
#include <string>
#include <fstream>
#include <iostream>
#include <cstring>
#include <algorithm>

using namespace std;

/* ifile requirements
 * structure
 * order by date (currently year, month)
 * year, month, index, lat, lon, val
 */

string months[12] = {"jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"};



/* Structure that describes a report header in a stn file */ 
struct rpthdr {
  char id[8];    /* Station ID */
  float lat;      /* Latitude of Station */
  float lon;      /* Longitude of Station */ 
  float t;        /* Time in grid-relative units */ 
  int   nlev;     /* Number of levels following */ 
  int   flag;     /* Level independent var set flag */ 
} hdr;

int skip_spaces (string &s, int &pos) {
    while (pos < s.size() && s[pos] == ' ')
        pos++;
    return pos;
}

typedef enum {
    NO_DATE,
    FULL_DATE,
    YEAR_MONTH,
    YEAR,
} date_type;

class Time {
public:
    int year;
    int month;
    int day;
    Time() {
        year = 2000;
        month = 1;
        day = 1;
    };
    Time& operator=(const Time &other_time) {
        year = other_time.year;
        month = other_time.month;
        day = other_time.day;
    };
    bool operator!= (const Time &other_time) {
        return (day != other_time.day
                || year != other_time.year
                || month != other_time.month);
    }
};

int main (int argc, char **argv) 
{
  FILE  *ofile; 
  ifstream fin;
  ofstream fout;
  string index;
  Time time, prev_time, start_time;
  float val;
  if (argc < 2) {
      printf("no input filename\n");
      return 0;
  }
  string input_file = string(argv[1]);
  string output_file;
  int i = 0;
  while (i < input_file.length() && input_file[i] != '.') {
    output_file.push_back(input_file[i]);
    i++;
  }
  output_file += ".dat";

  if (argc == 3)
    output_file = string(argv[2]);

  if (argc >= 4) {
    input_file = string(argv[3]) + '/' + string(argv[1]);
    output_file = string(argv[3]) + '/' + string(argv[2]);
  }

  fin.open(input_file);
  if (!fin) {
      printf("Error opening  input file\n");
      return 0;
  }

  ofile = fopen (output_file.c_str(),"wb");

  if (ofile==NULL) {
      printf("Error opening output file\n");
      return 0;
  }

  int n;
  int ind_exist;
  int dtype;
  fin >> dtype >> ind_exist >> n;
  hdr.t = 0.0;
  hdr.flag = 1;
  bool first_time_group = true;
  int num_time_groups = 1;

  //temp_start

  for (int i = 0; i < n; i++) {
      string date;
      switch(dtype) {
      case FULL_DATE:
          fin >> date;
          time.year = stoi(date.substr(0, 4));
          time.month = stoi(date.substr(5, 2));
          time.day = stoi(date.substr(8, 2));
          break;
      case YEAR_MONTH:
          fin >> time.year >> time.month;
          break;
      case YEAR:
          fin >> time.year;
          break;
      default:
          break;
      }
      if (ind_exist) {
          fin >> index;
          int j;
          for (int j = 0; j < min((int)index.size(), 8); hdr.id[j] = index[j], j++);
      }
      else {
          for (int j = 0; j < 8; j++) {
              hdr.id[j] = '0';
          }
          int ind = i;
          int pos = 7;
          while (ind != 0) {
              hdr.id[pos] = (ind % 10) + '0';
              ind /= 10;
              pos--;
          }
      }
      fin >> hdr.lat;
      fin >> hdr.lon;
      fin >> val;
      if (first_time_group) {
          start_time = prev_time = time;
          first_time_group = false;
      }
      if (time != prev_time) {
        //write terminator
        hdr.nlev = 0;
        fwrite(&hdr,sizeof(struct rpthdr), 1, ofile);
        num_time_groups++;
      }

      hdr.nlev = 1;
      fwrite (&hdr,sizeof(struct rpthdr), 1, ofile);
      fwrite (&val,sizeof(float), 1, ofile);
      prev_time = time;
  }

  //temp_end
  hdr.nlev = 0;
  fwrite (&hdr,sizeof(struct rpthdr), 1, ofile);

  fin.close();
  fclose(ofile);

  string meta_info_file("data.ctl");
  if (argc >= 4)
    meta_info_file = string(argv[3]) + '/' + meta_info_file;
  fout.open(meta_info_file);
  fout << "DSET   ^data.dat\n"
          "DTYPE  station\n"
          "STNMAP ^data.map\n"
          "UNDEF  -999.0\n"
          "TITLE  Station Data\n"
          "TDEF   " << num_time_groups << " LINEAR ";
  switch(dtype) {
  case YEAR_MONTH:
      fout << months[start_time.month - 1] << start_time.year << " 1mo\n";
      break;
  case YEAR:
      fout << "jan" << start_time.year << " 1yr\n";
      break;
  default:
      fout << start_time.day << months[start_time.month - 1] << start_time.year << " 1dy\n";
      break;
  }
  fout << "VARS 1\n"
          "v    0  99 value\n"
          "ENDVARS\n";
  fout.close();
} 
