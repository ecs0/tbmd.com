#!/bin/bash

ERROR="Parse error"

echo "Building Database"
mysql --user="root" --password="" < ./database/schema.sql

function lint {
    for file in $@
    do
        if [[ $file == *.php ]]
        then
            echo "Linting $file..."
            output=`php -l $file`
            if [[ $ERROR == *$output* ]]
            then
                echo $output
                exit 1
            fi
        fi
    done
}

lint ./php/*
lint *