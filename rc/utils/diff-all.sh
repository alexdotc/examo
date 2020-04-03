#!/bin/sh

WEBROOT=/var/www/html

for f in *; do
    diff $PWD/$f $WEBROOT/$(basename $PWD)/$f
done
