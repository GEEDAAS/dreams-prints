# Dreams&Prints 🎨🖨️

**Dreams&Prints** es un sistema web de impresiones personalizadas, desarrollado como proyecto final para la materia de *Ingeniería de Software*. Su objetivo es permitir a los clientes diseñar ideas creativas, realizar pedidos personalizados y gestionar su historial de compras, mientras los administradores controlan productos, ideas y verifican pagos.

## 🌐 Tecnologías utilizadas

- **Frontend:** HTML, CSS, JavaScript, AJAX
- **Backend:** PHP
- **Base de Datos:** MySQL
- **Control de versiones:** Git

---

## 🎓 Propósito Académico

Este proyecto fue desarrollado como entrega final del curso Ingeniería de Software, aplicando todas las etapas del ciclo de desarrollo de software: análisis de requerimientos, diseño arquitectónico, implementación y pruebas funcionales.

---

## ⚙️ Estructura del Proyecto

El sistema está estructurado según el patrón **Modelo-Vista-Controlador (MVC)** para mantener una separación clara entre la lógica del negocio, la presentación y el acceso a datos:

- `Dreams&Prints/`
  - `app/`
    - `controllers/` – Lógica de control (Cliente y Administrador)
    - `models/` – Acceso a datos y operaciones sobre la base de datos
    - `views/` – Interfaz de usuario separada por tipo de usuario
      - `cliente/` – Vistas del cliente (catálogo, cuenta, pagos, etc.)
      - `admin/` – Vistas del administrador (productos, ideas, pedidos)
      - `Inicio.php` – Vista principal del sistema web
  - `config/` – Configuración del sistema (credenciales, rutas, constantes)
  - `public/` – Carpeta pública del servidor (recursos accesibles directamente)
    - `css/` – Archivos de estilos personalizados
    - `js/` – Scripts de funcionalidad (AJAX, validaciones, etc.)
    - `Image/` – Imágenes utilizadas en el sitio (productos, perfiles, etc.)
    - `index.php` – Punto de entrada principal del sitio
  - `routes/` – Definición de rutas del sistema (mapa de URLs y controladores)
  - `.env` – Variables de entorno (configuración local sensible)

---

## 👤 Funcionalidades del Cliente

- Registro e inicio de sesión
- Visualización del catálogo de productos
- Agregado de productos al carrito
- Registro y gestión de ideas creativas
- Selección de método de pago
- Visualización del historial de compras
- Recuperación de contraseña

## 🛠️ Funcionalidades del Administrador

- Alta, edición e inactivación de productos
- Revisión, activación o desactivación de ideas de clientes
- Verificación y aprobación de pagos
- Cambios de estado en pedidos e impresiones
- Consulta de tarjetas registradas por los usuarios

---

## 🔐 Acceso

- **Cliente:** Registro libre desde la plataforma.
- **Administrador:** Acceso creado manualmente desde la base de datos.

---

## 📁 Instalación

Sigue estos pasos para ejecutar el sistema en tu entorno local:

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/usuario/DreamsPrints.git

2. **Mover al servidor local**
    Copia la carpeta del proyecto a htdocs si usas XAMPP, o la carpeta raíz correspondiente de tu servidor local.

3. **Crear base de datos**
    Abre phpMyAdmin y crea una base de datos (por ejemplo: dreams_prints_db). Importa el script .sql correspondiente

4. **Configurar conexión**
    Edita el archivo config/conexion.php (o .env si usas carga de variables)

5. **Iniciar el sistema**
    Abre tu navegador en:
    ```bash
    http://localhost/DreamsPrints/public/
    