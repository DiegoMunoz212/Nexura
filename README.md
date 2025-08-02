Proyecto: Nexura

# Nexura — CRUD de Empleados con PHP Orientado a Objetos

Este proyecto es un sistema de gestión de empleados (CRUD) desarrollado en **PHP puro con orientación a objetos**, utilizando **MySQL** como base de datos y **Bootstrap 5** para el diseño visual.

## 🧠 Funcionalidades

- ✅ Crear, listar, editar y eliminar empleados
- ✅ Validación de datos en el cliente (JavaScript) y servidor (PHP)
- ✅ Selección de roles obligatoria (checkbox múltiple)
- ✅ Inscripción opcional al boletín (checkbox)
- ✅ Diseño responsivo con Bootstrap 5
- ✅ Protección de rutas y estructura de carpetas
- ✅ Mensajes de éxito y error con `alert` y Bootstrap
- ✅ Estructura organizada en MVC básico (Model, View, Controller)
- ✅ Redirección automática a `listar.php` al acceder a `/nexura/`
- ✅ Seguridad: se evita acceso directo a carpetas como `controllers`, `models`, `config`, etc.

--- 

## 📁 Estructura del Proyecto
nexura/
├── config/
│ └── database.php # Conexión PDO a MySQL
│
├── controllers/
│ └── EmpleadoController.php # Lógica del CRUD
│
├── models/
│ ├── Empleado.php # Clase Empleado con métodos DB
│ ├── Area.php # Clase Area con métodos DB
│ └── Rol.php # Clase Rol con métodos DB
│
├── views/
│ └── empleados/
│   ├── crear.php # Formulario para agregar
│   ├── editar.php # Formulario para editar
│   └── listar.php # Lista con acciones
│
├── .htaccess # Configuración de rutas y protección
├── nexura.sql # Base de datos
└── README.md # Este archivo

---

## ⚙️ Requisitos

- PHP 8+
- MySQL 5.7 o superior
- Apache (recomendado: XAMPP)
- Navegador moderno

---

## 🚀 Instalación rápida

1. Clona el proyecto o copia los archivos a `htdocs/nexura`
2. Crea la base de datos en MySQL:

   - Ejecuta el script SQL proporcionado (`database.sql`) en MySQL Workbench o phpMyAdmin
   - O usa el script de inserción para cargar datos de prueba

3. Abre XAMPP y enciende Apache + MySQL
4. Abre el navegador y accede a: http://localhost/nexura/


---

## 📋 Validaciones

- En el cliente (JavaScript):
  - Todos los campos requeridos
  - Selección obligatoria de al menos un rol
- En el servidor (PHP):
  - Validación completa (evita inyecciones)
  - Rechaza campos vacíos o incorrectos

---

## 🔒 Seguridad

- `.htaccess` impide el acceso directo a carpetas críticas
- Solo se puede acceder a:
  - `listar.php`
  - `crear.php`
  - `editar.php`
  - `EmpleadoController.php` (solo para solicitudes POST)

---

## 📌 Extras posibles

- Autenticación con sesiones
- Filtro de búsqueda por nombre o área
- Exportar a Excel o PDF
- Paginación de resultados
- Rutas limpias (tipo `/crear`, `/editar/5`) con `router.php`

---

## 🧑‍💻 Autor

Desarrollado por Diego Fernando Muñoz Jansasoy  
Proyecto técnico para Nexura, 2025






