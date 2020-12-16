import sys
import conf
import datetime
import mysql.connector

def convertToBinaryData(filename):
    # Convert digital data to binary format
    byte_list = []

    with open(filename, "rb") as f:
        while True:
            byte = f.read(1)
            if not byte:
                break
            byte_list.append(byte)

    b = ""
    for byte in byte_list:
        int_value = ord(byte)
        binary_string = '{0:08b}'.format(int_value)
        b += binary_string
    return b


try:
    file = sys.argv[1]
    virus_name = sys.argv[2]

    f_binary = convertToBinaryData(file)

    cnx = mysql.connector.connect(**conf.conf)
    cursor = cnx.cursor()

    tuple_blob = (f_binary, virus_name)
    query = "INSERT INTO filehash (File, Name) VALUE (%s,%s)"
    result = cursor.execute(query, tuple_blob)
    cnx.commit()
except Exception as e:
    print("Storage Failed %s" %(e))


