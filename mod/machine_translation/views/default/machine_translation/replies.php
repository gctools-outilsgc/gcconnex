<?php
	/*
	 * replies.php
	 * This file contains the extended view for group discussions.
	 * Adds javascript to discussion for translating replies.
	 * 
	 */
	
	?>
	<style>
	.outputArea{
		width:100%;
		height:200px;
		border-style: solid;
		border-width: 1px;
		margin:5px;
		padding:5px;
		overflow-y: scroll;
		resize: none;
	}
	.loader{
		margin-left:auto;
		display:block;
		padding-top:45px;
	}
	.directionSelect{

		height:30px;
	}
	.inputsFloat{
		float:right;
	}
	#textSpan{
		float:left;
		padding-top:5px;
	}
	#outputContainer > ul{
		display: none;
	}
	#cke_1_top{
		
	}
	#cke_1_bottom{
		
	}
	.modal-transparent {
  		background: transparent;
	}
	.modal-transparent .modal-content {
	  background: transparent;
	}
	.modal-backdrop.modal-backdrop-transparent {
	  background: #ffffff;
	}
	.modal-backdrop.modal-backdrop-transparent.in {
	  opacity: .9 !important;
	  filter: alpha(opacity=90);
	}

	</style>
	<div class="modal modal-transparent fade" id="modal-transparent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog dialog-box">
        <div class="panel panel-custom">
            <div class="panel-heading">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <div class="modal-title" id="title"><h2><?php echo elgg_echo('mc:LCtool:title'); ?></h2></div>
    </div> <!-- close <div class="modal-header"> -->
   <div class="panel-body">
    <div class="basic-profile-standard-field-wrapper">
        <div class="alert alert-info">
        	<?php 
        	echo elgg_echo('mc:LCtool:disclaimerTitle'); 
        	echo elgg_echo('mc:LCtool:disclaimer1');
			echo elgg_echo('mc:LCtool:disclaimer2');
			echo elgg_echo('mc:LCtool:disclaimer3');
        	?>
        	
        </div> <!-- empty div for use later -->
        <div id="lctBody">
        	
        		
        	<div style="float:left;">
        		<span id='textSpan'><?php echo elgg_echo('mc:LCtool:originalText'); ?></span>
        	</div>
        	<div class='inputsFloat'>
        		
        		<select id='directionSelect' class='directionSelect' name='direction'>
        			<option value='e2f'>English &#8594; French</option>
        			<option value='f2e'>français &#8594; Anglais</option>
        		</select>
        	
        		<button id="translateButton" class='translateButton' type="button"><?php echo elgg_echo('mc:LCtool:button'); ?></button>
        	</div>
        	
        	<div id='outputContainer' style='width:100%;'>
        		<!-- <textarea id='outputArea' class='outputArea'></textarea> -->
        		
				<div id='outputArea' class='outputArea' contenteditable="true"></div>
        	</div>
        	
        	</div>
    <script type="text/javascript">
		
		$(document).ready(function () {
			
			//CKEDITOR.disableAutoInline = true;
			var textBlock;
			var domText;
			
			
			$(".modal-transparent").on('show.bs.modal', function () {
				
  				setTimeout( function() {
    				$(".modal-backdrop").addClass("modal-backdrop-transparent");
  				}, 0);
			});
			$(".modal-transparent").on('hidden.bs.modal', function () {
  				$(".modal-backdrop").addClass("modal-backdrop-transparent");
			});
			//grabs the metadata menu of each discussion reply
			var replyMenu = $('.elgg-item-object-discussion_reply').find('.elgg-menu-entity-default');
			//adds translate link to the front of the metadata list
			//replyMenu.prepend("<li class='mrgn-lft-sm'><a href='javascript:void(0);' id='translink' class='translink' name='trans' data-toggle='modal' data-target='#LCToolModal'><?php echo elgg_echo("machine:linktext"); ?></a></li>");
			replyMenu.prepend('<li class="mrgn-lft-sm"><a href="javascript:void(0);" id="translink" class="translink" name="trans" data-toggle="modal" data-target="#modal-transparent"><i class="fa fa-language fa-lg icon-unsel" title="Language Comprehension Tool" aria-hidden="true"><span class="wb-inv"><?php echo elgg_echo("machine:linktext"); ?></span></i></a></li>');
			/*document.getElementById("translateButton").addEventListener("click", function(){
				var direction = $('select.directionSelect').val();
				console.log('direction: '+direction);
			});*/
			
			$('.translink').click(function(){
				//traverse up the dom and then find the paragraph tag which holds the comment text
				$('#outputArea').text('');
        		textBlock = $(this).parent().parent().parent().find('div[data-role="discussion-reply-text"]');
        		console.log(textBlock[0].innerHTML)
        		
        		$('#outputArea').html(textBlock[0].innerHTML);
        		
        		////////////////
        		//var iframe = $('.cke_wysiwyg_frame');
        		//console.log('iframe: ' + JSON.stringify(iframe.contents().find('body').html()));
        		//$('#outputArea > p').each(function(index){
        		//	console.log(index);
        		//});
        		//$('#outputArea').innerhtml = 'test<br />1 2 3';
        		//iframe.children().each(function(index){
        		//	console.log(index);
        		//});
       		});
       		
       		
			$('#translateButton').click(function(){
				//console.log($('#outputArea').val());
				//var tmp = document.createElement("div");
				//tmp.innerHTML = $('#outputArea').val();
				
				
				//var tmp = $('#outputArea').val();
				//var pArray = tmp.querySelectorAll("p");
				//for (var i = 0; i<pArray.length; i++){
				//	console.log(pArray[i]);
				//}
				//.each(function(index){
					//console.log(index);
				//});
				
				//var outputText = $('<div class="outputArea"></div>');				
				var tmp = $('<div></div>');
				tmp.html($('#outputArea').html());
				
				$('#outputArea').html('');
				var outputArea = $('#outputArea');
				outputArea.hide();
				$('#outputArea').remove();
				
				$('#outputContainer').html('<img id="loader" class="loader" src="<?php echo elgg_get_site_url();?>mod/machine_translation/lib/img/ajax-loader.gif" alt="Wait" />');
				$('#textSpan').text('<?php echo elgg_echo('mc:LCtool:wait'); ?>');
				var count = tmp.children('p').length;
				
				tmp.children('p').each(function (index, element){
					//console.log('index: '+index+' element: '+$(element).text());
					var newText = $(element).text();
					var direction = $('#directionSelect').val();
					//console.log('direction: '+ direction);
					
					domText = newText;
                	var cleanedText = newText;
                	cleanedText = cleanedText.replace(/(\r\n|\n|\r)/gm,"");
               		//console.log('text: '+cleanedText);
                	
                	var sendData = {
        				"direction": direction, //translates to fr if en is sent and vice versa
        				"text": cleanedText,//grabs html contents p tag
        				//"text": 'This is a test',
        			};
        			
        			console.log(JSON.stringify(sendData));
        			
        			var txt = $('<textarea></textarea>');
                	$.ajax({
        				type: 'GET',
        				url: '<?php echo elgg_get_plugin_setting('apiurl','machine_translation'); ?>',
                		//url: 'https://portage-dev.pwgsc.gc.ca/translate',//translation bureau link
                		//url: 'http://192.168.2.53/translate.php?q=$text&lang=$lang',
                		data: sendData,
                		dataType: 'text',
                		success: function (feed){
                			var feedObj = JSON.parse(feed); 
                			var newText = feedObj.data.translations[0].translatedText;
                			
                			//txt.innerHTML = newText;
                			txt.html(newText);
                			//alert(html(newText));
                			//outputArea.append(txt.value);
                			///return txt.value;
                			//domText = txt.value;
                			//textBlock.html(txt.value).text();//swaps text of comment with translated results
                		}, 
                		//TODO: complete with alert for debug edit error
                    	complete: function (feed){
                    	    //alert(JSON.stringify(feed));
                    	    //$('#outputContainer').empty();
                    	    //outputArea.prop("readonly", true);
                    	    //$('#outputContainer').append(outputArea);
                    	    //$('#textSpan').text('<?php echo elgg_echo('mc:LCtool:translated'); ?>');
                    	    //console.log(txt.value);
                    	    //return '<p>'+txt.html()+'</p>';
                    	    outputArea.append('<p>'+txt.html()+'</p>');
                    	    if(index == count - 1){
                    	    	console.log('in if')
                    	    	$('#loader').hide();
                    	    	outputArea.show();
                    	    }
                    	    //if()
                        
                    	},
        			});
        			
        			//console.log(JSON.stringify(outputText.html()))
				});
				//console.log(outputText);
				//$('#outputContainer').empty();
				//outputArea.val(outputText.html());
				
				//longText.val(outputText.html());
                //outputText.prop("readonly", true);
                //console.log(outputText);
                $('#outputContainer').append(outputArea);
              	$('#textSpan').text('<?php echo elgg_echo('mc:LCtool:translated'); ?>');
				
				////////////////////////////
        		
        		
                
        		//ajax request to translation
        		
			});
			//add onlick trigger for translate link
			
        		$('#okButton').click(function(){
        			if ($('.outputArea').html() != '')
       					textBlock.html($('.outputArea').html());
       				else
       					textBlock.html($('.outputArea').val());
       			});
    		});
			
		
		
	</script>
        
    </div>
       

    </div>
            <div class="panel-footer">
                <!--Is this you?-->
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo elgg_echo('mc:button:cancel'); ?> </button> 
                <button id='okButton' type="button" class="btn btn-primary" data-dismiss="modal"><?php echo elgg_echo('mc:button:ok'); ?> </button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
