<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title><?php  echo Configure::read('CONFIG_SITE_TITLE'); ?></title>
            <?php echo $html->css('front/error_pages.css'); ?>
    </head>

    <body>

        <div class="content">
            <div class="blackbg">
            <?php echo $this->Html->link($this->Html->image('front/logo.png'), WEBSITE_URL, array('escape' => false)); ?>
            </div>
            <div class="grey-frame">
                <div class="grey-frame-inner">
                    <h1>Do not worry</h1>
                    <p>Your Session is still alive, Keep working</p>
                </div>
            </div>
        </div>
    </body>
</html>
