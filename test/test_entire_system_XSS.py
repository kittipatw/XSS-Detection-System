import csv
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
import time

passed_count = 0
failed_count = 0
total_count = 0
failed_inputs = []

driver = webdriver.Chrome()

try:
    # Step 1: Go to the login page
    driver.get("http://localhost:8888/authentication/login.php")

    # Step 2,3: Fill in the username & Fill in the password
    username_input = driver.find_element(By.NAME, "username")
    username_input.send_keys("admin")
    password_input = driver.find_element(By.NAME, "password")
    password_input.send_keys("admin")

    submit_button = driver.find_element(By.TAG_NAME, 'button')  # Adjust if the submit button has a different tag or identifier
    submit_button.click()

    # Step 4: Go to the order page
    driver.get("http://localhost:8888/main/order.php")

    # Step 5: Fill in the search input
    with open('./XSS_test_port-swagger-scripts.csv', newline='') as csvfile:
        csvreader = csv.reader(csvfile)
        next(csvreader) # skip header
        for row in csvreader:
            input_value = row[0]

            search_input = driver.find_element(By.ID, "search")
            search_input.send_keys(input_value)
            search_input.send_keys(Keys.RETURN)

            # Delay to load
            # time.sleep(20)

            # Step 6: Check redirection
            current_url = driver.current_url
            if current_url == "http://localhost:8888/malicious.php":
                print(f"PASSED for input: {input_value}")
                session_info = driver.find_element(By.ID, "sessionInfo").get_attribute("value")
                print(f"Detected by: {session_info}")
                passed_count += 1
            else:
                print(f"FAILED for input: {input_value}. Redirected to: {current_url}")
                failed_count += 1 
                failed_inputs.append(input_value)
            total_count += 1
            print("----------------------------------")
            
            # Step 7: Go back and check again
            driver.get("http://localhost:8888/main/order.php")


finally:
    # Step 8: Close Browser
    driver.quit()

print(f"Total PASSED: {passed_count}/{total_count}")
print(f"Total FAILED: {failed_count}/{total_count}")
print("Failed Inputs:")
for index, failed_input in enumerate(failed_inputs):
    print(f"Input {index+1}: {failed_input}")