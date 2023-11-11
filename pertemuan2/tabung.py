import tkinter as tk
from tkinter import Frame, Label, Entry, Button, END, W

def hitung_luasselimut():
    jarijari= float(txtjarijari.get())
    tinggi= float(txttinggi.get())
    
    Luasselimut = 2*3.14*jarijari*tinggi

    txtluasselimut.delete(0, END)
    txtluasselimut.insert(END,Luasselimut)


def hitung_luaspermukaan():
    jarijari= float(txtjarijari.get())
    tinggi= float(txttinggi.get())

    luaspermukaan = 2*3.14*jarijari*tinggi+2*3.14*jarijari**2
    
    txtluaspermukaan.delete(0,END)
    txtluaspermukaan.insert(END, luaspermukaan)

def hitung_luasvolume():
    jarijari= float(txtjarijari.get())
    tinggi= float(txttinggi.get())

    luasvolume = 3.14*jarijari**2*tinggi
    
    txtvolume.delete(0,END)
    txtvolume.insert(END, luasvolume)

def hitung():
    hitung_luasselimut()
    hitung_luaspermukaan()
    hitung_luasvolume()

app = tk.Tk()

app.title ("Kalkulator Mencari Luas dan Volume Tabung")

#Windows
frame = Frame (app)
frame.pack(padx=50, pady=50)
 
#Label Nama
Nama =Label(frame, text="Siti Qolbiyah 220511116")
Nama.grid(row=0, column=0, sticky=W, padx=5, pady=5)

#Label Jari Jari
jarijari= Label(frame, text="Jarijari:")
jarijari.grid(row=1, column=0, sticky=W, padx=5, pady=5)

#Label Tinggi
tinggi = Label(frame, text="Tinggi:")
tinggi.grid(row=2, column=0, sticky=W, padx=5, pady=5)

#Textbox Jari Jari
txtjarijari =Entry (frame)
txtjarijari.grid(row=1, column=1)

#Textbox Tinggi
txttinggi = Entry (frame)
txttinggi.grid(row=2, column=1)

#Button 
hitung_button = Button (frame, text="Hitung", command=hitung)
hitung_button.grid(row=3, column=1, sticky=W, padx=5, pady=5)

#Output Label Luas Selimut
luasselimut = Label(frame, text="Luas Selimut:")
luasselimut.grid(row=4, column=0, sticky=W, padx=5, pady=5)

#Output Label Luas Permukaan
luaspermukaan = Label(frame, text="Luas Permukaan:")
luaspermukaan.grid(row=5, column=0, sticky=W, padx=5, pady=5)

#Output Label Volume
volume = Label(frame, text="Volume:")
volume.grid(row=6, column=0, sticky=W, padx=5, pady=5)

#Output Textbox Luas Selimut
txtluasselimut = Entry (frame)
txtluasselimut.grid(row=4, column=1, sticky=W, padx=5, pady=5)

#Output Textbox Luas Permukaan
txtluaspermukaan = Entry (frame)
txtluaspermukaan.grid(row=5, column=1, sticky=W, padx=5, pady=5)

#Output Textbox Volume
txtvolume = Entry (frame)
txtvolume.grid(row=6, column=1, sticky=W, padx=5, pady=5)

app.mainloop()