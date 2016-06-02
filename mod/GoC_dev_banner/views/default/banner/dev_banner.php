<?php 

/**

    GoC_Dev_Banner
    
    Display big banner across top of webpage to show WIP development

**/
if (elgg_get_plugin_setting('Banneractive', 'GoC_dev_banner')) {
    if(elgg_get_plugin_setting('startdate','GoC_dev_banner')!="" && elgg_get_plugin_setting('enddate','GoC_dev_banner')!=""){
        //echo elgg_get_plugin_setting('Banneractive','GoC_dev_banner');
        $NotTextLang= get_current_language();

        $Notstartdate=date('Y-m-d',strtotime(elgg_get_plugin_setting('startdate','GoC_dev_banner')));
        $Notenddate=date('Y-m-d',strtotime(elgg_get_plugin_setting('enddate','GoC_dev_banner')));
        $currdate=date('Y-m-d');
        if(($currdate >$Notstartdate) &&  ($currdate<$Notenddate)){
            
            echo '<div class="alert alert-'.elgg_get_plugin_setting('bannertype','GoC_dev_banner').' text-center mrgn-bttm-0" role="alert"><p>' .elgg_get_plugin_setting('notice'.$NotTextLang,'GoC_dev_banner');
            if(elgg_get_plugin_setting('moreinfolink','GoC_dev_banner') !=""){
                echo '<a href="'.elgg_get_plugin_setting('moreinfolink','GoC_dev_banner').'">'.elgg_echo('dev_banner:MoreInfo').'</a>';
            }
            echo '</p></div>';

        }
    }
    else
    {
        echo '<div class="alert alert-warning text-center mrgn-bttm-0" role="alert">' . elgg_echo('dev_banner:alert') . '</div>';

    }
}
//