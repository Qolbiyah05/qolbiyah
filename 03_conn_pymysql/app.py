from flask import Flask, render_template, request, redirect, url_for
from connection import get_db

app = Flask(__name__)

# Route untuk menampilkan semua data
@app.route("/")
def index():
    db = get_db() 
    cursor = db.cursor()
    cursor.execute("SELECT * FROM dosen")
    data = cursor.fetchall()
    cursor.close()
    return render_template("index.html", dosen=data)

# Route untuk menambahkan data baru
@app.route("/tambah", methods=["GET", "POST"])
def tambah():
    if request.method == "POST":
        nidn = request.form["nidn"]
        nama = request.form["nama"]
        db = get_db()
        cursor = db.cursor()
        cursor.execute("INSERT INTO dosen (nidn, nama) VALUES (%s, %s)", (nidn, nama))
        db.commit()
        cursor.close()
        return redirect(url_for("index"))
    return render_template("tambah.html")

# Route untuk menghapus data
@app.route("/hapus/<string:nidn>", methods=["POST"])
def hapus(nidn):
    db = get_db()
    cursor = db.cursor()
    cursor.execute("DELETE FROM dosen WHERE nidn = %s", (nidn,))
    db.commit()
    cursor.close()
    return redirect(url_for("index"))


# Route untuk memperbarui data
@app.route("/update/<string:nidn>", methods=["GET", "POST"])
def update(nidn):
    db = get_db()
    cursor = db.cursor()
    if request.method == "POST":
        nama = request.form["nama"]
        cursor.execute("UPDATE dosen SET nama = %s WHERE nidn = %s", (nama, nidn))
        db.commit()
        cursor.close()
        return redirect(url_for("index"))
    cursor.execute("SELECT nama FROM dosen WHERE nidn = %s", (nidn,))
    data = cursor.fetchone()
    cursor.close()
    return render_template("update.html", nama=data[0])

if __name__ == '__main__':
    app.run(debug=True)
