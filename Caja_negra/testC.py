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

    # Acceder al formulario de Contrato C
    esperar_clickable(By.CSS_SELECTOR, "div.card[onclick*='ContratoC']").click()
    time.sleep(2)

    # Llenar los campos del formulario de Contrato C
    contrato_c = {
        "edadCorpo":"48",
        "nombreEmisor": "Pablo Santos",
        "edadEmisor": "40",
        "dpiEmisor": "192556811601",
        "departamentoEmisor": "Guatemala",
        "municipioEmisor": "Zona 1",
        "representanteEmisor": "Representante Legal",
        "entidadEmisor": "Empresa Emisora S.A.",
        "acreditaEmisor": "Patente de Comercio",
        "notarioEmisor": "Lic. Juan López",
        "registroMercantilEmisor": "123456",
        "folioEmisor": "45",
        "libroEmisor": "150",
        "nombreDistribuidor": "Juan Torres",
        "edadDistribuidor": "45",
        "dpiDistribuidor": "19216813001",
        "departamentoDistribuidor": "Guatemala",
        "municipioDistribuidor": "Guatemala",
        "representanteDistribuidor": "Propietario",
        "entidadDistribuidor": "Distribuidora XYZ",
        "acreditaDistribuidor": "Patente de Comercio",
        "notarioDistribuidor": "Lic. Carlos Martínez",
        "registroMercantilDistribuidor": "987654",
        "folioDistribuidor": "12",
        "libroDistribuidor": "15",
        "actividadEconomica": "Venta al por mayor",
        "nitDistribuidor": "123456789-1",
        "fechaVigencia": "16-05-2024"
    }

    # Llenar cada campo del formulario
    for campo, valor in contrato_c.items():
        driver.find_element(By.ID, campo).send_keys(valor)
        time.sleep(1)

    # Enviar el formulario
    esperar_clickable(By.CSS_SELECTOR, "button.btn-primary").click()
    print("Contrato C creado exitosamente.")
finally:
    driver.quit()
