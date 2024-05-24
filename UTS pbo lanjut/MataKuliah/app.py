# app.py
from flask import Flask
from routes.Route import app_matakuliah

app = Flask(__name__)

app.register_blueprint(app_matakuliah, url_prefix='/matakuliah')

if __name__ == '__main__':
    app.run(debug=True)