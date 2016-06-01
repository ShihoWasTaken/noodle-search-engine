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

def getResultsOfComposedWords(argument):
	results = dict()
	for word in argument:
		for chaine in word:
			position_check_list = []
			for indexToken, token in enumerate(chaine.split(':')):
				#print token
				stemmedWord = indexing.stemmer(token)
				values = stemOrderedDict.get(stemmedWord, None)
				if values is not None:
					position_check_list.append(values)
			if len(position_check_list) > 0:
				ok_documents = position_check_list[0]
				for i in range(1,len(position_check_list)):
					temp_ok_documents = None
					for document_infos in ok_documents:							
						splitedDocument = document_infos.split(':')
						for document_to_compare in position_check_list[i]:
							splittedDocument_to_compare = document_to_compare.split(':')								
							if splittedDocument_to_compare[0] == splitedDocument[0]:									
								if int(splitedDocument[1])+i == int(splittedDocument_to_compare[1]):
									temp_ok_documents = splitedDocument[0] + ":" + splitedDocument[1] + ":" + str(float(splitedDocument[2]) + float(splittedDocument_to_compare[2]))
									#if i == len(position_check_list):
									results[splitedDocument[0]] = float(temp_ok_documents.split(':')[2])
									#print "results[" + splitedDocument[0] + "] = " + str(results[splitedDocument[0]])
									#print "i = " + str(i) + " " + splitedDocument[0] + ":" + splitedDocument[1] + " == " + splittedDocument_to_compare[0]  + ":" + splittedDocument_to_compare[1]
					ok_documents = [temp_ok_documents]						
					#print "results[splitedDocument[0]] = " + str(results[splitedDocument[0]])
						#print ok_documents.get(splitedDocument[0],None)
						#print splitedDocument[0] + " " + splitedDocument[1]
		#sys.exit()
	return results

def getResultsOfNormalWords(argument):
	results = dict()
	for word in argument:
		word = word.lower()
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
	return results

def getResultsOfOrWords(argument):
	results = dict()
	return results

def addResult(key, value):
	global results
	if key not in results:
		results[key] = float(value)
	else:		
		results[key] += float(value)	

def removeResult(key):
	global results
	return results.pop(key, None)

def process(arguments):
	global composedWordsResults
	global composedWordsToRemoveResults
	global normalWordsToRemoveResults
	global normalWordsResults
	for index, argument in arguments.iteritems():
		# Composed Words
		if index == "cw":
			composedWordsResults = getResultsOfComposedWords(argument)
		# Composed Words To Remove
		if index == "cwtr":
			composedWordsToRemoveResults = getResultsOfComposedWords(argument)
		# Normal Words To Remove
		if index == "nwtr":
			normalWordsToRemoveResults = getResultsOfNormalWords(argument)
		# Normal Words
		if index == "nw":
			normalWordsResults = getResultsOfNormalWords(argument)
		# Ici on fusionne les résultats
		for key, result in composedWordsResults.iteritems():
			addResult(key, result)	
		for key, result in normalWordsResults.iteritems():
			addResult(key, result)	
		for key, result in composedWordsToRemoveResults.iteritems():
			removeResult(key)	
		for key, result in normalWordsToRemoveResults.iteritems():
			removeResult(key)	
		# Après la création de tout les résultats, on les écrit
		resultFile = open('output/results.txt','w')
		sorted_results = sorted(results.items(), key=operator.itemgetter(1), reverse=True)
		for key, value in sorted_results:
			resultFile.write(key + '|' + str(value) + '\n')
		resultFile.close()

#########################################################################################
#																						#
#									  	   Main			 								#
#																						#
#########################################################################################

if __name__ == '__main__':
	stopwords = indexing.getStopwords()
	results = dict()
	composedWordsResults = dict()
	normalWordsResults = dict()
	composedWordsToRemoveResults = dict()
	normalWordsToRemoveResults = dict()
	orWordsResults = dict()
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
	if arguments.get("ow",None) is None:	# Si on a pas de OR
		for index, argument in arguments.iteritems():
			# Composed Words
			if index == "cw":
				composedWordsResults = getResultsOfComposedWords(argument)
			# Composed Words To Remove
			if index == "cwtr":
				composedWordsToRemoveResults = getResultsOfComposedWords(argument)
			# Normal Words To Remove
			if index == "nwtr":
				normalWordsToRemoveResults = getResultsOfNormalWords(argument)
			# Normal Words
			if index == "nw":
				normalWordsResults = getResultsOfNormalWords(argument)
			# Ici on fusionne les résultats
			for key, result in composedWordsResults.iteritems():
				addResult(key, result)	
			for key, result in normalWordsResults.iteritems():
				addResult(key, result)	
			for key, result in composedWordsToRemoveResults.iteritems():
				removeResult(key)	
			for key, result in normalWordsToRemoveResults.iteritems():
				removeResult(key)	
			# Après la création de tout les résultats, on les écrit
			resultFile = open('output/results.txt','w')
			sorted_results = sorted(results.items(), key=operator.itemgetter(1), reverse=True)
			for key, value in sorted_results:
				resultFile.write(key + '|' + str(value) + '\n')
			resultFile.close()
	else:	# Si on a des OR
		if arguments.get("nw",None) is None:
			arguments["nw"] = []
		resultFile = open('output/results.txt','w')
		argumentsNormalWordsCopy = arguments["nw"]
		for orWordArg in arguments["ow"]:	# Pour chaque orWord
			arguments["nw"] = list(argumentsNormalWordsCopy)
			arguments["nw"].append(orWordArg)
			for index, argument in arguments.iteritems():
				# Composed Words
				if index == "cw":
					composedWordsResults = getResultsOfComposedWords(argument)
				# Composed Words To Remove
				if index == "cwtr":
					composedWordsToRemoveResults = getResultsOfComposedWords(argument)
				# Normal Words To Remove
				if index == "nwtr":
					normalWordsToRemoveResults = getResultsOfNormalWords(argument)
				# Normal Words
				if index == "nw":
					normalWordsResults = getResultsOfNormalWords(argument)
				# Ici on fusionne les résultats
				for key, result in composedWordsResults.iteritems():
					addResult(key, result)	
				for key, result in normalWordsResults.iteritems():
					addResult(key, result)	
				for key, result in composedWordsToRemoveResults.iteritems():
					removeResult(key)	
				for key, result in normalWordsToRemoveResults.iteritems():
					removeResult(key)		
		# Après la création de tout les résultats, on les écrit				
		sorted_results = sorted(results.items(), key=operator.itemgetter(1), reverse=True)
		for key, value in sorted_results:
			resultFile.write(key + '|' + str(value) + '\n')	
		resultFile.close()

#./query-manager.py nw="silent:movie" cw="Silent:movie:star||was:named:president:of:Howard:University" nwtr="jack" cwtr="coca:cola:cherry" ow="toto:tata:tutu"