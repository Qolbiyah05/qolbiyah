from flask import Flask, render_template, request
from datetime import datetime

app = Flask(__name__)

b_mapping = {
    "----pilih----": None,
    "Sepeda Motor (R2/R3)": 1,
    "Sepeda Motor >250cc": 1,
    "Mobil Penumpang/Barang Roda 3": 1,
    "Sedan": 1.025,
    "Jeep/ Minibus": 1.050,
    "Blind Van / Pick Up / Pivk Up Box": 1.085,
    "Microbus": 1.085,
    "Bus": 1.1,
    "Light Truck": 1.3,
    "Truck / Tronton": 1.4
}

swdkllj_mapping = {
    "Sepeda Motor (R2/R3)": 35000,
    "Sepeda Motor >250cc": 83000,
    "Mobil Penumpang/Barang Roda 3": 143000,
    "Sedan": 143000,
    "Jeep/ Minibus": 143000,
    "Microbus": 153000,
    "Bus": 153000,
    "Blind Van / Pick Up / Pivk Up Box": 163000,
    "Light Truck": 163000,
    "Truck / Tronton": 163000
}

progressif_mapping = {
    "Kepemilikan 1": 0.0112,
    "Kepemilikan 2": 0.0162,
    "Kepemilikan 3": 0.0212,
    "Kepemilikan 4": 0.0262,
    "Kepemilikan 5": 0.0312,
    "Kepemilikan >5": 0.0312
}

tarif_tetap = {
    "Tarif Angkutan Umum": 0.005,
    "Tarif Angkutan Karyawan": 0.005,
    "Tarif Angkutan Sekolah": 0.005,
    "Tarif Ambulans": 0.005,
    "Tarif Pemadam Kebakaran": 0.005,
    "Tarif Sosial Keagamaan": 0.005,
    "Tarif Lembaga Sosial dan Keagamaan": 0.005,
    "Tarif Instansi Pemerintah": 0.005
}

diskon_progressif = {
    "Kepemilikan 1": 0.0587,
    "Kepemilikan 2": 0.1633,
    "Kepemilikan 3": 0.2186,
    "Kepemilikan 4": 0.2528,
    "Kepemilikan 5": 0.2760,
    "Kepemilikan >5": 0.2760
}

biaya_tambahan = {
    "motor": {"stnk": 100000, "tnkb": 60000, "bpkb": 225000},
    "mobil": {"stnk": 200000, "tnkb": 100000, "bpkb": 375000}
}

@app.route("/baliknama_kendaraan")
def index():
    return render_template("index.html")

@app.route("/baliknama _kendaraan", methods=["POST"])
def hitung():
    nopol = request.form["nopol"]
    njkb = float(request.form["njkb"])
    jenis_kendaraan = request.form["jenis_kendaraan"]
    jenis_tarif = request.form["jenis_tarif"]
    kepemilikan = request.form.get("kepemilikan")
    jatuh_tempo = datetime.strptime(request.form["jatuh_tempo"], "%Y-%m-%d")
    hari_ini = datetime.now()

    b = b_mapping[jenis_kendaraan]

    if jenis_tarif == "Progressif":
        c = progressif_mapping[kepemilikan]
    else:
        c = tarif_tetap[jenis_tarif]

    pkb = njkb * b * c
    opsen_pkb = pkb * 0.66

    if jenis_tarif == "Progressif":
        diskon = pkb * diskon_progressif[kepemilikan]
        pkb -= diskon

    if hari_ini > jatuh_tempo:
        bulan_telat = (hari_ini.year - jatuh_tempo.year) * 12 + (hari_ini.month - jatuh_tempo.month)
        if hari_ini.day >= jatuh_tempo.day:
            bulan_telat += 1
    else:
        bulan_telat = 0

    denda_pkb = pkb * (bulan_telat * 0.01)
    denda_opsen = opsen_pkb * (bulan_telat * 0.01)

    if bulan_telat > 0:
        kelipatan_3bulan = (bulan_telat + 2) // 3
        denda_swdkllj = kelipatan_3bulan * 8000
    else:
        denda_swdkllj = 0

    swdkllj = swdkllj_mapping[jenis_kendaraan]

    tipe = "motor" if "Motor" in jenis_kendaraan else "mobil"
    bea = biaya_tambahan[tipe]

    total = (pkb + opsen_pkb + denda_pkb + denda_opsen +
             swdkllj + denda_swdkllj +
             bea["stnk"] + bea["tnkb"] + bea["bpkb"])

    tanggal = datetime.now().strftime("%d-%m-%Y %H:%M:%S")

    return render_template("hasil.html",
        nopol=nopol,
        jenis_kendaraan=jenis_kendaraan,
        pkb=pkb,
        opsen=opsen_pkb,
        denda_pkb=denda_pkb,
        denda_opsen=denda_opsen,
        swdkllj=swdkllj,
        denda_swdkllj=denda_swdkllj,
        stnk=bea["stnk"],
        tnkb=bea["tnkb"],
        bpkb=bea["bpkb"],
        total=total,
        tanggal=tanggal,
        bulan_telat=bulan_telat
    )

if __name__ == "__main__":
    app.run(host="0.0.0.0.", port=5000)
