<?php

if (isset($encoded_url)) {
    $paginator->options(array('url' => array("?" => $encoded_url)));
}

$options = array('class' => 'p_numbers', 'separator' => '');
echo $paginator->numbers($options);
echo $paginator->counter(array('format' => '&nbsp;&nbsp; Showing %page% out of %pages%.'));
?>
