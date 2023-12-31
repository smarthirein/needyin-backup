#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Apr  3 12:25:07 2020

@author: smarthirein
"""


'''
Author:Needyin Technology
Date:--/--/----
'''
#----------------Import Lib-----------------------------------------
import os
import json
import io
import spacy
import docx2txt
import constants as cs
from pdfminer.converter import TextConverter
from pdfminer.pdfinterp import PDFPageInterpreter
from pdfminer.pdfinterp import PDFResourceManager
from pdfminer.layout import LAParams
from pdfminer.pdfpage import PDFPage
from pdfminer.pdfparser import PDFSyntaxError
import glob
import PyPDF2
#from docx import Document


def extract_text_from_pdf(pdf_path):
    '''
    Helper function to extract the plain text from .pdf files

    :param pdf_path: path to PDF file to be extracted (remote or local)
    :return: iterator of string of extracted text
    '''
    if not isinstance(pdf_path, io.BytesIO):
        # extract text from local pdf file
        with open(pdf_path, 'rb') as fh:
            try:
                for page in PDFPage.get_pages(
                                fh,
                                caching=True,
                                check_extractable=True
                ):
                    resource_manager = PDFResourceManager()
                    fake_file_handle = io.StringIO()
                    converter = TextConverter(
                        resource_manager,
                        fake_file_handle,
                        #codec='utf-8',
                        laparams=LAParams()
                    )
                    page_interpreter = PDFPageInterpreter(
                        resource_manager,
                        converter
                    )
                    page_interpreter.process_page(page)

                    text = fake_file_handle.getvalue()
                    yield text

                    # close open handles
                    converter.close()
                    fake_file_handle.close()
            except PDFSyntaxError:
                return
    

def extract_text_from_docx(doc_path):
    '''
    Helper function to extract plain text from .docx files

    :param doc_path: path to .docx file to be extracted
    :return: string of extracted text
    '''
    try:
        temp = docx2txt.process(doc_path)
        text = [line.replace('\t', ' ') for line in temp.split('\n') if line]
        return ' '.join(text)
    except KeyError:
        return ' '
    
def extract_text_from_doc(doc_path):
    '''
    Helper function to extract plain text from .doc files

    :param doc_path: path to .doc file to be extracted
    :return: string of extracted text
    '''
    try:
        try:
            import textract
        except ImportError:
            return ' '
        temp = textract.process(doc_path).decode('utf-8')
        text = [line.replace('\t', ' ') for line in temp.split('\n') if line]
        return ' '.join(text)
    except KeyError:
        return ' '
def extract_text(file,extension):
            
        '''
        Wrapper function to detect the file extension and call text
        extraction function accordingly
    
        :param file_path: path of file of which text is to be extracted
        :param extension: extension of file `file_name`
        '''
        text = ''
        if extension == '.pdf':
            for page in extract_text_from_pdf(file):
                text += ' ' + page
        elif extension == '.docx':
            text = extract_text_from_docx(file)
        elif extension == '.doc':
            text = extract_text_from_doc(file)
        return text
    
def extract_entity_sections_professional(text):
    '''
    Helper function to extract all the raw text from sections of resume specifically for 
    professionals

    :param text: Raw text of resume
    :return: dictionary of entities
    '''
    text_split = [i.strip() for i in text.split('\n')]
    entities = {}
    key = False
    for phrase in text_split:
        if len(phrase) == 1:
            p_key = phrase
        else:
            p_key = set(phrase.lower().split()) & set(cs.RESUME_SECTIONS_PROFESSIONAL)
        try:
            p_key = list(p_key)[0]
        except IndexError:
            pass
        if p_key in cs.RESUME_SECTIONS_PROFESSIONAL:
            entities[p_key] = []
            key = p_key
        elif key and phrase.strip():
            entities[key].append(phrase)
    return entities


#-------------------Call_Main_Function---------------------------------
if __name__ == "__main__": 

    ##-----Load The Spacy Model Path---------------------------------------
    nlp = spacy.load(os.path.dirname(os.path.abspath(__file__)))

##----full path of directory-------------------------------------------
    try:
        FolderPath = os.path.join('/home/smarthirein/Documents/Resume_rework_Project-/demo_resume_parsing/Resume-Testing')
    ####
        if not os.path.exists(FolderPath):
            print("File does not exist?")
    except FileNotFoundError:
        print("File Success..")
    except:
        print("Try Latter Server Not Responding")
#-------Search the file's from folder(path)---------------------------        
        
    def MultiFileEx():
    # Glob module matches certain patterns
        doc_files = glob.glob(FolderPath+"/*.doc")
        docx_files = glob.glob(FolderPath+"/*.docx")
        pdf_files = glob.glob(FolderPath+"/*.pdf")
        rtf_files = glob.glob(FolderPath+"/*.rtf")
        text_files = glob.glob(FolderPath+"/*.txt")

        files = set(doc_files + docx_files + pdf_files + rtf_files + text_files)
        files = list(files)
        print ("%d files identified" %len(files))
        print()
        for file in files:
            print("Reading File %s"%file)
            if file.endswith('.pdf'):
                fileReader = PyPDF2.PdfFileReader(open(file, "rb"))
                count = fileReader.numPages
                print("PDF Pages Count Form Each File",count)
                print()
#-##------------------------------------------------------------------
        text = ' '
        master_entities =[]
        vNewFile = file.rstrip(".pdf")+"json"
        vBasePath = os.path.join('/home/smarthirein/Documents/Resume_rework_Project-/demo_resume_parsing/Resume-Testing')
#vBasePath = os.path.join(os.environ.get('demo_resume_parsing')
##########
        if not os.path.exists(vBasePath):
            os.makedirs(vBasePath)
    ##########
        vNewFilePath = os.path.join(vBasePath,vNewFile)
        print("vNewFilePath = ",vNewFilePath)           
        
###### ----Open Function---####----------------------------------------
        fwrite = open(vNewFilePath,"w")
        _fileObj = {}# Create JSON file object
            #######
        text_raw=extract_text_from_doc(file)  
        
        # print(text_raw)
        text =' '.join(text_raw.split()) #Split Raw_Data(text_data)
            # print(text)
        entity= extract_entity_sections_professional(text_raw)# Acesss tokenization(POS,NER,ReXp,etc.)section key,
            # print(entity)
        doc2 =nlp(text_raw)# call nlp method()               
        entities = {}
        for ent in doc2.ents:
            if ent.label_ not in entities.keys():
                entities[ent.label_] = [ent.text]
            else:                                
                entities[ent.label_].append(ent.text)
                for key in entities.keys():
                    entities[key] = list(set(entities[key]))
                    master_entities=entities
                # print(master_entities)
                      
 #####--Check Data redundancy---------------------------------------- 
        _fileObj.update(master_entities)
#-------------------------------------------------- 
        result = json.dumps({"DataJson":[_fileObj]})
#            print(result)
        fwrite.write(result)
####--Close Function---
#-------------------------------------------------     
        fwrite.close()
            
    MultiFileEx()