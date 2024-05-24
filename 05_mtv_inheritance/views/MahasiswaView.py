from flask import render_template, request, redirect
from models.MahasiswaModel import MahasiswaModel

class MahasiswaView:

    @staticmethod
    def index():
        data = MahasiswaModel().all()
        return render_template('mahasiswa_index.html', data=data)
    
    @staticmethod
    def create():
        return render_template('mahasiswa_create.html')
    
    @staticmethod
    def store():
        mahasiswa_obj = MahasiswaModel()
        post = request.form
        mahasiswa_obj.nidn = post['nidn']
        mahasiswa_obj.nama = post['nama']
        mahasiswa_obj.prodi = post['prodi']
        MahasiswaModel().store(mahasiswa_obj)
        return redirect('/mahasiswa')

    @staticmethod
    def edit(mahasiswa_id):
        obj = MahasiswaModel().find(mahasiswa_id)
        if obj:
            return render_template('mahasiswa_edit.html', obj=obj)
        else:
            return "Mahasiswa not found", 404
    
    @staticmethod
    def update(mahasiswa_id):
        data = MahasiswaModel().find(mahasiswa_id)
        if data:
            post = request.form
            mahasiswa_obj = MahasiswaModel()
            mahasiswa_obj.nidn = post['nidn']
            mahasiswa_obj.nama = post['nama']
            mahasiswa_obj.prodi = post['prodi']
            MahasiswaModel().update(mahasiswa_id, mahasiswa_obj)
            return redirect('/mahasiswa')
        else:
            return "Mahasiswa not found", 404
        
    @staticmethod
    def delete(mahasiswa_id):
        data = MahasiswaModel().find(mahasiswa_id)
        if data:
            MahasiswaModel().delete(mahasiswa_id)
            return redirect('/mahasiswa')
        else:
            return "Mahasiswa not found", 404
