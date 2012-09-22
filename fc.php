<?php
/****************************************
 *Author: Ron Watkins
 *Date: 2012, Sep 2nd
 *Program name: fc.php
 *Function: Test whether pure php is faster
 *          or slower than exec()
 ****************************************/

### getmicrotime() 
### gets time in nanoseconds
function getmicrotime($e = 7)
{
        list($u, $s) = explode(' ',microtime());
            return bcadd($u, $s, $e);
}

$iterations = 100;
$graph1 = "php_createfile.txt";
$graph2 = "php_deletefile.txt";
$graph3 = "exec_createfile.txt";
$graph4 = "exec_deletefile.txt";
$graph_phpcf= fopen($graph1, "a");
$graph_phpdf= fopen($graph2, "a");
$graph_execf= fopen($graph3, "a");
$graph_exedf= fopen($graph4, "a");

$i = 0;

$program_Start = getmicrotime();
for ($i == 0; $i < $iterations; $i++){

    $php_createfile_start = getmicrotime();
    // Create a file using php 
    php_createfile();
    $php_createfile_end = getmicrotime();

    $php_deletefile_start = getmicrotime();
    php_deletefile();
    $php_deletefile_end = getmicrotime();

    $exec_createfile_start = getmicrotime();
    // Create a file using exec()
    exec_createfile();
    $exec_createfile_end = getmicrotime();

    $exec_deletefile_start = getmicrotime();
    exec_deletefile();
    $exec_deletefile_end = getmicrotime();

    // Process the run time of the program
    graph("php_createfile", $graph_phpcf, $i, $php_createfile_start, $php_createfile_end);
    graph("exec_createfile", $graph_execf, $i, $exec_createfile_start, $exec_createfile_end);
    graph("php_deletefile", $graph_phpdf, $i, $php_deletefile_start, $php_deletefile_end);
    graph("exec_deletefile", $graph_exedf, $i, $exec_deletefile_start, $exec_deletefile_end);
}
$program_End = getmicrotime();

process("Runtime", $program_Start, $program_End);

fclose($graph_file);
fclose($graph_phpcf);
fclose($graph_phpdf);
fclose($graph_execf);
fclose($graph_exedf);

function graph($name, $file, $iteration, $start, $end){
    $time = $end - $start;
    $write = $iteration . " " . $time . "\n";
    fwrite($file, $write);
    echo "Task: " . $name . "\t\t Time: " . $time . "\n";
}

# process() will take the name, start, and end times
# of a task and output the name and total time it took
# to complete said task
function process($name, $start, $end){
    $time = $end - $start;
    echo "Task: " . $name . "\t\t Time: " . $time . "\n";
}

function php_deletefile(){
    $file = "meow.txt";
    unlink($file);
}

function exec_deletefile(){
    $file = "meow.txt";
    exec("rm -f " . $file);
}

function php_createfile(){
    $file = "meow.txt";
    $content = "meow meow meow";
    $open = fopen($file, "w");
    fwrite($open, $content);
    fclose($open);
}

function exec_createfile(){
    $file = "meow.txt";
    $content = "meow meow meow";
    exec("echo \"" . $content . "\" > " . $file);
}
?>
