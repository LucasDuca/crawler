<?php

/**
 * Classe responsável por quebras os links e algumas outras funcionalidades
 */
class Crawler {

    private $_escapelink = array(' ','"#','./','/..','../');
    private $_data;
    /**
     * Faz o download da url
     * @param type $url
     * @author Lucas Duca<lucasducaster@gmail.com>
     * @return html string
     */
    private function pageDown($url) {
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
            $site = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            curl_close($ch);
        }
        return $site;
    }

    /**
     * Retorna a lista de links do site utilizando a expressão regular recomendada
     * @param type $url
     * @author Lucas Duca<lucasducaster@gmail.com>
     * @return array links
     */
    public function getLinks($url) {
        $links = null;
        $base_url = $this->getBaseUrl($url);
        $this->_data = $this->pageDown($url);
        preg_match_all('/<a href=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?>/i',  $this->_data, $results);

        foreach ($results[1] as $td) {
            $lnk = $this->linkRepair($base_url, $td);
            $links[] = $lnk;
        }

        return $links;
    }
    
    
    /**
     * Retorna a lista de emails do site utilizando a expressão regular recomendada
     * @param type $url
     * @author Lucas Duca<lucasducaster@gmail.com>
     * @return array emails
     */
    public function getEmails() {
        preg_match_all('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i',  $this->_data, $results);

       
        return (isset($results[0])? $results[0] : '');
    }

    /**
     * Retorna a url base para correção de link
     * @param type $url
     * @return type
     */
    private function getBaseUrl($url) {
        $base = "";
        $tot = explode("/", $url);

        if (count($tot) > 3) {//se tiver caminho longo
            $base = "{$tot[0]}//{$tot[2]}";
        } elseif (count($tot) > 1) {//se tiver caminho curto
            $base = $url;
        }

        return $base;
    }

    /**
     * Repara o link, completa o endereço e remove links de funções js
     * @author Lucas Duca<lucasducaster@gmail.com>
     * * @param type $base
     * @param type $url
     * @return type
     */
    private function linkRepair($base, $url) {

        $url = $this->escape_url($url);
        $link = $url;

        if (strripos($url, "http") === false) {
            if (strripos($url, "//") === false) {

                if (substr($url, 0, 1) == "/") {
                    $link = "$base$url";
                } else {
                    $link = "$base/$url";
                }
            } else {
                $link = "http:$url";
            }
        }
        return $link;
    }

    /**
     * Remove caracteres que estragam o link
     * @author Lucas Duca<lucasducaster@gmail.com>
     * @param type $url
     * @return type
     */
    private function escape_url($url) {
        foreach ($this->_escapelink as $r)
            if (substr($url, 0, strlen($r)) == $r) {
                $url = str_replace($r, "", $url);
            }

        return $url;
    }

}
?>