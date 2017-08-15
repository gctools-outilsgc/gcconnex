<?php

return array(

        // general
        'group_tools:add_users' => "Agregar usuarios",
        'group_tools:delete_selected' => "Borrar usuarios",
        'group_tools:clear_selection' => "Limpiar selección",
        'group_tools:all_members' => "Todos los miembros",
        'group_tools:explain' => "Explicación",

        'group_tools:default:access:group' => "Miembros del grupo solamente",

        'group_tools:joinrequest:already' => "Cancelar pedido de incorporación a este grupo",
        'group_tools:joinrequest:already:tooltip' => "Ya has solicitado la incorporación a este grupo, haz click aquí para cancelar tu solicitud",
        'group_tools:join:already:tooltip' => "Fuiste invitado a este grupo, puedes unirte ahora.",

        'item:object:group_tools_group_mail' => "Mail del Grupo",

        // menu
        'group_tools:menu:mail' => "Miembros del Mail",
        'group_tools:menu:invitations' => "Gestionar invitaciones",
        
		'admin:groups:bulk_delete' => "Borrar varios grupos",
        'admin:groups:admin_approval' => "Se necesita aprobación",
		'admin:groups:tool_presets' => "Configuraciones predefinidas de herramientas de grupo",

        // plugin settings
        'group_tools:settings:default_off' => "Si, configuraciones por defecto desactivadas",
        'group_tools:settings:default_on' => "Yes, configuraciones por defecto activadas",
        'group_tools:settings:required' => "Si, requerido",

        'group_tools:settings:invite:title' => "Opciones de invitación a grupos",
        'group_tools:settings:management:title' => "Opciones de grupos generales",
        'group_tools:settings:default_access:title' => "Acceso a grupos por defecto",

        'group_tools:settings:admin_transfer' => "Permitir transferencia de propietario de grupo",
        'group_tools:settings:admin_transfer:admin' => "Solo administradores del sitio",
        'group_tools:settings:admin_transfer:owner' => "Propietarios de grupo y administadores del sitio",

        'group_tools:settings:multiple_admin' => "Permitir múltiples administradores de grupo",
        'group_tools:settings:auto_suggest_groups' => "Sugerir grupos automaticamente en la página 'Sugeridos' basados en la información del perfil. Será completado con los grupos sugeridos predefinidos. Marcar esto como 'No' solo mostrará los grupos sugeridos predefinidos, en caso de haberlos.",

        'group_tools:settings:notifications:title' => "Configuración de las notificaciones de grupo",
        'group_tools:settings:notifications:notification_toggle' => "Mostrar la configuración de notificaciónes al unirse al grupo",
        'group_tools:settings:notifications:notification_toggle:description' => "Esto mostrará un mensaje del sistma en el cual los usuarios podrán modificar la configuración de noticiaciones, y agragar un link en las notificaciones via email para acceder a la configuración.",

        'group_tools:settings:invite' => "Permitir la invitación a todos los usuarios (no solamente amigos)",
        'group_tools:settings:invite_friends' => "Permitir la invitación a amigos",
        'group_tools:settings:invite_email' => "Permitir la invitación a todos los usuarios via dirección de correo electrónico",
        'group_tools:settings:invite_email:match' => "Intentar coincidir los correos electrónicos de los usuarios existentes",
        'group_tools:settings:invite_csv' => "Permitir la invitación a todos los usuarios via archivo CSV",
        'group_tools:settings:invite_members' => "Permitir a los miembros la invitación de nuevos usuarios.",
        'group_tools:settings:invite_members:description' => "Propietarios y administradores de grupo pueden habilitar/deshabilitar esta opción para su grupo",
        'group_tools:settings:domain_based' => "Permitir grupos basados en dominios",
        'group_tools:settings:domain_based:description' => "Los usuarios pueden unirse a grupos basados en su dominio de correo electrónico (@ejemplo.com). Durante el registro serán incorporados automáticamente según el dominio de su correo.",
        'group_tools:settings:join_motivation' => "La incorporación en grupos cerrados requiere una motivación",
        'group_tools:settings:join_motivation:description' => "Cuando un usuario quiere unirse a un grupo cerrado, se le solicita un motivo. Los propietarios de grupo pueden cambiar esta configuración, sino modificarla a 'no' o 'requerida'.",

        'group_tools:settings:mail' => "Permitir un mail grupal (permite a los administradores enviar un email a todos los miembros)",

        'group_tools:settings:mail:members' => "Permite a los administradores habilitar el mail grupal a los miembros",
        'group_tools:settings:mail:members:description' => "La opción Mail Grupal debe estar habilidata",

        'group_tools:settings:listing:title' => "Configuración de listados de grupos",
        'group_tools:settings:listing:description' => "Aquí puedes configurar que pestañas estarán visibles en la página de listados de grupos, cual será la pestaña principal, y cual será el criterio de orden por defecto en cada pestaña.",
        'group_tools:settings:listing:enabled' => "Habilitado",
        'group_tools:settings:listing:default_short' => "Pestaña por defecto",
        'group_tools:settings:listing:default' => "Pestaña de listados de grupos por defecto",
        'group_tools:settings:listing:available' => "Pestañas de listados de grupos disponibles",

        'group_tools:settings:default_access' => "Cuál debe ser el acceso por defecto para el contenido de los grupos en este sitio?",

        'group_tools:settings:search_index' => "Permitir que los grupos cerrados sean indexados en los motores de búsqueda",
        'group_tools:settings:auto_notification' => "Habilitar automáticamente notificaciones de grupo al unirse",
        'group_tools:settings:show_membership_mode' => "Mostrar el estado abierto/cerrado de las membresias y el bloqueo del propietario en el perfil de grupo",
        'group_tools:settings:show_hidden_group_indicator' => "Mostrar un indicador si el grupo es oculto",
        'group_tools:settings:show_hidden_group_indicator:group_acl' => "Si, si el grupo es solo para miembros",
        'group_tools:settings:show_hidden_group_indicator:logged_in' => "Si, para todos los grupos no públicos",

        'group_tools:settings:special_states' => "Grupos con un estado especial",
        'group_tools:settings:special_states:featured:description' => "Los administradores de grupo han elegido esta funcionalidad para los siguientes grupos.",
        'group_tools:settings:special_states:auto_join' => "Incorporación automática",
        'group_tools:settings:special_states:auto_join:description' => "Nuevos usuarios serán incorporados automáticamente a los siguientes grupos.",
        'group_tools:settings:special_states:suggested' => "Sugeridos",
        'group_tools:settings:special_states:suggested:description' => "Los siguientes grupos son sugeridos a los (nuevos) usuarios. Es posible sugerir grupos automáticamente, en caso de que hayan pocos grupos o no sean detectados, el listado será completado con estos grupos.",

        'group_tools:settings:fix:title' => "Corregir problemas de acceso a grupos",
        'group_tools:settings:fix:missing' => "Hay %d usuarios que son miembros de un grupo pero no tienen acceso al contenido compartido con el grupo.",
        'group_tools:settings:fix:excess' => "Hay %d usuario que tienen acceso al contenido de un grupo del cual no forman más parte.",
        'group_tools:settings:fix:without' => "Hay %d grupos sin la posibilidad de compartir contenido con sus miembros.",
        'group_tools:settings:fix:all:description' => "Corregir todos los problemas seleccionados de una sola vez.",
        'group_tools:settings:fix_it' => "Corregir esto",
        'group_tools:settings:fix:all' => "Corregir todos los problemas",

        'group_tools:settings:member_export' => "Permitir a los administradores de grupo exportar la información de los miembros",
        'group_tools:settings:member_export:description' => "Esto incluye el nombre, usuario y correo electrónico de los usuarios.",

        'group_tools:settings:admin_approve' => "Los administradores de usuario necesitan aprobar nuevos grupos",
        'group_tools:settings:admin_approve:description' => "Cualquier usuario puede crear un grupo, pero un administrador del sitio debe aprobarlo",

        // group tool presets
        'group_tools:admin:group_tool_presets:description' => "Aquí puedes configurar las herramientas predefinidas del grupo.
Cuando un usuario crea un grupo, puede elegir una de los configuraciones predefinidas para obtener rápidamente las herramientas correctas. Una opción en blanco es ofrecida al usuario para que ajuste sus propias configuraciones.",
        'group_tools:admin:group_tool_presets:header' => "Configuraciones predefinidas existentes",
        'group_tools:create_group:tool_presets:description' => "Puedes elegir una configuración predefinida para las herramientes de grupo aquí. Si hacer eso, tendrás un grupo de herramientas preconfiguradas según tu selección. Siempre podrás agregar herramientas adicionales a tu configuración, o elegir quitar algunas que no desees.",
        'group_tools:create_group:tool_presets:active_header' => "Herramientas para esta configuracón predefinida",
        'group_tools:create_group:tool_presets:more_header' => "Herramientas extra",
        'group_tools:create_group:tool_presets:select' => "Elige el tipo de grupo",
        'group_tools:create_group:tool_presets:show_more' => "Más herramientas",
        'group_tools:create_group:tool_presets:blank:title' => "Grupo en blanco",
        'group_tools:create_group:tool_presets:blank:description' => "Elige este tipo de grupo para configurar tus propias herramientas.",


        // group invite message
        'group_tools:groups:invite:body' => "Hola %s,

%s te ha invitado a unirte al grupo '%s'.
%s

Haz click debajo para ver tus invitaciones:
%s",

        // group add message
        'group_tools:groups:invite:add:subject' => "Te han agregado al grupo %s",
        'group_tools:groups:invite:add:body' => "Hola %s,

%s te ha agregado al grupo %s.
%s

Para ver el grupo haz click en este link
%s",
        // group invite by email
        'group_tools:groups:invite:email:subject' => "Te han invitado al grupo %s",
        'group_tools:groups:invite:email:body' => "Hola,

%s te ha invitado a unirte al grupo %s en %s.
%s

Si no tienes usuario en %s por favor regístrate aquí
%s

Si tienes un usuario o luego de registrarte, haz click en el siguiente link para aceptar la invitación
%s

También puedes ir a Todos los grupos -> Invitaciones de grupo e incluir el siguiene código:
%s",
        // group transfer notification
        'group_tools:notify:transfer:subject' => "La administración del grupo %s te ha sido asignada",
        'group_tools:notify:transfer:message' => "Hola %s,

%s te ha asignado como el nuevo administrador del grupo %s.

Para visitar el grupo haz click sobre el siguiente link:
%s",

        // deline membeship request notification
        'group_tools:notify:membership:declined:subject' => "Su pedido de incorporación para el grupo '%s' fue rechazado",
        'group_tools:notify:membership:declined:message' => "Hola %s,

Tu pedido de incorporación para el grupo '%s' fue rechazado.

Puedes encontrar el grupo aquí:
%s",
        'group_tools:notify:membership:declined:message:reason' => "Hola %s,

Tu pedido de incorporación para el grupo '%s' fue rechazado, debido a la siguiente razón:

%s

Puedes encontrar el grupo aquí:
%s",

        // group edit tabbed
        'group_tools:group:edit:profile' => "Perfil",
        'group_tools:group:edit:access' => "Acceso",
        'group_tools:group:edit:tools' => "Herramientas",
        'group_tools:group:edit:other' => "Otras opciones",

        // admin transfer - form
        'group_tools:admin_transfer:current' => "Mantener propietario actual: %s",
        'group_tools:admin_transfer:myself' => "Yo mismo/a",

        // special states form
        'group_tools:special_states:title' => "Estados especiales de grupo",
        'group_tools:special_states:description' => "Un grupo puede tener distintos estados especiales, aquí hay un resumen de los estados especiales y sus valores actuales.",
        'group_tools:special_states:featured' => "Es este grupo destacado",
        'group_tools:special_states:auto_join' => "Los usuarios se uniran automáticamente a este grupo",
        'group_tools:special_states:auto_join:fix' => "Para convertir a todos los usuarios del sitio miembros de este grupo, haz %sclick aquí%s.",
        'group_tools:special_states:suggested' => "Es este grupo sugerido a (nuevos) usuarios",

        // group admins
        'group_tools:multiple_admin:group_admins' => "Administradores de grupo",
        'group_tools:multiple_admin:profile_actions:remove' => "Borrar administrador de grupo",
        'group_tools:multiple_admin:profile_actions:add' => "Agregar administrador de grupo",

        'group_tools:multiple_admin:group_tool_option' => "Permitir a los administradores de grupo asignar otros administradores",

        // cleanup options
        'group_tools:cleanup:title' => "Limpieza de barra lateral de grupos",
        'group_tools:cleanup:description' => "Limpia la barra lateral del grupo. Esto no tendrá efecto para los administradores de grupo.",
        'group_tools:cleanup:extras_menu' => "Ocultar el menú de extras",
        'group_tools:cleanup:extras_menu:explain' => "El menú de extras puede ser encontrado en la parte superior de la barra lateral, algunos links pueden ser publicados en este área (ejemplo: links de RSS).",
        'group_tools:cleanup:actions' => "Ocultar el botón de unirse al grupo o solicitar incorporación",
        'group_tools:cleanup:actions:explain' => "Dependiendo en tu configuración de grupo, usuario pueden directamente unirse al grupo o solicitar incorporación.",
        'group_tools:cleanup:menu' => "Ocultar items del menu lateral",
        'group_tools:cleanup:menu:explain' => "Oculta los enlaces del menú a las diferentes herramientas del grupo. Los usuarios sólo tendran acceso a las herramientas del grupo a través de los widgets.",
        'group_tools:cleanup:members' => "Ocultar los miembros del grupo",
        'group_tools:cleanup:members:explain' => "En la página del perfil del grupo, un listado de miembros puede verse en la barra lateral. Puedes ocultar este listado.",
        'group_tools:cleanup:search' => "Ocultar la búsqueda en el grupo",
        'group_tools:cleanup:search:explain' => "En la página de perfil del grupo una caja de búsqueda está disponible. Puedes elegir ocultarla.",
        'group_tools:cleanup:featured' => "Mostrar grupos destacados en la barra lateral",
        'group_tools:cleanup:featured:explain' => "Puedes elegir mostrar un listado de grupos destacados en la barra lateral de la página de perfil del grupo",
        'group_tools:cleanup:featured_sorting' => "Como ordenar grupos destacados",
        'group_tools:cleanup:featured_sorting:time_created' => "Recientes primero",
        'group_tools:cleanup:my_status' => "Ocultar la barra lateral de Mi Estado",
        'group_tools:cleanup:my_status:explain' => "En la barra lateral de la página de perfil de grupo hay un item que muestra tu actual estado de membresía y otra información de estado. Puedes elegir ocultar esto.",

        // group default access
        'group_tools:default_access:title' => "Nivel de acceso por defecto en el grupo",
        'group_tools:default_access:description' => "Aquí puedes controlar cual será el nivel de acceso por defecto del nuevo contenido en tu grupo.",

        // group admin approve
        'group_tools:group:admin_approve:notice' => "Los grupos nuevos necesitan se aprobados por el administrador del sitio. Puedes crear/editar el grupo, pero este no será visible para los otros usuarios hasta que sea aprobado por el administrador.",
        'group_tools:group:admin_approve:decline:confirm' => "Estas seguro que deseas rechazar este grupo? Esto eliminaría el grupo.",
        'group_tools:group:admin_approve:admin:description' => "Esta es una lista de grupos que necesitan ser aprobados por el administrador del sitio antes de que puedan utilizarse.

Si apruebas un grupo, el propietario recibirá una notificación de que su grupo está disponible para su uso.

Si rechazas un grupo, el propietario recibirá una notificación de que su grupo fue removido, y el mismo será eliminado.",

        'group_tools:group:admin_approve:approve:success' => "El grupo ahora puede ser utilizado en el sitio",
        'group_tools:group:admin_approve:decline:success' => "El grupo fue eliminado",

        'group_tools:group:admin_approve:approve:subject' => "Tu grupo '%s' fue aprobado",
        'group_tools:group:admin_approve:approve:summary' => "Tu grupo '%s' fue aprobado",
        'group_tools:group:admin_approve:approve:message' => "Hola %s,

tu grupo '%s' fue aprobado por el administrador del sitio. Ahora puedes utilizarlo.

Para visitar el grupo haz click aquí:
%s",
        'group_tools:group:admin_approve:admin:subject' => "Un nuevo grupo '%s' fue creado y requiere aprobación",
        'group_tools:group:admin_approve:admin:summary' => "Un nuevo grupo '%s' fue creado y requiere aprobación",
        'group_tools:group:admin_approve:admin:message' => "Hola %s,

%s creó el grupo '%s' que necesita ser aprobado por un administrador del sitio.

Para visitar el grupo haz click aquí:
%s

Para ver todos los grupos que requieren acciones haz click aquí:
%s",

        'group_tools:group:admin_approve:decline:subject' => "Tu grupo '%s' ha sido rechazado",
        'group_tools:group:admin_approve:decline:summary' => "Tu grupo '%s' ha sido rechazado",
        'group_tools:group:admin_approve:decline:message' => "Hola %s,

tu grupo '%s' fue rechazado y eliminado por un administrador del sitio.",

        // group notification
        'group_tools:notifications:title' => "Notificaciones de grupo",
        'group_tools:notifications:description' => "Este grupo tiene %s miembros, de los cuales %s han activado las notificaciones de actividad en este grupo. Debajo puedes cambiar esto para todos los usuarios del grupo.",
        'group_tools:notifications:disclaimer' => "Con grupos numerosos esto puede demorar unos momentos.",
        'group_tools:notifications:enable' => "Activar las notificaciones para todos",
        'group_tools:notifications:disable' => "Desactivas las notificaciones para todos",

        'group_tools:notifications:toggle:email:enabled' => "Actualmente tu estás recibiendo las notificaciones de la actividad en este grupo. Si no deseas recibir notificaciones, cambia la configuración aquí %s",
        'group_tools:notifications:toggle:email:disabled' => "Actualmente tu no estás recibiendo las notificaciones de la actividad en este grupo. Si deseas recibir notificaciones, cambia la configuración aquí %s",

        'group_tools:notifications:toggle:site:enabled' => "Actualmente tu estás recibiendo las notificaciones de la actividad en este grupo. Si no deseas recibir notificaciones, haz click aquí %s",
        'group_tools:notifications:toggle:site:enabled:link' => "desactivar notificaciones",
        'group_tools:notifications:toggle:site:disabled' => "Actualmente tu no estás recibiendo las notificaciones de la actividad en este grupo. Si deseas recibir notificaciones, haz click aquí %s",
        'group_tools:notifications:toggle:site:disabled:link' => "activar notificaciones",

        // group mail
        'group_tools:tools:mail_members' => "Permitir a los miembros del grupo escribir correos a otros miembros",
        'mail_members:group_tool_option:description' => "Esto permitirá a los miembros normales del grupo enviar un correo electrónico a otros miembros. Por defecto esta función está limitada a administradores de grupo.",

        'group_tools:mail:message:from' => "Del grupo",

        'group_tools:mail:title' => "Enviar un correo a los miembros del grupo",
        'group_tools:mail:form:recipients' => "Número de destinatarios",
        'group_tools:mail:form:members:selection' => "Seleccionar miembros individuales",

        'group_tools:mail:form:title' => "Asunto",
        'group_tools:mail:form:description' => "Cuerpo del texto",

        'group_tools:mail:form:js:members' => "Por favor, selecciona al menos un miembro al cual enviar el mensaje",
        'group_tools:mail:form:js:description' => "Por favor, ingresa el mensaje",

        // group invite
        'group_tools:groups:invite:error' => "Las opciones de invitación no están disponibles",
        'group_tools:groups:invite:title' => "Invitar usuarios a este grupo",
        'group_tools:groups:invite' => "Invitar usuarios",
        'group_tools:groups:invite:user_already_member' => "El usuario ya es miembro de este grupo",

        'group_tools:group:invite:friends:select_all' => "Seleccionar todos mis amigos",
        'group_tools:group:invite:friends:deselect_all' => "Deseleccionar todos mis amigos",

        'group_tools:group:invite:users' => "Encontrar usuario(s)",
        'group_tools:group:invite:users:description' => "Ingresa el nombre o usuario que quieres encontrar y seleccionalo de la lista",
        'group_tools:group:invite:users:all' => "Invitar a todos los usuarios del sitio a este grupo",

        'group_tools:group:invite:email' => "Usa una dirección de correo electrónico",
        'group_tools:group:invite:email:description' => "Ingresa una dirección de correo electrónico válida y eligela del listado",

        'group_tools:group:invite:csv' => "Una un archivo CSV",
        'group_tools:group:invite:csv:description' => "Puedes cargar un archivo CSV que contenga usuarios para invitar.<br />El formato del archivo debe ser: nombre;e-mail. No debe tener encabezado.",

        'group_tools:group:invite:text' => "Nota personal (opcional)",
        'group_tools:group:invite:add:confirm' => "Estás seguro que desea agregar estos usuarios directamente?",

        'group_tools:group:invite:resend' => "Reenviar invitaciones a usuarios que ya fueron invitados",

        'group_tools:groups:invitation:code:title' => "Invitación a grupo vía correo electrónico",
        'group_tools:groups:invitation:code:description' => "Si has recibido una invitación para unirte a un grupo via correo electrónico, puedes ingresar el código de la invitación aquí para aceptarla. Si hacer click en el link que te fue enviado, el código será ingresado automáticamente.",

        // group membership requests
        'group_tools:groups:membershipreq:requests' => "Solicitudes de incorporación",
        'group_tools:groups:membershipreq:invitations' => "Usuarios invitados",
        'group_tools:groups:membershipreq:invitations:none' => "No hay invitaciones pendientes",
        'group_tools:groups:membershipreq:email_invitations' => "Correos electrónicos invitados",
        'group_tools:groups:membershipreq:email_invitations:none' => "No hay invitaciones a correos electrónicos pendientes",
        'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Estás seguro que deseas revocar esta invitación",
        'group_tools:groups:membershipreq:kill_request:prompt' => "Puedes comunicar al usuario porque revocastes la solicitud.",

        // group invitations
        'group_tools:group:invitations:request' => "Solicitudes de incorporación destacadas",
        'group_tools:group:invitations:request:revoke:confirm' => "Estás seguro que deseas revocar esta invitación",
        'group_tools:group:invitations:request:non_found' => "No hay solicitudes de incorporación destacadas en este momento",

        // group listing
        'group_tools:groups:sorting:open' => "Abiertos",
        'group_tools:groups:sorting:closed' => "Cerrados",
        'group_tools:groups:sorting:ordered' => "Ordenados",
        'group_tools:groups:sorting:suggested' => "Sugeridos",

        // allow group members to invite
        'group_tools:invite_members:title' => "Los miembros del grupo pueden invitar",
        'group_tools:invite_members:description' => "Permite a los miembros de un grupo invitar a nuevos miembros",
        'group_tools:invite_members:disclaimer' => "Por favor ten en cuenta que para grupos cerrados esto significa que las invitaciones realizadas por miembros no requerirán aprobación del propietario o administradores de grupo.",

        // group tool option descriptions
        'activity:group_tool_option:description' => "Mostrar un feed de actividad sobre contenidos relacionados al grupo.",

        // actions
        // group edit
        'group_tools:action:group:edit:error:default_access' => "El nivel de acceso elegido por defecto es más abierto que el nivel de acceso del grupo, por lo que el accese por defecto a sido reducido a los miembros del grupo.",

        // group admins - action
        'group_tools:action:toggle_admin:error:group' => "El valor ingresado no sirve en un grupo, no puedes editar este grupo o el usuario no es miembro",
        'group_tools:action:toggle_admin:error:remove' => "Un error desconocido ocurrió mientras se quitaba al usuario como administrador de grupo",
        'group_tools:action:toggle_admin:error:add' => "Un error desconocido ocurrió mientras se añadía al usuario como administrador de grupo",
        'group_tools:action:toggle_admin:success:remove' => "El usuario fue removido exitosamente como administrador de grupo",
        'group_tools:action:toggle_admin:success:add' => "El usuario fue añadido exitosamente como administrador de grupo",

        // group mail - action
        'group_tools:action:mail:success' => "Mensaje enviado exitosamente",

        // group - invite - action
        'group_tools:action:invite:error:invite'=> "Ningún usuario fue invitado (%s ya invitados, %s ya son miembros)",
        'group_tools:action:invite:error:add'=> "Ningún usuario fue añadido (%s ya invitados, %s ya son miembros)",
        'group_tools:action:invite:success:invite'=> "%s usuarios exitosamente invitados (%s ya invitados, %s ya son miembros)",
        'group_tools:action:invite:success:add'=> "%s usuarios exitosamente añadidos (%s ya invitados, %s ya son miembros)",

        // group - invite - accept e-mail
        'group_tools:action:groups:email_invitation:error:code' => "El código de invitación ingresado ya no es válido",
        'group_tools:action:groups:email_invitation:error:join' => "Un error desconocido ocurrió mientras te unías al grupo %s, tal vez ya eras miembro",
        'group_tools:action:groups:email_invitation:success' => "Te has unido exitosamente al grupo",

        // group - invite - decline e-mail
        'group_tools:action:groups:decline_email_invitation:error:delete' => "Un error ocurrió mientras se borraba la invitación",

        // suggested groups
        'group_tools:suggested_groups:info' => "Los siguientes grupos pueden ser de tu interés. Haz click en los botones para unirte inmediatamente o en el título para ver más información sobre los grupos.",
        'group_tools:suggested_groups:none' => "No podemos sugerirte grupos. Esto puede suceder si tenemos poca información sobre tí o si ya eres miembro de los grupos que queremos recomendarte. Usa la búsqueda para encontrar más grupos.",

        // group toggle auto join
        'group_tools:action:toggle_special_state:error:auto_join' => "Un error ocurrió mientras se guardaban los nuevas configuraciones de la incorporación automática",
        'group_tools:action:toggle_special_state:error:suggested' => "Un error ocurrió mientras se guardaban las nuevas configuraciones sugeridas",
        'group_tools:action:toggle_special_state:error:state' => "Estado inválido",
        'group_tools:action:toggle_special_state:auto_join' => "Las nuevas configuraciones de incorporación automática fueron guardadas exitosamente",
        'group_tools:action:toggle_special_state:suggested' => "Las nuevas configuraciones sugeridas fueron guardadas exitosamente",

        // group fix auto_join
        'group_tools:action:fix_auto_join:success' => "Incorporación a grupo corregida: %s nuevos miembros, %s ya eran miembros y %s errores",

        // group cleanup
        'group_tools:actions:cleanup:success' => "Las configuraciones de limpieza fueron guardadas exitosamente",

        // group notifications
        'group_tools:action:notifications:error:toggle' => "Opción inválida",
        'group_tools:action:notifications:success:disable' => "Las notificaciones han sido desabilitadas para todos los miembros",
        'group_tools:action:notifications:success:enable' => "Las notificaciones han sido habilitadas para todos los miembros",

        // fix group problems
        'group_tools:action:fix_acl:error:input' => "Opción inválida que no puedes corregir: %s",
        'group_tools:action:fix_acl:error:missing:nothing' => "No se han encontrado usuarios perdidos en la ACL del grupo",
        'group_tools:action:fix_acl:error:excess:nothing' => "No se han encontrado usuarios excedentes en la ACL del grupo",
        'group_tools:action:fix_acl:error:without:nothing' => "No se pueden encontrar grupos sin la ACL",

        'group_tools:action:fix_acl:success:missing' => "Se han añadido exitosamente %d usuarios a la ACL del grupo",
        'group_tools:action:fix_acl:success:excess' => "Se han removido exitosamente %d usuarios a la ACL del grupo",
        'group_tools:action:fix_acl:success:without' => "Se han creado exitosamente %d ACL de grupo",

        // Widgets
        // Group River Widget
        'widgets:group_river_widget:title' => "Actividad de Grupo",
    'widgets:group_river_widget:description' => "Muestra la actividad de un grupo en un widget",

    'widgets:group_river_widget:edit:num_display' => "Número de actividades",
        'widgets:group_river_widget:edit:group' => "Elige un grupo",
        'widgets:group_river_widget:edit:no_groups' => "Necesitas ser miembro de al menos un grupo para usar este widget",

        'widgets:group_river_widget:view:not_configured' => "Este widget no está configurado todavía",

        'widgets:group_river_widget:view:noactivity' => "No pudimos encontrar actividad.",

        // Group Members
        'widgets:group_members:title' => "Miembros de Grupo",
          'widgets:group_members:description' => "Muestra los miembros de este grupo",

        'widgets:group_members:view:no_members' => "No se han encontrado miembros en el grupo",

          // Group Invitations
        'widgets:group_invitations:title' => "Invitaciones de Grupo",
          'widgets:group_invitations:description' => "Muestra las invitaciones de grupo destacadas para el usuario vigente",

        // index_groups
        'widgets:index_groups:description' => "Lista los grupos de tu comunidad",
        'widgets:index_groups:show_members' => "Muestra la suma de miembros",
        'widgets:index_groups:featured' => "Muestra solo los grupos destacados",
        'widgets:index_groups:sorting' => "Como ordenar los grupos",

        'widgets:index_groups:filter:field' => "Filtrar los grupos basado en el campo grupal",
        'widgets:index_groups:filter:value' => "con valor",
        'widgets:index_groups:filter:no_filter' => "Sin filtro",

        // Featured Groups
        'widgets:featured_groups:description' => "Muestra una lista aleatoria de grupos destacados",
          'widgets:featured_groups:edit:show_random_group' => "Muestra una lista aleatoria de grupos no destacados",

        // group_news widget
        "widgets:group_news:title" => "Noticias de Grupo",
        "widgets:group_news:description" => "Muestra los últimos 5 blogs de varios grupos",
        "widgets:group_news:no_projects" => "No hay grupos configurados",
        "widgets:group_news:no_news" => "Este grupo no tiene blogs",
        "widgets:group_news:settings:project" => "Grupo",
        "widgets:group_news:settings:no_project" => "Elige un grupo",
        "widgets:group_news:settings:blog_count" => "Número máximo de blogs",
        "widgets:group_news:settings:group_icon_size" => "Tamaño del ícono del grupo",

        'groups:search:title' => "Buscar grupos que coincidan con '%s'",

        // welcome message
        'group_tools:welcome_message:title' => "Mensaje de bienvenida de grupo",
        'group_tools:welcome_message:description' => "Puedes configurar un mensaje de bienvenida para los nuevos usuarios que se unan a este grupo. Si no quieres enviar un mensaje, deja este casillero en blanco.",
        'group_tools:welcome_message:explain' => "Para personalizar el mensaje tu puedes usar los siguientes campos de texto:
[name]: el nombre del nuevo usuario (ej. %s)
[group_name]: el nombre del grupo (ej. %s)
[group_url]: la url del grupo (ej. %s)",

        'group_tools:action:welcome_message:success' => "El mensaje de bienvenida fue guardado",

        'group_tools:welcome_message:subject' => "Bienvenido/a a %s",

        // email invitations
        'group_tools:action:revoke_email_invitation:error' => "Un error ocurrió mientras se revocaba la invitación, por favor intente nuevamente",
        'group_tools:action:revoke_email_invitation:success' => "La invitación fue revocada",

        // domain based groups
        'group_tools:join:domain_based:tooltip' => "Tu dominio de correo coincide con el de este grupo, puedes unirte.",

        'group_tools:domain_based:title' => "Configurar los dominios de los correos electrónicos",
        'group_tools:domain_based:description' => "Cuando configuras uno o más dominios de correo, los usuarios con ese dominio serán incorporados automáticamente a tu grupo cuando se registren. Tambien si tienes un grupo cerrado los usuarios con el dominio de correo pueden unirse sin invitación. Puedes configurar múltiples dominios usando una coma. No incluyas el símbolo @",

        'group_tools:action:domain_based:success' => "Los nuevos dominios de correo electrónico fueron guardados",

        // related groups
        'groups_tools:related_groups:tool_option' => "Mostrar grupos relacionados",

        'groups_tools:related_groups:widget:title' => "Grupos relacionados",
        'groups_tools:related_groups:widget:description' => "Muestra un listado de grupos que has agregado como relacionados con este grupo.",

        'groups_tools:related_groups:none' => "No se encontraron grupos relacionados.",
        'group_tools:related_groups:title' => "Grupos relacionados",

        'group_tools:related_groups:form:placeholder' => "Buscar un nuevo grupo relacionado",
        'group_tools:related_groups:form:description' => "Puedes buscar un nuevo grupo relacionado, elígelo de la lista y haz click en Añadir.",

        'group_tools:action:related_groups:error:same' => "No puedes relacionar ese grupo con sí mismo",
        'group_tools:action:related_groups:error:already' => "El grupo elegido ya está relacionado",
        'group_tools:action:related_groups:error:add' => "Un error desconocido ocurrió mientras se añadía una relación, por favor intenta nuevamente.",
        'group_tools:action:related_groups:success' => "El grupo ahora está relacionado",

        'group_tools:related_groups:notify:owner:subject' => "Un nuevo grupo relacionado fue agregado",
        'group_tools:related_groups:notify:owner:message' => "Hola %s,

%s agregó tu grupo %s como un grupo relacionado de %s.",

        'group_tools:related_groups:entity:remove' => "Remover grupo relacionado",

        'group_tools:action:remove_related_groups:error:not_related' => "Este grupo no está relacionado",
        'group_tools:action:remove_related_groups:error:remove' => "Un error desconocido ocurrió mientras se removía la relación, por favor intente de nuevo",
        'group_tools:action:remove_related_groups:success' => "Este grupo no está más relacionado",

        'group_tools:action:group_tool:presets:saved' => "Se han guardado las nuevas configuraciones predefinidas para las herramientas de grupo",

        'group_tools:forms:members_search:members_search:placeholder' => "Ingresa el nombre del usuario al que estas buscando",

        // group member export
        'group_tools:member_export:title_button' => "Exportar miembros",

        // csv exporter
        'group_tools:csv_exporter:group_admin:name' => "Nombre del administrador(es) de grupo",
        'group_tools:csv_exporter:group_admin:email' => "Correo electrónico del administrador(es) de grupo",
        'group_tools:csv_exporter:group_admin:url' => "Url del perfil del administrador(es) de grupo",

        'group_tools:csv_exporter:user:group_admin:name' => "Nombre de los grupos administrados",
        'group_tools:csv_exporter:user:group_admin:url' => "Url de los grupos administrados",

        // group bulk delete
        'group_tools:action:bulk_delete:success' => "El grupo elegido fue eliminado",
        'group_tools:action:bulk_delete:error' => "Un error ocurrió mientras se borraban los grupos, intenta nuevamente",

        // group toggle notifications
        'group_tools:action:toggle_notifications:disabled' => "Las notificaciones para el grupo '%s' han sido desabilitadas",
        'group_tools:action:toggle_notifications:enabled' => "Las notificaciones para el grupo '%s' han sido habilitadas",

        // group join motivation
        'group_tools:join_motivation:edit:option:label' => "La incorporación a este grupo cerrado requiere una motivación",
        'group_tools:join_motivation:edit:option:description' => "Los grupos cerrados pueden solicitar que los nuevos miembros envien una motivación de porqué quieren unirse.",

        'group_tools:join_motivation:title' => "Porque quieres unirte a '%s'?",
        'group_tools:join_motivation:description' => "El propietario de '%s' ha fijado que una motivación es necesaria para unirse a este grupo. Por favor, escribe tu motivación debajo para que el propietario pueda decidir sobre tu solicitud.",
        'group_tools:join_motivation:label' => "Mi motivación para unirme a este grupo",

        'group_tools:join_motivation:notification:subject' => "%s ha solicitado unirse a %s",
        'group_tools:join_motivation:notification:summary' => "%s ha solicitado unirse a %s",
        'group_tools:join_motivation:notification:body' => "Hola %s,

%s ha solicitado unirse al grupo '%s'.

Su motivación para unirse es:
%s

Haz click aquí para ver su perfil:
%s

Haz click debajo para ver las solicitudes de adhesión del grupo:
%s",
        'group_tools:join_motivation:toggle' => "Mostrar motivación",
        'group_tools:join_motivation:listing' => "Razón para unirse:",

);
