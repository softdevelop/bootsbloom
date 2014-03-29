<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Unauthorized Access</title>
            <?php echo $html->css('front/error_pages.css'); ?>

    </head>

    <body>

        <div class="content">
            <div class="blackbg">
            <?php echo $this->Html->link($this->Html->image('front/logo.png'), WEBSITE_URL, array('escape' => false)); ?>
            </div>
            <div class="grey-frame">
                <div class="grey-frame-inner">
                    <h1>404 Page Not Found</h1>
                    <p>We apologize but page you are looking for is not available.</p>
                    <p>Would you like to: <a href="javascript:history.go(-1)">Go Back</a> or <?php echo $this->Html->link('Go to Home Page', WEBSITE_URL, array('escape' => false)); ?>?</p>
                </div>
            </div>
        </div>
    </body>
</html>
