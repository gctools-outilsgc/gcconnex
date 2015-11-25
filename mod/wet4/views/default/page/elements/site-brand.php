<?php
/**
 * WET 4 Site Branding
 * 
 */

// footer
//echo elgg_view('core/account/login_dropdown');
$site_url = elgg_get_site_url();


?>


    <div id="app-brand">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 ">
                    <div class="app-name">
                    <a href="<?php echo $site_url; ?>">
                        <span><span class="bold-gc">GC</span>connex</span>
                    </a>
                    </div>
                    
                    
                </div>
                <div class="col-sm-2 col-sm-offset-7 hidden-xs">
                    <div class="dropdown  pull-right tools-navigator ">
                        <a  href="#" class=" dropdown-toggle" type="button" id="tools-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        GCTools
                    <i class="fa fa-chevron-down"></i>
                        </a>
                    <ul class="dropdown-menu tools-navigator-menu tools-dropdown-holder clearfix" aria-labelledby="tools-dropdown">
                       
                            
                            <li class="col-xs-6 clearfix"><a href="#"><div class=" img-responsive"><i class="fa fa-file-text-o fa-4x center-block"></i><div>GCpedia</div></div></a></li>
                            <li class="col-xs-6"><a href="#"><i class="fa fa-share-alt fa-4x"></i><div>GCconnex</div></a></li>
                            <li class="col-xs-6"><a href="#"><i class="fa fa-video-camera fa-4x"></i><div>GCVideo</div></a></li>
                            <li class="col-xs-6"><a href="#"><i class="fa fa-globe fa-4x"></i><div>Intranet</div></a></li>

                    </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
