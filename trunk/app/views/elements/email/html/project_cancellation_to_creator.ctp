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
                            Hi <?php echo ucfirst($project['User']['name']) . ','; // Project Owner,   ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
							We have cancelled your project “<?php echo $project['Project']['title']; ?>”. All pledges made on it have been cancelled. 
                        </td>
                    </tr>
                    <tr>
                        <td>
							Canceling is not recommended because it is a disappointment for backers who believed in you. <br/>
							We hope you will post another project on Boostbloom. But first, please visit the Help sections of the website where you will find useful advice for your next venture.
                        </td>
                    </tr>
                    <tr>
                        <td>  Good luck, 
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
