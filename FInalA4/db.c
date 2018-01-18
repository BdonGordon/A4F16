#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <mysql/mysql.h>

#define MAX_QUERY 512
#define HOSTNAME  "dursley.socs.uoguelph.ca"
/*
	HOSTNAME can be defined with IP or hostname.

	eg: #define HOSTNAME "131.104.49.147"
	    #define HOSTNAME "gradpc-38.cis.uoguelph.ca"

*/
#define USERNAME  "bgordo01"
#define PASSWORD  "0850874"
#define DATABASE  "bgordo01"

//standard error clause.
void error(char *msg, MYSQL *mysql);

//clear the contents of an array of char's
void clrstr(char *buf);


int main(int argc,char *argv[]){
	MYSQL mysql;
	MYSQL_RES *res;
	MYSQL_ROW row;
//	MYSQL_FIELD *field;
	char query[MAX_QUERY];
//	int x;
	int i = 0;

	//dealing with the DB store function?
	//printf("Connecting to database ...\n");

	mysql_init(&mysql);
	mysql_options(&mysql, MYSQL_READ_DEFAULT_GROUP, "db");

	if (!mysql_real_connect(&mysql, HOSTNAME, USERNAME, PASSWORD,
		DATABASE, 0, NULL, 0)) {
	   error("Could not connect to host.",&mysql);
	}

	//printf("Selecting a database.\n");
	clrstr(query);

	if((argc == 2) || (argc == 3)){
		if(strcasecmp(argv[1], "-clear") == 0){
			printf("Clearing rows from table.\n");
			strcpy(query, "DELETE FROM files;");
			if(mysql_query(&mysql, query)){
				error("Failed to delete rows from tables.", &mysql);
			}
			clrstr(query);
		}
		else if(strcasecmp(argv[1], "-reset") == 0){
			printf("Dropping table.\n");
			strcpy(query, "DROP TABLE files;");
			if(mysql_query(&mysql, query)){
				error("Failed to drop tables.", &mysql);
			}
			clrstr(query);
		}
		else if(strcasecmp(argv[1], "-show") == 0){
			strcpy(query, "SELECT * FROM files;");
			if(mysql_query(&mysql, query)){
                error("Failed to show table data.", &mysql);
            }
			if(!(res = mysql_store_result(&mysql))){
				error("Failed to store results", &mysql);
			}
			printf("-------------------------------------------------------------------------\n");
			printf("Length    Name                Timestamp\n");
			while((row = mysql_fetch_row(res))){
				for(i=1; i<mysql_num_fields(res); i++){
				//for(i=mysql_num_fields(res)-1; i>=0; i--){ 
					printf("%s       ", row[i]);
				}
				printf("\n");
				printf("-------------------------------------------------------------------------\n");
			}
           	clrstr(query);
		}
		else if(strcasecmp(argv[1], "-help") == 0){
			printf("db.c program usage:\n");
			printf("The table used for the database is named 'files'.\n");
			printf("1) Show the contents in 'files' enter: [./db -show]\n");
			printf("2) Clear rows in 'files' enter: [./db -clear]\n");
			printf("3) Drop the 'files' table enter: [./db] -reset]\n");
			printf("On the command line (do not include the '[' ']' characters.\n");
		}
		else if(strcasecmp(argv[1], "-php") == 0){
			strcpy(query, "SELECT Name FROM files;");
			if(mysql_query(&mysql, query)){

			}
			if(!(res = mysql_store_result(&mysql))){
   		 		//error("Failed to store results", &mysql);
			}
			while((row = mysql_fetch_row(res))){
    			for(i=0; i<mysql_num_fields(res); i++){
        			printf("%s ", row[i]);
    			}
			}
			clrstr(query);
		}
		//the >2 is to check for the file name which will be done in php
		else if(strcasecmp(argv[1], "-content") == 0 && argc == 3){
            strcpy(query, "SELECT Content FROM files WHERE Name = '");
			strcat(query, argv[2]);
			strcat(query, "';");
            if(mysql_query(&mysql, query)){

            }
            if(!(res = mysql_store_result(&mysql))){
                //error("Failed to store results", &mysql);
            }
            while((row = mysql_fetch_row(res))){
                for(i=0; i<mysql_num_fields(res); i++){
                    printf("%s ", row[i]);
                }
            }
            clrstr(query);
        }
		else{
			printf("Invalid flag. Valid flags are:\n");
			printf("-clear || -reset || -show || -help\n");
		}
	}

	else{
		printf("Invalid no. of arguments. Valid flags are:\n");
                printf("-clear || -reset || -show || -help\n");
	}
	//dealing with the DB store function
	//mysql_close(&mysql);
    //mysql_library_end();

	return 0;
}


void clrstr(char *buf){
	buf[0] = '\0';
}

void error(char *msg, MYSQL *mysql){
	printf("%s\n%s\n",msg,mysql_error(mysql));
	exit(1);
}
