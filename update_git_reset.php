<?php
/**
 * Created by PhpStorm.
 * User: niketpathak
 * Date: 29/07/16
 * Time: 23:37
 */
//echo `git pull`;
//setup
//$cmd = 'git clone https://niketpathak89:pw@github.com/niketpathak/restaurant_naf.git';

$descriptorspec = array(
    0 => array("pipe", "r"),  // stdin is a pipe that the child will read from	| anonymous pipe since "pipe" is used as input :: anonymous pipe is a temporary pipe, the most common one in use
    1 => array("pipe", "w"),  // stdout is a pipe that the child will write to	| anonymous pipe since "pipe" is used as input
    2 => array("file", "git-error-output.txt", "a") // stderr is a file to write to | named pipe since "file" is used as input :: named pipe is a permanent pipe and be reused
);

$cmd = 'git reset --hard origin/master';	//fix conflicts
//$cmd = 'git rm --cached -r uploads/';	        //remove all uploads
$process = proc_open($cmd, $descriptorspec, $pipes);

if (is_resource($process)) {

// set both pipes non-blocking
//    stream_set_blocking($pipes[0], 0);
//    stream_set_blocking($pipes[1], 0);

//    fwrite($pipes[0], '-a');

    fclose($pipes[0]);

    echo "*****".date("Y-m-d h:i:sa")."***** ".stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    $return_value = proc_close($process);

    echo "command returned $return_value\n";
}
