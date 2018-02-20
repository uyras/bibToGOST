#!/bin/bash
sudo -H -u www-data bash -c 'ht latex "\def\bibfilename{123}\input mypapers.tex"'
sudo -H -u www-data bash -c 'biber mypapers"'
sudo -H -u www-data bash -c 'ht latex "\def\bibfilename{123}\input mypapers.tex"'
find . -type f -not -name '123.bib' -not -name 'fontsload.sh' -not -name 'mypapers.tex' -delete