#!/bin/bash
echo "Wait for apache start..." >> /dev/stdout
wait-for localhost:80 -t 300 -- echo "Apache ready!" >> /dev/stdout

echo "Wait for mysql database start..." >> /dev/stdout
wait-for db1:3306 -t 300 -- echo "MySQL ready!" >> /dev/stdout

echo "Seeding database with curl..." >> /dev/stdout
curl 'http://localhost/index.php' -H 'Content-Type: application/x-www-form-urlencoded' \
--data-raw "host=db1&user=root&senha=pass&database=scholarevents" --compressed >> /dev/stdout