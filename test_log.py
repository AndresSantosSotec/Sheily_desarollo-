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
    time.sleep(3)

    def esperar_clickable(by, identifier, timeout=15):
        """Espera hasta que un elemento sea clickeable."""
        return WebDriverWait(driver, timeout).until(
            EC.element_to_be_clickable((by, identifier))
        )

    # Inicia sesión
    correo = "sheilyGonzalezAdmin@gmail.com"
    contrasena = "Sheily1995@"

    esperar_clickable(By.ID, 'btn__iniciar-sesion').click()
    time.sleep(2)
    driver.find_element(By.ID, "email").send_keys(correo)
    driver.find_element(By.ID, "password").send_keys(contrasena)
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    time.sleep(3)

    # Verifica si el login fue exitoso
    if "Dashboard - Gestión de Contratos" in driver.page_source:
        print("Inicio de sesión exitoso.")
    else:
        print("Error en el inicio de sesión.")
        driver.quit()
        exit()

    # Navega al contrato de servicio a terceros
    esperar_clickable(By.CSS_SELECTOR, "div.card").click()
    time.sleep(2)

    # Completa el formulario de contrato de servicio a terceros
    contrato_terceros = {
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

    for campo, valor in contrato_terceros.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(1)

    # Envía el formulario
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    print("Contrato de Servicio a Terceros registrado exitosamente.")
    time.sleep(5)

    # Regresa al inicio usando la barra lateral
    esperar_clickable(By.CSS_SELECTOR, "a[href='dashboard.php']").click()
    time.sleep(3)

    # Navega al contrato con distribuidores
    esperar_clickable(By.CSS_SELECTOR, "div.card.w-100[onclick*='ContratoB']").click()
    time.sleep(2)

    # Completa el formulario del contrato con distribuidores
    contrato_distribuidores = {
        "nombreEmisor": "Pedro Gómez",
        "edadEmisor": "50",
        "dpiEmisor": "1234567890001",
        "nombreDistribuidor": "Distribuidora ABC",
        "edadDistribuidor": "45",
        "dpiDistribuidor": "9876543210001",
        "domicilioDistribuidor": "Zona 10, Guatemala",
        "municipio": "Guatemala",
        "departamento": "Guatemala",
        "entidad": "Distribuidora ABC S.A.",
        "registroMercantil": "98765",
        "folio": "12",
        "libro": "Libro B",
        "nit": "78945612-3",
        "fechaInicio": "2024-01-01",
        "direccionDistribuidora": "Avenida Reforma 12-34, Guatemala"
    }

    for campo, valor in contrato_distribuidores.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(1)

    # Envía el formulario del contrato con distribuidores
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    print("Contrato con Distribuidores registrado exitosamente.")
    time.sleep(5)

    # Regresa al inicio usando la barra lateral
    esperar_clickable(By.CSS_SELECTOR, "a[href='dashboard.php']").click()
    print("Navegación finalizada con éxito.")

finally:
    # Espera 5 segundos y cierra el navegador
    time.sleep(5)
    driver.quit()
