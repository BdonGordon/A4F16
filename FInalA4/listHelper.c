#include "listio.h"

char *spaceMove(char *str){
	int i, spPlus=0;
	char *holder;

	holder = malloc(sizeof(char) * strlen(str)+20);
	//holder[0] = '\0';
	strcpy(holder, "");

	for(i=0; i<strlen(str)+1; i++, spPlus++){
		if(str[i] == ' ' && str[i+1] == ' '){
			strcat(holder, " ");
			i += 1;
		}
		else if(str[i] == '\t' && str[i+1] == '\t'){
			strcat(holder, "\t");
			i += 1;
		}
		holder[spPlus] = str[i];
	}
	//strcpy(str, holder);
	free(str);

	return holder;
}

char *newLine(char *str){
	int i,j;
	char *holder;
	char *pTag = "<P>";
	char *brTag = "<BR>";
	int newL = 0;
	int spaces = 1;

	holder = malloc(strlen(str)+200);
	holder[0] = '\0';

	for(i=0; i<strlen(str)+1; i++){		
		if((str[i] == '\n' && str[i+1] != '\n' && str[i+1] != ' ') || (str[i] == '\r' && str[i+1] != '\r' && str[i+1] != ' ')){
			newL = 1;
			break;
		}
		else if((str[i] == '\n' && str[i+1] == ' ') || (str[i] == '\r' && str[i+1] == ' ')){
			j = i+1;
			while(str[j] == ' '){
				j++;
				spaces = j-i;
			}
			if(str[j] == '\n' || str[j] == '\r'){
				//printf("ynoh\n");
				//i = j;
				//spaces = j-i;
				break;
			}
			else{
				newL = 1;
				break;
			}
		}
		else if((str[i] == '\n' && str[i+1] == '\n') || (str[i] == '\r' && str[i+1] == '\r') || (str[i] == '\n' && str[i+1] == '\r')){
			//printf("yeah\n");
			break;
		}
	}
	if(newL){
		strncpy(holder, str, i);
		holder[i] = '\0';
		//printf("^%s^\n", holder);
		strcat(holder, brTag);
		for(j=i+1; j<strlen(str)+1; j++){
			holder[j+3] = str[j];
		}
	}
	else{
		strncpy(holder, str, i);
		holder[i] = '\0';
		//printf("^%s^\n", holder);
		strcat(holder, pTag);
		for(j=i+1; j<strlen(str)+1; j++){
			holder[j+2] = str[j+spaces];
		}
	}

	/*remember if write and readstrings is tested this can cause a double free
	**corruption*/
	free(str);
	return holder;
}


char *nameEdit(char *dbName){
	char *str = malloc(strlen(dbName)+50);
	char *tk;

	strcpy(str, dbName);

	tk = strtok(dbName, "/");
	while(tk != NULL){
		strcpy(str, tk);
		tk = strtok(NULL, "/");
	}

	return str;
}
