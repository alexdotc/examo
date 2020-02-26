#!/bin/sh

WEBROOT=$HOME/public_html

for f in *; do
    diff $PWD/$f $WEBROOT/$(basename $PWD)/$f
done
