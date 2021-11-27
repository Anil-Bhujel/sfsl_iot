import time
import csv
import requests
import json

from datetime import datetime
from co2_sensor_module import mh_z19
from temp_hum_module import DHT22

DHT_PIN = 4

# Set the logging interval
log_interval = 60

# defining the api-endpoint  
API_ENDPOINT = "restserver-API"

# parameter send same as get request
paramload = {'sensor-id': 'ls3sensor1'}

while True:
    temperature,humidity = DHT22(DHT_PIN)
    CO2 = mh_z19()
    # adjustment
    #CO2 = CO2-150
    
    log_date = datetime.now().strftime("%Y-%m-%d")
    log_time = datetime.now().strftime("%H:%M:00")

    #if humidity is not None and temperature is not None:
    #    print("Temp={}*C  Humidity={}%".format(temperature, humidity))
    #else:
    #    print("Failed to retrieve data from humidity sensor")
    
    # JSON data preparation for HTTP POST request
    data = {
        "temp": temperature,
        "humid": humidity,
        "CO2": CO2
        }
    
    timestamp = {
        "data_date": log_date,
        "data_time": log_time
        }
    
    json_data = json.dumps({
        'data': data,
        'timestamp': timestamp
        },indent = 4)
    
    # sending post request and saving response as response object 
    response = requests.post(url = API_ENDPOINT, params = paramload, data = json_data) 
  
    # extracting response text  
    resp_status = response.status_code 
    resp_msg = response.text

    #print("Status Code:%s"%resp_status) 
    #print("Received message:%s"%resp_msg)
    
    #print(json_data)
    
    time.sleep(log_interval)
    
