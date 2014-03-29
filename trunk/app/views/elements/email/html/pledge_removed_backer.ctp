<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Project Started</title>

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
                            Hello there!
                        </td>
                    </tr>
                    <tr>
                        <td>
                            We're sorry to see that you have decided to cancel your pledge of <?php echo $email_temp['Backer_info']['Backer']['currency'] . '' . $email_temp['Backer_info']['Backer']['amount']; ?> on project <a href="<?php echo $email_temp['Project_info']['link']; ?>"><?php echo $email_temp['Project_info']['title']; ?></a>.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Your pledge has been cancelled and no money will be taken from your account.  
                        </td>
                    </tr>
                    <tr>
                        <td>
						Cancelling often impacts motivation of project creators, that's why we do not recommend it.
   </td>
                    </tr>
                    <tr>
                        <td>
						 We hope you will believe in other projects. See you soon on Boostbloom!
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