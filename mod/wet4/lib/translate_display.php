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
    $value="[:en]".$english_txt."[:fr]".$french_txt."[:]";

    return $value;
}

function gc_explode_translation($imploded_txt, $lang)
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
            $value=$imploded_txt;
        }
    }
    else
    {
        $value=$imploded_txt;
    }
    return $value;

}
?>