/*
 * fileinput.js
 *
 * Initialize bootstra fileinput
 *
 * @package multi_file_input
 * @author GCTools Team
 */
var dtpath = elgg.normalize_url() + 'mod/multi_file_upload/js/fileinput';

require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "fileinput": dtpath
    }
});
requirejs( ["fileinput"], function() {

    //define french language here
    //elgg wasn't liking loading this file
    $.fn.fileinputLocales['fr'] = {
        fileSingle: 'fichier',
        filePlural: 'fichiers',
        browseLabel: 'Parcourir',
        removeLabel: 'Retirer',
        removeTitle: 'Retirer les fichiers sélectionnés',
        cancelLabel: 'Annuler',
        cancelTitle: "Annuler l'envoi en cours",
        uploadLabel: 'Transférer',
        uploadTitle: 'Transférer les fichiers sélectionnés',
        msgNo: 'Non',
        msgNoFilesSelected: '',
        msgCancelled: 'Annulé',
        msgZoomModalHeading: 'Aperçu détaillé',
        msgSizeTooSmall: 'File "{name}" (<b>{size} KB</b>) is too small and must be larger than <b>{minSize} KB</b>.',
        msgSizeTooLarge: 'Le fichier "{name}" (<b>{size} Ko</b>) dépasse la taille maximale autorisée qui est de <b>{maxSize} Ko</b>.',
        msgFilesTooLess: 'Vous devez sélectionner au moins <b>{n}</b> {files} à transmettre.',
        msgFilesTooMany: 'Le nombre de fichier sélectionné <b>({n})</b> dépasse la quantité maximale autorisée qui est de <b>{m}</b>.',
        msgFileNotFound: 'Le fichier "{name}" est introuvable !',
        msgFileSecured: "Des restrictions de sécurité vous empêchent d'accéder au fichier \"{name}\".",
        msgFileNotReadable: 'Le fichier "{name}" est illisble.',
        msgFilePreviewAborted: 'Prévisualisation du fichier "{name}" annulée.',
        msgFilePreviewError: 'Une erreur est survenue lors de la lecture du fichier "{name}".',
        msgInvalidFileName: 'Invalid or unsupported characters in file name "{name}".',
        msgInvalidFileType: 'Type de document invalide pour "{name}". Seulement les documents de type "{types}" sont autorisés.',
        msgInvalidFileExtension: 'Extension invalide pour le fichier "{name}". Seules les extensions "{extensions}" sont autorisées.',
        msgUploadAborted: 'Le téléchargement du fichier a été interrompu',
        msgUploadThreshold: 'Processing...',
        msgValidationError: 'Erreur de validation',
        msgLoading: 'Transmission du fichier {index} sur {files}&hellip;',
        msgProgress: 'Transmission du fichier {index} sur {files} - {name} - {percent}% faits.',
        msgSelected: '{n} {files} sélectionné(s)',
        msgFoldersNotAllowed: 'Glissez et déposez uniquement des fichiers ! {n} répertoire(s) exclu(s).',
        msgImageWidthSmall: 'Largeur de fichier image "{name}" doit être d\'au moins {size} px.',
        msgImageHeightSmall: 'Hauteur de fichier image "{name}" doit être d\'au moins {size} px.',
        msgImageWidthLarge: 'Largeur de fichier image "{name}" ne peut pas dépasser {size} px.',
        msgImageHeightLarge: 'Hauteur de fichier image "{name}" ne peut pas dépasser {size} px.',
        msgImageResizeError: "Impossible d'obtenir les dimensions de l'image à redimensionner.",
        msgImageResizeException: "Erreur lors du redimensionnement de l'image.<pre>{errors}</pre>",
        dropZoneTitle: 'Glissez et déposez les fichiers ici&hellip;',
        dropZoneClickTitle: '<br>(or click to select {files})',
        fileActionSettings: {
            removeTitle: 'Supprimer le fichier',
            uploadTitle: 'Télécharger un fichier',
            zoomTitle: 'Voir les détails',
            dragTitle: 'Move / Rearrange',
            indicatorNewTitle: 'Pas encore téléchargé',
            indicatorSuccessTitle: 'Posté',
            indicatorErrorTitle: 'Ajouter erreur',
            indicatorLoadingTitle: 'ajout ...'
        },
        previewZoomButtonTitles: {
            prev: 'View previous file',
            next: 'View next file',
            toggleheader: 'Toggle header',
            fullscreen: 'Toggle full screen',
            borderless: 'Toggle borderless mode',
            close: 'Close detailed preview'
        }
    };

    //console.log(elgg.get_page_owner_guid());
    $("#multi-file-upload").fileinput({
        uploadAsync: false,
        allowedPreviewTypes: null,
        allowedPreviewMimeTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'image/gif', 'text/plain'], //only allow preview for these file types
        language: elgg.get_language(),
        //maxFileSize: 10000,
        allowedFileExtensions: get_file_tools_settings(),
        maxFileCount: 10,
        uploadUrl: elgg.normalize_url('/mod/multi_file_upload/actions/file/upload.php'),
        maxFilePreviewSize: 10240,
        removeFromPreviewOnError: true,
        uploadExtraData:function() {
            var obj = {};
            obj['folder_guid'] = $('#file_tools_file_parent_guid').find(":selected").val();
            obj['access_id'] = $('#file_tools_file_access_id').find(":selected").val();
            obj['container_guid'] = elgg.get_page_owner_guid();
            //folder_guid: $('#file_tools_file_parent_guid').find(":selected").val(),
            //access_id: $('#file_tools_file_access_id').find(":selected").val(),
            return obj;
        },
        previewFileIconSettings: { //display nice icons for filetypes that don't have preview
        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
        'mp4': '<i class="fa fa-file-movie-o text-warning"></i>',
        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
    },
    });
    $('#multi-file-upload').on('filebatchuploadsuccess', function(event, data) {
        //window.location.replace(data.response.forward_url);
        //elgg.system_message(data.response.system_messages.success);
        elgg.register_error(data.response.system_messages.error);
        elgg.forward(data.response.forward_url);

    });

    $('#multi-file-upload').on('fileuploaded', function(event, data) {
        elgg.system_message(data.response.system_messages.success);
        elgg.register_error(data.response.system_messages.error);
    });

    //change tabindex of inputs for accessibility
    $('.file-caption-main button, .file-caption-main .fileinput-upload-button, .file-caption-main .file-caption').attr('tabindex', '0');

    $('#multi-file-upload').on('filebatchuploaderror', function(event, data, msg) {
        console.log('event error'+JSON.stringify(event));
        console.log('files error'+JSON.stringify(data));
        //console.log('extra '+JSON.stringify(extra));
    });


});
