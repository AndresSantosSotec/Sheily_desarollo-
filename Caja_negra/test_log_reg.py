import time
import random
import string
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Genera un correo aleatorio con el dominio @gmail.com
def generar_correo():
    return f"{''.join(random.choices(string.ascii_lowercase + string.digits, k=8))}@gmail.com"

# Genera una contraseña segura con al menos un número y un carácter especial
def generar_contrasena():
    while True:
        contrasena = ''.join(random.choices(
            string.ascii_letters + string.digits + "!@#$%^&*()", k=8))
        if any(c.isdigit() for c in contrasena) and any(c in "!@#$%^&*()" for c in contrasena):
            return contrasena

# Inicializa el WebDriver (asegúrate de que ChromeDriver esté en el PATH)
driver = webdriver.Chrome()

# URL de la aplicación web
url = "http://localhost/proyectos%204/Sheily/login_register.php"

try:
    # Accede a la aplicación y maximiza la ventana
    driver.get(url)
    driver.maximize_window()

    # Función auxiliar para esperar elementos clickeables
    def esperar_clickable(by, identifier, timeout=10):
        return WebDriverWait(driver, timeout).until(
            EC.element_to_be_clickable((by, identifier))
        )

    # Navegar al formulario de registro
    esperar_clickable(By.ID, 'btn__registrarse').click()

    # Datos aleatorios para el registro
    correo = generar_correo()
    contrasena = generar_contrasena()

    # Completar formulario de registro
    campos_registro = {
        "nombre": "UsuarioPrueba",
        "apellido": "ApellidoPrueba",
        "email-register": correo,
        "usuario": "TestUser",
        "password-register": contrasena,
    }

    for campo, valor in campos_registro.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(0.5)  # Simular interacción humana

    # Enviar el formulario de registro
    esperar_clickable(By.CSS_SELECTOR, "button.btn-success").click()
    time.sleep(2)  # Dar tiempo para la redirección

    # Navegar al formulario de inicio de sesión
    esperar_clickable(By.ID, 'btn__iniciar-sesion').click()

    # Completar formulario de inicio de sesión
    driver.find_element(By.ID, "email").send_keys(correo)
    driver.find_element(By.ID, "password").send_keys(contrasena)

    # Enviar el formulario de inicio de sesión
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()

    # Verificar si el inicio de sesión fue exitoso
    time.sleep(2)
    mensaje = "Inicio de sesión exitoso." if "Dashboard" in driver.page_source else "Error en el inicio de sesión."
    print(mensaje)

finally:
    # Cerrar el navegador después de 5 segundos
    time.sleep(5)
    driver.quit()
