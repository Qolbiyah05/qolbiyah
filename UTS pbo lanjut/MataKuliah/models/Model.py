from connection import get_db
from coremodels.CoreModelMata_Kuliah import CoreModelMata_Kuliah

class MataKuliahModel(CoreModelMata_Kuliah):
    def __init__(self):
        self.table_name = "mata_kuliah"
        self.table_id = "id"
        self.id = ""
        self.mata_kuliah = None
        self.nama_dosen = None
        self.jumlah_sks = None
