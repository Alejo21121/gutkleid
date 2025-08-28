# Estrategia de Backup y Recuperación - Gutkleid

## 1. Objetivo
Garantizar la disponibilidad, integridad y confidencialidad de los datos críticos del ecommerce Gutkleid, estableciendo procedimientos para la realización de copias de seguridad y la recuperación efectiva de la información en caso de fallos, errores humanos o desastres.

## 2. Alcance
Esta estrategia cubre los siguientes componentes del sistema:
- **Base de Datos MySQL:** Contiene toda la información transaccional, de usuarios, productos y pedidos.
- **Código Fuente de la Aplicación Laravel:** Incluye toda la lógica de negocio, configuraciones y vistas.
- **Archivos Multimedia:** Imágenes de productos, logos y cualquier otro asset subido por los administradores.

## 3. Tipos de Copia de Seguridad
Se implementará una estrategia híbrida para optimizar espacio y tiempo de recuperación:

- **Copia Completa (Full):** Se realiza cada **domingo a las 02:00 AM**. Captura el estado completo de la base de datos y todos los archivos del proyecto.
- **Copia Incremental (Incremental):** Se realiza de **lunes a sábado a las 02:00 AM**. Captura solo los cambios realizados desde la última copia (completa o incremental).

## 4. Frecuencia y Retención
| Tipo de Copia        | Frecuencia       | Período de Retención | Localización                           |
| --------------------- | ---------------- | -------------------- | -------------------------------------- |
| **Completa (BD)**     | Semanal (Domingo) | 4 semanas            | Servidor (Nube), Disco Duro Externo    |
| **Incremental (BD)**  | Diaria (L-S)     | 7 días               | Servidor (Nube)                        |
| **Completa (Código)** | Con cada release | Permanentemente      | GitHub (Repositorio), Disco Duro Externo |
| **Completa (Medios)** | Semanal (Domingo) | 12 meses             | Servidor (Nube), Disco Duro Externo    |

## 5. Estrategia 3-2-1
Para mitigar riesgos, seguimos la regla 3-2-1:
- **3 Copias de los datos:** La original y dos backups.
- **2 Medios de almacenamiento diferentes:** Discos duros (SSD/HDD) y almacenamiento en la nube.
- **1 Copia fuera del sitio (Off-site):** La copia en la nube cumple este requisito.

**Implementación para Gutkleid:**
1.  **Copia 1 (Original):** Servidor de producción (Ej: DigitalOcean, AWS).
2.  **Copia 2 (Local):** Disco duro externo o NAS. Se sincroniza manualmente tras cada backup automático.
3.  **Copia 3 (Off-site/Cloud):** Servicio de cloud storage (). Los backups automáticos del servidor se envían aquí.

## 6. Herramientas y Procedimientos

### Base de Datos (MySQL)
- **Herramienta:** Comando `mysqldump` para copias completas. Binlogs para incrementales.
- **Script de Ejemplo (`scripts/backup_mysql.sh`):**
    ```bash
    #!/bin/bash
    FECHA=$(date +%Y%m%d_%H%M%S)
    mysqldump -u [usuario] -p[contraseña] [nombre_bd] > /ruta/backups/db/db_completa_$FECHA.sql
    # Comprimir y enviar a la nube...
    ```
- **Recuperación:**
    ```bash
    mysql -u [usuario] -p[contraseña] [nombre_bd] < /ruta/backups/db/archivo_respaldo.sql
    ```

### Código Fuente y Archivos de la App (Laravel)
- **Herramienta:** Control de versiones Git (GitHub) como backup principal del código.
- **Procedimiento:** Los archivos de medios se comprimen (`tar -czf`) y se incluyen en el backup semanal.
- **Recuperación:** Clonar el repositorio de GitHub y descomprimir los archivos de medios en la carpeta `storage/app/public`.

## 7. Procedimiento de Recuperación de Desastres (DRP)
1.  **Identificar el fallo:** Determinar el componente afectado (BD, código, medios).
2.  **Localizar el backup más reciente** válido según el tipo de fallo.
3.  **Restaurar en un entorno aislado** si es posible, para verificar integridad.
4.  **Ejecutar la restauración en producción:**
    - **Base de Datos:** Restaurar la última copia completa y luego las incrementales en orden.
    - **Código:** Clonar el repositorio estable desde GitHub.
    - **Medios:** Descomprimir el archivo de medios en la ubicación correcta.
5.  **Verificar** que la aplicación funcione correctamente.

## 8. Responsables
- **Equipo de Desarrollo:** Ejecución y monitoreo de backups automáticos, restauración de código.
- **Administrador de Sistemas:** Verificación de integridad de backups en medios externos y nube, restauración completa del sistema.

## 9. Pruebas de Recuperación
Se realizarán pruebas trimestrales de recuperación para validar la efectividad de los backups y la familiaridad del equipo con los procedimientos. Los resultados se documentarán.