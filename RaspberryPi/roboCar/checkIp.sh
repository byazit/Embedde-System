#!/bin/sh

SUBJ="This is new IP for Pi"
EMAIL="byazit@gmail.com"

ip1=""
ip2=""

read ip1 < ip.txt
ip2=$(wget -qO- ifconfig.me/ip)

if [ "$ip1" = "$ip2" ]
then
  exit
else
  echo "$ip2" > ip.txt
  echo "$ip2" | mail -s "$SUBJ" "$EMAIL"
  exit
fi
