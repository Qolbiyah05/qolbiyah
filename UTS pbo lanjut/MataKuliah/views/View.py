from flask import render_template, request, redirect
from models.Model import MataKuliahModel

class MataKuliahView:

    @staticmethod
    def index():
        data = MataKuliahModel().all()
        return render_template('matakuliah_index.html', data=data)
    
    @staticmethod
    def create():
        return render_template('matakuliah_create.html')
    
    @staticmethod
    def store():
        matakuliah_obj = MataKuliahModel()
        post = request.form
        matakuliah_obj.mata_kuliah = post['mata_kuliah']
        matakuliah_obj.nama_dosen = post['nama_dosen']
        matakuliah_obj.jumlah_sks = post['jumlah_sks']
        MataKuliahModel().store(matakuliah_obj)
        return redirect('/matakuliah')

    @staticmethod
    def edit(matakuliah_id):
        obj = MataKuliahModel().find(matakuliah_id)
        if obj:
            return render_template('matakuliah_edit.html', obj=obj)
        else:
            return "MataKuliah not found", 404
    
    @staticmethod
    def update(matakuliah_id):
        data = MataKuliahModel().find(matakuliah_id)
        if data:
            post = request.form
            matakuliah_obj = MataKuliahModel()
            matakuliah_obj.mata_kuliah = post['mata_kuliah']
            matakuliah_obj.nama_dosen = post['nama_dosen']
            matakuliah_obj.jumlah_sks = post['jumlah_sks']
            MataKuliahModel().update(matakuliah_id, matakuliah_obj)
            return redirect('/matakuliah')
        else:
            return "MataKuliah not found", 404
        
    @staticmethod
    def delete(matakuliah_id):
        data = MataKuliahModel().find(matakuliah_id)
        if data:
            MataKuliahModel().delete(matakuliah_id)
            return redirect('/matakuliah')
        else:
            return "MataKuliah not found", 404
