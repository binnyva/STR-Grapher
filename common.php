<?php
require('../../../../../iframe/common.php');

$time_zone_offset = 12.5 * 60 * 60;

function getVoteCount($project_id) {
	$content = load('http://www.sparktherise.com/projectdetail.php?pid='.$project_id);
	if(preg_match('/<div class\=\"voteCounter\">(\d+)<br>/', $content, $matches)) {
		$count = $matches[1];
	}

	return $count;
}