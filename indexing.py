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

#########################################################################################
#																						#
#									  	   Main			 								#
#																						#
#########################################################################################

if __name__ == '__main__':
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
						if(docNoList.get(word, None) is None):		# On teste si la clé du dictionnaire est vide
							print "On crée la clé " + word + " avec le num " + docno
							docNoList[word] = [docno]					# On crée une liste contenant le docno actuel
						else:										# Si elle n'est pas vide
							print "On ajoute le num " + docno + " à docNoList[" + word + "]"
							docNoList[word].append(docno)			# On ajoute le docno à la liste
		sys.exit(0) # On termine après le premier fichier