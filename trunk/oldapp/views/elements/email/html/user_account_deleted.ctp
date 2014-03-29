<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Payment Success</title>       
    </head>

    <table cellspacing="5" cellpadding="2">
        <tr>
            <td style="padding:10px 0 10px 5px;background-color: #000;">
                <a href="<?php echo WEBSITE_FRONT_URL; ?>">
                    <img alt="" src="<?php echo WEBSITE_IMG_URL; ?>front/logo.png">
                </a>
            </td>
        </tr>

        <tr>
            <td>
                <table class="content" >
                    <tr>
                        <td>
                            Hi <?php echo ucfirst($user_info['name']) . ','; // Project Owner,   ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            You have just deleted your <?php echo Configure::read('CONFIG_SITE_TITLE');?> account. 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Please be aware that unless you have cancelled your pledges, you remain responsible for fulfilling them.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            If you decide to join us again, just contact <?php echo Configure::read('CONFIG_SITE_TITLE');?>.
                        </td>
                    </tr>
                    <tr>
                        <td> 
                             You will be able to use the site like you used to.
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            We hope you come back soon.
                        </td>
                    </tr>
                    <tr>
                        <td>The <?php echo Configure::read('CONFIG_SITE_TITLE'); ?> team.</td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td>
                <p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:9.5pt;font-family:"MyriadProRegular";color:#666666'>Copyrights
                        <?php echo date('Y'); ?> <?php echo Configure::read('CONFIG_SITE_TITLE'); ?>.com All Rights Reserved.<o:p></o:p></span></p>
            </td>
        </tr>

    </table>
</html>
