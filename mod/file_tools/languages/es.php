<?php

return array(
	'file_tools' => "File Tools",

	'file_tools:file:actions' => 'Acciones',

	'file_tools:list:sort:type' => 'Tipo',
	'file_tools:list:sort:time_created' => 'Hora de creación',
	'file_tools:list:sort:asc' => 'Ascendente',
	'file_tools:list:sort:desc' => 'Descendente',

	// object name
	'item:object:folder' => "Carpeta de archivos",

	// menu items
	'file_tools:menu:mine' => "Tus carpetas",
	'file_tools:menu:user' => "carpetas de %s",
	'file_tools:menu:group' => "Carpetas de grupo",
	
	// group tool option
	'file_tools:group_tool_option:structure_management' => "Permitir la gestión de carpetas por los miembros",
	
	// views

	// object
	'file_tools:object:files' => "%s fichero(s) en esta carpeta",
	'file_tools:object:no_files' => "No hay ficheiros en esta carpeta",

	// input - folder select
	'file_tools:input:folder_select:main' => "Carpeta principal",

	// list
	'file_tools:list:title' => "Listar carpetas",
	
	'file_tools:list:folder:main' => "Carpeta principal",
	'file_tools:list:files:none' => "No se encontraron ficheros en esta carpeta",
	'file_tools:list:select_all' => 'Seleccionar todo',
	'file_tools:list:deselect_all' => 'Des-seleccionar todo',
	'file_tools:list:download_selected' => 'Descargar seleccionados',
	'file_tools:list:delete_selected' => 'Eliminar seleccionados',
	'file_tools:list:alert:not_all_deleted' => 'No se pueden borrar todos los ficheros',
	'file_tools:list:alert:none_selected' => 'No se seleccionó ningún elemento',
	

	'file_tools:list:tree:info' => "Lo sabías?",
	'file_tools:list:tree:info:1' => "Puedes arrastrar y soltar ficheros en las carpetas para organizarlos!",
	'file_tools:list:tree:info:2' => "Puedes hacer doble click en cualquier carpeta para expandir todas sus subcarpetas!",
	'file_tools:list:tree:info:3' => "¡Puedes reordenar las carpetas arrastrándolas hasta su nuevo lugar en el árbol!",
	'file_tools:list:tree:info:4' => "¡Puedes mover estructuras de carpetas completas!",
	'file_tools:list:tree:info:5' => "¡Si borras una carpeta, puedes escoger opcionalmente eliminar todos los archivos!",
	'file_tools:list:tree:info:6' => "¡Cuando borras una carpeta,  se borrarán también todas sus subcarpetas!",
	'file_tools:list:tree:info:7' => "¡Este mensaje es aleatorio!",
	'file_tools:list:tree:info:8' => "¡Cuando eliminas una carpeta, pero no sus archivos, los archivos aparecerán en la carpeta raíz!",
	'file_tools:list:tree:info:9' => "¡Una carpeta nueva se puede poner directamente en la subcarpeta correcta!",
	'file_tools:list:tree:info:10' => "¡Cuando subes o editas un fichero puedes escoger en que carpeta aparecerá!",
	'file_tools:list:tree:info:11' => "¡Arrastrar ficheros sólo está disponible en la vista de lista, no en la vista de galería!",
	'file_tools:list:tree:info:12' => "¡Puedes actualizar el nivel de acceso en todas las subcarpetas y también (opcional) en todos los ficheros cuando editas una carpeta!",

	'file_tools:list:files:options:sort_title' => 'Ordenando',
	'file_tools:list:files:options:view_title' => 'Ver',

	'file_tools:usersettings:time' => 'Visualización de la hora',
	'file_tools:usersettings:time:description' => 'Cambiar la manera en que se muestra la hora de un fichero/carpeta',
	'file_tools:usersettings:time:default' => 'Visualización de hora predeterminada',
	'file_tools:usersettings:time:date' => 'Fecha',
	'file_tools:usersettings:time:days' => 'Días atrás',
	
	// new/edit
	'file_tools:new:title' => "Nueva carpeta",
	'file_tools:edit:title' => "Editar carpeta",
	'file_tools:forms:edit:title' => "Título",
	'file_tools:forms:edit:description' => "Descripción",
	'file_tools:forms:edit:parent' => "Seleccionar la carpeta superior",
	'file_tools:forms:edit:change_children_access' => "Actualizar acceso en todas las subcarpetas",
	'file_tools:forms:edit:change_files_access' => "Actualizar acceso en todos los ficheiros en esta carpeta (y todas las subcarpetas si está seleccionado)",
	'file_tools:forms:browse' => 'Navegar..',
	'file_tools:forms:empty_queue' => 'Cola vacía',

	'file_tools:folder:delete:confirm_files' => "Quieres eliminar todos los ficheiros de las (sub)carpetas eliminadas",

	// upload
	'file_tools:upload:tabs:single' => "Fichero único",
	'file_tools:upload:tabs:multi' => "Multi-fichero",
	'file_tools:upload:tabs:zip' => "Fichero Zip",
	'file_tools:upload:form:choose' => 'Escoger fichero',
	'file_tools:upload:form:info' => 'Pulsa navegar para subir (multiples) archivos',
	'file_tools:upload:form:zip:info' => "Puedes subir un fichero zip. Se extraerá el contenido y se importará cada fichero por separado. Si  tienes carpetas en tu fichero zip también se importarán en su carpeta específica. Se saltarán los ficheros de tipos no permitidos.",
	
	// actions
	// edit
	'file_tools:action:edit:error:input' => "Entrada incorrecta para crear/editar una carpeta",
	'file_tools:action:edit:error:owner' => "No se pudo encontrar el propietario de la carpeta",
	'file_tools:action:edit:error:folder' => "No hai ningunha carpeta para crear/editar",
	'file_tools:action:edit:error:parent_guid' => "Carpeta superior inválida, la carpeta superior no puede ser la propia carpeta.",
	'file_tools:action:edit:error:save' => "Error desconocido al salvar la carpeta",
	'file_tools:action:edit:success' => "La carpeta se creó/editó correctamente",

	'file_tools:action:move:parent_error' => "No se puede soltar la carpeta sobre si misma",
	
	// delete
	'file_tools:actions:delete:error:input' => "Entrada incorrecta para borrar la carpeta",
	'file_tools:actions:delete:error:entity' => "No se pudo encontrar el GUID proporcionado",
	'file_tools:actions:delete:error:subtype' => "El GUID proporcionado no es una carpeta",
	'file_tools:actions:delete:error:delete' => "Ocurrió un error desconocido al eliminar la carpeta",
	'file_tools:actions:delete:success' => "La carpeta se eliminó correctamente",

	//errors
	'file_tools:error:pageowner' => 'Error al obtener el propietario de la página.',
	'file_tools:error:nofilesextracted' => 'No se encontraron archivos para extraer.',
	'file_tools:error:cantopenfile' => 'No se pudo abrir el archivo zip (comprueba que el archivo que has subido es un archivo .zip)',
	'file_tools:error:nozipfilefound' => 'El archivo subido no es un archivo .zip.',
	'file_tools:error:nofilefound' => 'Escoge un archivo para subir.',

	//messages
	'file_tools:error:fileuploadsuccess' => 'El archivo zip se subió y se extrajo correctamente.',
	
	// move
	'file_tools:action:move:success:file' => "El fichero se movió correctamente",
	'file_tools:action:move:success:folder' => "La carpeta se movió correctamente",
	
	// buld delete
	'file_tools:action:bulk_delete:success:files' => "Se han eliminado %s archivos correctamente",
	'file_tools:action:bulk_delete:error:files' => "Hubo un error al elminar algunos archivos",
	'file_tools:action:bulk_delete:success:folders' => "Se han eliminado %s carpetas correctamente",
	'file_tools:action:bulk_delete:error:folders' => "Hubo un error al eliminar algunas carpetas",
	
	// reorder
	'file_tools:action:folder:reorder:success' => "Se reordenaron las carpetas correctamente",
	
	//settings
	'file_tools:settings:allowed_extensions' => 'Extensiones permitidas (separadas por comas)',
	'file_tools:settings:user_folder_structure' => 'Usar estructura de carpetas',
	'file_tools:settings:sort:default' => 'Opciones de ordenación de carpetas',

	'file:type:application' => 'Aplicación',
	'file:type:text' => 'Texto',

	// widgets
	// file tree
	'widgets:file_tree:title' => "Carpetas",
	'widgets:file_tree:description' => "Escaparate de tus carpetas",
	
	'widgets:file_tree:edit:select' => "Seleccionar que carpeta(s) mostrar",
	'widgets:file_tree:edit:show_content' => "Mostrar el contenido de las carpetas",
	'widgets:file_tree:no_folders' => "No se configuraron carpetas",
	'widgets:file_tree:no_files' => "No se configuraron archivos",
	'widgets:file_tree:more' => "Más carpetas",

	'widget:file:edit:show_only_featured' => 'Mostrar solo archivos destacados',
	
	'widget:file_tools:show_file' => 'Archivo destacado (widget)',
	'widget:file_tools:hide_file' => 'Archivo sin destacar',

	'widgets:file_tools:more_files' => 'Más archivos',
	
	// Group files
	'widgets:group_files:description' => "Mostrar los últimos archivos del grupo",
	
	// index_file
	'widgets:index_file:description' => "Mostrar los últimos archivos en tu comunidad",

);
