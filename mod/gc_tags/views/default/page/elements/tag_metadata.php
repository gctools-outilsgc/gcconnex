<?php
/*
* Extends the site head if the entity has communities or audiences with metadata
* 
* @author Nick github.com/piet0024
*/

global $my_page_entity;

//Does this entity have communities?
if($my_page_entity->audience){
    $audience = $my_page_entity->audience;
    //if multiple communities loop and create a <meta> for each
    if(is_array($audience)){
        foreach($audience as $value){
             echo '<meta name="dcterms.audience" content="'.$value.'">';
        }
       
    }else{
        echo '<meta name="dcterms.audience" content="'.$audience.'">';
    }
    
}
