print ("Konversi suhu Fahrenheit")

#Entry
suhu = input ("Masukkan Suhu dalam Fahrenheit")

# rumus
C = (5/9 * float(suhu-32))
R = (4/9 * float(suhu-32))
K = (5/9 * float(suhu-32)) +273

#output
print(suhu + " Fahrenhait sama dengan")
print(str(C) + " Celcius")
print(str(R) + "Reamur")
print(str(K) + "Kelvin")