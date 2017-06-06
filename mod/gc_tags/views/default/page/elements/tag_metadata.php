<?php
/*
* 
* Extends the site head if the entity has communities or audiences with metadata
*
*/

//$entity = $vars['entity'];
global $my_page_entity;

//Does this entity have communities?
if($my_page_entity->audience){
    $audience = $my_page_entity->audience;
    //if multiple communities
    if(is_array($audience)){
        foreach($audience as $value){
            $audience_string .= $value .',';
        }
        echo '<meta name="dcterms.audience" content="'.$audience_string.'">';
    }else{
        echo '<meta name="dcterms.audience" content="'.$audience.'">';
    }
    
}
