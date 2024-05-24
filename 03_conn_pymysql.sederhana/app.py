from flask import Flask, render_template
from connection import get_db

app = Flask(__name__)

@app.route("/")
def index():
    db = get_db() 
    # Mengambil koneksi saat fungsi dipanggil
    cursor = db.cursor()
    cursor.execute("SELECT * FROM dosen")
    data = cursor.fetchall()
    cursor.close()
    #db.close()  
    # Menutup koneksi setelah selesai menggnakan semua kursor
    return render_template("index.html", dosen=data)

if __name__ == '__main__':
    app.run(debug=True)