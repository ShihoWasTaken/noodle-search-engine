#!/usr/bin/env python
# -*- coding: utf-8 -*-

#########################################################################################
#																						#
#										 Imports										#
#																						#
#########################################################################################

import os
import sys
import indexing

#########################################################################################
#																						#
#										Constantes										#
#																						#
#########################################################################################

#########################################################################################
#																						#
#									Variables globales									#
#																						#
#########################################################################################


#########################################################################################
#																						#
#										Fonctions										#
#																						#
#########################################################################################

#########################################################################################
#																						#
#									  	   Main			 								#
#																						#
#########################################################################################

if __name__ == '__main__':
	resultFile = open('output/results.txt','w')
	# Pour chaque argument sans le ./query-manager.py
	stemOrderedDict = indexing.getStemOrderedDict()
	for word in sys.argv[1:]:
		# On traite le mot seulement s'il n'est pas dans les stopwords
		if indexing.stemmer(word) not in indexing.getStopwords():
			stemmedWord = indexing.stemmer(word)
			values = stemOrderedDict.get(stemmedWord, None)
			if values is not None:
				for document in values:
					resultFile.write(document + ' | adresse document ' + document + ' | résumé document ' + document + '\n')
	resultFile.close()