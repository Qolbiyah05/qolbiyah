from flask import Flask, render_template

app = Flask(__name__)

class Mahasiswa :
    def __init__(self, nim, nama, spesialis):
        self.nim = nim
        self.nama = nama
        self.spesialis = spesialis

@app.route("/one")
def one_object():
    mhs = Mahasiswa("123", "Siti Qolbiyah", "PBO")
    return render_template("one_object.html", mhs = mhs)

@app.route("/many")
def many_object():
    mhs = [
            Mahasiswa("111", "Agung", "Rekayasa Perangkat Lunak"),
            Mahasiswa("222", "Bobon", "Jaringan komputer"),
            Mahasiswa("333", "Candra", "Sains Data"),
            Mahasiswa("444", "Deden", "Pemograman Mobile"),
            Mahasiswa("555", "Endra", "Basis Data")

    ]
    return render_template("many_object.html", mhs = mhs)