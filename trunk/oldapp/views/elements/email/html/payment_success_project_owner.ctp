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
                            Dear <?php echo ucfirst($email_temp['project_owner_name']) . ','; // Project Owner,  ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Congratulations!
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <?php echo $email_temp['user_name']; ?> has pledged <?php echo Configure::read('CONFIG_CURRENCYSYMB') . $email_temp['amount']; ?> to your project <a href="<?php echo $email_temp['link']; ?>"><?php echo $email_temp['project_name']; ?></a> and selected the reward associated with "<?php if ($pledge_info['reward']['id'] != 0) {
                                echo 'Pledge ' . Configure::read('CONFIG_CURRENCYSYMB') . ' ' . $reward_info['Reward']['pledge_amount'] . ' or more';
                            } else {
                                echo "No Thanks";
                            } ?>"!  
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Log in to <?php echo Configure::read('CONFIG_SITE_TITLE'); ?> to post updates on your progress and to reply to questions! 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Also don’t forget to share your project around you! The more you communicate on and out Boostbloom, the more chances your project will get to be funded.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            For more tips on sharing, <a href="http://www.boostbloom.com/display/sharing">click here</a>.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Happy funding!
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
