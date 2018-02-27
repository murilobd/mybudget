#!/bin/bash
nginx -t

echo "restarting nginx"

service nginx restart
exec "$@"