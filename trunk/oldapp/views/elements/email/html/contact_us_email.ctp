<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Contact Us</title>
</head>

<body>
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
                <table border="0" class="content">
                    <tr>
                        <td align="left" colspan="3">Dear admin,</td>
                    </tr>
                    <tr>					
                        <td colspan="3" align="left" class="pl70">You received a new inquiry from <?php echo $this->data['Page']['name'] ?>.</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="pl70">
						Details are given below.</td>
                    </tr>
                    <tr>
                        <td style="width:45%" align="right">Question :</td>
                        <td width="5%"></td>
                        <td  align="left"><?php echo $this->data['Page']['question'] ?></td>
                    </tr>
                    <tr>
                        <td style="width:45%" align="right" valign="top">Question details :</td>
                        <td width="5%"></td>
                        <td align="left"><?php echo $this->data['Page']['details'] ?></td>
                    </tr>
                    <tr>
                        <td style="width:45%" align="right">Name :</td>
                        <td width="5%"></td>
                        <td align="left"><?php echo $this->data['Page']['name'] ?></td>
                    </tr>
                    <tr>
                        <td style="width:45%" align="right">Your email address :</td>
                        <td width="5%"></td>
                        <td align="left"><?php echo $this->data['Page']['email'] ?></td>
                    </tr>
                    <tr>
                        <td style="width:45%" align="right">Link to your project or profile :</td>
                        <td width="5%"></td>
                        <td align="left"><?php echo $this->data['Page']['profile_lnk'] ?></td>
                    </tr>
                    <tr>
                        <td style="width:45%" align="right">My question is about :</td>
                        <td width="5%"></td>
                        <td align="left"><?php echo $this->data['Page']['question_about'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:9.5pt;font-family:"MyriadProRegular";color:#666666'>Copyrights 2014 <?php echo Configure::read('CONFIG_SITE_TITLE'); ?>.com All Rights Reserved.<o:p></o:p></span></p>
            </td>
        </tr>
    </table>
</body>
</html>