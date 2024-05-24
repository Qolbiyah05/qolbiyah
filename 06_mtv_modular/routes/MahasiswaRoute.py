from flask import *
from mahasiswa.views.View import MahasiswaView

app_mahasiswa = Blueprint('app_mahasiswa', __name__, template_folder='templates')
app_mahasiswa.add_url_rule('/', 'index', MahasiswaView().index, methods=['GET'])
app_mahasiswa.add_url_rule('/create', 'create', MahasiswaView().create, methods=['GET'])
app_mahasiswa.add_url_rule('/edit/<int:mahasiswa_id>', 'edit', MahasiswaView().edit, methods=['GET'])
app_mahasiswa.add_url_rule('/store', 'store', MahasiswaView().store, methods=['POST'])
app_mahasiswa.add_url_rule('/update/<int:mahasiswa_id>', 'update', MahasiswaView().update, methods=['POST'])
app_mahasiswa.add_url_rule('/delete/<int:mahasiswa_id>', 'delete', MahasiswaView().delete, methods=['GET'])
