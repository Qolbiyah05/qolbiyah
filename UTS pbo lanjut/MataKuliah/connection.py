import pymysql

def get_db ():
    connection = pymysql.connect(
        host = "localhost",
        port =3306,
        user = "root",
        password = "root",
        database = "akademik",
        cursorclass=pymysql.cursors.DictCursor
    )
    return connection