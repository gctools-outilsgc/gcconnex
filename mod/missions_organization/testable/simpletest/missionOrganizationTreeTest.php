<?php
class MissionDatabaseTest extends ElggCoreUnitTest {
	
	private $list_of_nodes = array();
	private $orphan_count = 0;
	private $severed_count = 0;
	
	function setUp() {
		$options['type'] = 'object';
		$options['subtype'] = 'orgnode';
		$options['limit'] = 0;
		$this->list_of_nodes = elgg_get_entities_from_metadata($options);
	}
	
	function tearDown() {
		unset($this->list_of_nodes);
	}
	
	public function testForEachNode() {
		$result = $this->assertTrue((count($this->list_of_nodes) > 0), elgg_echo('missions_organization:diagnostic_suite:no_nodes_in_db'));
		if($result) {
			$this->assertTrue((mo_get_tree_root() != ''), elgg_echo('missions_organization:diagnostic_suite:no_tree_root'));
		}
		
		$count = 0;
		foreach($this->list_of_nodes as $node) {
			$this->testNodeHasOnlyOneParent($node);
			$this->testNodeCanReachRoot($node);
		}
		$this->assertTrue(($this->orphan_count == 0), elgg_echo('missions_organization:diagnostic_suite:orphans', array($this->orphan_count)));
		$this->assertTrue(($this->severed_count == 0), elgg_echo('missions_organization:diagnostic_suite:severed', array($this->severed_count)));
	}
	
	private function testNodeHasOnlyOneParent($node) {
		$parent = mo_node_immediate_parent($node->guid);
		/*$options['type'] = 'object';
		$options['subtype'] = 'orgnode';
		$options['relationship'] = 'org-related';
		$options['relationship_guid'] = $node->guid;
		$options['inverse_relationship'] = true;
		$options['limit'] = 0;
		$parent = elgg_get_entities_from_relationship($options);*/
		//$parent = get_entity_relationships($node->guid, true);
		
		$parentage_string = '';
		foreach($parent as $p) {
			$parentage_string = $p->guid . ' with subtype ' . $p->subtype . ' /\/ ';
		}
		
		$result_two = true;
		$result_one = $this->assertTrue((count($parent) < 2), elgg_echo('missions_organization:diagnostic_suite:node_has_more_than_one_parent', array($node->abbr, $node->guid, $parentage_string)));
		if(mo_get_tree_root()->guid != $node->guid) {
			$result_two = $this->assertTrue((count($parent) > 0), elgg_echo('missions_organization:diagnostic_suite:node_has_no_parent', array($node->abbr, $node->guid)));
		}
		
		if(!$result_one || !$result_two) {
			$this->orphan_count++;
		}
	}
	
	private function testNodeCanReachRoot($node) {
		$result = true;
		if(mo_get_tree_root()->guid != $node->guid) {
			$node_string = "MOrg:" . $node->guid;
			$result = $this->assertTrue((count(mo_get_all_ancestors($node_string, false)) != 0), elgg_echo('missions_organization:diagnostic_suite:node_cannot_reach_root', array($node->abbr, $node->guid)));
		}
		
		if(!$result) {
			$this->severed_count++;
		}
	}
}