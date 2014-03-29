<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Core", "HttpSocket");
App::import("Lib", "Xmlrpc.Xmlrpc");

class PingbacksComponent extends Object
{
    public $components = array( "Session" );
    private $Socket = NULL;
    public $controller = null;

    public function initialize($controller)
    {
        $this->Socket = new HttpSocket();
        $this->controller = $controller;
    }

    public function pingback($sourceUri, $text)
    {
        $links = $this->extractLinks($text, false);
        foreach( $links as $link ) 
        {
            $this->pingbackUrl($sourceUri, $link);
        }
    }

    public function pingbackUrl($sourceUri, $targetUri)
    {
        $urlData = $this->Socket->get($targetUri);
        $pingbackServerUri = $this->_determinePingbackUri($this->Socket->response);
        if( !empty($pingbackServerUri) ) 
        {
            $XmlRpcClient = new XmlRpcClient($pingbackServerUri);
            try
            {
                $Request = new XmlRpcRequest("pingback.ping", array( new XmlRpcValue($sourceUri), new XmlRpcValue($targetUri) ));
                $result = $XmlRpcClient->call($Request);
            }
            catch( Exception $e ) 
            {
            }
        }

    }

    public function trackback($sourceUri, $text)
    {
        $links = $this->extractLinks($text, false);
        foreach( $links as $link ) 
        {
            $this->trackbackUrl($sourceUri, $link);
        }
    }

    public function trackbackUrl($sourceUri, $targetUri)
    {
        $urlData = $this->Socket->get($targetUri);
        $trackbackServerUri = $this->_determineTrackbackUri($this->Socket->response);
        if( !empty($trackbackServerUri) ) 
        {
            $response = $this->Socket->post($targetUri, $data);
        }

    }

    public function extractLinks($text, $allowLocalLinks = false)
    {
        $matches = array(  );
        $result = preg_match_all("/href=\"([^\"]+)\"/i", $text, $matches);
        if( isset($matches[1]) ) 
        {
            $urls = $matches[1];
        }
        else
        {
            $urls = array(  );
        }

        $result = array(  );
        foreach( $urls as $url ) 
        {
            if( $allowLocalLinks ) 
            {
                $result[] = $url;
            }
            else
            {
                $urlInfo = HttpSocket::parseuri($url);
                $serverHost = "";
                if( isset($urlInfo["host"]) && isset($urlInfo["scheme"]) ) 
                {
                    $schemeLen = strlen($urlInfo["scheme"]) + 3;
                    $serverHost = $urlInfo["scheme"] . "://" . $urlInfo["host"];
                    if( strpos(substr(FULL_BASE_URL, $schemeLen), ":") !== false ) 
                    {
                        $serverHost .= ":" . $urlInfo["port"];
                    }

                }

                if( $serverHost != FULL_BASE_URL ) 
                {
                    $result[] = $url;
                }

            }

        }
        return $result;
    }

    public function _determineTrackbackUri($text)
    {
        $result = false;
        preg_match_all("|(\\<rdf\\:RDF.+?\\<\\/rdf\\:RDF\\>)|is", $text, $matches);
        if( isset($matches[1]) ) 
        {
            foreach( $matches[1] as $match ) 
            {
                $Xml = new Xml($match);
                $result = $this->_scanRdf($Xml);
                if( !empty($result) ) 
                {
                    return $result;
                }

            }
        }

        if( empty($result) ) 
        {
            $result = $this->_testRelLink($text, "trackback");
        }

        if( empty($result) ) 
        {
            $result = $this->_testTagClass($text, "span", "trackbacks-link");
        }

        return $result;
    }

    protected function _scanRdf($xml)
    {
        if( 0 < count($xml->children) ) 
        {
            $rootNode = $xml->children[0];
            if( $rootNode->namespace . ":" . $rootNode->name != "rdf:RDF" || !isset($rootNode->namespaces["trackback"]) ) 
            {
                return false;
            }

            foreach( $rootNode->children as $child ) 
            {
                if( $child->namespace . ":" . $child->name == "rdf:Description" && isset($child->attributes["trackback:ping"]) ) 
                {
                    return $child->attributes["trackback:ping"];
                }

            }
        }

        return false;
    }

    protected function _determinePingbackUri($response)
    {
        foreach( $response["header"] as $header => $value ) 
        {
            if( strtolower($header) == "x-pingback" ) 
            {
                return $value;
            }

        }
        return $this->_testRelLink($response["body"], "pingback");
    }

    protected function _testRelLink($text, $relType)
    {
        if( preg_match("|<link rel=\"" . $relType . "\" href=\"([^\"]+)\" ?/?>|", $text, $matches) ) 
        {
            return str_replace(array( "&amp;", "&lt;", "&gt;", "&quot;" ), array( "&", "<", ">", "\"" ), $matches[1]);
        }

        return false;
    }

    protected function _testTagClass($text, $tag, $class)
    {
        if( preg_match("|<" . $tag . ".*? class=\"" . $class . "\".*?>([^<]+?)</" . $tag . ">|", $text, $matches) ) 
        {
            return str_replace(array( "&amp;", "&lt;", "&gt;", "&quot;" ), array( "&", "<", ">", "\"" ), $matches[1]);
        }

        return false;
    }

}




?>