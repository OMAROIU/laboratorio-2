## nombres 
## Omar Salvador Garcia Vasquez
## Flor Marina Torres Jandres

1. ¿De qué forma manejaste el login de usuarios? Explica con tus palabras por qué en tu página funciona de esa forma.
El login se manejó mediante el uso de Sesiones de PHP (session_start) y consultas preparadas con MySQL. Funciona verificando si el nombre de usuario existe en la tabla usuarios; si existe, se compara la contraseña ingresada con la almacenada en la base de datos. He implementado una validación flexible que permite comparar tanto texto plano como hashes encriptados para asegurar que el acceso sea funcional durante las pruebas en XAMPP una vez validado, se crea una variable de sesión que "recuerda" al usuario, permitiéndole acceder al panel de gestión sin tener que reingresar sus credenciales en cada página.

2. ¿Por qué es necesario para las aplicaciones web utilizar bases de datos en lugar de variables?
Las variables en PHP son volátiles y su ciclo de vida termina en cuanto el script finaliza su ejecución o se cierra el navegador. Para una aplicación que requiere un control de usuarios y registro de datos (como este laboratorio), es indispensable la persistencia. Una base de datos relacional (MariaDB) permite que la información se almacene de forma permanente en el disco duro del servidor, permitiendo recuperar, ordenar y filtrar los datos en cualquier momento futuro, independientemente de si la sesión del usuario ha terminado.

3. ¿En qué casos sería mejor utilizar bases de datos para su solución y en cuáles utilizar otro tipo de datos temporales como cookies o sesiones?


Base de Datos: Se debe utilizar para información crítica y permanente, como las credenciales de acceso de los usuarios y los registros de la gestión de inventario o datos ingresados.


Sesiones: Son ideales para mantener el estado de autenticación (saber qué usuario está conectado) de forma segura en el servidor mientras el navegador esté abierto.

Cookies: Serían útiles para preferencias no sensibles del lado del cliente, como recordar el idioma de la interfaz o el nombre de usuario en el formulario de login para futuras visitas.

4. Descripción de tablas y tipos de datos utilizados:

Tabla usuarios:

id (INT AUTO_INCREMENT): Clave primaria para identificar de forma única a cada usuario. Se eligió INT por eficiencia en la indexación.

usuario (VARCHAR 50): Almacena el nombre de acceso. Se eligió VARCHAR porque los nombres tienen longitud variable y este tipo optimiza el espacio.

password (VARCHAR 255): Se eligió una longitud de 255 caracteres para permitir el almacenamiento de contraseñas encriptadas (hashes), que suelen ser cadenas largas y complejas.

Tabla registros:


id (INT AUTO_INCREMENT): Identificador único para cada dato ingresado.

nombre_item (VARCHAR 100): Para la descripción del dato. VARCHAR permite flexibilidad para nombres de productos o ítems.


cantidad (INT): Se utiliza para valores numéricos enteros, lo que permite realizar operaciones matemáticas o validaciones de inventario.


fecha_registro (TIMESTAMP): Se eligió para grabar automáticamente el momento exacto en que se ingresó el dato, facilitando el requisito de verlos ordenados
