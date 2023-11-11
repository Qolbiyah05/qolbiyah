import tkinter as tk
from tkinter import Frame, Label, Entry, Button, END, W

def hitung_luas():
    jarijari= float(txtjarijari.get())
    
    Luas = 4*3.14*jarijari**2

    txtLuas.delete(0,END)
    txtLuas.insert(END,Luas)

def hitung_volume():
    jarijari= float(txtjarijari.get())

    
    Volume = 4/3*3.14*jarijari**3

    txtvolume.delete(0,END) 
    txtvolume.insert(END,Volume)

def hitung():
    hitung_luas()
    hitung_volume()

# Create tkinter object
app = tk.Tk()

# Tambahkan judul
app.title("Kalkulator Luas dan Volume Bola")

# Windows
frame = Frame (app)
frame.pack(padx=50, pady=50)

# Label Nama
Nama =Label(frame, text="siti qolbiyah 220511116")
Nama.grid(row=0, column=0, sticky=W, padx=5, pady=5)

# Label jari jari
panjang= Label (frame, text="jari jari: ")
panjang.grid(row=1, column=0, sticky=W, padx=5, pady=5)


# Textbox jari jari
txtjarijari = Entry (frame)
txtjarijari.grid(row=1, column=1)

# Button
hitung_button = Button (frame, text="Hitung", command=hitung) 
hitung_button.grid(row=4, column=1, sticky=W, padx=5, pady=5)

# Output Label Luas
luas = Label(frame, text="Luas: ") 
luas.grid(row=5, column=0, sticky=W, padx=5, pady=5)

# Output Label Volume
volume = Label (frame, text="Volume: ")
volume.grid(row=6, column=0, sticky=W, padx=5, pady=5)

# Output Textbox Luas
txtLuas = Entry (frame) 
txtLuas.grid(row=5, column=1, sticky=W, padx=5, pady=5)

# Output Textbox Volume
txtvolume = Entry (frame)
txtvolume.grid(row=6, column=1, sticky=W, padx=5, pady=5)

app.mainloop()