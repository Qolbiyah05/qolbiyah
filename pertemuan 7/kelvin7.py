class Kelvin:
  def __init__(self, suhu):
    self.suhu = suhu

  def get_kelvin(self):
    val = self.suhu
    return val
    
  def get_celcius(self):
    val = self.suhu - 273
    return val
  
  def get_fahrenheit(self):
    val = (9/5 * self.suhu - 273 ) + 32
    return val
  
  def get_reamur(self):
    val = (4/5 * self.suhu) - 273
    return val
 
K = Kelvin(110)
val = K.get_kelvin()
C = K.get_celcius()
F = K.get_fahrenheit()
R = K.get_reamur()

print( str(val) + " Kelvin, sama dengan:")
print(str(C) + " Celcius")
print(str(F) + " Fahrenheit")
print(str(R) + " Reamur")
