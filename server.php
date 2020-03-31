<?php
set_time_limit(0);

header("Content-Type: text/event-stream");
header('Cache-Control: no-cache');

while(connection_status() === 0) {

    // Experimente modificar o arquivo data.txt durante a execucao
    $newcontent = str_replace(PHP_EOL, " ", file_get_contents('data.txt'));

    if(!isset($oldcontent) || $oldcontent != $newcontent) {
        echo 'event: fileRead', "\n";
        echo 'data: ' . $newcontent, "\n\n";
        $alert      = TRUE;
        $oldcontent = $newcontent;
    } elseif($alert ?? TRUE) {
        echo 'data: data.txt inalterado, edite o arquivo!', "\n\n";
        $alert = FALSE;
    }

    while (ob_get_level() > 0) {
        ob_end_flush();
    }
    
    flush();

    sleep(1);
}

exit();
