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

    # Acceder al formulario de Contrato B
    esperar_clickable(By.CSS_SELECTOR, "div.card[onclick*='ContratoB']").click()
    time.sleep(2)

    # Llenar los campos del formulario de Contrato B, incluyendo notario y libro
    contrato_b = {
        "nombreEmisor": "Pedro Gómez",
        "edadEmisor": "50",
        "dpiEmisor": "1234567890001",
        "nombreDistribuidor": "Distribuidora XYZ",
        "edadDistribuidor": "45",
        "dpiDistribuidor": "9876543210001",
        "domicilioDistribuidor": "Zona 10, Guatemala",
        "municipio": "Guatemala",
        "departamento": "Guatemala",
        "entidad": "Distribuidora ABC S.A.",
        "registroMercantil": "98765",
        "folio": "12",
        "libro": "15",
        "notario": "Carlos Martínez",  # Campo adicional para el nombre del notario
        "nit": "78945612-3",
        "fechaInicio": "01-05-2024",
        "direccionDistribuidora": "Avenida Reforma 12-34, Guatemala"
    }

    for campo, valor in contrato_b.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(1)

    # Enviar el formulario
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    print("Contrato B creado exitosamente.")
    time.sleep(5)

    # Regresar al dashboard o listado de contratos
    esperar_clickable(By.CSS_SELECTOR, "a[href*='registro_contratos.php']").click()
    time.sleep(3)

    # Seleccionar el contrato recién creado y eliminarlo (basado en el nombre del distribuidor)
    print("Buscando el contrato en el listado para eliminar...")
    contratos = driver.find_elements(By.CSS_SELECTOR, "table tbody tr")

    for contrato in contratos:
        if "Distribuidora XYZ" in contrato.text:  # Busca el contrato en el listado
            # Hacer clic en el botón de eliminar para el contrato correspondiente
            contrato.find_element(By.CSS_SELECTOR, "button.btn-danger").click()
            print("Contrato encontrado y se va a eliminar.")
            time.sleep(2)
            # Aceptar el diálogo de confirmación de eliminación usando SweetAlert
            WebDriverWait(driver, 10).until(EC.alert_is_present())
            alert = driver.switch_to.alert
            alert.accept()  # Aceptar la alerta de confirmación
            print("Eliminación confirmada.")
            break

finally:
    driver.quit()
