var dtpath = elgg.normalize_url() + 'mod/multi_file_upload/js/fileinput';

require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "fileinput": dtpath
    }
});
requirejs( ["fileinput"], function() {
    //console.log(elgg.get_page_owner_guid());
    $("#red").fileinput({
        uploadAsync: false,
        //showRemove: false,
        //showUpload:false,
        //theme: 'fa',
        uploadUrl: elgg.normalize_url('/mod/multi_file_upload/actions/file/upload.php'),
        //uploadUrl: elgg.normalize_url('action/multi_file/upload'),
        maxFilePreviewSize: 10240,
        uploadExtraData:function() {
            var obj = {};
            obj['folder_guid'] = $('#file_tools_file_parent_guid').find(":selected").val();
            obj['access_id'] = $('#file_tools_file_access_id').find(":selected").val();
            obj['container_guid'] = elgg.get_page_owner_guid();
            //folder_guid: $('#file_tools_file_parent_guid').find(":selected").val(),
            //access_id: $('#file_tools_file_access_id').find(":selected").val(),
            return obj;
        },
    });
    $('#red').on('filebatchuploadsuccess', function(event, data) {
        //console.log(JSON.stringify(data.response));
        //console.log(data.response.forward_url);
        window.location.replace(data.response.forward_url);
        //console.log('event '+JSON.stringify(event));
        //console.log('files '+JSON.stringify(data));
        //console.log('extra '+JSON.stringify(extra));
    });
   /*$('#red').on('filebatchuploadcomplete', function(event, data) {
        console.log('event complete '+JSON.stringify(event));
        console.log('files complete'+data);
        //console.log('extra '+JSON.stringify(extra));
    });*/
    $('#red').on('filebatchuploaderror', function(event, data, msg) {
        console.log('event error'+JSON.stringify(event));
        console.log('files error'+JSON.stringify(data));
        //console.log('extra '+JSON.stringify(extra));
    });
    
    
});
