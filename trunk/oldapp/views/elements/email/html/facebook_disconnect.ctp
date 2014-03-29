<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Email Verification</title>
     
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
                            If this is correct, please ignore this email. 
                        </td>
                    </tr>
                   
                    <tr>
                        <td>
                            If this is a mistake, please reconnect here: 
                          
                        </td>
                    </tr>
                    <tr>
                        <td>
                             <?php echo WEBSITE_URL.'users/account-setting'; ?>
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