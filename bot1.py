#this is a test to see if I can access stockifydb

import mysql.connector, datetime

present = datetime.datetime.now()

mydb = mysql.connector.connect(
    host = "localhost",
    username = "root",
    password = "")

myCursor = mydb.cursor()

insertStmt = "INSERT INTO stockifydb.products (product_name, quantity, buffer_stock, price, lead_time, shelf_age, date_added, attributes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
val = ("Acer Chromebook Spin 713", "300", "25", "$629.00", "4", "", present, "Color: Black, Battery Life: 10 hours")

#cursor will execute and commit the desired insert
myCursor.execute(insertStmt, val)
mydb.commit()
