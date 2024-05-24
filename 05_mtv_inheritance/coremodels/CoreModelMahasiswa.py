# core/CoreModelMahasiswa.py
from connection import get_db
from interfaces.MahasiswaInterface import *

class CoreModelMahasiswa(MahasiswaInterface):
    def __init__(self):
        pass

    def all(self):
        connection = get_db()
        cursor = connection.cursor()    
        query = f"SELECT * FROM {self.table_name};"
        cursor.execute(query)
        result = cursor.fetchall()
        cursor.close()
        connection.close()

        return result
    
    def find(self, mahasiswa_id):
        connection = get_db()
        cursor = connection.cursor()
        query = f"SELECT * FROM {self.table_name} WHERE {self.table_id} = %s LIMIT 1;"
        cursor.execute(query, (mahasiswa_id,))
        result = cursor.fetchone()

        cursor.close()
        connection.close()

        return result
    
    def store(self, mahasiswa_obj):
        connection = get_db()
        cursor = connection.cursor()
        set_columns = []
        set_placeholders = []
        set_values = []

        for key, value in vars(mahasiswa_obj).items():
            if key not in ['table_name', 'table_id']:
                set_columns.append(key)
                set_placeholders.append('%s')
                set_values.append(value)

        columns_string = ', '.join(set_columns)
        placeholders_string = ', '.join(set_placeholders)

        query = f"INSERT INTO {self.table_name} ({columns_string}) VALUES ({placeholders_string});"

        cursor.execute(query, tuple(set_values))
        
        connection.commit()
        cursor.close()
        connection.close()
        
    def update(self, mahasiswa_id, mahasiswa_obj):
        connection = get_db()
        cursor = connection.cursor()

        set_columns = []
        set_values = []

        for key, value in vars(mahasiswa_obj).items():
            if key not in ['table_name', 'table_id']:
                column = f"{key} = %s"
                set_columns.append(column)
                set_values.append(value)

        set_column_string = ', '.join(set_columns)
        query = f"UPDATE {self.table_name} SET {set_column_string} WHERE {self.table_id} = %s;"
        set_values.append(mahasiswa_id)
        cursor.execute(query, tuple(set_values))

        connection.commit()
        cursor.close()
        connection.close()

    def delete(self, mahasiswa_id):
        connection = get_db()
        cursor = connection.cursor()

        query = f"DELETE FROM {self.table_name} WHERE {self.table_id} = %s;"
        
        cursor.execute(query, (mahasiswa_id,))
        connection.commit()
        cursor.close()
        connection.close()
