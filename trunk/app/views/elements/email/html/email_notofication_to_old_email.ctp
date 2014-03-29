<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Email Notification</title>

    </head>

    <table cellspacing="0">
        <tr>
            <td style="padding:10px 0 10px 5px;background-color: #000;">
                <a href="<?php echo WEBSITE_FRONT_URL; ?>">
                    <img alt="" src="<?php echo WEBSITE_IMG_URL; ?>front/logo.png">
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <table class="content">
                    <tr>
                        <td>
                            Hi there,
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Your contact email has been changed from <a href="mailo:<?php echo $tmp_email; ?>"><?php echo $tmp_email; ?></a>  to 
                            <a href="mailo:<?php echo $this->data ['User']['email']; ?>"><?php echo $this->data ['User']['email']; ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            if you did not make this change , please use the link below to restore you email to <a href="mailo:<?php echo $tmp_email; ?>"><?php echo $tmp_email; ?></a>.<br>
							 This link will expire in 1 day.
                                <?php echo $this->Html->link('click here.', $restore_email); ?>
                        </td>
                    </tr>
                </table>   
            </td>
        </tr>
        <tr>
            <td>
                <p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:9.5pt;font-family:"MyriadProRegular";color:#666666'>Copyrights
                        2014 <?php echo Configure::read('CONFIG_SITE_TITLE'); ?>.com All Rights Reserved.<o:p></o:p></span></p>
            </td>
        </tr>
    </table>
</html>