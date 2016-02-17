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
function gc_implode_translation($english_txt,$french_txt)
{
    $value="[:en]".$english_txt."[:fr]".$french_txt."[:]";

    return $value;
}

function gc_explode_translation($imploded_txt, $lang)
{
    $text_ar=explode('[:',$imploded_txt);
    $en='';
    $fr='';
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
            $value=$en;
     }
    else
    {
        if($lang=='en'){
            $value='No entries found.';
        }
        else
        {
            $value='Aucune information fut trouvé.';
        }
    }

    return $value;

}
?>