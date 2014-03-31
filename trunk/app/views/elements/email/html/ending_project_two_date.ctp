<?php
$total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($ending_soon_project['Project']['id'], $ending_soon_project['Project']['funding_goal'], $ending_soon_project['Backer']);
if ($total_funded_percentage > 100) {
    $total_funded_slider_percentage = 100;
} else {
    $total_funded_slider_percentage = $total_funded_percentage;
}
?>

<table width="100%" >
    <tr>
        <td colspan="2">
            This is just a reminder that <strong><?php echo $ending_soon_project['Project']['title']; ?></strong> ends in just 48 hours.
        </td>
    </tr>
    <tr><td>
            <table width="100%"  style="background-color: #E9E9E9">

                <tr>
                    <td>
                        <table >
                            <tr>
                                <td>
                                    <?php $project_image_url = $this->GeneralFunctions->show_project_image($ending_soon_project['Project']['image'], "210px", "280px"); ?>
                                    <img width="280" height="210" alt="" src="<?php echo $project_image_url; ?>"> 
                                </td>
                                <td valign="top">
                                    <table >
                                        <tr>
                                            <td valign="top">
                                                <a style="color:#55A4F2;text-decoration:none; font-weight: bold" href="<?php echo $email_temp['project_link']; ?>">
                                                    <?php echo $ending_soon_project['Project']['title']; ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <span style="color:#6c6c6c;font-size:11px;">By&nbsp;<a style="color:#595858;font-size:11px;text-decoration:underline;" target="_blank" href="<?php echo $email_temp['user_link']; ?>"><?php echo $ending_soon_project['User']['name']; ?></a></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <div style="float:left;font:15px;color:#595858;line-height:20px;padding-top:15px;height:85px;"><?php echo $ending_soon_project['Project']['short_description']; ?></div>
                                            </td>
                                        </tr>

                                    </table>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td width="30%">
                                    <div style="float:left;font:15px;color:#595858;line-height:20px;padding-top:15px;height:85px;"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $this->GeneralFunctions->get_total_pledge_amount($ending_soon_project['Backer']); ?> <br /> Pledged</div>
                                </td>

                                <td width="30%">
                                    <div style="float:left;font:15px;color:#595858;line-height:20px;padding-top:15px;height:85px;"><?php echo count($ending_soon_project['Backer']); ?> <br /> Backer(s)</div>
                                </td>
                                <td width="30%">
                                    <div style="float:left;font:15px;color:#595858;line-height:20px;padding-top:15px;height:85px;"> <?php $time_rem = $this->GeneralFunctions->show_left_time(time(), $ending_soon_project['Project']['project_end_date']);
                                                    echo $time_rem['time'] . '<br /> ' . sprintf(__('frnt_daystogo', true), $time_rem['unit']); ?></div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>


            </table>
        </td>
    </tr>
    <tr>
        <td>
            Now's your chance to jump in and help <?php echo $ending_soon_project['Project']['title']; ?> come to life!
        </td>
    </tr>
</table>

