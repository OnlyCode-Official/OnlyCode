<?php
$git = 'cd /tmp && git clone https://github.com/Hardwaregore/Hardwaregore';
$useless = array();
$failed = 0;

// exec($git, $output, $failed);

if ($failed !== 0) {
    // Command failed
    echo "Git command failed with error code: $failed\n";
} else {
    // Command succeeded
    echo "Git command succeeded. Output: \n";
}
