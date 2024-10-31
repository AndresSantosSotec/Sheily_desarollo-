import numpy as np
import pyautogui
import tkinter as tk
from tkinter import ttk
from PIL import Image, ImageTk
import win32gui
import win32con

# Colores inspirados en Discord
COLOR_FONDO = "#2c2f33"
COLOR_TEXTO = "#ffffff"
COLOR_BOTON = "#7289da"
COLOR_HOVER = "#5b6eae"

# Filtros de daltonismo
filtros_daltonismo = {
    "Protanopia": np.array([
        [0.56667, 0.43333, 0],
        [0.55833, 0.44167, 0],
        [0, 0.24167, 0.75833]
    ]),
    "Deuteranopia": np.array([
        [0.625, 0.375, 0],
        [0.7, 0.3, 0],
        [0, 0.3, 0.7]
    ]),
    "Tritanopia": np.array([
        [0.95, 0.05, 0],
        [0, 0.43333, 0.56667],
        [0, 0.475, 0.525]
    ])
}

# Función para aplicar el filtro de daltonismo
def aplicar_filtro(img, tipo, nivel):
    matriz = filtros_daltonismo[tipo]
    matriz_ajustada = np.clip(matriz * nivel / 100, 0, 1)
    return np.dot(img, matriz_ajustada.T).astype(np.uint8)

# Captura de pantalla sin incluir la ventana (evitar efecto espejo)
def capturar_pantalla():
    ventana.withdraw()  # Oculta la ventana para evitar el "efecto espejo"
    screenshot = pyautogui.screenshot()  # Captura la pantalla
    ventana.deiconify()  # Muestra la ventana de nuevo
    return screenshot

# Actualizar la pantalla con el filtro aplicado
def actualizar_pantalla():
    img = capturar_pantalla()
    tipo = seleccion_filtro.get()
    nivel = slider_nivel.get()

    # Aplicar filtro
    img_filtrada = aplicar_filtro(np.array(img), tipo, nivel)
    img_pil = Image.fromarray(img_filtrada)
    img_tk = ImageTk.PhotoImage(img_pil)

    etiqueta.config(image=img_tk)
    etiqueta.image = img_tk

    ventana.after(500, actualizar_pantalla)  # Actualiza cada 500ms

# Configurar ventana transparente y siempre al frente
def hacer_transparente(hwnd):
    estilos = win32gui.GetWindowLong(hwnd, win32con.GWL_EXSTYLE)
    win32gui.SetWindowLong(
        hwnd,
        win32con.GWL_EXSTYLE,
        estilos | win32con.WS_EX_LAYERED | win32con.WS_EX_TRANSPARENT
    )
    win32gui.SetLayeredWindowAttributes(hwnd, 0, 180, win32con.LWA_ALPHA)

# Configuración de la ventana principal
ventana = tk.Tk()
ventana.title("Filtro de Daltonismo - Estética Discord")
ventana.geometry("1920x1080")
ventana.attributes("-fullscreen", True)
ventana.configure(bg=COLOR_FONDO)
ventana.overrideredirect(True)  # Elimina la barra de título

# Configurar ventana para transparencia de clics y estilo superposición
hwnd = win32gui.GetForegroundWindow()
hacer_transparente(hwnd)

# Configuración del estilo de widgets
style = ttk.Style()
style.configure("TLabel", background=COLOR_FONDO, foreground=COLOR_TEXTO, font=("Helvetica", 14))
style.configure("TButton", background=COLOR_BOTON, foreground=COLOR_TEXTO, font=("Helvetica", 12, "bold"))
style.map("TButton", background=[("active", COLOR_HOVER)])

# Selección de filtro y ajuste de nivel
ttk.Label(ventana, text="Seleccione el tipo de daltonismo:", font=("Helvetica", 16, "bold")).pack(pady=10)
seleccion_filtro = tk.StringVar(ventana)
seleccion_filtro.set("Protanopia")
menu_filtro = ttk.OptionMenu(ventana, seleccion_filtro, *filtros_daltonismo.keys())
menu_filtro.pack(pady=5, ipadx=10, ipady=5)

ttk.Label(ventana, text="Ajustar nivel del filtro:", font=("Helvetica", 16)).pack(pady=20)
slider_nivel = ttk.Scale(ventana, from_=0, to=100, orient="horizontal")
slider_nivel.set(50)
slider_nivel.pack(padx=20, pady=5, fill='x')

# Etiqueta para mostrar la imagen filtrada
etiqueta = ttk.Label(ventana)
etiqueta.pack(pady=20)

# Botón para salir de la simulación
boton_salir = ttk.Button(ventana, text="Salir", style="TButton", command=ventana.quit)
boton_salir.pack(pady=20, ipadx=20, ipady=10)

# Iniciar la actualización de pantalla
actualizar_pantalla()

# Ejecutar la ventana principal
ventana.mainloop()
