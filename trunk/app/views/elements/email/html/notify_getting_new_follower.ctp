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
                            Hi <?php echo $etemplate['to_user_info']['name'];?>,
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong><?php echo $etemplate['from_user_info']['name'];?></strong> started following you. <a href='<?php echo $etemplate['to_user_info']['friend_link'];?>'>Click Here</a> to find more friends
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
