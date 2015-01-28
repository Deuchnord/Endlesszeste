#!/bin/bash

if [ $# -eq 0 ]
then
	echo "Usage: $0 <nb_chap>"
	exit
fi

if [ -e storypdf ]
then
	rm -rf storypdf
fi

mkdir storypdf

for n in $(seq 1 1 $1)
do
	wget http://endlesszeste.tk/latex/latexify.php?chap=$n -O storypdf/chap$n.tex
done

pdflatex Un_Zeste_sans_Fin.tex
pdflatex Un_Zeste_sans_Fin.tex

rm -rf storypdf Un_Zeste_sans_Fin.aux Un_Zeste_sans_Fin.log
