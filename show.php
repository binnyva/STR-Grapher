<?php
require('./common.php');
header("Content-type: text/plain");

$mad_count = getVoteCount(5433);
$sam_count = getVoteCount(5424);

print "MAD: $mad_count
SAM: $sam_count
Difference: ";
print $mad_count - $sam_count;