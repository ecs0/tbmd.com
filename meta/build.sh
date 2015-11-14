#!/bin/bash

echo "Building Database"
mysql --user="root" --password="" < ./database/schema.sql

