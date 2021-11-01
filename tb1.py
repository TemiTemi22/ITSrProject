# connect to stock
#using chrome to connect to web

import selenium
import webdriver

driver = webdriver.Chrome()
url = "https://localhost:8012/stockify/login.php"
driver.get(url)

#log-in to stock

#find the manager username
id_box = driver.find_element_by_id('username')

#send id info
id_box.send_keys('Tbot1')

#find password box
pass_box = driver.
#navigate to PA page
#add functional reqs
