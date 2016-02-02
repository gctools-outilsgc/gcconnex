

<!-- Form Code Start -->
<!-- FAQ PART-->
<?php //echo elgg_echo("contactform:body"); ?>
<!-- END FAQ PART-->

<h2 class="h2"><?php echo elgg_echo('contactform:help'); ?></h2>
					<h3><?php echo elgg_echo('contactform:title'); ?></h3>
						<?php echo elgg_echo('contactform:list'); ?>

					<h3><?php echo elgg_echo('contactform:faq'); ?></h3>
						
					<div class="accordion">
	<!-- Accordion section 1 -->
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'><?php echo elgg_echo('contactform:title:lostpwd'); ?></summary>
		<div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
			<?php echo elgg_echo('contactform:content:lostpwd'); ?>
            </div>
		</div>
	</details>
	<!-- Accordion section 2 -->
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'><?php echo elgg_echo('contactform:title:lostuser'); ?></summary>
		<div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
		<?php echo elgg_echo('contactform:content:lostuser'); ?>
            </div>
						
		</div>
	</details>
                            <!-- Accordion section 3 -->
    <details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'><?php echo elgg_echo('contactform:title:create'); ?></summary>
		<div class="tgl-panel">
            <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
			<?php echo elgg_echo('contactform:content:create'); ?>
			</div>			
		</div>
	</details>
                            
                            	<!-- Accordion section 4 -->
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'><?php echo elgg_echo('contactform:title:picture'); ?></summary>
        <div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
		 <?php echo elgg_echo('contactform:content:picture'); ?>
            </div>
        </div>
	</details>

</div>
				
						

					<h3><?php echo elgg_echo('contactform:useful'); ?></h3>
						<ul>
						<li> <a href='http://gcconnex.gc.ca/groups/profile/211647/clicks-and-tips'><?php echo elgg_echo('contactform:clickandtips'); ?></a> </li>
						<li> <a href='http://gcconnex.gc.ca/groups/profile/226392/gc20-tools-outils-gc20'><?php echo elgg_echo('contactform:gc20'); ?></a> </li>
						</ul>
