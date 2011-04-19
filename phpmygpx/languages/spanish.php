<?php
/**
* @version $Id: english.php 319 2010-07-23 21:38:57Z sebastian $
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_VALID_OSM') or die('Acceso no permitido');


DEFINE('_LANGUAGE','en');
DEFINE('_TRANSLATOR_NAME', 'Andr�s G�mez Casanova');
DEFINE('_TRANSLATOR_EMAIL', 'angoca at yahoo dot com');

// Site page note found
DEFINE('_404', 'Lo lamentamos, pero la p�gina que usted solicit� no pudo ser encontrada.');
DEFINE('_404_RTS', 'Volver al sitio');

// common
DEFINE('_APP_NAME','phpMyGPX');
DEFINE('_HTML_TITLE','phpMyGPX ::: gesti�n de puntos de trazado');

DEFINE('_DATE_FORMAT_LC',"%d/%m/%Y"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2',"%A, %d %B %Y %H:%M");
DEFINE('_DATE_FORMAT_LC3',"%Y-%m-%d %H:%M:%S");
DEFINE('_TIME_FORMAT_LC4',"%H:%M:%S h");

DEFINE('_NOT_AUTH','Usted no est� autorizado para ver este recurso.');
DEFINE('_DO_LOGIN','Usted necesita estar conectado.');
DEFINE('_VALID_AZ09',"Por favor ingrese un %1% v�lido.  Sin espacio, con m�s de %2% caracteres y que contenga solamente 0-9,a-z,A-Z");
DEFINE('_CMN_YES','Si');
DEFINE('_CMN_NO','No');
DEFINE('_CMN_SHOW','Mostrar');
DEFINE('_CMN_HIDE','Ocultar');

DEFINE('_CMN_NAME','Nombre');
DEFINE('_CMN_DESCRIPTION','Descripci�n');
DEFINE('_CMN_SAVE','Guardar');
DEFINE('_CMN_APPLY','Aplicar');
DEFINE('_CMN_CANCEL','Cancelar');
DEFINE('_CMN_PRINT','Imprimir');
DEFINE('_CMN_PDF','PDF');
DEFINE('_CMN_EMAIL','Correo electr�nico');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','Padre');
DEFINE('_CMN_ORDERING','Ordernar');
DEFINE('_CMN_ACCESS','Nivel de acceso');
DEFINE('_CMN_SELECT','Seleccionar');
DEFINE('_CMN_SELECT_ALL','Seleccionar todo');
DEFINE('_CMN_STATUS','Estado');
DEFINE('_CMN_SEARCH_RESULTS','%1% resultados de la b�squeda:');

DEFINE('_CMN_FIRST','Primera');
DEFINE('_CMN_LAST','�ltima');
DEFINE('_CMN_NEXT','Siguiente');
DEFINE('_CMN_NEXT_ARROW'," &gt;&gt;");
DEFINE('_CMN_PREV','Anterior');
DEFINE('_CMN_PREV_ARROW',"&lt;&lt; ");

DEFINE('_CMN_SORT_NONE','Sin ordernar');
DEFINE('_CMN_SORT_ASC','Orden ascendente');
DEFINE('_CMN_SORT_DESC','Orden descendente');

DEFINE('_CMN_NEW','Nuevo');
DEFINE('_CMN_NONE','Ninguno');
DEFINE('_CMN_LEFT','Izquierda');
DEFINE('_CMN_RIGHT','Derecha');
DEFINE('_CMN_CENTER','Centro');
DEFINE('_CMN_TOP','Arriba');
DEFINE('_CMN_BOTTOM','Abajo');
DEFINE('_CMN_FROM',' desde ');
DEFINE('_CMN_TO',' hasta ');

DEFINE('_CMN_DELETE','Borrar');

DEFINE('_CMN_FOLDER','Directorio');
DEFINE('_CMN_SUBFOLDER','Sub-directorio');
DEFINE('_CMN_WRITABLE','Escribible');
DEFINE('_CMN_NOT_WRITABLE','NO escribible');
DEFINE('_CMN_AVAILABLE','Disponible');
DEFINE('_CMN_MISSING','Faltante');
DEFINE('_CMN_OPTIONAL','Opcional');
DEFINE('_CMN_REQUIRED','Requerido');


DEFINE('_CMN_SCRIPT_EXEC_TIME','P�gina generada en ');
DEFINE('_CMN_MOUSEOVER_FOR_TOOLTIP','Si necesita ayuda, desplace el mouse sobre cada uno de los campos.');
DEFINE('_CMN_NOT_IMPLEMENTED','Esta funcionalidad aun no est� implementada.');
DEFINE('_CMN_BACK','Atr�s');
DEFINE('_CMN_CONTINUE','Continuar');
DEFINE('_CMN_WARNING','Atenci�n!');
DEFINE('_CMN_PAGE','P�gina');
DEFINE('_CMN_BATCH','Procesamiento en Batch');
DEFINE('_CMN_SINGLE_FILE','Un solo archivo');
DEFINE('_CMN_MAX_FILE_SIZE','M�ximo tama�o de archivo: ');
DEFINE('_CMN_COPY_DATE','Copiar fecha');
DEFINE('_CMN_OTHER','Otro');
DEFINE('_CMN_VIEW','Ver');
DEFINE('_CMN_VIEW_SIMPLE','Simple');
DEFINE('_CMN_VIEW_DETAIL','Detallado');

// error descriptions taken from http://de.php.net/manual/en/features.file-upload.errors.php
DEFINE('_CMN_UPLOAD_ERR_SIZE','El archivo cargado excede el tama�o m�ximo de archivo permitido.');
DEFINE('_CMN_UPLOAD_ERR_PARTIAL','El archivo fue cargado parcialmente.');
DEFINE('_CMN_UPLOAD_ERR_NO_FILE','Ning�n archivo fue cargado.');
DEFINE('_CMN_UPLOAD_ERR_NO_TMP_DIR','Falta un directorio temporal.');
DEFINE('_CMN_UPLOAD_ERR_CANT_WRITE','Fallo al escribir el archivo al disco.');

DEFINE('_CMN_GEO_TAGGING','Geo-Tagging');
DEFINE('_CMN_GEO_TAGGING_MAN','Para geo-tagging autom�tico, un archivo GPX tiene que ser seleccionado.');
DEFINE('_CMN_TIMEZONE','Huso horario');
DEFINE('_CMN_TIMEZONE_CAM','Huso horario del reloj de la c�mara');
DEFINE('_CMN_LOCATION','Ubicaci�n');
DEFINE('_CMN_BBOX','Cuadro delimitador');
DEFINE('_CMN_RANGE','Rango');
DEFINE('_CMN_INSERTED','insertado');
DEFINE('_CMN_PUBLIC','p�blico');
DEFINE('_CMN_VISIBLE','visible');
DEFINE('_CMN_TITLE','T�tulo');
DEFINE('_CMN_THUMB','Miniatura');
DEFINE('_CMN_PHOTO_ID','ID de la foto');
DEFINE('_CMN_USER_ID','ID del usuario');
DEFINE('_CMN_GPX_ID','ID de GPX');
DEFINE('_CMN_BM_ID','ID del marcador');
DEFINE('_CMN_BM_NAME','Nombre del marcador');
DEFINE('_CMN_FILE_NAME','Nombre del archivo');
DEFINE('_CMN_FILE_SIZE','Tama�o del archivo');
DEFINE('_CMN_LENGTH','Longitud');
DEFINE('_CMN_COMMENT','Comentario');
DEFINE('_CMN_DATE','Fecha');
DEFINE('_CMN_ZOOM','Nivel de zoom');
DEFINE('_CMN_LAT','Latitud');
DEFINE('_CMN_LON','Longitud');
DEFINE('_CMN_ALT','Altitud');
DEFINE('_CMN_COURSE','Ruta');
DEFINE('_CMN_SPEED','Velocidad');
DEFINE('_CMN_FIX','Sat Fix');
DEFINE('_CMN_SAT','Satelites');
DEFINE('_CMN_HDOP','HDOP');
DEFINE('_CMN_PDOP','PDOP');


/** installation */
DEFINE('_INST_OSM_SETUP','phpMyGPX-Instalaci�n: ');
DEFINE('_INST_WELCOME','Bienvenido');
DEFINE('_INST_CHECKS','Verificaci�n del ambiente');
DEFINE('_INST_CONFIG','Configuraci�n');
DEFINE('_INST_DB_INST','Instalaci�n de la base de datos');
DEFINE('_INST_DONE','Instalaci�n terminada');

DEFINE('_INST_GUIDED','Usted ser� guiado a trav�s del proceso de instalaci�n. Simplemente tiene que seguir las instrucciones.');
DEFINE('_INST_MAN_LOGIN','Si usted tiene <b>accesso root</b> a la base de datos, digite la contrase�a a continuaci�n.<br>
Para las utilisaciones futuras, una cuenta de usuario con menos privilegios ser� usada por razones de seguridad, y esta ser� creada by el proceso de instalaci�n. El nombre de usuario de esta cuenta debe definido en el archivo de configuraci�n.<br><br>
Si su base de datos es <b>compartida</b>, usted puede tener probablemente una sola cuenta de usuario. En este caso, use los datos de la cuenta para <b>ambos</b> el archivo de configuraci�n <b>y</b> este script de instalaci�n.'); 

DEFINE('_INST_DB_ACCOUNT','Datos de la cuenta MySQL ');
DEFINE('_INST_DB_HOST','Nombre del Host');
DEFINE('_INST_DB_NAME','Nombre de la base de datoa');
DEFINE('_INST_DB_TABLE_PREFIX','Prefijo para los nombres de tablas');
DEFINE('_INST_DB_USER','Nombre de usuario');
DEFINE('_INST_DB_PASSWORD','Contrase�a');
DEFINE('_INST_DB_ROOT_ACCOUNT','Datos de la cuenta Root MySQL ');
DEFINE('_INST_DB_ROOT_ACCOUNT_MAN','Si usted tiene <b>acceso root access</b> a su base de datos, simplemente digite el nombre de usuario y constrase�a en los campos siguientes, de otro modo deje dichos campos vac�os.<br>
Para uso futuro, un usuario con menos privilegios ser� usado por razones de seguridad y este ser� creado por esta proceso de instalaci�n.');
DEFINE('_INST_DB_ROOT','Nombre de usuario Root');
DEFINE('_INST_DB_ROOTPASS','Contrase�a de Root');
DEFINE('_INST_CFG_ADMIN_ACCESS','Acceso de administrador');
DEFINE('_INST_CFG_ADMIN_ACCESS_MAN','Si su servidor es de acceso p�blico, usted deber�a seleccionar este campo y dar una contrase�a para procesos administrativos!');
DEFINE('_INST_CFG_PUBLIC_HOST','Host con acceso p�blico');
DEFINE('_INST_CFG_ADMIN_PASSWORD','Contrase�a del administrador');
DEFINE('_INST_CFG_HOME_LOCATION','Lugar principal');
DEFINE('_INST_CFG_HOME_LOCATION_MAN','Por favor seleccione el lugar principal sobre su mapa (realice zoom, haga drag and drop sobre la previsualizaci�n a la derecha).');

DEFINE('_INST_LANGUAGE','Idioma');
DEFINE('_INST_LANGUAGE_CHOOSE','Por favos seleccione su idioma preferido.');
DEFINE('_INST_MODE','Modo de instalaci�n');
DEFINE('_INST_MODE_NEW','Instalaci�n nueva');
DEFINE('_INST_MODE_UPGR3','Actualizaci�n a la versi�n 0.3');
DEFINE('_INST_MODE_UPGR_LATEST','Actualizar a la versi�n m�s recente');
DEFINE('_INST_MODE_NEW_DESC',' (la base de datos y todas las tablas ser�n creadas, si ellas no existen)');
DEFINE('_INST_MODE_UPGR3_DESC',' (tablas existente ser�n modificadas y las faltantes ser�n creadas)');
DEFINE('_INST_PROG_CHECKS','Permison sobre directorio y la configuraci�n del servidor van a ser revisadas...');
DEFINE('_INST_PROG_PHOTOS_DISABLED','Caracter�sticas de fotos est�n deshabilitadas porque las extensiones EXIF y mbstring faltan.');
DEFINE('_INST_PROG_CHECKED','Todos los tests fueron satisfactorios.');
DEFINE('_INST_PROG_CONFIG_FOUND','Se encontr� un antiguo archivo de configuraci�n y sus valores vas a ser utilisados.');
DEFINE('_INST_PROG_CONFIG_UPDATED','El archivo de configuraci�n fue actualizado y guardado.');
DEFINE('_INST_DB_CREATE_SETUP','Crea y configura la base de datos ');
DEFINE('_INST_PROG_INST','Su base de datos MySQL y todas las tablas ser�n creadas...');
DEFINE('_INST_DB_CONN_ERROR','La conexi�n a la base de datos a fallado. ');
DEFINE('_INST_UPGR3_ADD_BOOKM_TBL','Tabla para marcadores ha sido creada.');
DEFINE('_INST_UPGR3_ADD_WAYPTS_TBL','Tabla para waypoints ha sido creada.');
DEFINE('_INST_UPGR5_ADD_POIS_TBL','Tabla para POIs/fotos ha sido creada.');
DEFINE('_INST_PROG_DB','La base de datos ha sido creada.');
DEFINE('_INST_PROG_RENAMED','El directorio de instalaci�n fue renombrado por razones de seguridad.');
DEFINE('_INST_PROG_RENAME_ERROR','Por razones de seguridad, por favor BORRE el directorio de instalaci�n!');
DEFINE('_INST_PROG_DONE','<b>FELICITACIONES!</b> Usted ha instalado satisfactoriamente la aplicaci�n!');
DEFINE('_INST_PROG_TEST','�ltimo test fue realizado satisfactoriamente.');
DEFINE('_INST_ERROR','Un error ocurri�. Intente resolver el problema y vuelva a cargar este script!');
DEFINE('_INST_DB_ERROR','Error en la consulta: ');
DEFINE('_INST_DB_STAT','Estad�sticas de la base de datos ');

/** html.classes.php */
DEFINE('_MENU_GPX','Archivo GPX');
DEFINE('_MENU_GPX_VIEW','Ver el GPX');
DEFINE('_MENU_GPX_DETAILS','detalles');
DEFINE('_MENU_GPX_IMAGE','imagen');
DEFINE('_MENU_GPX_UPL','Subir GPX');
DEFINE('_MENU_GPX_BATCH_IMPORT','importaci�n en batch de GPX');
DEFINE('_MENU_GPX_IMPORT','importar');
DEFINE('_MENU_GPX_EXPORT','exportar');
DEFINE('_MENU_GPX_DOWNL','descargar');
DEFINE('_MENU_GPX_EDIT','editar');
DEFINE('_MENU_GPX_DELETE','borrar');
DEFINE('_MENU_GPX_SEARCH','Buscar en GPX');
DEFINE('_MENU_TRKPT','Trackpoints');
DEFINE('_MENU_TRKPT_VIEW','Ver Trackpoints');
DEFINE('_MENU_TRKPT_SEARCH','buscar Trackpoints');
DEFINE('_MENU_WPT','Waypoints');
DEFINE('_MENU_WPT_VIEW','Ver Waypoints');
DEFINE('_MENU_WPT_SEARCH','buscar Waypoints');
DEFINE('_MENU_PHOTO','Fotos');
DEFINE('_MENU_PHOTO_VIEW','Ver fotos');
DEFINE('_MENU_PHOTO_DETAILS','Detalles de la foto');
DEFINE('_MENU_PHOTO_UPL','Subir fotos');
DEFINE('_MENU_PHOTO_BATCH_IMPORT','Importaci�n de fotos en batch');
DEFINE('_MENU_PHOTO_IMPORT','Importar fotos');
DEFINE('_MENU_PHOTO_DELETE','Borrar fotos');
DEFINE('_MENU_VIEW','Ver');
DEFINE('_MENU_UPL','Subir');
DEFINE('_MENU_SEARCH','Buscar');

DEFINE('_MENU_HOME','Inicio');
DEFINE('_MENU_ABOUT','Acerca de...');
DEFINE('_MENU_BOOKMARK','Marcadores');
DEFINE('_MENU_MAP','Mapa');
DEFINE('_MENU_MISC','Miscel�nea');
DEFINE('_MENU_DB','base de datos');
DEFINE('_MENU_DB_STAT','Estad�sticas');
DEFINE('_MENU_LOGIN','CONEXI�N');
DEFINE('_MENU_LOGOUT','DESCONEXI�N');

/** index.php */
DEFINE('_HOME_WELCOME_TO','Bienvenido a ');
DEFINE('_HOME_INTRO','A hacer: Introducci�n');
DEFINE('_LOGIN_FAILED','Conexi�n fallida. Su contrase�a no es correcta.');
DEFINE('_LOGIN_SUCCESS','Usted ahora est� conectado.');
DEFINE('_LOGOUT_SUCCESS','Usted ahora est� desconectado.');
DEFINE('_LOGIN_DESCRIPTION','Para acceder a la interfaz de administraci�n, por favor connectese:');

/** traces.php */
DEFINE('_TRC_NO_WPTS_IN_DB','No hay waypoints disponibles.');
DEFINE('_TRC_NO_TRKPTS_IN_DB','No hay trackpoints disponibles.');
DEFINE('_TRC_NO_GPX_IN_DB','No hay archivos GPX en la base de datos.');
DEFINE('_TRC_GPX_DOES_NOT_EXIST','Este archivo GPX no existe!');
DEFINE('_TRC_DETAILS_OF_GPX','Estad�sticas y detalles del archivo GPX # ');
DEFINE('_TRC_APPROX_DIST','distancia aproximada');
DEFINE('_TRC_TRIP_TIME','tiempo del trayecto');
DEFINE('_TRC_AVG_SPEED','velocidad media');
DEFINE('_TRC_TRACK','Track ');
DEFINE('_TRC_HALT','Parada: ');
DEFINE('_TRC_TOTAL','Total');
DEFINE('_TRC_DETAILS_CHART_SPLIT','El diagrama de elevaci�n est� dividido debido a pausas en el track:');
DEFINE('_TRC_SHOW_MAP','Mostrar mapa');
DEFINE('_TRC_SHOW_OSM_MAP','Mostrar mapa en OSM');
DEFINE('_TRC_USE_DP_FOR_SEARCH','Por favor use punto para la parte decimal de n�meros flotantes.');
DEFINE('_TRC_SEARCH_PARAMS_LOGIC_AND','Los par�metros de b�squeda son evaluados como AND l�gico.');
DEFINE('_TRC_CHOOSE_SEARCH_FILTER','Escoja un filtro para la b�squeda: ');
DEFINE('_TRC_CHOOSE_UPL_FILE','Seleccione un archivo para subir: ');
DEFINE('_TRC_BATCH_IMPORT_INFO','Para hacer una importaci�n en batch, copie sus archivos (via FTP) al directorio "/upload/" antes de continuar.');
DEFINE('_TRC_BATCH_IMPORTING_DIR','Los archivos ser�n importados desde este directorio: <i>"%1%"</i>');
DEFINE('_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING','Por favor seleccione los archivos que ser�n importados: ');
DEFINE('_TRC_START_IMPORT','Iniciar la importaci�n batch');
DEFINE('_TRC_WAIT_WHILE_IMPORTING','Por favor espere mientras se realiza la importaci�n: ');
DEFINE('_TRC_IMPORT_DONE','Importaci�n terminada.');
DEFINE('_TRC_MAY_TAKE_SECONDS','Esto puede llegar a tomar algunos segundos.');
DEFINE('_TRC_UPL_ERROR','Error al subir archivo: ');
DEFINE('_TRC_UPL_SUCCESS','Archivo subido satisfactoriamente: ');
DEFINE('_TRC_READING_FILE','Leyendo archivo "<i>%1%</i>"...');
DEFINE('_TRC_NO_VALID_XML','Lo lamento, este no parece ser un formato valido de XML!');
DEFINE('_TRC_MISS_TIMESTAMP','No puede importar este archivo GPX porque hacen falta los timestamp!');
DEFINE('_TRC_DUPLICATE_FILENAME','El nombre de archivo debe ser �nico! Est� usted re-importando?');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','Timestamps deben ser �nicos! Est� usted re-importando?');
DEFINE('_TRC_NO_PHP_DOM_EXT','Extensi�n PHP DOM no est� instalado!');
DEFINE('_TRC_WPTS_PROCESSED',' Waypoints procesados.');
DEFINE('_TRC_TRKPTS_PROCESSED',' Trackpoints procesados.');
DEFINE('_TRC_REALLY_DELETE','Usted realmente quiere BORRAR este archivo GPX<br />y todos los puntos de track incluidos?<br />NO hay funci�n de deshacer!');
DEFINE('_TRC_CONFIRM_DELETE','Para confirmar el borrado, por favor escriba "Si".');
DEFINE('_TRC_NO_CONFIRM_DELETE','Usted ha cancelado el borrado.');
DEFINE('_TRC_WPT_DELETED','%1% waypoints borrado.');
DEFINE('_TRC_TRKPT_DELETED','%1% trackpoints borrado.');
DEFINE('_TRC_GPX_DELETED','%1% archivos GPX borrado.');
DEFINE('_TRC_GPX_EDITED','archivo GPX modificado.');
DEFINE('_TRC_EXPORT_AS_GPX','exportar a un archivo en formato GPX');

/** traces.html.php */

/** bookmark.php */
DEFINE('_BOOKM_NONE_IN_DB','No hay marcadores disponibles en la base de datos.');
DEFINE('_MENU_BOOKM_VIEW','Ver marcadores');
DEFINE('_MENU_BOOKM_ADD','Adicionar marcador');
DEFINE('_MENU_BOOKM_DELETE','Borrar marcador');
DEFINE('_BOOKM_ADDED','Un marcador fue adicionado');
DEFINE('_BOOKM_NO_URL','No hay un URL para este marcador.');
DEFINE('_BOOKM_DELETED','El marcador fue borrado.');

/** photos.php */
DEFINE('_PHOTO_NONE_IN_DB','No hay fotos disponibles.');
DEFINE('_PHOTO_DOES_NOT_EXIST','Esta foto no existe!');
DEFINE('_PHOTO_NO_PHP_GD2_EXT','La extensi�n PHP GD no est� instalada!');
DEFINE('_PHOTO_IPTC_TITLE','Campo IPTC "t�tulo"');
DEFINE('_PHOTO_IPTC_DESC','Campo IPTC "descripci�n"');
DEFINE('_PHOTO_TIME_OFFSET','Time offset');
DEFINE('_PHOTO_TIME_OFFSET_MAN','Time offset [GPS - c�mara] en segundos');
DEFINE('_PHOTO_LOCATION_FROM_EXIF','Lectura de ubicaci�n desde encabezado EXIF: ');
DEFINE('_PHOTO_LOCATION_FROM_TRKPT','Lectura de ubicaci�n desde GPX: ');
DEFINE('_PHOTO_NO_LOCATION','No se encontr� la ubicaci�n de la captura!');
DEFINE('_PHOTO_NO_EXIF','No se encontr� informaci�n GPS en el encabezado EXIF!');
DEFINE('_PHOTO_NO_VALID_JPG','No es un archivo JPEG v�lido!');
DEFINE('_PHOTO_REALLY_DELETE','Usted realmente quiere BORRAR esta foto?<br />NO hay posibilidad de deshacer la operaci�n!');
DEFINE('_PHOTO_DELETED','La foto fue borrada.');

/** import.php */
DEFINE('_IMPORT_NO_AJAX','Su navegador no soporta AJAX!');
DEFINE('_IMPORT_PHP_ERROR','Lo lamento, esto no puede ocurrir! Usted podr�a querer reportar un bug e incluir las l�neas siguientes:');
DEFINE('_IMPORT_FILE_ERROR','Error al abrir el archivo!');
DEFINE('_IMPORT_COPY_FAILED','La copia de este archivo al directorio destino ha fallado!');
DEFINE('_IMPORT_FAILED','Importaci�n fallida!');
DEFINE('_IMPORT_SUCCESS','Importaci�n satisfactoria.');

/** database.php */
DEFINE('_DB_GPX_AVAILABLE',' archivo(s) GPX encontrado(s) en la base de datos.');
DEFINE('_DB_WPTS_AVAILABLE',' waypoint(s) encontrado(s) en la base de datos.');
DEFINE('_DB_TRKPTS_AVAILABLE',' trackpoint(s) encontrado(s) en la base de datos.');
DEFINE('_DB_DAYS_AVAILABLE',' d�a(s) encontrado(s) en la base de datos.');
DEFINE('_DB_BOOKM_AVAILABLE',' marcador(es) encontrado(s) en la base de datos.');
DEFINE('_DB_PHOTOS_AVAILABLE',' foto(s) encontrada(s) en la base de datos.');
DEFINE('_DB_PHOTOS_SIZE',' tama�o total de archivos de fotos.');
DEFINE('_DB_GPX_SIZE',' tama�o total de archivos GPX.');
DEFINE('_DB_TOTAL_DISTANCE',' de distancia total');

/** about.php */
DEFINE('_ABOUT_CREDITS','Cr�ditos');
DEFINE('_ABOUT_LICENSE','Licencia');
DEFINE('_UPDATE_CHECK_DISABLED','La verificaci�n de actualizaciones ha sido desactivada.');
DEFINE('_UPDATE_AVAIL','Una actualizaci�n de este software est� disponible.');
DEFINE('_NO_UPDATE_AVAIL','No hay actualizaciones disponibles.');
DEFINE('_UPDATE_SERVER_ERROR404','El servidor de actualizaciones devolvi� un error 494 (Documento no encontrado).');
DEFINE('_UPDATE_SERVER_CONN_ERROR','La conexi�n al servidor de actualizaciones ha fallado.');

/** map.php */
DEFINE('_MAP_CURRENT_AREA',' (de la zona actual sobre el mapa)');
#DEFINE('_MAP_AREA_TRKPT','view all trackpoints of current map area');
DEFINE('_MAP_JOSM_EDIT','	 con JOSM');
DEFINE('_MAP_ADD_BOOKM','Crear un marcador');
DEFINE('_MAP_JS_BOOKM_NAME','Nombre del marcador: ');

/** graph.php */
DEFINE('_CHART_ELEVATION_TITLE', 'Diagrama de elevaci�n');
DEFINE('_CHART_AXIS_ELE', 'elevaci�n');
DEFINE('_CHART_AXIS_SPEED', 'velocidad');
DEFINE('_CHART_AXIS_TIME', 'tiempo');
DEFINE('_CHART_AXIS_DIST', 'distancia');

// DO NOT edit anything below this line!
include(_PATH ."version.inc.php");
?>
