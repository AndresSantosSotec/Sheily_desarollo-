import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Inicializa el WebDriver (asegúrate de que ChromeDriver esté en tu PATH)
driver = webdriver.Chrome()

# URL de la aplicación web
url = "http://localhost/proyectos%204/Sheily/login_register.php"

try:
    # Accede a la aplicación y maximiza la ventana
    driver.get(url)
    driver.maximize_window()
    time.sleep(3)  # Espera para cargar completamente la página

    def esperar_clickable(by, identifier, timeout=15):
        """Espera hasta que el elemento sea clickeable."""
        return WebDriverWait(driver, timeout).until(
            EC.element_to_be_clickable((by, identifier))
        )

    # Iniciar sesión con las credenciales proporcionadas
    correo = "sheilyGonzalezAdmin@gmail.com"
    contrasena = "Sheily1995@"

    esperar_clickable(By.ID, 'btn__iniciar-sesion').click()
    time.sleep(1.5)

    driver.find_element(By.ID, "email").send_keys(correo)
    time.sleep(1.5)
    driver.find_element(By.ID, "password").send_keys(contrasena)
    time.sleep(2)

    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    time.sleep(3)

    # Verificar si el login fue exitoso
    if "Dashboard - Gestión de Contratos" in driver.page_source:
        print("Inicio de sesión exitoso.")
    else:
        print("Error en el inicio de sesión.")
        driver.quit()
        exit()

    # Acceder al contrato de servicio a terceros
    time.sleep(2)
    esperar_clickable(By.CSS_SELECTOR, "div.card").click()
    time.sleep(2)

    # Completar formulario del contrato con pausas
    contrato_data = {
        "nombreEmisor": "Juan Pérez",
        "edadEmisor": "40",
        "dpiEmisor": "1234567890101",
        "nombreReceptor": "Carlos López",
        "edadReceptor": "35",
        "dpiReceptor": "9876543210102",
        "domicilioReceptor": "Ciudad de Guatemala",
        "departamentoEmision": "Guatemala",
        "municipioEmision": "Zona 1",
        "nombreContratante": "Empresa XYZ",
        "fechaPatente": "2023-10-01",
        "numeroInscripcion": "123456",
        "folioRegistro": "45",
        "libroRegistro": "Libro A",
        "actividadEconomica": "Consultoría",
        "nit": "12345678-9",
        "tarifaMensual": "500",
        "cobroUnico": "1000",
        "fechaValidez": "2024-10-29",
        "rango_documentos": "A001-A100",
        "direccionContratante": "Avenida Central 5-10"
    }

    for campo, valor in contrato_data.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(1)  # Pausa entre cada entrada

    # Enviar el formulario del contrato
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    time.sleep(3)
    print("Contrato registrado exitosamente.")

finally:
    # Esperar 5 segundos antes de cerrar el navegador
    time.sleep(5)
    driver.quit()
