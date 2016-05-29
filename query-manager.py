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
import operator

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
	results = dict()
	# Pour chaque argument sans le ./query-manager.py
	stemOrderedDict = indexing.getStemOrderedDict()
	if len(sys.argv[1:]) != 1:
		for word in sys.argv[1:]:
			writted = []	# document déjà présent dans les résultats
			# On traite le mot seulement s'il n'est pas dans les stopwords
			if indexing.stemmer(word) not in indexing.getStopwords():
				stemmedWord = indexing.stemmer(word)
				values = stemOrderedDict.get(stemmedWord, None)
				if values is not None:
					for document in values:
						splitted = document.replace('\n','').split(':')
						if splitted[0] not in writted:
							#resultFile.write(splitted[0] + '|' + splitted[2] + '\n')
							if splitted[0] not in results:
								results[splitted[0]] = float(splitted[2])
								writted.append(splitted[0])	# Pour ne pas avoir plusieurs fois le résultat
							else:
								results[splitted[0]] += float(splitted[2])
		sorted_results = sorted(results.items(), key=operator.itemgetter(1), reverse=True)
		for key, value in sorted_results:
			resultFile.write(key + '|' + str(value) + '\n')
		resultFile.close()
	else:
		for word in sys.argv[1:]:
			writted = []	# document déjà présent dans les résultats
			# On traite le mot seulement s'il n'est pas dans les stopwords
			if indexing.stemmer(word) not in indexing.getStopwords():
				stemmedWord = indexing.stemmer(word)
				values = stemOrderedDict.get(stemmedWord, None)
				if values is not None:
					for document in values:
						splitted = document.replace('\n','').split(':')
						if splitted[0] not in writted:
							#resultFile.write(splitted[0] + '|' + splitted[2] + '\n')
							if splitted[0] not in results:
								results[splitted[0]] = float(splitted[2])
								writted.append(splitted[0])	# Pour ne pas avoir plusieurs fois le résultat
							else:
								results[splitted[0]] += float(splitted[2])
		sorted_results = sorted(results.items(), key=operator.itemgetter(1), reverse=True)
		for key, value in sorted_results:
			resultFile.write(key + '|' + str(value) + '\n')
		resultFile.close()