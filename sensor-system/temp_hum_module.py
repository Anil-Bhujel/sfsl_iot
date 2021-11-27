import Adafruit_DHT

def DHT22(DHT_PIN):
    try:
        DHT_SENSOR = Adafruit_DHT.DHT22
        
        humidity, temperature = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_PIN)
        humidity = round(humidity,3)
        temperature = round(temperature,3)
        return(temperature,humidity)
    
    except:
        return(0,0)
        