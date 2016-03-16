<?php
$siteurl=elgg_get_site_url();
$tour='<ol id="joyRideTipContent"><li data-id="activity" data-text="'.elgg_echo('gcTour:next').'"><h2>'.elgg_echo('gcTour:step1').'</h2><p>'.elgg_echo('gcTour:step1txt').'</p></li><li data-id="tool-link" data-text="'.elgg_echo('gcTour:next').'"  data-options="tipLocation:bottom"><h2>'.elgg_echo('gcTour:step2').'</h2><p>'.elgg_echo('gcTour:step2txt').'</p></li><li data-class="elgg-menu-item-profile" data-button="'.elgg_echo('gcTour:close').'"  data-options="tipLocation:top"><h2>'.elgg_echo('gcTour:step3').'</h2><p>'.elgg_echo('gcTour:step3txt').'</p></li></ol>';
$tourScriptCookie = $siteurl.'mod/wet4/views/default/widgets/feature_tour/js/jquery.cookie.js';
$tourScriptmodernize = $siteurl.'mod/wet4/views/default/widgets/feature_tour/js/modernizr.mq.js';
$tourScriptjoyride = $siteurl.'mod/wet4/views/default/widgets/feature_tour/js/jquery.joyride-2.1.js';
?>

<script>

    $(document).ready(function () {
        $('#tour').parent().parent().remove();
        $('head').append('<link rel="stylesheet" href="<?php echo elgg_get_site_url();?>mod/wet4/views/default/widgets/feature_tour/css/joyride-2.1.css">');
        $('body').append('<?php echo $tour;?>');
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = '<?php echo $tourScriptCookie;?>';
        $('body').append(script);
        var script2 = document.createElement('script');
        script2.type = 'text/javascript';
        script2.src = '<?php echo $tourScriptmodernize;?>';
        $('body').append(script2);
        var script3 = document.createElement('script');
        script3.type = 'text/javascript';
        script3.src = '<?php echo $tourScriptjoyride;?>';
        $('body').append(script3);
        $('<script>$(window).load(function() {$("#joyRideTipContent").joyride({autoStart : true,modal:true,tipLocation:\'top\',\'cookieMonster\': true,\'cookieName\': \'GCconnex\', });});</' + 'script>').appendTo(document.body);
    });
</script>

<?php


?>

<div id="tour"></div>

