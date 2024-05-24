from flask import *
from views.View import MataKuliahView

app_matakuliah = Blueprint('app_matakuliah', __name__, template_folder='templates')
app_matakuliah.add_url_rule('/', 'index', MataKuliahView().index, methods=['GET'])
app_matakuliah.add_url_rule('/create', 'create', MataKuliahView().create, methods=['GET'])
app_matakuliah.add_url_rule('/edit/<int:matakuliah_id>', 'edit', MataKuliahView().edit, methods=['GET'])
app_matakuliah.add_url_rule('/store', 'store', MataKuliahView().store, methods=['POST'])
app_matakuliah.add_url_rule('/update/<int:matakuliah_id>', 'update', MataKuliahView().update, methods=['POST'])
app_matakuliah.add_url_rule('/delete/<int:matakuliah_id>', 'delete', MataKuliahView().delete, methods=['GET'])
