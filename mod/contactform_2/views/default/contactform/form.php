<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/creating-a-contact-form.html
*/

<div class='form-group'>
    <label for='text' ><?php echo elgg_echo('SecondMessage'); ?></label><br/>
    <select class="form-control" id='text' name='text' value='<?php echo $formproc->SafeDisplay('text') ?>'>
<option>--</option>
<option>1</option>
<option >2</option>
<option>3</option>
<option>4</option>
<option>5</option>
</select>
   
</body>
</html>
