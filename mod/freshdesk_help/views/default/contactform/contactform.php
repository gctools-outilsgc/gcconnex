<?php ?>

<h2 class="h2 mrgn-tp-lg"><?php echo elgg_echo('freshdesk:additionalinfo'); ?></h2>

<div class="additional-info">
	<h3><?php echo elgg_echo('contactform:useful'); ?></h3>
	<div class="accordion">
	<!-- Accordion section 1 -->
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'><?php echo elgg_echo('contactform:helpful'); ?></summary>
		<div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
        			<ul class='list-unstyled'>
                <li><a href= 'https://gcconnex.gc.ca/groups/profile/662668/ambassadors-network-for-the-gc20-tools-reseau-des-ambassadeurs-des-outils-gc20'><?php echo elgg_echo('contactform:ambassadors'); ?></a></li>
                <li><a href= 'https://gcconnex.gc.ca/groups/profile/211647/clicks-and-tips-clics-et-conseils'><?php echo elgg_echo('contactform:clicks'); ?></a></li>
                <li><a href= 'https://gcconnex.gc.ca/groups/profile/226392/gc20-tools-outils-gc20'><?php echo elgg_echo('contactform:groupgcconnex'); ?></a></li>
                <li><a href= 'http://www.gcpedia.gc.ca/wiki/GC2.0_Tools_Team_-_%C3%89quipe_des_Outils_GC2.0'><?php echo elgg_echo('contactform:teamgcpedia'); ?></a></li>
        			</ul>
            </div>
		</div>
	</details>
	<!-- Accordion section 2 -->
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'><?php echo elgg_echo('contactform:learn'); ?></summary>
		<div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
    					<ul class='list-unstyled'>
                <li><a href= <?php echo elgg_echo('contactform:collaborating:link'); ?>><?php echo elgg_echo('contactform:collaborating'); ?></a></li>
                <li><a href= <?php echo elgg_echo('contactform:socialmedia:link'); ?>><?php echo elgg_echo('contactform:socialmedia'); ?></a></li>
                <li><?php echo elgg_echo('contactform:guidance'); ?></li>
              </ul>
            </div>

		</div>
	</details>

	</div>

  <div class="mrgn-tp-md">
    <a href= "mailto:GCTools-OutilsGC@tbs-sct.gc.ca?subject=Subscription%20to%20Newsletter%20/%20Abonnement%20à%20l'infolettre&body=Please%20share%20your%20department's%20name%20/%20Veuillez%20partager%20le%20nom%20de%20votre%20ministère"><?php echo elgg_echo('contactform:newsletter'); ?></a>
  </div>
</div>
