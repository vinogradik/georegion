#include <vector>
#include <fstream>
#include <cstring>
#include <chrono>
#include <random>
#include <iostream>
#include <cstdlib>
using namespace std;



int main(int argc, char** argv) {
    double xstep = 2;
    double ystep = 2;
    switch (argc) {
    case 2:
        cout << "Using default xstep = 2, ystep = 2 degrees.\n";
        break;
    case 3:
        cout << "Using xstep = " << argv[2] << ", ystep = 2 degress.\n";
        xstep = atof(argv[2]);
        break;
    case 4:
        cout << "Using xtep = " << argv[2] << ", ystep = " << argv[3]  << "\n";
        xstep = atof(argv[2]);
        ystep = atof(argv[3]);
        break;
    default:
        cout << "no dir found error" << endl;
        return 1;
    }
    string dir(argv[1]);
    int xgrid = (int)(360.0 / xstep);
    int ygrid = (int)(180.0 / ystep + 1);
    ofstream fo(dir + "/grid.ctl");
    fo << "DSET  ^grid.dat\n"
          "TITLE grid\n"
          "UNDEF -9.99E33\n"
          "XDEF " << xgrid << " LINEAR   0.0 " << xstep << "\n"
          "YDEF " << ygrid << " LINEAR -90.0 " << ystep << "\n"
          "ZDEF  1 LINEAR 1 1\n"
          "TDEF  1 LINEAR 1JAN2000 1DY\n"
          "VARS  1\n"
          "x 0 99 grid\n"
          "ENDVARS\n";
    fo.close();

    ofstream fout(dir + "/grid.dat", ios::binary);
    int size = xgrid * ygrid;
    float* buffer = new float[size];
    unsigned seed = std::chrono::system_clock::now().time_since_epoch().count();
    std::mt19937 generator (seed);  // mt19937 is a standard mersenne_twister_engine

    for (int i = 0; i < size; i++) {
        buffer[i] = (float)((generator() % 1000) / 10.0);
        fout.write( reinterpret_cast<char*>( &buffer[i] ), sizeof buffer[i] );
    }
    delete[] buffer;
    fout.close();
    return 0;
}


