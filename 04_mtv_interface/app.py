from flask import Flask, render_template
from routes.Route import app_mahasiswa

app = Flask(__name__)

app.register_blueprint(app_mahasiswa, url_prefix='/mahasiswa')

@app.route('/')
def index():
    return render_template('index.html')

if __name__ == '__main__':
    app.run(debug=True)