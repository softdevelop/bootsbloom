<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


    <table cellspacing="0">
        <tr>
            <td style="padding:10px 0 10px 5px;background-color: #000;">
                <a href="<?php echo WEBSITE_FRONT_URL; ?>">
                    <img alt="" src="<?php echo WEBSITE_IMG_URL; ?>front/logo.png">
                </a>
            </td>
        </tr>
        <tr >
            <td>
                <table style="width:550px;  -moz-border-radius:5px;  border:1px solid #D7D7D7;">
                    <tr style="padding-top:10px;">
                        <td>Hello <?php echo $user_name; ?>,</td>
                    </tr>
                    <tr style="paddding-top:10px; padding-bottom:10px; word-wrap:break-word;">
                        <td>
                            Welcome to Boostbloom! It's a pleasure to have you on board.
                        </td>
                    </tr>
                    <tr style="paddding-top:10px; padding-bottom:10px; word-wrap:break-word;">
                        <td>
                            You are now part of the family! Use your email <?php echo $user_email; ?> to log in. And don't forget to join our newsletter to get weekly updates and insights regarding projects in Armenia.
                        </td>
                    </tr>
                    <?php if(isset($is_facebook_user) && $is_facebook_user==1){ // send password to facebook user only  ?>
                    <tr  style="paddding-top:10px; padding-bottom:5px; word-wrap:break-word;">
                        <td >
                            <strong>Please use this password <?php echo $password; ?> to login on <?php echo Configure::read('CONFIG_SITE_TITLE'); ?> </strong> 
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td >
                            <ul>
                              <li>Visit <a href="<?php echo WEBSITE_URL; ?>/help/help-detail/faq/boostbloom-basics?ref=email">our FAQ </a> to quickly find an answer to any questions </li>
                                <li>Discover great projects <a href="<?php echo WEBSITE_URL; ?>/projects/discover?ref=email"> right here </a> 	
                            </ul>
                        </td>
                    </tr>
                    <tr >
                        <td>
                            Thank you for using Boostbloom! 
                        </td>
                    </tr>

                </table>   
            </td>
        </tr>
        <tr>
            <td>
                <p align=center style='text-align:center'><span
                        style='font-size:9.5pt;font-family:"MyriadProRegular";color:#666666'>Copyrights
                        2014 <?php echo Configure::read('CONFIG_SITE_TITLE'); ?>.com All Rights Reserved.<o:p></o:p></span></p>
            </td>
        </tr>
    </table>
</html>