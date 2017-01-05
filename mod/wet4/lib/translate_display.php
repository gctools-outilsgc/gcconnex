<?php
/*This Lib serves to combine english and french text into the single entry as well as explode the entry to retreive the english and french
 *
 *
 * */
/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * MBlondin 	2016-02-14 		Creation of library

 ***********************************************************************/
 /**
 * GCconnex combine English and French text into one string
 *
 *
 * @uses string    $english_txt            English text
 * @uses string  $french_txt          French Text
 *
 */
function gc_implode_translation($english_txt,$french_txt)
{
    $value = json_encode( array( "en" => $english_txt, "fr" => $french_txt ) );

    return $value;
}

function gc_explode_translation($imploded_txt, $lang)
{
    $json=json_decode($imploded_txt);

    if(count($json)>0){
        if($lang=='en' && trim($json->en)<>''){
            $value=$json->en;
        }
        elseif($lang=='fr' && trim($json->fr)<>''){
            $value=$json->fr;
        }
        else
        {
            if( ($lang=='fr') && trim($json->fr) == '' ){
                $value=$json->en;
            }
            else if( ($lang=='en') && trim($json->en) == '' ){
                $value=$json->fr;
            }
        }
    }
    else
    {
        $value=$imploded_txt;
    }

    return $value;
}
?>