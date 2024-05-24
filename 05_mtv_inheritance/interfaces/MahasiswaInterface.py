from abc import ABC, abstractmethod

class MahasiswaInterface(ABC):
    @abstractmethod
    def all(self):
        pass

    @abstractmethod
    def store(self, mahasiswa_obj):
        pass
    
    @abstractmethod
    def find(self, mahasiswa_id):
        pass

    @abstractmethod
    def update(self, mahasiswa_id, new_mahasiswa_obj):
        pass
    
    @abstractmethod
    def delete(self, mahasiswa_id):
        pass
