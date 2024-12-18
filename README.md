
# **CRUD_Sessions_Users**

## Tabla de Contenidos

- [Introducción](#introducción)
- [Características](#características)
- [Tecnologías Usadas](#tecnologías-usadas)
- [Instrucciones de Configuración](#instrucciones-de-configuración)
- [Uso](#uso)
- [Capturas de Pantalla](#capturas-de-pantalla)
- [Estructura del Código](#estructura-del-código)
- [Contribución](#contribución)
- [Licencia](#licencia)

---

## Introducción

**CRUD_Sessions_Users** es una aplicación web que permite gestionar usuarios y automóviles mediante operaciones **CRUD** (Crear, Leer, Actualizar, Eliminar). Proporciona autenticación de usuarios con manejo de sesiones y la posibilidad de **recordar las credenciales del usuario** gracias al uso de **cookies** en PHP.

El sistema también incluye alertas interactivas de confirmación y error implementadas con **SweetAlert2**, garantizando una experiencia de usuario amigable y dinámica.

---

## Características

### Características para Invitados

- Visualización de la lista de automóviles públicos.
- Acceso a formularios de inicio de sesión y registro.

### Características para Usuarios Registrados

- **Inicio/cierre de sesión** con opción para **recordar credenciales** mediante cookies.
- Crear nuevos registros de automóviles con validación de entradas.
- Actualizar datos de automóviles y usuarios con validaciones de duplicado.
- Eliminar registros con alertas de confirmación.
- Visualización de notificaciones de éxito en acciones completadas.

### Características para Administradores

- Gestión completa de usuarios (crear, actualizar, eliminar).
- Visualización de la lista de usuarios y detalles.
- Actualización de perfiles con validaciones específicas.

---

## Tecnologías Usadas

### Frontend

- **HTML5** y **CSS3** para la estructura y estilo.
- **Tailwind CSS** para un diseño moderno y responsivo.
- **SweetAlert2** para mostrar alertas interactivas en eventos como **inicio de sesión**, **crear**, **actualizar** y **eliminar registros**.

### Backend

- **PHP 8.1+** para lógica de servidor y gestión de sesiones.
- **Composer** para gestión de dependencias.
- **Faker Library** para la generación de datos ficticios.

### Base de Datos

- **MySQL** para el almacenamiento persistente de usuarios y automóviles.

---

## Instrucciones de Configuración

### Requisitos Previos

- PHP 8.1 o superior.
- MySQL.
- Composer.
- Un servidor web (Apache).

### Pasos

1. **Clonar el repositorio:**

   ```bash
   git clone https://github.com/Omatple/CRUD_Sessions_Users.git
   cd CRUD_Sessions_Users
   ```

2. **Actualizar dependencias:**

   ```bash
   composer update
   ```

3. **Configurar la base de datos:**
   - Crear una nueva base de datos en MySQL.
   - Importar el esquema de base de datos desde `database/tables.sql`.

4. **Configurar el entorno:**
   - Renombrar `env.example` a `.env`.
   - Actualizar las credenciales de la base de datos:

     ```env
     HOST='127.0.0.1'
     PORT='3306'
     DBNAME='<nombre_de_tu_base_de_datos>'
     USERNAME='<usuario_mysql>'
     PASSWORD='<contraseña_mysql>'
     ```

5. **Ejecutar la aplicación:**
   - Configurar Apache para apuntar al directorio `public/`.
   - Acceder a `http://127.0.0.1` desde el navegador.

6. **Generar datos ficticios (opcional):**

   ```bash
   php scripts/generateFakeData.php
   ```

---

## Uso

### Invitado

- Acceder a la página principal, inicio de sesión o registro.

### Usuario

- Actualizar su perfil.
- Visualizar la lista de automóviles.

### Administrador

- **Gestión de Automóviles:**
  - Crear, editar y eliminar registros.
- **Gestión de Usuarios:**
  - Agregar nuevos usuarios.
  - Editar o eliminar usuarios.

---

## Capturas de Pantalla

### Página de Registro - Formulario Vacío

![Registro Vacío](public/screenshots/Registration%20Page%20-%20Empty%20Form.png)

### Página de Registro - Errores de Validación

![Registro Errores](public/screenshots/Registration%20Page%20-%20Validation%20Errors.png)

### Página de Inicio de Sesión - Formulario Vacío

![Login Vacío](public/screenshots/Login%20Page%20-%20Empty%20Form.png)

### Página de Inicio de Sesión - Errores de Validación

![Login Errores](public/screenshots/Login%20Page%20-%20Validation%20Errors.png)

### Lista de Automóviles - Vista Invitado

![Lista Automóviles Invitado](public/screenshots/Cars%20List%20Page%20-%20Guest%20View.png)

### Lista de Automóviles - Vista Administrador

![Lista Automóviles Admin](public/screenshots/Cars%20List%20Page%20-%20Logged-in%20Admin%20View.png)

### Agregar Nuevo Automóvil - Formulario Vacío

![Nuevo Automóvil Vacío](public/screenshots/Add%20New%20Car%20Page%20-%20Empty%20Form.png)

### Agregar Nuevo Automóvil - Errores de Validación

![Nuevo Automóvil Errores](public/screenshots/Add%20New%20Car%20Page%20-%20Validation%20Errors.png)

### Actualizar Automóvil - Formulario Lleno

![Actualizar Automóvil](public/screenshots/Update%20Car%20Page%20-%20Filled%20Form.png)

### Actualizar Automóvil - Error por Duplicado

![Actualizar Duplicado](public/screenshots/Update%20Car%20Page%20-%20Duplicate%20Car%20Error.png)

### Editar Perfil de Usuario - Formulario Vacío

![Editar Perfil Vacío](public/screenshots/Edit%20User%20Profile%20Page%20-%20Empty%20Form.png)

### Editar Perfil de Usuario - Errores de Validación

![Editar Perfil Errores](public/screenshots/Edit%20User%20Profile%20Page%20-%20Validation%20Errors.png)

### Editar Perfil de Usuario - Formulario Lleno

![Editar Perfil Lleno](public/screenshots/Edit%20User%20Profile%20Page%20-%20Filled%20Form.png)

### Editar Perfil de Usuario - Error por Nombre o Correo Duplicado

![Editar Perfil Duplicado](public/screenshots/Edit%20User%20Profile%20Page%20-%20Duplicate%20Username%20or%20Email%20Error.png)

### Lista de Usuarios - Vista Administrador

![Lista Usuarios Admin](public/screenshots/Users%20List%20Page%20-%20Admin%20View.png)

### Lista de Usuarios - Notificación de Actualización Exitosa

![Notificación de Actualización](public/screenshots/Users%20List%20Page%20-%20Update%20Success%20Notification.png)

---

## Estructura del Código

### Directorios y Archivos

```
CRUD_Sessions_Users/
├── database/
│   ├── tables.sql                 # Esquema de la base de datos.
├── public/
│   ├── cars/
│   │   ├── img/                   # Imágenes de automóviles.
│   │   ├── delete.php             # Eliminar un automóvil.
│   │   ├── index.php              # Listar automóviles.
│   │   ├── new.php                # Formulario para agregar automóviles.
│   │   ├── update.php             # Actualizar datos de automóviles.
│   ├── screenshots/               # Capturas de pantalla.
│   │   ├── Add New Car Page - Empty Form.png
│   │   ├── Add New Car Page - Validation Errors.png
│   │   ├── Cars List Page - Guest View.png
│   │   ├── Cars List Page - Logged-in Admin View.png
│   │   ├── Edit User Profile Page - Duplicate Username or Email Error.png
│   │   ├── Edit User Profile Page - Empty Form.png
│   │   ├── Edit User Profile Page - Filled Form.png
│   │   ├── Edit User Profile Page - Validation Errors.png
│   │   ├── Login Page - Empty Form.png
│   │   ├── Login Page - Validation Errors.png
│   │   ├── Registration Page - Empty Form.png
│   │   ├── Registration Page - Validation Errors.png
│   │   ├── Update Car Page - Duplicate Car Error.png
│   │   ├── Update Car Page - Filled Form.png
│   │   ├── Users List Page - Admin View.png
│   │   ├── Users List Page - Update Success Notification.png
│   ├── users/
│   │   ├── img/                   # Imágenes de usuarios.
│   │   ├── delete.php             # Eliminar un usuario.
│   │   ├── index.php              # Listar usuarios.
│   │   ├── new.php                # Formulario para agregar usuarios.
│   │   ├── update.php             # Actualizar datos de usuarios.
│   ├── login.php                  # Página de inicio de sesión.
│   ├── logout.php                 # Cerrar sesión.
│   ├── register.php               # Página de registro.
├── scripts/
│   ├── generateFakeData.php       # Script para generar datos ficticios.
├── src/
│   ├── Database/
│   │   ├── CarModel.php           # Modelo de datos de automóviles.
│   │   ├── Connection.php         # Conexión a la base de datos.
│   │   ├── QueryExecutor.php      # Ejecutor de consultas SQL.
│   │   ├── UserModel.php          # Modelo de datos de usuarios.
│   ├── Utils/
│   │   ├── CarBrand.php           # Constantes relacionadas con las marcas de automóviles.
│   │   ├── CarValidator.php       # Validación de datos de automóviles.
│   │   ├── CookiesManager.php     # Gestión de cookies para recordar credenciales de usuario.
│   │   ├── ImageConstants.php     # Constantes de imágenes (tamaño, nombre por defecto, etc.).
│   │   ├── ImageProcessor.php     # Procesamiento de imágenes (subida y validación).
│   │   ├── InputValidator.php     # Validación de entradas de formularios.
│   │   ├── Navigation.php         # Manejo de redirección y navegación de páginas.
│   │   ├── NotificationAlert.php  # Generación de alertas con SweetAlert2.
│   │   ├── Role.php               # Enumeración de roles (Admin, User, etc.).
│   │   ├── SessionErrorDisplay.php# Mostrar errores de sesión.
│   │   ├── UserValidator.php      # Validación específica para usuarios.
├── .env                           # Configuración de entorno.
├── .gitignore                     # Archivos ignorados por Git.
├── composer.json                  # Dependencias del proyecto.
├── composer.lock                  # Registro de versiones exactas de dependencias.
├── env.example                    # Archivo de ejemplo para configuración del entorno.
├── LICENSE.txt                    # Licencia del proyecto.
├── README.md                      # Documentación del proyecto.
```

---

## Contribución

1. Realiza un fork del repositorio.
2. Crea una rama para tus cambios:

   ```bash
   git checkout -b feature/new-feature
   ```

3. Realiza commits de tus cambios:

   ```bash
   git commit -m "Descripción de los cambios"
   ```

4. Sube los cambios a tu repositorio fork:

   ```bash
   git push origin feature/new-feature
   ```

5. Envía un Pull Request para revisión.

---

## Licencia

Este proyecto está licenciado bajo la [Licencia MIT](LICENSE.txt).
