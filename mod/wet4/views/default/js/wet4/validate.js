var dtpath = elgg.normalize_url() + '/mod/wet4/views/default/js/wet4/jquery.validate.min';

require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "form-validate": dtpath,
    }
});

var validExtentions = get_file_tools_settings('single');
var newExt = validExtentions.replace(/, /g, '|'); //format the extensions for validation

requirejs( ["form-validate"], function() {
   $(".elgg-form").each(function(){
     $(this).validate({
     showErrors: function(errorMap, errorList) {
             $("#myErrorContainer").html("Your form contains "
              + this.numberOfInvalids()
              + " errors, see details below.");
              this.defaultShowErrors();
            },
    invalidHandler: function(form, validator) {
              var errors = validator.numberOfInvalids();
              if (errors) {

                var element = validator.errorList[0].element;

                //check to see if textarea
                if($(element).is('textarea:hidden')){
                  for(var i in CKEDITOR.instances){
                    if(CKEDITOR.instances[i].name == $(element).attr('name') || CKEDITOR.instances[i].name == $(element).attr('id')){
                      $('#cke_'+$(element).attr('id')).attr('aria-labelledby', $(element).attr('id')+'-error');
                      CKEDITOR.instances[i].focus();
                    }
                  }
                } else {
                  validator.errorList[0].element.focus();
                }
              }
          },
          submitHandler: function(form) {
            $(form).find('button').prop('disabled', true);
            form.submit();
          },
    ignore: ':hidden:not(.validate-me)',
     rules: {
       generic_comment: {
          required: true
      },
      description: {
         required: true
      },
       description2: {
         required: true
       },
       upload: {
         extension: newExt
       },
    },
    messages: {  //add custom message for file validation
        upload:{
            extension:elgg.echo('form:invalid:extensions',[validExtentions])
        }
    }
   });
 });

   if(elgg.get_language() == 'fr'){
   $.extend( $.validator.messages, {
     	required: "Ce champ est obligatoire.",
     	remote: "Veuillez corriger ce champ.",
     	email: "Veuillez fournir une adresse électronique valide.",
     	url: "Veuillez fournir une adresse URL valide.",
     	date: "Veuillez fournir une date valide.",
     	dateISO: "Veuillez fournir une date valide (ISO).",
     	number: "Veuillez fournir un numéro valide.",
     	digits: "Veuillez fournir seulement des chiffres.",
     	creditcard: "Veuillez fournir un numéro de carte de crédit valide.",
     	equalTo: "Veuillez fournir encore la même valeur.",
     	extension: "Veuillez fournir une valeur avec une extension valide.",
     	maxlength: $.validator.format( "Veuillez fournir au plus {0} caractères." ),
     	minlength: $.validator.format( "Veuillez fournir au moins {0} caractères." ),
     	rangelength: $.validator.format( "Veuillez fournir une valeur qui contient entre {0} et {1} caractères." ),
     	range: $.validator.format( "Veuillez fournir une valeur entre {0} et {1}." ),
     	max: $.validator.format( "Veuillez fournir une valeur inférieure ou égale à {0}." ),
     	min: $.validator.format( "Veuillez fournir une valeur supérieure ou égale à {0}." ),
     	maxWords: $.validator.format( "Veuillez fournir au plus {0} mots." ),
     	minWords: $.validator.format( "Veuillez fournir au moins {0} mots." ),
     	rangeWords: $.validator.format( "Veuillez fournir entre {0} et {1} mots." ),
     	letterswithbasicpunc: "Veuillez fournir seulement des lettres et des signes de ponctuation.",
     	alphanumeric: "Veuillez fournir seulement des lettres, nombres, espaces et soulignages.",
     	lettersonly: "Veuillez fournir seulement des lettres.",
     	nowhitespace: "Veuillez ne pas inscrire d'espaces blancs.",
     	ziprange: "Veuillez fournir un code postal entre 902xx-xxxx et 905-xx-xxxx.",
     	integer: "Veuillez fournir un nombre non décimal qui est positif ou négatif.",
     	vinUS: "Veuillez fournir un numéro d'identification du véhicule (VIN).",
     	dateITA: "Veuillez fournir une date valide.",
     	time: "Veuillez fournir une heure valide entre 00:00 et 23:59.",
     	phoneUS: "Veuillez fournir un numéro de téléphone valide.",
     	phoneUK: "Veuillez fournir un numéro de téléphone valide.",
     	mobileUK: "Veuillez fournir un numéro de téléphone mobile valide.",
     	strippedminlength: $.validator.format( "Veuillez fournir au moins {0} caractères." ),
     	email2: "Veuillez fournir une adresse électronique valide.",
     	url2: "Veuillez fournir une adresse URL valide.",
     	creditcardtypes: "Veuillez fournir un numéro de carte de crédit valide.",
     	ipv4: "Veuillez fournir une adresse IP v4 valide.",
     	ipv6: "Veuillez fournir une adresse IP v6 valide.",
     	require_from_group: "Veuillez fournir au moins {0} de ces champs.",
     	nifES: "Veuillez fournir un numéro NIF valide.",
     	nieES: "Veuillez fournir un numéro NIE valide.",
     	cifES: "Veuillez fournir un numéro CIF valide.",
     	postalCodeCA: "Veuillez fournir un code postal valide."
     } );
   }

   //allows validation of file types
   $.validator.addMethod( "extension", function( value, element, param ) {
	param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
	return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
  });

 } );
require(['ckeditor'], function(CKEDITOR) {
 //deal with copying the ckeditor text into the actual textarea
    CKEDITOR.on('instanceReady', function () {
       $.each(CKEDITOR.instances, function (instance) {
            CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
            CKEDITOR.instances[instance].document.on("paste", CK_jQ);
            CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
            CKEDITOR.instances[instance].document.on("blur", CK_jQ);
            //CKEDITOR.instances[instance].document.on("change", CK_jQ);
            CKEDITOR.instances[instance].on("change", CK_jQ);
           CKEDITOR.instances[instance].on("insertHtml", CK_jQ);
           CKEDITOR.instances[instance].on("afterCommandExec", CK_jQ);
        });
    });

    function CK_jQ() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
      }
    }
});