# import mysql.connector

# mydb = mysql.connector.connect(
#   host="localhost",
#   user="root",
#   passwd="N@edy1n.C0m_D",
#   database="ni_screening_db"
# )

# mycursor = mydb.cursor()

# mycursor.execute("SELECT * FROM tbl_jobdesc")

# myresult = mycursor.fetchall()

# for x in myresult:
#   print(x)
from sqlalchemy import create_engine
import pymysql
import pandas as pd
db_connection_str = 'mysql+pymysql://root:N@edy1n.C0m_D@localhost/ni_screening_db'
db_connection = create_engine(db_connection_str)

df = pd.read_sql('SELECT * FROM tbl_jobdesc', con=db_connection)