<?php
include('./common.php');

$mad_count = getVoteCount(5433);
$sam_count = getVoteCount(5424);

$type = i($QUERY, 'type', 'info');

if($mad_count and $sam_count) {
	$content = file_get_contents($type . '.txt');
	$line = time() . ",$mad_count,$sam_count";
	file_put_contents($type . '.txt', $content . "\n" . $line);
}
print $line;
