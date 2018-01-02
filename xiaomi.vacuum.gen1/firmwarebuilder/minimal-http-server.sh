#!/bin/bash
while true; do { echo -e 'HTTP/1.1 200 OK\r\n'; sh /root/minimal-http-server-content.sh; } | nc -l 80; done
exit 0
