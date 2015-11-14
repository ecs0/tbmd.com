#!/bin/bash

echo "Building Database"
mysql -u "root" -p < ./database/schema.sql

