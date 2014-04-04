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
                            Hi <?php echo ucfirst($backer['User']['name']) . ','; // Project Backer,   ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Unfortunately, project “<?php echo $project['title']; ?>” has been cancelled by admin.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            We place tremendous effort to limit such actions but we can’t totally prevent them. 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Your pledge has been automatically cancelled. No money was taken from your account.
                        </td>
                    </tr>
                    <tr>
                        <td>  We hope you will find other exciting projects to support.
                        </td>
                    </tr>
                    <tr>
                        <td>  We apologize for the inconvenience.
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
