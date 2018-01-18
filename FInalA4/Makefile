CC = gcc 
CFLAGS = -Wall -g

all: listio db

listio: listio.o listHelper.o a4.o db.o
	ar rc liblistio.a listio.o listHelper.o
	$(CC) $(CFLAGS) a4.o liblistio.a -o a4 -lmysqlclient -L/usr/lib/x86_64-linux-gnu/
	
db: db.o
	$(CC) $(CFLAGS) db.o -o db -lmysqlclient -L/usr/lib/x86_64-linux-gnu/ 

listio.o: listio.h listio.c
	$(CC) $(CFLAGS) listio.c -o listio.o -c

listHelper.o: listio.h listHelper.c
	$(CC) $(CFLAGS) listHelper.c -o listHelper.o -c

a4.o: a4.c
	$(CC) $(CFLAGS) a4.c -o a4.o -c

db.o : db.c
	$(CC) $(CFLAGS) db.c -o db.o -c

ht:
	rm ./files/*.html

clean:	
	@ rm -f *.o liblistio.a 
	rm a4
	rm db
