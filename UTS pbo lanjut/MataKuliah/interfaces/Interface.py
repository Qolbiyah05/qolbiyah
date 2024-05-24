from abc import ABC, abstractmethod

class Mata_KuliahInterface(ABC):
    @abstractmethod
    def all(self):
        pass

    @abstractmethod
    def store(self, mata_kuliah_obj):
        pass
    
    @abstractmethod
    def find(self, mata_kuliah_id):
        pass

    @abstractmethod
    def update(self, mata_kuliah_id, new_mata_kuliah_obj):
        pass
    
    @abstractmethod
    def delete(self, mata_kuliah_id):
        pass
