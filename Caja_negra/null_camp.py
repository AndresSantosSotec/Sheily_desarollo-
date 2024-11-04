import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Función para esperar a que un elemento sea clickeable
def esperar_clickable(driver, by, identifier, timeout=10):
    return WebDriverWait(driver, timeout).until(EC.element_to_be_clickable((by, identifier)))

# Inicializar WebDriver
driver = webdriver.Chrome()

# URL de la aplicación web
url = "http://localhost/proyectos%204/Sheily/login_register.php"

try:
    # Acceder a la aplicación
    driver.get(url)
    driver.maximize_window()

    ### PRIMERA PARTE: Validación de Campos Vacíos en el Registro (Caso de Prueba 10) ###
    print("Iniciando Test 1: Validación de Campos Vacíos en el Registro")

    # Cambiar a la pestaña de "Registrarse"
    esperar_clickable(driver, By.ID, 'btn__registrarse').click()

    # Llenar el formulario de registro dejando vacío el campo de correo electrónico
    driver.find_element(By.ID, "nombre").send_keys("Prueba")
    driver.find_element(By.ID, "apellido").send_keys("Usuario")
    driver.find_element(By.ID, "usuario").send_keys("usuarioPrueba")
    driver.find_element(By.ID, "password-register").send_keys("Password123@")
    # No se llena el campo de correo electrónico

    # Intentar enviar el formulario de registro
    esperar_clickable(driver, By.CSS_SELECTOR, "button[type='submit']").click()
    
    # Verificar si aparece el mensaje de error por campos vacíos
    time.sleep(2)  # Esperar la respuesta del sistema
    try:
        error_message = driver.find_element(By.CLASS_NAME, "error").text
        assert "El campo email es obligatorio" in error_message
        print("Test 1 exitoso: Mensaje de error por campo de correo vacío encontrado ->", error_message)
    except Exception as e:
        print("Test 1 fallido: No se encontró el mensaje de error esperado.")

    # Limpiar el formulario antes de la siguiente prueba
    driver.refresh()
    time.sleep(2)

    ### SEGUNDA PARTE: Validación de Correos Electrónicos Inválidos en el Registro (Caso de Prueba 11) ###
    print("Iniciando Test 2: Validación de Correos Electrónicos Inválidos en el Registro")

    # Cambiar a la pestaña de "Registrarse"
    esperar_clickable(driver, By.ID, 'btn__registrarse').click()

    # Llenar el formulario de registro con un correo electrónico inválido
    driver.find_element(By.ID, "nombre").send_keys("Prueba")
    driver.find_element(By.ID, "apellido").send_keys("Usuario")
    driver.find_element(By.ID, "usuario").send_keys("usuarioPrueba")
    driver.find_element(By.ID, "email-register").send_keys("correo_invalido.com")  # Formato incorrecto
    driver.find_element(By.ID, "password-register").send_keys("Password123@")

    # Intentar enviar el formulario de registro
    esperar_clickable(driver, By.CSS_SELECTOR, "button[type='submit']").click()

    # Verificar si aparece el mensaje de error por correo inválido
    time.sleep(2)  # Esperar la respuesta del sistema
    try:
        error_message_invalid_email = driver.find_element(By.CLASS_NAME, "error").text
        assert "Formato de correo electrónico inválido" in error_message_invalid_email
        print("Test 2 exitoso: Mensaje de error por correo inválido encontrado ->", error_message_invalid_email)
    except Exception as e:
        print("Test 2 fallido: No se encontró el mensaje de error esperado.")
    
    # Limpiar el formulario antes de la siguiente prueba
    driver.refresh()
    time.sleep(2)

    ### TERCERA PARTE: Registro Exitoso ###
    print("Iniciando Test 3: Registro de nuevo usuario con datos válidos")

    # Cambiar a la pestaña de "Registrarse"
    esperar_clickable(driver, By.ID, 'btn__registrarse').click()

    # Llenar el formulario de registro con datos válidos
    driver.find_element(By.ID, "nombre").send_keys("Prueba")
    driver.find_element(By.ID, "apellido").send_keys("Usuario")
    driver.find_element(By.ID, "usuario").send_keys("usuarioPrueba")
    driver.find_element(By.ID, "email-register").send_keys("usuario@prueba.com")
    driver.find_element(By.ID, "password-register").send_keys("Password123@")

    # Enviar el formulario
    esperar_clickable(driver, By.CSS_SELECTOR, "button[type='submit']").click()
    time.sleep(2)

    # Verificar si el registro fue exitoso comprobando si cambia a la pantalla de inicio de sesión
    try:
        assert "Iniciar Sesión" in driver.page_source
        print("Test 3 exitoso: Registro completado correctamente.")
    except Exception as e:
        print("Test 3 fallido: El registro no fue exitoso.")

finally:
    # Cerrar el navegador
    driver.quit()
