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

    # Acceder al formulario de Contrato A
    esperar_clickable(By.CSS_SELECTOR, "div.card[onclick*='ContratoA']").click()
    time.sleep(2)

    # Llenar los campos del formulario de Contrato A
    contrato_a = {
        "nombreEmisor": "Carlos López",
        "edadEmisor": "40",
        "dpiEmisor": "1234567890101",
        "nombreReceptor": "Juan Pérez",
        "edadReceptor": "35",
        "dpiReceptor": "9876543210102",
        "domicilioReceptor": "Ciudad de Guatemala",
        "departamentoEmision": "Guatemala",
        "municipioEmision": "Zona 1",
        "nombreContratante": "Empresa XYZ",
        "fechaPatente": "10-01-2023",
        "numeroInscripcion": "123456",
        "folioRegistro": "45",
        "libroRegistro": "25",
        "actividadEconomica": "Consultoría",
        "nit": "12345678-9",
        "tarifaMensual": "500",
        "cobroUnico": "1000",
        "fechaValidez": "10-01-2024",
        "rango_documentos": "200",
        "direccionContratante": "Avenida Central 5-10"
    }

    for campo, valor in contrato_a.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(1)

    # Enviar el formulario
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    print("Contrato A creado exitosamente.")
finally:
    driver.quit()
