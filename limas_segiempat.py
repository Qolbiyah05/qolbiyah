print ("program menghitung luas dan volume limas segiempat")
"""
programmer : siti qolbiyah
pertemuan : 1
tanggal : 22 oktober 2023
"""
# Nilai
tinggi = 3
sisi = 4
sisi_miring = ((sisi*0.5)*(sisi*0.5)+(tinggi*tinggi))
segitiga = 0.5*sisi * sisi_miring

# Rumus
luas = (sisi*sisi) + (4*segitiga)
volume = (1/3) *(sisi*sisi) * tinggi

# Output
print("tinggi :", tinggi)
print("sisi :",sisi)
print("sisi_miring :",sisi_miring)
print("segitiga :",segitiga)
print("luas :",luas)
print("volume :",volume)
