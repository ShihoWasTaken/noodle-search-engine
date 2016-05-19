#!/usr/bin/env python
# -*- coding: utf-8 -*-

#########################################################################################
#																						#
#										 Imports										#
#																						#
#########################################################################################

import os
import sys
import PorterStemmer

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
	#	sys.argv[1] = chaîne contenant la requête de l'utilisateur
	result = list() #	liste des documents contenant au moins un mot de la requête utilisateur
	#	On a besoin d'avoir accès aux stopwords et au dictionnaire
	for word in sys.argv[1].split(' '):
		if word not in stopwords:
			alteredWord = PorterStemmer.stem(word, 0,len(word)-1)
			values = docNoList.get(alteredWord, None)
			if values != None:
				result.append(values)
	return result