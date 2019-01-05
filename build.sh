#!/bin/bash

#ensure dist directories exists and are empty
mkdir -p dist/tiny/js
find ./dist/tiny -type f -delete

sass sass/style.scss:style.css  sass/editor-style.scss:editor-style.css

cp *.{php,png} dist/tiny
cp LICENSE dist/tiny
cp README.md dist/tiny/README.txt
cp js/tiny.js dist/tiny/js

csso style.css --output dist/tiny/style.css
csso editor-style.css --output dist/tiny/editor-style.css