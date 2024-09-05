import os
import ssl
import wifi
import socketpool
import adafruit_requests
print("Connecting to WiFi")
#  connect to your SSID
wifi.radio.connect(os.getenv('CIRCUITPY_WIFI_SSID'), os.getenv('CIRCUITPY_WIFI_PASSWORD'))
print("Connected to WiFi")
pool = socketpool.SocketPool(wifi.radio)
requests = adafruit_requests.Session(pool, ssl.create_default_context())
server = "192.168.0.1" # replaced with your IP address

import time
import board
import busio
import digitalio
from adafruit_sps30.i2c import SPS30_I2C
i2c = busio.I2C(board.D22, board.D21, frequency=100000)
sps30 = SPS30_I2C(i2c, fp_mode=False)
actuator = digitalio.DigitalInOut(board.D2)
actuator.direction = digitalio.Direction.OUTPUT
print("Found SPS30 sensor, reading data...")

while True:
    time.sleep(2) # in second
    try:
        aqdata = sps30.read()
        # print(aqdata)
    except RuntimeError as ex:
        print("Unable to read from sensor, retrying..." + str(ex))
        continue
    print()
    print("Concentration Units (standard)")
    print("--------------------------------------------------------------")
    print(
        "PM 1.0: {} -||- PM2.5: {} -||- PM4: {} -||- PM10: {}".format(
            aqdata["pm10 standard"], aqdata["pm25 standard"], aqdata["pm40 standard"], aqdata["pm100 standard"]
        )
    )
    # Make GET request
    print("--------------------------------------------------------------")
    print("~~Send the Data to Database~~")
    response = requests.get("http://" + server + "/airparticlemonitor/kirimdata.php" +
                            "?pm10=" + str(aqdata["pm10 standard"]) + "&pm25=" + str(aqdata["pm25 standard"]) +
                            "&pm40=" + str(aqdata["pm40 standard"]) + "&pm100=" + str(aqdata["pm100 standard"]))
    # Get response code
    response_code = response.status_code
    # Get response content
    response_content = response.content
    # Print results
    print('Response code: ', response_code)
    print('Response content:', response_content)
    
    if aqdata["pm25 standard"] > 100:
        actuator.value = True
        print("--------------------------------------------------------------")
        print("--------------------------------------------------------------")
        print("DANGER STATUS PM2.5 INDEX MORE THAN 100µg/m³")
        print("--------------------------------------------------------------")
        print("--------------------------------------------------------------")
    else:
        actuator.value = False
        print("--------------------------------------------------------------")
        print("Normal Status PM2.5 Index Less Than 100µg/m³")
        print("--------------------------------------------------------------")