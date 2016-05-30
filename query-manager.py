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
	stopwords = indexing.getStopwords()
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
		if index == "cw":
			for word in argument:
				for chaine in word:
					position_check_list = []
					ok_composed_values = []
					for indexToken, token in enumerate(chaine.split(':')):
						print token
						stemmedWord = indexing.stemmer(token)
						values = stemOrderedDict.get(stemmedWord, None)
						if values is not None:
							position_check_list.append(values)
					ok_documents = position_check_list[0]
					for i in range(1,len(position_check_list)):
						temp_ok_documents = []
						for document_infos in ok_documents:							
							splitedDocument = document_infos.split(':')
							for document_to_compare in position_check_list[i]:
								splittedDocument_to_compare = document_to_compare.split(':')								
								if splittedDocument_to_compare[0] == splitedDocument[0]:									
									if int(splitedDocument[1])+i == int(splittedDocument_to_compare[1]):
										temp_ok_documents.append(splitedDocument[0] + ":" + splitedDocument[1] + ":" + str(float(splitedDocument[2]) + float(splittedDocument_to_compare[2])))
										print "i = " + str(i) + " " + splitedDocument[0] + ":" + splitedDocument[1] + " == " + splittedDocument_to_compare[0]  + ":" + splittedDocument_to_compare[1]
						ok_documents = temp_ok_documents
						print temp_ok_documents
							#print ok_documents.get(splitedDocument[0],None)
							#print splitedDocument[0] + " " + splitedDocument[1]
					sys.exit()
					print str(position_check_list[i-1]) + " " + str(position_check_list[i])
					print i
					sys.exit()
					# Si on est pas dans la première case, on compare avec la case précédente
					if(indexToken != 0):
						position_check_list[indexToken] + position_check_list[indexToken - 1]
					for document in values:
						splitted = document.replace('\n','').split(':')
						#if splitted[0] not in writted:
							#resultFile.write(splitted[0] + '|' + splitted[2] + '\n')
						if splitted[0] not in results:
							results[splitted[0]] = float(splitted[2])
							writted.append(splitted[0])	# Pour ne pas avoir plusieurs fois le résultat
						else:
							results[splitted[0]] += float(splitted[2])
				sys.exit()
				writted = []	# document déjà présent dans les résultats
				# On traite le mot seulement s'il n'est pas dans les stopwords
				if indexing.stemmer(word) not in stopwords:
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
		if index == "nw":
			for word in argument:
				writted = []	# document déjà présent dans les résultats
				# On traite le mot seulement s'il n'est pas dans les stopwords
				if indexing.stemmer(word) not in stopwords:
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
		if indexing.stemmer(word) not in stopwords:
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
#./query-manager.py nw="silent:movie" cw="Silent:movie:star||was:named:president:of:Howard:University" nwtr="jack" cwtr="coca:cola:cherry" ow="toto:tata:tutu"