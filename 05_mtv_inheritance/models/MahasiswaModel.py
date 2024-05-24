from connection import get_db
from coremodels.CoreModelMahasiswa import CoreModelMahasiswa

class MahasiswaModel(CoreModelMahasiswa):
    def __init__(self):
        self.table_name = "mahasiswa"
        self.table_id = "id"