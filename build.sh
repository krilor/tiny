#!/bin/bash

#ensure dist directories exists and are empty
mkdir -p dist/tiny/js
find ./dist/ -type f -delete

sass sass/style.scss:style.css  sass/editor-style.scss:editor-style.css

cp *.{php,png,txt,css} dist/tiny

cp LICENSE dist/tiny
cp js/tiny.js dist/tiny/js

# Remove source mapping
sed -i '/sourceMapping/d' dist/tiny/*.css

#csso style.css --output dist/tiny/style.css
#csso editor-style.css --output dist/tiny/editor-style.css

cd dist
zip -r -q tiny.zip tiny