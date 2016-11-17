<?php
/*
* stepOne.php - Groups
*
* First and only step loaded by the groups module
* Has option to search for groups or pick from featured/popular groups
*/
?>
<div class="col-xs-12" id="tracker">
    <?php echo elgg_view('groups-steps/group-tracker'); ?>
</div>

<div id="search" class="col-xs-12">
    <?php
    $loading = elgg_view('output/img', array(
            'src' => 'mod/wet4/graphics/loading.gif',
            'alt' => 'loading'
        ));

    $url = elgg_get_site_url() . 'groups/search';
    $body = elgg_view_form('groups/find-onboard', array(
        'action' => $url,
        'method' => 'get',
        'disable_security' => true,
    ));

    $body .= '<div id="searchResults" class="wb-eqht"></div>';

        echo elgg_view_module('mod', elgg_echo('groups:searchtag'), $body );?>
</div>

<div id="featured" class="col-sm-6 col-xs-12">
    <?php echo elgg_view_module('mod', elgg_echo("groups:featured"), elgg_view('widgets/featured_groups') );?>
</div>

<div id="popular" class="col-sm-6 col-xs-12">
    <?php echo elgg_view_module('mod', elgg_echo("groups:popular"), elgg_view('widgets/popular_groups') );?>
</div>

<script>

    //search entered
    $('.searchGroups').on('click', function (e) {

        //stop form submitting
        e.preventDefault();

        //loading animation
        $('#searchResults').html('<div class="text-center" style="margin: 0 auto;display:block;"><?php echo $loading; ?></div>');

        //perform search action
        elgg.action('onboard/search', {
            data: {
                tag: $('#tagSearch').val()
            },
            success: function (wrapper) {
                //display results
                $('#searchResults').html(wrapper.output.groups);
                //add query string to group links
                addString();
            }
        });

    });

    //join group and perform animation
    function joinGroup(type, guid) {

        //grab content of button
        var oldHTML = $('#' + type + '-' + guid).html();

        //add spinner - chane button colour
        $('#' + type + '-' + guid).html('<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i><span class="sr-only">Loading...</span>').removeClass('btn-primary').addClass('btn-default');

        //perform join action
        elgg.action('onboard/join', {
            data: {
                group_guid: guid
            },
            success: function (wrapper) {
                if (wrapper.output.result == 'joined') { //joined group
                    $('#' + type + '-' + guid).html("<?php echo elgg_echo('groups:joined'); ?>").attr('disabled', true);
                    updateTracker();
                } else if(wrapper.output.result == 'requestsent') { //join request sent
                    $('#' + type + '-' + guid).html("<?php echo elgg_echo('groups:joinrequestmade'); ?>").attr('disabled', true);
                    updateTracker();
                } else if (wrapper.output.result == 'failed') { //failed
                    $('#' + type + '-' + guid).html(oldHTML).removeClass('btn-default').addClass('btn-primary');
                }
            }
        });
    }

    //update group tracker on top of page
    function updateTracker() {
        elgg.get('ajax/view/groups-steps/group-tracker', {
            success: function (output) {

                $('#tracker').html(output);

            }
        });
    }

    //add query string to each group link
    function addString() {

        $('.summary-title a').each(function () {
            var href = $(this).attr('href');
            //dont add query string if link already has one
            if (href.indexOf('?onboard=true') == -1) {
                $(this).attr('href', href + '?onboard=true')
            }
        });



    }

    addString();

</script>
