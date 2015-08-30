<?php

include_once('database/func.php');
include_once('database/dbpdo.php');
include_once('lib/crawler.php');


define('DATABASE_NAME', 'webx');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');
define('DATABASE_HOST', 'localhost');

$craw = new Crawler();
$func = new Func();

$result[] = null;

do {
    if (isset($result[0])) {//SE FOR UM RESULTADO
        $e = 1;
        foreach ($result as $row) {
            //LISTA TODOS OS LINKS EM UM ARRAY
            $links = $craw->getLinks($row['url']);

            // INSERE AS URLS
            for ($i = 0; $i < count($links); $i++) {
                echo "Processando links de {$row['url']} --- [$i-" . (count($links) - 1) . "] ###### \r\n";
                if (!$func->linkExists($links[$i])) {
                    $func->inserirUrl($links[$i]);
                } else {
                    echo "Link existente {$links[$i]}!\r\n";
                }
            }

            // INSERE OS EMAILS
            $emails = $craw->getEmails();
            for ($i = 0; $i < count($emails); $i++) {
                if (!$func->emailExists($emails[$i])) {
;
                    $func->inserirEmail($emails[$i]);
                } else {
                    echo "Email existente {$emails[$i]}!\r\n";
                }
            }
            $e++;
        }
        $func->setVisited($row['url']);
    } else {
        echo "Starting process!\n";
    }
    $result = $func->getAllUrls();
    $rcont = $func->getCountUrls();
} while (isset($result[0]) || isset($result['url']));
?>