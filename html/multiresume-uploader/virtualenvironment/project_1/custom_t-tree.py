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
import os
import json
import spacy
import docx2txt
import constants as cs
import glob

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

def extract_text_from_docx(doc_path):
    '''
co    Helper function to extract plain text from .docx files

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

#-------------------Call_Main_Function---------------------------------
if __name__ == "__main__": 

    ##-----Load The Spacy Model Path---------------------------------------
    nlp = spacy.load(os.path.dirname(os.path.abspath(__file__)))

##----full path of directory-------------------------------------------
    try:
        FolderPath = os.path.join('/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/100-Sample-Resumes')
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

        files = set(doc_files + docx_files + pdf_files + rtf_files + text_files)
        files = list(files)
        # print ("%d files identified" %len(files))
        # print()
        for file in files:
            print("Reading File %s"%file)
            ####
            if file.endswith('.docx'):
                text = docx2txt.process(file)
            elif file.endswith('.doc'):
                # converting .doc to .docx
                doc_files=FolderPath + file + 'x'
        ###       
            text = ' '
            master_entities =[]
            vNewFile = file.rstrip(".doc/docx/pdf")+".json"
            vBasePath = os.path.join('/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/100-Sample-Resumes')
    #vBasePath = os.path.join(os.environ.get('demo_resume_parsing')
    ##########
            if not os.path.exists(vBasePath):
                os.makedirs(vBasePath)
    ##########
            vNewFilePath = os.path.join(vBasePath,vNewFile)
            # print("vNewFilePath = ",vNewFilePath)           
            
    ###### ----Open Function---####----------------------------------------
            fwrite = open(vNewFilePath,"w")
            _fileObj = {}# Create JSON file object
            #######
            text_raw=extract_text_from_doc(file)  #--having Isues
            #text_raw=extract_text_from_docx(file)
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
            

            basic_details = {}
            Summary={}
            Current_company={}
            PREVIOUS_COMPANY={}
            Organization={}
            DESIGNATION={}
            Professional_detail={}
            # ROLE={}
            Education_detail = {}
            Professional_detail  = {}
            Project_Work={}
            Project={}
            # Project_disc={}
            # Responsibilities={}
            Skills={}
            Frameworks={}
            # Programming_Language={}
            IDE={}
            Domain={}
            Tools={}
            Operating_System={}
            Awards={}
            Certificates={}
            Location={}
            Other={}
            
            

            if 'NAME' in master_entities: 
                basic_details['NAME'] = master_entities['NAME'][0]
            else:
                basic_details['NAME'] = "NULL"

            if 'EMAIL' in master_entities: 
                basic_details['EMAIL'] = master_entities['EMAIL'][0]
            else:
                basic_details['EMAIL'] = "NULL"

            if 'PHONE NUMBER' in master_entities: 
                basic_details['PHONE NUMBER'] = master_entities['PHONE NUMBER'][0]
            else:
                basic_details['PHONE NUMBER'] = "NULL"

            if 'DOB' in master_entities: 
                basic_details['DOB'] = master_entities['DOB'][0]
            else:
                basic_details['DOB'] = "NULL"
            
            #Summary
                
            if 'Profile Summary' in master_entities: 
                Summary['Summary'] = master_entities['Profile Summary'][0]
            else:
                Summary['Summary'] = "NULL"
            
            #Current_company
            if 'CURRENT COMPANY WISE DURATION' in master_entities: 
                Current_company['CURRENT COMPANY WISE DURATION'] = master_entities['CURRENT COMPANY WISE DURATION'][0]
            else:
                Current_company['CURRENT COMPANY WISE DURATION'] = "NULL"    
            
            #PREVIOUS COMPANY
            if 'PREVIOUS COMPANY' in master_entities: 
                PREVIOUS_COMPANY['PREVIOUS COMPANY'] = master_entities['PREVIOUS COMPANY'][0]
            else:
                PREVIOUS_COMPANY['PREVIOUS COMPANY'] = "NULL"
            
            
            #Organization:
            if 'Organization' in master_entities: 
                Organization['Organization'] = master_entities['Organization'][0]
            else:
                Organization['Organization'] = "NULL"
           
            #DESIGNATION
            if 'DESIGNATION' in master_entities: 
                DESIGNATION['DESIGNATION'] = master_entities['DESIGNATION'][0]
            else:
                DESIGNATION['DESIGNATION'] = "NULL"    
                
            #RoLE:
            if 'ROLE' in master_entities: 
                DESIGNATION['ROLE'] = master_entities['ROLE'][0]
            else:
                DESIGNATION['ROLE'] = "NULL"    
                    
                
            # PROFESSIONAL EXPERIENCE
            if 'PROFESSIONAL EXPERIENCE' in master_entities: 
                Professional_detail = master_entities['PROFESSIONAL EXPERIENCE'][0]
            else:
                Professional_detail['PROFESSIONAL EXPERIENCE'] = "NULL"
            
                if 'WORK EXPERIENCE' in master_entities: 
                    Professional_detail['WORK EXPERIENCE'] = master_entities['WORK EXPERIENCE'][0]
                else:
                    Professional_detail['WORK EXPERIENCE'] = "NULL"
    
                    if 'Total Experience' in master_entities: 
                        Professional_detail['Total Experience'] = master_entities['RELEVENT EXPERIENCE'][0]
                    else:
                        Professional_detail['Total Experience'] = "NULL"
                   
                    if 'Relevent Experience' in master_entities: 
                        Professional_detail['Relevent Experience'] = master_entities['RELEVENT EXPERIENCE'][0]
                    else:
                        Professional_detail['Relevent Experience'] = "NULL"
                    
                    
                        
            # EDUCATION
            if 'EDUCATIONAL QUALIFICATION' in master_entities: 
                Education_detail = master_entities['EDUCATIONAL QUALIFICATION'][0]
            else:
                Education_detail['EDUCATION']= "NULL"
            
                if 'MASTER' in master_entities: 
                    Education_detail = master_entities['MASTER'][0]
                else:
                    Education_detail['MASTER_DEGREE']="NULL"
                    
                if 'BACHELOR' in master_entities: 
                    Education_detail = master_entities['BACHELOR'][0]
                else:
                    Education_detail['BACHELOR_DEGREE'] = "NULL"
                    
                if '10th' in master_entities: 
                    Education_detail = master_entities['10th'][0]
                else:
                    Education_detail['10th'] = "NULL"
                    
                if '12th' in master_entities: 
                    Education_detail = master_entities['12th'][0]
                else:
                    Education_detail['12th'] = "NULL"
                
            # Project_Details
            # PROJECTS
            if 'Project' in master_entities: 
               Project = master_entities['Project'][0]
            else:
                Project['PROJECTS']= "NULL"
                
            
                if 'Project Title' in master_entities: 
                    Project = master_entities['Project Title'][0]
                else:
                    Project['Project Title']= "NULL"
                    
                if 'PROJECT DESCRIPTION' in master_entities: 
                    Project = master_entities['PROJECT DESCRIPTION'][0]
                else:
                    Project['PROJECT DESCRIPTION']= "NULL"
                
                if 'Responsibilities' in master_entities: 
                    Project = master_entities['Responsibilities'][0]
                else:
                    Project['Responsibilities'] = "NULL"
                           
                   #ROLES and RESPONSIBILITIES
                    if 'ROLES and RESPONSIBILITIES' in master_entities: 
                        Project = master_entities['ROLES and RESPONSIBILITIES'][0]
                    else:
                        Project['ROLES and RESPONSIBILITIES'] = "NULL"
                        
                    
                    if 'Project Name' in master_entities: 
                        Project = master_entities['Project Name'][0]
                    else:
                        Project['Project Name']= "NULL"
                        
                        if 'Duration' in master_entities: 
                              Project = master_entities['DURATION'][0]
                        else:
                              Project['DURATION'] = "NULL"
                             
                        if 'Team Size' in master_entities: 
                            Project = master_entities['Team Size'][0]
                        else:
                              Project['Team Size'] = "NULL"
                            
                            
                        if 'Client' in master_entities: 
                            Project = master_entities['Client'][0]
                        else:
                            Project['Client']="NULL"                       
                                        
                        
            
                
            if 'Contribution' in master_entities: 
                Project_Work = master_entities['Contribution'][0]
            else:
                Project_Work['Contribution'] = "NULL"
                
            #Skill's
            if 'DATABASE' in master_entities: 
                Skills = master_entities['DATABASE'][0]
            else:
                Skills['DATABASE'] = "NULL"
                                      
                if 'Programming_Language' in master_entities:
                    Skills=master_entities['Programming_Language'][0]
                else:
                    Skills['Programming_Language']="NULE"
                    
                    if 'TECHNICAL SKILLS' in master_entities:
                        Skills=master_entities['TECHNICAL SKILLS'][0]
                    else:
                        Skills['TECHNICAL SKILLS']="NULE"
                        
                    
                        if 'Relevent_Skills' in master_entities: 
                            Skills = master_entities['Relevent_Skills'][0]
                        else:
                            Skills['Relevent_Skills'] = "NULL"
                        
                        if 'Preferred_Skills' in master_entities: 
                            Skills = master_entities['Preferred_Skills'][0]
                        else:
                            Skills['Preferred_Skills'] = "NULL"
                       
                        if 'IDE' in master_entities: 
                            Skills = master_entities['IDE'][0]
                        else:
                            Skills['IDE'] = "NULL"
                    
                    if 'Frameworks' in master_entities: 
                         Frameworks = master_entities['Frameworks'][0]
                    else:
                        Frameworks['Frameworks'] = "NULL"
                            
                    #Tools:
                    if 'Tools' in master_entities: 
                        Tools = master_entities['Tools'][0]
                    else:
                        Tools['Tools'] = "NULL"
                            
                    #Operating System
                    if 'Operating System' in master_entities: 
                        Operating_System = master_entities['Operating System'][0]
                    else:
                        Operating_System['OS'] = "NULL"
            
                            
             #IDE
            if 'IDE' in master_entities: 
                IDE = master_entities['IDE'][0]
            else:
                IDE['IDE'] = "NULL"
            
            #Domain
            if 'Domain' in master_entities: 
                Domain = master_entities['Domain'][0]
            else:
                Domain['Domain'] = "NULL"
            
            # #Tools:
            # if 'Tools' in master_entities: 
            #     Tools = master_entities['Tools'][0]
            # else:
            #     Tools['Tools'] = "NULL"
            
            # #Operating System
            # if 'Operating System' in master_entities: 
            #     Operating_System = master_entities['Operating System'][0]
            # else:
            #     Operating_System['Operating System'] = "NULL"
            
            #Award:
            if 'Awards' in master_entities: 
                Awards = master_entities['Awards'][0]
            else:
                Awards['Awards'] = "NULL"
             
            #Certificates:    
            if 'CERTIFICATIONS' in master_entities: 
                Certificates = master_entities['CERTIFICATIONS'][0]
            else:
                Certificates['Certificates'] = "NULL"
                
            #OTHER:
            if 'Other' in master_entities: 
                Other = master_entities['Other'][0]
            else:
                Other['Other'] = "NULL"   
                
            #Location 
            if 'LOCATION' in master_entities: 
                Location['LOCATION'] = master_entities['LOCATION'][0]
            else:
                Location['LOCATION'] = "NULL"
                
            #JSON:Tree
            summary = {}
            summary['Summary']=Summary
            summary['General_info'] = basic_details
            summary['Current_company']=Current_company
            summary['PREVIOUS COMPANY']=PREVIOUS_COMPANY
            summary['Organization']=Organization
            summary['Designation']=DESIGNATION
            # summary['ROLE']=ROLE
            summary['Education_detail'] = Education_detail
            summary['Professional_detail'] = Professional_detail
            summary['Project_Work'] = Project_Work
            # summary['Project_disc']=Project_disc
            summary['Project']=Project
            # summary['Responsibilities']=Responsibilities
            summary['Tools']=Tools
            summary['Awards'] = Awards
            summary['Certificates'] = Certificates
            summary['Other']=Other
            summary['Skills']=Skills
            summary['Frameworks']=Frameworks
            # summary['Programming_Language']=Programming_Language
            # summary['IDE']=IDE
            summary['Domain']=Domain
            summary['Operating System']=Operating_System
            summary['Location']=Location
            
            

            print(summary)



 #####--Check Data redundancy---------------------------------------- 
            _fileObj.update(summary)
#-------------------------------------------------- 
            result = json.dumps({"DataJson":[_fileObj]})
            # print(result)
            fwrite.write(result)
####--Close Function---
#-------------------------------------------------     
            fwrite.close()
    MultiFileEx()