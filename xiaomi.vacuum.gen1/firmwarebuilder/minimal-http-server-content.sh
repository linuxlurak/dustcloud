#!/bin/bash

echo "************ minimalistic http server ***************\n"

echo "Token:"
printf $(cat /mnt/data/miio/device.token) | xxd -p
echo "\n"

echo "System Details (/etc/OS_VERSION):"
cat /etc/OS_VERSION
echo "\n"

echo "Resources (vmstat -S M):"
vmstat -S M
echo "\n"

echo "Interfaces (ifconfig):"
ifconfig
echo "\n"

echo "Running processes (ps -aux):"
ps -aux
