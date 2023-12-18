'''Resume Parsing and Screening Code
Author:SmartHirein.Ai
Date:-25/02/20202 Imp Dependanci libray
#pip install textract
#pip install python=3.6
#pip install spacy=2.0.1
#sudo apt-get install antiword
#pip install python-docx
#sudo apt-get install python-dev libxml2-dev libxslt1-dev antiword unrtf poppler-utils pstotext tesseract-ocr flac ffmpeg lame libmad0 libsox-fmt-mp3 sox libjpeg-dev swig

'''
#----------------Import Lib-----------------------------------------
# import nltk
# nltk.download('punkt')
import os
import json
import spacy
import docx2txt

# import constants as cs
import glob

import textract
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
NAME_PATTERN      = [{'POS': 'PROPN'}, {'POS': 'PROPN'}]

# Education (Upper Case Mandatory)
EDUCATION         = [
                    'BE','B.E.', 'B.E', 'BS', 'B.S', 'ME', 'M.E', 'M.E.', 'MS', 'M.S', 'BTECH', 'MTECH', 
                    'SSC', 'HSC', 'CBSE', 'ICSE', 'X', 'XII','Intermediate','10th','12th','10+2'
                    ]

NOT_ALPHA_NUMERIC = r'[^a-zA-Z\d]'

NUMBER            = r'\d+'

# For finding date ranges
MONTHS_SHORT      = r'(jan)|(feb)|(mar)|(apr)|(may)|(jun)|(jul)|(aug)|(sep)|(oct)|(nov)|(dec)'
MONTHS_LONG       = r'(january)|(february)|(march)|(april)|(may)|(june)|(july)|(august)|(september)|(october)|(november)|(december)'
MONTH             = r'(' + MONTHS_SHORT + r'|' + MONTHS_LONG + r')'
YEAR              = r'(((20|19)(\d{2})))'

# STOPW ORDS         = set(stopwords.words('english'))

RESUME_SECTIONS_PROFESSIONAL = [
                    "name",
                     "email",
                     "phone number",
                     "designation",
                     "professional experience",
                     "relevant experience",
                     "work experience",
                     "job profile",
                     "summary",
                     "internship",
                     "freelancing",
                     "technical skills",
                     "non technical skills",
                     "key role",
                     "web technologies",
                     "technologies",
                     "frameworks",
                     "server",
                     "ide",
                     "environment",
                     "programming_language",
                     "networking",
                     "education",
                     "current company wise duration",
                     "previous company",
                     "role",
                     "location",
                     "projects",
                     "project name",
                     "project title",
                     "client",
                     "project description",
                     "project details",
                     "duration",
                     "hosting platforms",
                     "operating system",
                     "responsibilities",
                     "certification",
                     "achievement",
                     "contributions",
                     "database",
                     "tools",
                     "computer proficiency",
                     "other keywords",
                     "domain",
                     "testing tool",
                     "organization",
                     "soft_skills",
                     "product",
                     "team size"

                ]
##
# Define raw text from sections of resume
##
def extract_entity_sections_professional(text):
    '''
    Helper function to extract all the raw text from sections of resume specifically for 
    professionals

    :param text: Raw text of resume
    :return: dictionary of entities
    :for clening puppose used NLTK and Re.exp for pattern maching
    '''
    text_split = [i.strip() for i in text.split('\n')]
    entities = {} # Make Dict
    key = False
    for phrase in text_split:
        if len(phrase) == 1:
            p_key = phrase
        else:
            p_key = set(phrase.lower().split()) & set(RESUME_SECTIONS_PROFESSIONAL)
        try:
            p_key = list(p_key)[0]
        except IndexError:
            pass
        if p_key in RESUME_SECTIONS_PROFESSIONAL: 
            entities[p_key] = []
            key = p_key
        elif key and phrase.strip():
            entities[key].append(phrase)
    return entities

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


def extract_text_from_doc(docx_file):
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
        temp = textract.process(docx_file).decode('utf-8')
        text = [line.replace('\t', ' ') for line in temp.split('\n') if line]
        return ' '.join(text)
    except KeyError:
        return ' '
def read_pdf(pdf_f):
    try:
        temp1 = textract.process(pdf_f).decode('utf-8')
        #The word_tokenize() function will break our text phrases into individual words.
        tokens = word_tokenize(temp1)
        #We'll create a new list that contains punctuation we wish to clean.
        punctuations = ['(',')',';',':','[',']',',','|','.','#','>','']
        #We initialize the stopwords variable, which is a list of words like "The," "I," "and," etc. that don't hold much value as keywords.
        stop_words = stopwords.words('english')
        #We create a list comprehension that only returns a list of words that are NOT IN stop_words and NOT IN punctuations.
        keywords = [word for word in tokens if not word in stop_words and not word in punctuations]
        #text = [line.replace('\t', ' ') for line in temp1.split('\n') if line]
        if keywords != "":
            keywords = keywords
        #If the above returns as False, we run the OCR library textract to #convert scanned/image based PDF files into text.
        else:
            keywords = textract.process(fileurl, method='tesseract', language='eng')
        #Now we have a text variable that contains all the text derived from our PDF file. Type print(text) to see what it contains. It likely contains a lot of spaces, possibly junk such as '\n,' etc.
        #Now, we will clean our text variable and return it as a list of keywords.
        return ' '.join(keywords)
    except KeyError:
        return ' '
        # pdf=pdftotext.PDF(extract_text_from_doc).decode('utf-8')
        # text = [line.replace('\t', ' ') for line in pdf.split('\n') if line]
        # # Read all the text into one string
        # return '\n\n'.join(text)
    # except KeyError:
    #     return ' '

#-------------------Call_Main_Function---------------------------------
if __name__ == "__main__": 

    ##-----Load The Spacy Model Path---------------------------------------
    nlp = spacy.load(os.path.dirname(os.path.abspath(__file__)))

##----full path of directory-------------------------------------------
    try:
        FolderPath = os.path.join('/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads')
    ####
        if not os.path.exists(FolderPath):
            print("File does not exist?")
    except FileNotFoundError:
        print("File Success..")
    except:
        print("Try Latter Server Not Responding")
  
#-------Search the file's from folder(path)---------------------------        
   
    def MultiFileEx():
    # Glob module matches certain patterns extention
        doc_files = glob.glob(FolderPath+"/*.doc")
        docx_files = glob.glob(FolderPath+"/*.docx")
        pdf_files = glob.glob(FolderPath+"/*.pdf")
        rtf_files = glob.glob(FolderPath+"/*.rtf")
        text_files = glob.glob(FolderPath+"/*.txt")
        image_files =glob.glob(FolderPath+"/*.jpg")

        files = set(doc_files + docx_files + pdf_files + rtf_files + text_files+image_files)
        files = list(files)
        print ("%d files identified" %len(files))
        print()
        for file in files:
            print("Reading File %s"%file)
            ####
            if file.endswith('.docx'):
                docx_files = docx2txt.process(file)
            elif file.endswith('.doc'):
                  # converting .doc to .docx
                  doc_files=FolderPath + file + 'x' 
            elif file.endswith('.pdf'):
                  pdf_files=textract.process(file)
            elif file.endswith('.jpg'):
                  image_files=textract.process(file)
            elif file.endswith('.txt'):
                  text_files=textract.process(file)
            elif file.endswith('.rtf'):
                  rtf_files=textract.process(file)
                     
                     
                     
                     
        ###
            
            # text = ' '
            master_entities =[]
            vNewFile = file.rstrip(".doc/docx/pdf/txt/jpg/png/")+".json"
            vBasePath = os.path.join('/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads')
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
            # text_raw=extract_text_from_doc(file)  
            text_raw=read_pdf(file)
            # print(text_raw)
            #text =' '.join(text_raw.split()) #Split Raw_Data(text_data)
            # print(text)
            entity= extract_entity_sections_professional(text_raw)# Acesss tokenization(POS,NER,ReXp,etc.)section key,
            print(entity)
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
                    print(master_entities)
                      
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