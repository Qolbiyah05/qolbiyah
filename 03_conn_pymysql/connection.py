import pymysql

def get_db ():
    connection = pymysql.connect(
        host = "localhost",
        port =3306,
        user = "root",
        password = "root",
        database = "pbo2",
        cursorclass=pymysql.cursors.DictCursor
    )
    return connection