#include <iostream>
#include <fstream>
#include <string>
#include <time.h>
using namespace std;

int main () {
  string line;
	int i=0;
	for(i=0;i>-1;i++){
	sleep(1);
  ifstream myfile ("example.txt");
  if (myfile.is_open())
  {
    while ( getline (myfile,line) )
    {
      cout << line << '\n';
    }
    myfile.close();
  }

  else cout << "Unable to open file"; 
	}
  return 0;
}
