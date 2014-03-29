<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <table cellspacing="0">
        <tr>
            <td style="padding:10px 0 10px 5px;background-color: #DDDDDD; text-align: center" >
                <a href="<?php echo WEBSITE_FRONT_URL; ?>">
                    <img alt="" src="<?php echo WEBSITE_IMG_URL; ?>front/bloomlogo.png">
                </a>
                <br />
                <span style="color: #404042; font-size: 18px;"> <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $newsletter_info['SendEmailBackup']['date']); ?></span>
            </td>
        </tr>
        <tr>
            <td>
            <?php echo $message; ?>
            </td>
            </tr>
            <tr>
                <td>
                    <p align=center style='text-align:center'>
                        <span  style='font-size:9.5pt;font-family:"MyriadProRegular";color:#666666'>
                            Copyrights 2014 <?php echo Configure::read('CONFIG_SITE_TITLE'); ?>.com All Rights Reserved.
                        </span>
                    </p>
                </td>
            </tr>
    </table>
</html>