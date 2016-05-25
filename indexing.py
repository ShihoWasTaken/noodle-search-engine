#!/usr/bin/env python
# -*- coding: utf-8 -*-

#########################################################################################
#																						#
#										 Imports										#
#																						#
#########################################################################################

from __future__ import division					# Pour la division en float
import os
import sys
import collections
import re
from nltk import PorterStemmer					# Pour le Stemmer de Porter de la lib NLTK
from lxml import etree
import math										# Pour la fonction log


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

docNoList = collections.OrderedDict()	# La map qui va contenir la liste des docno avec pour chaque clé un stem
indexPositionList = collections.OrderedDict()	# La map qui va contenir la liste des index positionnels avec pour chaque clé un stem
total_number_of_docs = 0

#########################################################################################
#																						#
#										Fonctions										#
#																						#
#########################################################################################

def getStopwords():
	fichier = open('stopwords.txt', 'r')
	stopwords = [word.strip('\n\r') for word in fichier.readlines()]
	# print stopwords
	fichier.close()
	return stopwords

def getStemOrderedDict():
	stem = collections.OrderedDict()
	with open('output/indexedStem.txt', 'r') as stemFile:
		for line in stemFile:
			words = line.split(' | ')
			key = words[0]
			values = words[1].split(' ')
			stem[key] = values
	# Affichage de la table de hash
	#for key, value in stem.items():
	#	print "stem[" + key +"] = " + value 
	return stem

def stemmer(word):
	return PorterStemmer().stem_word(word).decode().encode('utf-8')

def trim(word):
	word = word.replace(".","")
	word = word.replace(",","")
	word = word.replace(";","")
	word = word.replace("?","")
	word = word.replace("!","")
	word = word.replace("/","")
	word = word.replace("_","")
	word = word.replace("'","")
	word = word.replace("`","")
	word = word.replace("(","")
	word = word.replace(")","")
	word = word.replace("[","")
	word = word.replace("]","")
	word = word.replace("{","")
	word = word.replace("}","")
	word = word.replace(":","")
	word = word.lower()
	return word

def idf(term):
	global total_number_of_docs
	dft = 0							# Number of documents containing the term t
	N = total_number_of_docs		# Total number of documents
	return math.log10(N/dft)

# Nombre d’apparition du mot dans le document divisé par le nombre d’apparition du mot le plus fréquent
def tf(term, document):
	return None

def tfidf(term, document):
	return idf(term) * tf(term, document)

#########################################################################################
#																						#
#									  	   Main			 								#
#																						#
#########################################################################################

if __name__ == '__main__':
	stopwords = getStopwords()
	parser = etree.XMLParser(recover=True)
	documentPerFile = open("output/documentPerFile.txt","w")
	documentAbstract = open("output/documentAbstract.txt","w")
	# Pour chaque fichier du dossier data on effectuera les traitements qui suivent
	for fichier in os.listdir('data/'):
		print "fichier = " + "data/" + fichier
		root = etree.parse('data/' + fichier, parser).getroot()
		#root = xml.etree.ElementTree.parse().getroot()
		for childs in root:
			docno = None
			for child in childs:
				if (child.tag.upper() == "DOCNO"):
					docno = child.text
					documentPerFile.write(docno + " | " + fichier + "\n")
					total_number_of_docs += 1
				elif (child.tag.upper() == "TEXT"):
					if child.text is not None:
						# On ajoute le résume du texte au fichier des résumés
						documentAbstract.write(docno + " | " + child.text[:50].replace("\n","") + "\n")
						words = re.split(' |\n|\t', child.text)
						wordPosition = 0
						for word in words:
							wordPosition += 1
							word = trim(word)
							stemmedWord = stemmer(word)
							if word not in stopwords:
								if(docNoList.get(stemmedWord, None) is None):		# On teste si la clé du dictionnaire est vide
									#print "On crée la clé " + stemmer(word) + " avec le num " + docno
									docNoList[stemmedWord] = [docno]					# On crée une liste contenant le docno actuel
								else:										# Si elle n'est pas vide
									#print "On ajoute le num " + docno + " à docNoList[" + stemmer(word) + "]"
									# Si le docno n'est pas dans la case du tableau, on l'ajoute (à revoir pour les pertinences)
									if(docno not in docNoList[stemmedWord]):
										docNoList[stemmedWord].append(docno)			# On ajoute le docno à la liste
								if(indexPositionList.get(stemmedWord, None) is None):		# On teste si la clé du dictionnaire est vide
									indexPositionList[stemmedWord] = collections.OrderedDict()
									indexPositionList[stemmedWord][docno] = [str(wordPosition)]
								else:
									if(indexPositionList[stemmedWord].get(docno, None) is None):	
										indexPositionList[stemmedWord][docno] = [str(wordPosition)]
									else:
										indexPositionList[stemmedWord][docno].append(str(wordPosition))						
	documentPerFile.close()								
	documentAbstract.close()
	#sys.exit(0) # Pour tester le tf idf
	indexedFile = open("output/indexedStem.txt","w")
	for stem, listDoc in docNoList.iteritems():
		indexedFile.write(stem + " | " + " ".join(listDoc) + "\n")
	indexedFile.close()

	indexPositionListToWrite = collections.OrderedDict()
	indexPosition = open("output/indexPosition.txt","w")
	for stem, docnoList in indexPositionList.iteritems():
		indexPositionListToWrite[stem] = []
		for docno, positions in docnoList.iteritems():
			for position in positions:
				indexPositionListToWrite[stem].append(docno + ":" + position)
		indexPosition.write(stem + " | " + " ".join(indexPositionListToWrite[stem]) + "\n")

	indexPosition.close()

	print "nombre stems = " + str(len(docNoList))
	#sys.exit(0) # On termine après le premier fichier