#!/usr/bin/env python
# -*- coding: utf-8 -*-

#########################################################################################
#																						#
#										 Imports										#
#																						#
#########################################################################################

import xml.etree.ElementTree
import os
import sys
import collections
import re

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

def indexingStopwords():
	fichier = open('stopwords.txt', 'r')
	stopwords = [word.strip('\n\r') for word in fichier.readlines()]
	# print stopwords
	fichier.close()
	return stopwords

def getStemOrderedDict():
	stem = collections.OrderedDict()
	with open('txt/stem.txt', 'r') as stemFile:
		for line in stemFile:
			words = line.split(' | ')
			value = words[0]
			keys = words[1].strip().split(' ')
			for key in keys:
				stem[key] = value
	# Affichage de la table de hash
	#for key, value in stem.items():
	#	print "stem[" + key +"] = " + value 
	return stem

#########################################################################################
#																						#
#									  	   Main			 								#
#																						#
#########################################################################################

if __name__ == '__main__':
	stem = getStemOrderedDict()
	# Pour chaque fichier du dossier data on effectuera les traitements qui suivent
	for fichier in os.listdir('data/'):
		root = xml.etree.ElementTree.parse('data/' + fichier).getroot()
		for childs in root:
			docno = None
			for child in childs:
				if (child.tag.upper() == "DOCNO"):
					docno = child.text
				elif (child.tag.upper() == "TEXT"):
					words = re.split(' |\n', child.text)
					for word in words:
						word = word.strip(".,")
						if(docNoList.get(word, None) is None):		# On teste si la clé du dictionnaire est vide
							print "On crée la clé " + word + " avec le num " + docno
							docNoList[stem.get(word, word)] = [docno]					# On crée une liste contenant le docno actuel
						else:										# Si elle n'est pas vide
							print "On ajoute le num " + docno + " à docNoList[" + word + "]"
							docNoList[word].append(docno)			# On ajoute le docno à la liste
		sys.exit(0) # On termine après le premier fichier