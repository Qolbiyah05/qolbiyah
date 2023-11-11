import tkinter as tk
from tkinter import Frame, Label, Entry, Button, END, W

def hitung_luas():
    rusuk = float(txtrusuk.get())
    
    luas = round(6*rusuk**2)
    txtLuas.delete(0, END)
    txtLuas.insert(END,luas)

def hitung_volume():
    rusuk = float(txtrusuk.get())

    Volume = round(rusuk**3)
    txtVolume.delete(0,END)
    txtVolume.insert(END, Volume)

def hitung():
    hitung_luas()
    hitung_volume()

app = tk.Tk()

app.title ("Kalkulator Mencari Luas dan Volome Kubus")

#Windows
frame = Frame (app)
frame.pack(padx=50, pady=50)
 
#Label Nama
Nama =Label(frame, text="siti qolbiyah 220511116")
Nama.grid(row=0, column=0, sticky=W, padx=5, pady=5)

#La
rusuk =Label(frame, text="rusuk:")
rusuk.grid(row=1, column=0, sticky=W, padx=5, pady=5)


#textbox LA
txtrusuk = Entry(frame)
txtrusuk.grid(row=1, column=1,  sticky=W, padx=5, pady=5)

# Button
hitung_button = Button(frame, text="Hitung", command=hitung)
hitung_button.grid(row=2, column=1, sticky=W, padx=5, pady=5)

# Output Label Luas
luas= Label(frame, text="Luas: ")
luas.grid(row=3, column=0, sticky=W, padx=5, pady=5)

# output label volume
volume = Label (frame, text="volume: ")
volume.grid(row=4, column=0, stick=W, padx=5, pady=5)

# Output Textbox Luas
txtLuas = Entry(frame)
txtLuas.grid(row=3, column=1, sticky=W, padx=5, pady=5)

# Output Textbox Volume
txtVolume = Entry (frame)
txtVolume.grid(row=4, column=1, sticky=W, padx=5, pady=5)

app.mainloop()