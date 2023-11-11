import tkinter as tk
from tkinter import Frame, Label, Entry, Button, END, W

def hitung_luas():
    panjang = float(txtpanjang.get())
    lebar = float(txtlebar.get())
    tinggi = float(txttinggi.get())

    luas = 2*panjang*lebar + 2*panjang*tinggi + 2*lebar*tinggi
    txtLuas.delete(0, END)
    txtLuas.insert(END,luas)

def hitung_volume():
    panjang = float(txtpanjang.get())
    lebar = float(txtlebar.get())
    tinggi  = float (txttinggi.get())

    Volume = panjang*lebar*tinggi


    txtVolume.delete(0,END)
    txtVolume.insert(END, Volume)

def hitung():
    hitung_luas()
    hitung_volume()

app = tk.Tk()

app.title ("Kalkulator Mencari Luas dan Volume Balok")

frame = Frame (app)
frame.pack(padx=20, pady=20)

# Label nama
nama =Label(frame, text="siti qolbiyah 220511116")
nama.grid(row=0, column=0, sticky=W, padx=5, pady=5)

#La
panjang =Label(frame, text="panjang:")
panjang.grid(row=1, column=0, sticky=W, padx=5, pady=5)
#ls
lebar = Label(frame, text="lebar:")
lebar.grid(row=2, column=0,sticky=W, padx=5, pady=5)
#t
tinggi = Label(frame, text="tinggi:")
tinggi.grid(row=3, column=0,sticky=W, padx=5, pady=5)


#textbox LA
txtpanjang = Entry(frame)
txtpanjang.grid(row=1, column=1,  sticky=W, padx=5, pady=5)

#textbox LS
txtlebar = Entry(frame)
txtlebar.grid(row=2, column=1, sticky=W, padx=5, pady=5)
#textbox tinggi
txttinggi= Entry(frame)
txttinggi.grid(row=3, column=1, sticky=W, padx=5, pady=5)

# Button
hitung_button = Button(frame, text="Hitung", command=hitung)
hitung_button.grid(row=4, column=0, sticky=W, padx=5, pady=5)

# Output Label Luas
luas= Label(frame, text="Luas: ")
luas.grid(row=5, column=0, sticky=W, padx=5, pady=5)

# output label volume
volume = Label (frame, text="volume: ")
volume.grid(row=6, column=0, stick=W, padx=5, pady=5)

# Output Textbox Luas
txtLuas = Entry(frame)
txtLuas.grid(row=5, column=1, sticky=W, padx=5, pady=5)

# Output Textbox Keliling
txtVolume = Entry (frame)
txtVolume.grid(row=6, column=1, sticky=W, padx=5, pady=5)

app.mainloop()