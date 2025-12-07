Guía de Configuración del Entorno de Desarrollo (Local)
Proyecto: Void Box CMS Sistema Operativo: Linux Mint (Base Ubuntu/Debian) Fecha de Configuración: 26 de Noviembre, 2025 Tipo de Entorno: LAMP Stack (Linux, Apache, MariaDB, PHP)
1. Actualización del Sistema
Se aseguró que los repositorios y paquetes del sistema operativo base estuvieran sincronizados.
Bash
sudo apt update && sudo apt upgrade -y

2. Servidor Web (Apache)
Instalación del servidor HTTP para servir la aplicación web.
Paquete: apache2
Estado: Activo y ejecutándose.
Verificación: Acceso exitoso a http://localhost.
3. Lenguaje y Extensiones (PHP)
Instalación del intérprete PHP y las librerías necesarias para el CMS (manejo de XML para Markdown, MySQL para la base de datos, etc.).
Comando de instalación:
Bash
sudo apt install php libapache2-mod-php php-mysql php-xml php-mbstring php-curl php-zip unzip -y


4. Base de Datos (MariaDB)
Instalación del sistema gestor de base de datos relacional.
Paquete: mariadb-server
Seguridad: Se ejecutó el script mysql_secure_installation para endurecer la seguridad predeterminada.
5. Gestión de Dependencias (Composer)
Instalación del gestor de paquetes estándar de PHP para futuras librerías (Parsedown).
Binario: Instalado globalmente en /usr/local/bin/composer.
6. Permisos del Directorio Web
Se modificó la propiedad del directorio raíz de Apache para permitir la edición sin privilegios elevados (sudo), facilitando el desarrollo en IDEs.
Directorio: /var/www/html
Comando ejecutado:
Bash
sudo chown -R $USER:$USER /var/www/html


7. Herramientas de Administración (phpMyAdmin)
Instalación de interfaz gráfica para gestión de bases de datos.
7.1 Corrección de Configuración Apache
Se detectó un fallo en la vinculación automática durante la instalación. Se aplicó la siguiente corrección manual para vincular la configuración de phpMyAdmin a Apache:
Bash
# Crear enlace simbólico
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf

# Habilitar configuración y recargar servicio
sudo a2enconf phpmyadmin
sudo systemctl reload apache2

7.2 Creación de Usuario Administrativo
Debido a las restricciones de acceso root en MariaDB vía socket unix, se creó un superusuario dedicado para el acceso vía phpMyAdmin/Web.
Sentencias SQL Ejecutadas:
SQL
CREATE USER 'admin'@'localhost' IDENTIFIED BY '[CREDENCIAL_SEGURA]';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;


Acceso: http://localhost/phpmyadmin
Credenciales: Usuario admin activo.

8. Estrategia de Control de Versiones (Git/GitHub)
El proyecto utiliza Git para el control de versiones, alojado en GitHub. Se implementa una estrategia de seguridad estricta para prevenir la filtración de credenciales en un entorno de repositorio público.
8.1 Información del Repositorio
URL Pública: https://github.com/LuisEnriquePH/capibaragames.com
Rama Principal: main (Producción/Estable)
Gestión de Acceso: Vía SSH con pares de llaves dedicadas (Ed25519).
8.2 Protocolo de Seguridad (.gitignore)
Se ha configurado un archivo .gitignore robusto para excluir explícitamente cualquier archivo que contenga vectores de ataque o información sensible del servidor.
Archivos Excluidos (Nunca se suben):
/config/db.php: Contiene credenciales de acceso a la base de datos (Host, Usuario, Contraseña).
/vendor/: Directorio de dependencias gestionado por Composer.
/.env: Variables de entorno (si aplica en el futuro).
Logs y archivos temporales del sistema (.DS_Store, Thumbs.db).
8.3 Flujo de Trabajo (Workflow)
Para mantener la integridad del código, el flujo de desarrollo estándar es:
Desarrollo: Codificación en entorno local (Linux Mint).
Staging: git add . para preparar los cambios.
Commit: git commit -m "Descripción semántica del cambio" (Usar verbos imperativos: "Agrega", "Corrige", "Refactoriza").
Push: git push origin main (Autenticado vía alias SSH configurado en ~/.ssh/config).
8.4 Configuración de Conexión (SSH Alias)
Debido al uso de múltiples identidades en la máquina de desarrollo, el repositorio remoto se configura utilizando un alias de host para asegurar el uso de la llave SSH correcta:
Bash
# Configuración del remoto (Ejemplo)
git remote add origin git@github.com-LuisEnriquePH:LuisEnriquePH/capibaragames.com.git

