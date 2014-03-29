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
                            A message was sent about Project <a href="<?php echo $emailVars['Project']['link']; ?>"><?php echo $emailVars['Project']['title']; ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong><?php echo ucfirst($emailVars['Sender']['name']); ?> </strong> said:
                        </td>

                    </tr>
                   
                    <tr>
                        <td>
                            <?php echo $emailVars['Message']['message']; ?>

                        </td>
                    </tr>
                     <tr>
                        <td>
                            <?php __('follow_link') ?>

                        </td>
                    </tr>
					<tr>
						
                        
						<td>
                           <a href="<?php echo $emailVars['Message']['reply_url'];?>" target="_blank"> <?php echo $emailVars['Message']['reply_url'];?></a>

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
