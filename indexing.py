#!/usr/bin/env python
# -*- coding: utf-8 -*-

#########################################################################################
#																						#
#										 Imports										#
#																						#
#########################################################################################

import os
import sys
import collections
import re
from nltk import PorterStemmer
from lxml import etree


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

#########################################################################################
#																						#
#									  	   Main			 								#
#																						#
#########################################################################################

if __name__ == '__main__':
	stem = getStemOrderedDict()
	stopwords = getStopwords()
	parser = etree.XMLParser(recover=True)
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
				elif (child.tag.upper() == "TEXT"):
					if child.text is not None:
						words = re.split(' |\n|\t', child.text)
						for word in words:
							word = trim(word)
							stemmedWord = stemmer(word)
							if word not in stopwords:
								if(docNoList.get(stemmedWord, None) is None):		# On teste si la clé du dictionnaire est vide
									#print "On crée la clé " + stemmer(word) + " avec le num " + docno
									docNoList[stemmedWord] = [docno]					# On crée une liste contenant le docno actuel
								else:										# Si elle n'est pas vide
									#print "On ajoute le num " + docno + " à docNoList[" + stemmer(word) + "]"
									docNoList[stemmedWord].append(docno)			# On ajoute le docno à la liste
	indexedFile = open("output/indexedStem.txt","w")
	for stem, listDoc in docNoList.iteritems():
		indexedFile.write(stem + " | " + " ".join(listDoc) + "\n")
	indexedFile.close()
	print "nombre stems = " + str(len(docNoList))
			#sys.exit(0) # On termine après le premier fichier