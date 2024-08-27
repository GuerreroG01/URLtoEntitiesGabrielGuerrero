# Extractor de Entidades Web

Este proyecto es una aplicación web desarrollada con Laravel, jQuery y Python que permite a los usuarios ingresar una URL, extraer su contenido y calcular las entidades presentes en dicho contenido utilizando la API de Google para entidades. La aplicación muestra las 5 entidades más relevantes en una tabla.

## Requisitos

- **Laravel 9.x**
- **Python 3.x**
- **Composer**
- **Google Cloud SDK** 
- **Playwright**
- **BeautifulSoup4**

### Instalar dependencias
composer install

### Configuracion de entorno y genera la clave
cp .env.example .env
php artisan key:generate

### Instalar dependencias de python
pip install google-cloud-language playwright beautifulsoup4

### Habilitar Google Cloud API 
## Descarga las credenciales del servicio y configura la variable de entorno GOOGLE_APPLICATION_CREDENTIALS que apunte al archivo de credenciales json.

# export GOOGLE_APPLICATION_CREDENTIALS="/agrega la ruta/credenciales.json"

### Ejecuta playwright (solo la primera vez)
python -m playwright install

### Ejecuta
php artisan serve


**Estructura relevante del proyecto:** 

**app/Http/Controllers/EntityController.php**
**resources/views/index.blade.php**
**scripts/extract_entities.py**
**routes/web.php**

**Consideraciones**
**Asegurate de que las urls ingresadas sean accesibles y no se requiera autenticacion.**
**El tiempo de extraccion y analisis de las entidades puede llevar algunos segundos dependiendo del tamaño y complejidad de la pagina.**


**Este archivo `README.md` proporciona una guía detallada sobre cómo configurar y ejecutar el proyecto como tambien la estructura y algunas cosas que considere relevante**
