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

    # SEGUNDA PARTE: Protección contra Fuerza Bruta
    print("Iniciando Test 2: Intento de Fuerza Bruta")

    intentos_fallidos = 0
    max_intentos = 5  # Número de intentos fallidos permitidos

    while intentos_fallidos < max_intentos:
        # Completar los campos con credenciales incorrectas
        driver.find_element(By.ID, "email").send_keys(f"usuario_prueba{intentos_fallidos}@test.com")
        driver.find_element(By.ID, "password").send_keys("ContraseñaIncorrecta")

        # Enviar el formulario de inicio de sesión
        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

        # Verificar si aparece un mensaje de error después de cada intento
        time.sleep(2)  # Esperar la respuesta
        try:
            error_message = driver.find_element(By.CLASS_NAME, "error").text
            print(f"Intento fallido {intentos_fallidos + 1}: {error_message}")
            intentos_fallidos += 1
        except:
            print("No se encontró el mensaje de error.")
            break

    # Verificar si el sistema aplicó alguna medida de protección (bloqueo o CAPTCHA)
    try:
        captcha_present = driver.find_element(By.CLASS_NAME, "captcha")  # Verificar si hay CAPTCHA
        print("Test 2 exitoso: El sistema aplicó un CAPTCHA tras múltiples intentos fallidos.")
    except:
        print("Test 2 fallido: No se aplicó un CAPTCHA o medida de protección tras los intentos fallidos.")

finally:
    # Cerrar el navegador
    driver.quit()
