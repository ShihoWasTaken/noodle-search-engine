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
	arguments = dict()
	for word in sys.argv[1:]:
		egalSplitted = word.split('=')
		arguments[egalSplitted[0]] = []
		if egalSplitted[0] == 'cw':
			arguments[egalSplitted[0]].append(egalSplitted[1].split('||'))				
			#print arguments[egalSplitted[0]]
		elif egalSplitted[0] == 'cwtr':
			arguments[egalSplitted[0]].append(egalSplitted[1].split('||'))	
			#print arguments[egalSplitted[0]]
		else:
			#print egalSplitted[1]
			for doublePointSplitted in egalSplitted[1].split(':'):
					arguments[egalSplitted[0]].append(doublePointSplitted)
	for index, argument in arguments.iteritems():
		if index == "nw":
			for word in argument:
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
	sys.exit()
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
#./query-manager.py nw="silent:movie" cw="silent:movie:star||silet:mvie:sar" nwtr="jack" cwtr="coca:cola:cherry" ow="toto:tata:tutu"