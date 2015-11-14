#!/bin/bash

echo "Building Database"
mysql --user="root" --password="" < ./database/schema.sql

function lint {
    for file in $@
    do
        if [[ $file == *.php ]]
        then
            echo "Linting $file..."
            php -l $file
        fi
    done
}

lint ./php/*
lint *