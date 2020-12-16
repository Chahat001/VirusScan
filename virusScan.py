import sys

import fuzz as fuzz

import conf

import mysql.connector
from difflib import SequenceMatcher


file = sys.argv[1]
byte_list = []

print("Running Scan => ")

try:
    with open(file, "rb") as f:
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

    cnx = mysql.connector.connect(**conf.conf)
    cursor = cnx.cursor()

    query = ("SELECT * FROM filehash")
    cursor.execute(query)
    for (File, virus_name) in cursor:
        print("Percentage Match %s virusName =>  %s |   | " % (str(SequenceMatcher(None, File, b).ratio()), virus_name))


except Exception as e:
    print("Scan Failed %s"%(e))








