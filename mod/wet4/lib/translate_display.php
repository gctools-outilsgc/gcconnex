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
 * Ilia Salem   2017-01-        Reworked for JSON

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

    if( isset($json->en) || isset($json->fr) ){
        if( $lang == 'en' && trim($json->en) != ''){
            $value=$json->en;
        }
        else if( $lang == 'fr' && trim($json->fr) != ''){
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

function old_gc_explode_translation($imploded_txt, $lang)
{
    $text_ar=explode('[:',$imploded_txt);
    $en='';
    $fr='';
    if(count($text_ar)>0){
        foreach($text_ar as $value){
            if(strpos($value, "en]")!==false){
                $en=substr($value,3,strlen($value));
            }
            elseif(strpos($value, "fr]")!==false)
            {
                $fr=substr($value,3,strlen($value));
            }
        }
        if($lang=='en' && trim($en)<>''){
            $value=$en;
        }
        elseif($lang=='fr' && trim($fr)<>''){
            $value=$fr;
        }
        else
        {
            if(($lang=='fr') && (!$fr)){
       /*         $value=$fr;
            }else{*/
                $value="";      // for migration we want to maintain these as is
            }

             if(($lang=='en') && (!$en)){
      /*          $value=$en;
            }else{*/
                $value="";      // for migration we want to maintain these as is
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