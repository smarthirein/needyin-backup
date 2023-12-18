'''
Author:-Santosh Maher-
Date:--/--/----

import pdftotext

# Load your PDF
with open("/home/smarthirein/Desktop/Sample_JD/32.pdf", "rb") as f:
    pdf = pdftotext.PDF(f)
    
    # Read all the text into one string
print("\n\n".join(pdf))
'''
#----------------Import Lib-----------------------------------------
import glob
import PyPDF2
import os
import json
#import io
import spacy
import constants as cs

def extract_entity_sections_professional(text):
    '''
    Helper function to extract all the raw text from sections of resume specifically for 
    professionals

    :param text: Raw text of resume
    :return: dictionary of entities
    '''
    text_split = [i.strip() for i in text.split('\n\n')]
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
    FolderPath = os.path.join('/home/smarthirein/Documents/Resume_rework_Project-/demo_resume_parsing/Resume-Testing')
    for file in glob.glob(FolderPath + "/*.pdf"):
        #print(file)
        if file.endswith('.pdf') or file.endswith('.txt') or file.endswith('.docx') or file.endswith('.doc'):
            fileReader = PyPDF2.PdfFileReader(open(file, "rb"))
            count = fileReader.numPages
	##------------------------------------------------------------------
            text = ' '
            master_entities =[]
            vNewFile = file.rstrip(".pdf")+".json"
            vBasePath = os.path.join('/home/smarthirein/Documents/Resume_rework_Project-/demo_resume_parsing/Resume-Testing')
            #vBasePath = os.path.join(os.environ.get('demo_resume_parsing')
            ##########
            if not os.path.exists(vBasePath):
                 os.makedirs(vBasePath)
            ##########
            vNewFilePath = os.path.join(vBasePath,vNewFile)
            print("vNewFilePath = ",vNewFilePath)
	    ## ----Open Function---####--
            fwrite = open(vNewFilePath,"w")
            _fileObj = {}# file object
            for i in range(count):# Acesss All Page_wise
                pageObj = fileReader.getPage(i)# Read Page_wise
                text_raw = pageObj.extractText() # Extract text from each page
                text =' '.join(text_raw.split()) #Split Raw_Data(text_data)
		###--Print PageWise Extraction----------
                print()
                print(text_raw)
                print("This is page:-----------------------------------|" + str(i))
                print()
                entity   = extract_entity_sections_professional(text_raw)# Acesss tokenization(POS,NER,ReXp,etec.)section key,
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
     #####--Mearge-and_Data redundancy---------------------------------------- 
                    _fileObj.update(master_entities)
     #### Dump_Obj___JSON  -------------------------------------------------- 
                result = json.dumps({"DataJson":[_fileObj]})
                print(result)
            fwrite.write(result)
    ####--Close Function---
    #-------------------------------------------------     
            fwrite.close()

