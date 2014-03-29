<?php

if($_REQUEST['key'] != 'deadf00d')
{
	exit();
}


echo "<pre><b>Updating the website from git repo</b>\n";

echo "\n<b>git pull</b>\n";
if(system('git pull') === false)
{
	echo "Error!\n";
}

echo "\n<b>Done</b>\n</pre>";
