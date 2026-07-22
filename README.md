# 📺 SeriesSphere

Plataforma web para el seguimiento y descubrimiento de series de televisión. Desarrollada como **Proyecto Final de Ciclo (DAW)** en el IES El Cañaveral.

> Inspirada en plataformas como IMDB o Letterboxd, SeriesSphere permite a los usuarios llevar un registro organizado de las series que ven, han visto o quieren ver, así como descubrir nuevas recomendaciones.

---

## 📸 Vista del proyecto
 
**Inicio**
![Home](docs/screenshots/home.png)
 
**Búsqueda**
![Search](docs/screenshots/search.png)
 
**Registro**
![Register](docs/screenshots/register.png)
 
**Página de serie (1)**
![Serie Profile 1](docs/screenshots/serie-profile-1.png)
 
**Página de serie (2)**
![Serie Profile 2](docs/screenshots/serie-profile-2.png)
 
**Perfil de usuario**
![User Profile](docs/screenshots/user-profile.png)
 
---

## 🛠 Stack tecnológico

| Categoría | Tecnología |
|---|---|
| Backend | PHP · Symfony |
| Plantillas | Twig |
| Frontend | HTML5 · CSS3 · JavaScript · Bootstrap |
| Interactividad | jQuery · AJAX · Select2 |
| Visualización | amCharts |
| Base de datos | MySQL · Doctrine ORM |
| Control de versiones | Git · GitHub |
| Entorno | Linux · VirtualBox |

---

## ✨ Funcionalidades principales

### 👤 Roles de usuario

El sistema implementa tres roles con permisos diferenciados:

| Rol | Permisos |
|---|---|
| **Usuario** | Buscar series, gestionar listas personales, seguimiento de episodios |
| **Manager** | Acceso a gráficas estadísticas de uso de la plataforma |
| **Admin** | CRUD completo sobre series, géneros, temporadas y usuarios |

### 📋 Gestión de listas
- **Viendo** → series en progreso con seguimiento de temporada y capítulo
- **Vistas** → historial de series completadas
- **Por ver** → lista de seguimiento y watchlist
- **Favoritas** → series marcadas como favoritas

### 🔍 Búsqueda y descubrimiento
- Búsqueda en tiempo real por nombre mediante **AJAX** (sin recargar la página)
- Filtrado avanzado por **género**, **plataforma de streaming** y **año de lanzamiento** con **Select2**
- Página de series **Destacadas** con recomendaciones por popularidad y novedades

### 📊 Seguimiento de episodios
- Contador de temporada y capítulo actual por serie
- Actualización dinámica desde la página de inicio
- Persistencia por usuario en base de datos

### 📈 Panel de estadísticas (Manager)
- Gráficas interactivas con **amCharts**
- Géneros más frecuentes entre los programas de la plataforma

### 🔐 Seguridad
- Autenticación de usuarios con sesiones
- Contraseñas encriptadas con el hasher de Symfony (`PasswordAuthenticatedUserInterface`)
- Control de acceso por rol en todas las rutas
- Páginas de error personalizadas (404, acceso denegado)
- Sistema de **logs rotativos** con Monolog para trazabilidad de acciones administrativas

---

## 🗂 Estructura de la base de datos

```
usuario          → lista (1:N)
serie            → temporada (1:N)
serie            → genero (N:M) via genero_serie
serie            → streaming (N:M) via streaming_serie
serie            → director (N:M) via director_serie
lista            → serie (N:M) via serie_lista
usuario          → contador_capitulos (seguimiento por serie)
```

---

## 🚀 Cómo ejecutarlo en local

### Requisitos previos
- PHP 8.x
- Composer
- MySQL
- Symfony CLI (opcional)

### 1. Clona el repositorio

```bash
git clone https://github.com/jorgemonteroh/TFG_23-24.git
cd series-tracker
```

### 2. Instala las dependencias

```bash
composer install
```

### 3. Configura el entorno

Copia el archivo de entorno y edita los datos de conexión a la base de datos:

```bash
cp .env .env.local
```

```env
DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/seriesSphere"
```

### 4. Crea la base de datos y ejecuta las migraciones

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Arranca el servidor

```bash
symfony server:start
# o alternativamente:
php -S localhost:8000 -t public/
```

La aplicación estará disponible en `http://localhost:8000`

---

## 📁 Estructura del proyecto

```
proyecto_final/
├── config/
│   └── packages/
│       └── monolog.yaml        # Configuración de logs rotativos
├── src/
│   ├── Controller/
│   │   ├── SecurityController.php
│   │   ├── HomeController.php
│   │   ├── ListaController.php
│   │   ├── SerieController.php
│   │   ├── BusquedaController.php
│   │   ├── InvitadoController.php
│   │   ├── DashboardController.php  # Admin CRUD
│   │   └── ManagerController.php    # Estadísticas
│   ├── Entity/
│   │   ├── Usuario.php
│   │   ├── Serie.php
│   │   ├── Lista.php
│   │   ├── SerieLista.php
│   │   ├── Genero.php
│   │   ├── Streaming.php
│   │   ├── Director.php
│   │   ├── Temporada.php
│   │   └── ContadorCapitulos.php
│   └── Repository/
│   │   ├── UsuarioRepository.php
│   │   ├── SerieRepository.php
│   │   ├── ListaRepository.php
│   │   ├── SerieListaRepository.php
│   │   ├── GeneroRepository.php
│   │   ├── StreamingRepository.php
│   │   ├── DirectorRepository.php
│   │   ├── TemporadaRepository.php
│   │   └── ContadorCapitulosRepository.php
├── templates/                  # Vistas Twig
├── public/                     # Assets Symfony (CSS, JS, imágenes)
├── assets/                     # Assets Específicos App (CSS, JS, imágenes)
└── var/log/                    # Logs del sistema
```

---

## 💡 Decisiones técnicas

**¿Por qué Symfony?**
Symfony impone la arquitectura MVC de forma natural, incluye componentes de seguridad robustos y Doctrine como ORM, lo que permitió gestionar relaciones complejas entre entidades sin escribir SQL directamente.

**¿Por qué AJAX para la búsqueda?**
La búsqueda en tiempo real sin recargar la página mejora significativamente la experiencia de usuario. Se implementó con jQuery y una ruta específica en el controlador que devuelve HTML renderizado.

**¿Por qué un sistema de logs rotativos?**
Para mantener trazabilidad de las acciones administrativas (creación, modificación y eliminación de datos) sin que los archivos de log crezcan indefinidamente. Configurado con Monolog y rotación diaria con máximo de 30 archivos.

**¿Por qué tres roles de usuario?**
Separar las responsabilidades de gestión de contenido (Admin), análisis de datos (Manager) y uso de la plataforma (Usuario) permite escalar la aplicación sin comprometer la seguridad ni la experiencia de cada tipo de usuario.

---

## 📄 Licencia

MIT — libre para usar y modificar.

---

*Desarrollado por [Jorge Montero Holgado](https://linkedin.com/in/jorgemonteroholgado) · Proyecto Final de Ciclo DAW · IES El Cañaveral · 2024*
