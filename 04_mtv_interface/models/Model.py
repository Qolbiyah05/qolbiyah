from connection import get_db
from interfaces.Interface import MahasiswaInterface

class MahasiswaModel(MahasiswaInterface):
    def all(self):
        connection = get_db()
        cursor = connection.cursor()
        
        query = "SELECT * FROM mahasiswa"
        cursor.execute(query)
        result = cursor.fetchall()

        cursor.close()
        connection.close()

        return result
    
    def find(self, mahasiswa_id):
        connection = get_db()
        cursor = connection.cursor()

        query = "SELECT * FROM mahasiswa WHERE id = %s LIMIT 1"
        cursor.execute(query, (mahasiswa_id,))
        result = cursor.fetchone()

        cursor.close()
        connection.close()

        return result
    
    def store(self, mahasiswa_obj):
        connection = get_db()
        cursor = connection.cursor()

        query = "INSERT INTO mahasiswa (nim, nama) VALUES (%s, %s)"
        try:
            cursor.execute(query, (mahasiswa_obj.nim, mahasiswa_obj.nama))
            connection.commit()
        except Exception as e:
            connection.rollback()
            raise e
        finally:
            cursor.close()
            connection.close()
        
    def update(self, mahasiswa_id, mahasiswa_obj):
        connection = get_db()
        cursor = connection.cursor()

        query = "UPDATE mahasiswa SET nim = %s, nama = %s WHERE id = %s"
        try:
            cursor.execute(query, (mahasiswa_obj.nim, mahasiswa_obj.nama, mahasiswa_id))
            connection.commit()
        except Exception as e:
            connection.rollback()
            raise e
        finally:
            cursor.close()
            connection.close()

    def delete(self, mahasiswa_id):
        connection = get_db()
        cursor = connection.cursor()

        query = "DELETE FROM mahasiswa WHERE id = %s"
        try:
            cursor.execute(query, (mahasiswa_id,))
            connection.commit()
        except Exception as e:
            connection.rollback()
            raise e
        finally:
            cursor.close()
            connection.close()
