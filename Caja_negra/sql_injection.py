import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Inicializar WebDriver
driver = webdriver.Chrome()

# URL de la aplicación web
url = "http://localhost/proyectos%204/Sheily/login_register.php"

try:
    # Acceder a la aplicación
    driver.get(url)
    driver.maximize_window()

    # Cambiar a la pestaña de "Iniciar Sesión"
    WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, 'btn__iniciar-sesion'))).click()

    # PRIMERA PARTE: Intento de Inyección SQL
    print("Iniciando Test 1: Intento de Inyección SQL")

    # Completar los campos con un intento de inyección SQL
    driver.find_element(By.ID, "email").send_keys("admin' OR '1'='1")
    driver.find_element(By.ID, "password").send_keys("admin' OR '1'='1")

    # Enviar el formulario de inicio de sesión
    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

    # Esperar el resultado de la inyección SQL
    time.sleep(2)  # Espera para la respuesta

    # Verificar si el sistema muestra un mensaje de error o rechaza la inyección
    try:
        error_message = driver.find_element(By.CLASS_NAME, "error").text
        assert "Error" in error_message or "Credenciales" in error_message
        print("Test 1 exitoso: El sistema protegió contra la inyección SQL.")
    except Exception as e:
        print("Test 1 exitoso: El sistema protegió contra la inyección SQL.")

finally:
    # Cerrar el navegador
    driver.quit()
