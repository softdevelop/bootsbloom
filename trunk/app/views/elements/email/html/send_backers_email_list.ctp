<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Project Approved</title>

    </head>

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
                <table class="content">
                    <tr class="pt10">
                        <td>Dear <?php echo ucfirst($project_info['User']['name']); ?>,</td>
                    </tr>
                    <tr class="word-wrap pt10 pb10">
                        <td>
                           Here are the emails of your backers. It is essential to communicate with them immediately and regularly about rewards. Do not make them wait! They are probably very exciting to get the rewards they have pledged for. 
                        </td>
                    </tr>
                    <tr class="word-wrap pt10 pb10">
                        <td>
                            <table>
                                <?php foreach ($backer_list as $backer){ ?>
                                <tr>
                                    <td>
                                        <?php echo $backer['name']; ?>:
                                    </td>
                                    <td>
                                        <?php echo $backer['email']; ?>
                                    </td>
                                </tr>
                                
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                 
                    <tr class="word-wrap pt10 pb10">
                        <td>
                          Happy rewarding! And congratulations!
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