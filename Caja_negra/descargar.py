import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Inicializa el WebDriver
driver = webdriver.Chrome()

# URL de la aplicación web
url = "http://localhost/proyectos%204/Sheily/login_register.php"

try:
    # Acceder a la aplicación
    driver.get(url)
    driver.maximize_window()
    time.sleep(2)

    # Esperar que el botón de inicio de sesión sea clickeable
    def esperar_clickable(by, identifier, timeout=15):
        return WebDriverWait(driver, timeout).until(EC.element_to_be_clickable((by, identifier)))

    # Inicia sesión con las credenciales
    correo = "sheilyGonzalezAdmin@gmail.com"
    contrasena = "Sheily1995@"
    
    esperar_clickable(By.ID, 'btn__iniciar-sesion').click()
    time.sleep(1)
    driver.find_element(By.ID, "email").send_keys(correo)
    driver.find_element(By.ID, "password").send_keys(contrasena)
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    
    time.sleep(2)

    # Acceder al Dashboard
    esperar_clickable(By.CSS_SELECTOR, "a[href='dashboard.php']").click()
    time.sleep(2)

    # Acceder al "Registro de Contratos"
    esperar_clickable(By.CSS_SELECTOR, "a[href='registro_contratos.php']").click()
    time.sleep(2)

    # Seleccionar un contrato específico para descargar (botón de descarga)
    # Asumiendo que el primer contrato tiene un botón de descarga
    descargar_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "a.btn-info[title='Descargar']"))
    )
    descargar_button.click()
    time.sleep(2)

    print("Contrato descargado exitosamente en PDF.")
finally:
    driver.quit()
