# app.py
from flask import Flask
from routes.MahasiswaRoute import app_mahasiswa

app = Flask(__name__)

app.register_blueprint(app_mahasiswa, url_prefix='/mahasiswa')

if __name__ == '__main__':
    app.run(debug=True)