<?php
class RssHelper extends AppHelper {
 
    var $helpers = array('Xml');
 
    function parseRss($limit = 3) {
        // Parse the RSS feed
        $xml = new Xml('http://example.com/rss-feed.xml');
        $data = $xml->toArray();
 
        // Filter any non-news items
        $items = $this->filterItems($data);
 
        // Prepare output array
        $output = array();
 
        // Loop over the results
        for($i = 0;$i < $limit;$i++) {
            $output[] = $items[$i];
        }
 
        // Return the filtered and limited items list
        return $output;
    }
 
    function filterItems($data) {
        // Prepare results array
        $results = array();
 
        // Filter any non-news items
        foreach($data['Rss']['Channel']['Item'] as $item) {
            if($item['category'] == 'News') {
                $results[] = $item;
            }
        }
 
        return $results;
    }
 
}
