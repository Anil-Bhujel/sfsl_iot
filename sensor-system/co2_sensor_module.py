### MH-Z19B CO2 sensor Python code for Raspberry Pi.
# https://www.circuits.dk/testing-mh-z19-ndir-co2-sensor-module/

#!/usr/bin/python
import serial, os, time, sys, datetime, csv


#Function to calculate MH-Z19 crc according to datasheet
def crc8(a):
    crc=0x00
    count=1
    b=bytearray(a)
    while count<8:
        crc+=b[count]
        count=count+1
    #Truncate to 8 bit
    crc%=256
    #Invert number with xor
    crc=~crc&0xFF
    crc+=1
    return crc

    # try to open serial port

port='/dev/serial0'
#sys.stderr.write('Trying port %s\n' % port)

def mh_z19():
    try:
        # try to read a line of data from the serial port and parse    
        with serial.Serial(port, 9600, timeout=2.0) as ser:
            # zero point calibration
            #result=ser.write(b'\xff\x01\x87\x00\x00\x00\x00\x00\x79')
            # 'warm up' with reading one input
            result=ser.write(b'\xff\x01\x86\x00\x00\x00\x00\x00\x79')
        
            time.sleep(0.1)
            
            s=ser.read(9)
        
            #print(s)
            #print(s[0],' ',s[1])
            z=bytearray(s)
            # Calculate crc
            crc=crc8(s) 
            if crc != z[8]:
                sys.stderr.write('CRC error calculated %d bytes= %d:%d:%d:%d:%d:%d:%d:%d crc= %dn' % (crc, z[0],z[1],z[2],z[3],z[4],z[5],z[6],z[7],z[8]))
        
        
            # loop will exit with Ctrl-C, which raises a KeyboardInterrupt
            #while True:
            #Send "read value" command to MH-Z19 sensor
            #readcmd = "\xff\x01\x86\x00\x00\x00\x00\x00\x79"
            #result=ser.write(readcmd.encode())
            result=ser.write(b'\xff\x01\x86\x00\x00\x00\x00\x00\x79')
            time.sleep(0.1)
            s=ser.read(9)
            z=bytearray(s)
            #print(s)
            #print(z[8])
            #print(z[2], ',', z[3])
            
            crc=crc8(s)
            #Calculate crc
            if crc != z[8]:
                sys.stderr.write('CRC error calculated %d bytes= %d:%d:%d:%d:%d:%d:%d:%d crc= %dn' % (crc, z[0],z[1],z[2],z[3],z[4],z[5],z[6],z[7],z[8]))
            #else:       
                #if s[0] == "\xff" and s[1] == "\x86":
                #if s[0] == 255 and s[1] == 134:
                    #print ("co2=", s[2]*256 + s[3])
                    #print ("co2=", (s[2]*256 + s[3]))
            co2value=s[2]*256 + s[3]
            #print(co2value)
            #co2value=ord(s[2])*256 + ord(s[3])
            #now=time.ctime()
            #parsed=time.strptime(now)
            #lgtime=time.strftime("%Y-%m-%d %H:%M:%S")
            #row=[lgtime,co2value]
            
            #Sample every minute, synced to local time
            #t=datetime.datetime.now()
            #sleeptime=60-t.second
            #time.sleep(sleeptime)
        return co2value
    except Exception as e:
        return 0
        ser.close()
        sys.stderr.write('Error reading serial port %s: %sn' % (type(e).__name__, e))
    except KeyboardInterrupt as e:
        ser.close()

# while True:
#     co2val = mh_z19()
#     print('current CO2:', co2val['co2'])
#     time.sleep(30)

