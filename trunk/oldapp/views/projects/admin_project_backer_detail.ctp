<div class="ochead" >
    <div class="floatleft" id="breadcrumb">
        <?php if (isset($project_detail['Project']['title'])) { ?>
            <?php echo ucfirst(substr($project_detail['Project']['title'], 0, 120)); ?>
        <?php } ?>
    </div>
    <div class="floatright padtop_6px">
        <div class="floatleft font11">
            <?php echo $this->Html->link("Back To Project", array('plugin' => false, 'controller' => 'projects', 'action' => 'index'), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
        <tr class="ui-widget-header ui-corner-all" style="height:30px;">
            <td width="15%">&nbsp;</td>
            <td width="30%" align="left">Funded</td>
            <td width="30%" align="left">Pledged</td>
            <td width="" align="left">Days to Go</td>
        </tr>
        <tr>
            <td width="15%"></td>
            <td width="30%" align="left"><?php $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project_detail['Project']['id'], $project_detail['Project']['funding_goal'], $project_detail['Backer']); ?>
                <?php echo $total_funded_percentage; ?> %								
            </td>
            <td width="30%" align="left">$ <?php echo $this->GeneralFunctions->get_total_pledge_amount($project_detail['Backer']); ?></td>
            <td width="" align="left"><?php echo $this->GeneralFunctions->dateDiffTs(time(), $project_detail['Project']['project_end_date']); ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>
</div>
<div class="pt15"></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all ">
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
        <tr class="ui-widget-header ui-corner-all" style="height:30px;">
            <td align="left">Backer Image</td>
            <td align="left">Backer Name</td>
            <td align="left">Amount</td>
            <td align="left">Rewards</td>
            <td align="left">Date</td>
        </tr>
        <?php
        if (count($project_backers) > 0) {
            $i = 0;
            $class = 'odd_row';
            foreach ($project_backers as $project_backer) {
                $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                ?>
                <tr class="<?php echo $class; ?>" id="row_<?php echo $project_backer['Backer']['id']; ?>">
                    <td width="14%" valign="top">
                        <?php echo $this->Html->link($this->Html->image(WEBSITE_IMG_URL . "image.php?image=" . $project_backer['User']['profile_image'] . '&height=75px&width=100px', array('escape' => false)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $project_backer['User']['slug']), array('escape' => false)); ?>
                    </td>
                    <td width="30%" valign="top">
                        <div class="pl5">
                            <?php echo $project_backer['User']['name']; ?></div>
                        <div class="pt5">
                            <?php if ($project_backer['User']['country_json'] != '') { ?>
                                <?php echo $this->Html->image('front/location-icon.png', array('alt' => '', 'width' => '17', 'height' => '15')); ?>
                                <?php
                                $country = explode("##", $project_backer['User']['country_json']);
                                $country1 = explode(":", $country[1]);
                                $country2 = explode(',', $country[1]);
                                echo str_replace('"', "", $country2[0]);
                            }
                            ?></div>

                        <div class="pt5"> </div>	

                    </td>
                    <td width="20%" valign="top">
                        <div>$ <?php echo $project_backer['Backer']['amount']; ?></div>	
                    </td>

                    <td width="20%" valign="top"><div><?php if ($project_backer ['Reward']['pledge_amount'] != '') { ?>
            						Pledge $ <?php echo $project_backer ['Reward']['pledge_amount']; ?> or more 
                            <?php } else { ?>
                                <?php echo 'No Reward';
                            } ?>

                        </div>	
                    </td>

                    <td width="20%" valign="top">
                        <div>
        <?php echo date('M, d Y', $project_backer['Backer']['created']); ?></div>
                    </td>

                </tr>
                <?php $i++;
            } ?>
            <tr>
                <td colspan="5"><div class="ochead"></div></td>
            </tr>	
            <?php
        } else {
            ?>
            <tr class="odd_row"><td colspan="5" align="center">No record  found!</td></tr>
<?php } ?>		   
    </table>
</div>

