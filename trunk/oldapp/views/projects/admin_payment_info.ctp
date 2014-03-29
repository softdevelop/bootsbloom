<script type="text/javascript">
    $(function(){
        $('#ProjectTransactionAdminCommissionPercent').keyup(function(){
            calculate_amount();
        });
        $('#ProjectTransactionPaypalCommission').keyup(function(){
            calculate_amount();
        });
        $("#is_paid").click(function(){
            if(($("#is_paid").attr('checked'))){
                
                $("#payment_date").show();
            }else{
                $("#payment_date").hide();
            }
        });
        $("#ProjectTransactionPaymentDate").datetimepicker();
    });
    
    function calculate_amount(){
        var total_pledge =   '<?php echo $this->data['ProjectTransaction']['pledge_amount']; ?>';
        var admin_percent   =    $('#ProjectTransactionAdminCommissionPercent').val();
        var paypal_percent   =    $('#ProjectTransactionPaypalCommission').val();
        var admin_amount    =   (total_pledge*(admin_percent)/100);
        var paypal_amount    =   (total_pledge*(paypal_percent)/100);
        if((admin_amount+paypal_amount)>total_pledge){
            alert('Total commission amount is exceeding the total pledged amount. Please re-enter values again.');
            $('#ProjectTransactionAdminCommissionPercent').val( '<?php echo $this->data['ProjectTransaction']['admin_commission_percent']; ?>');
            $('#ProjectTransactionPaypalCommission').val( '<?php echo $this->data['ProjectTransaction']['paypal_commission']; ?>');
            $("#admin_commission_amount").html('<?php echo $this->data['ProjectTransaction']['admin_commission_amount']; ?>');
            $("#paypal_commission_amount").html('<?php echo $this->data['ProjectTransaction']['paypal_commission_amount']; ?>');
            return false;
        }else{
            var amount_to_owner =   total_pledge-(admin_amount+paypal_amount);
            $("#admin_commission_amount").html(admin_amount);
           
            $("#paypal_commission_amount").html(paypal_amount);
            $("#ProjectTransactionAdminCommissionAmount").val(admin_amount);
            $("#ProjectTransactionPaypalCommissionAmount").val(paypal_amount);
            
            $("#ProjectTransactionAmountForProjectOwner").val(amount_to_owner);
        }
    }
    
</script>
<?php //pr($this->data);
echo $this->Form->create($model, array("class" => "form-horizontal")); ?>

<div class="ochead">

    <div class="floatleft padtop_20px">Payment Information</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;">
            <?php echo $this->Html->link("Back To Projects", array("plugin" => false, "controller" => "projects", "action" => "admin_successful_projects"), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr class="odd_row">
            <td colspan="4">
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Project Name</td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $this->data['Project']['title']; ?></td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>  
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>   

        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Total Pledged Amount</td>
            <td width="1%" valign="top">:</td>
            <td valign="top"> <?php echo $this->data['ProjectTransaction']['pledge_amount']; ?></td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>	
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

        <tr class="odd_row">
            <td colspan="4">
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Admin Commission<font color='red'></font></td>
            <td width="1%" valign="top">:</td>
            <td valign="top"> 
                <?php
                if ($this->data['ProjectTransaction']['is_paid'] == 0) {
                    echo $this->Form->text('ProjectTransaction.admin_commission_percent', array('class' => 'ui-widget-content ui-corner-all numeric')) . ' %';
                } else {
                    if(empty ($this->data['ProjectTransaction']['admin_commission_percent'])){
                       echo '0%';
                    }else{
                        echo $this->data['ProjectTransaction']['admin_commission_percent'] . '%';
                    }
                    
                }
                ?>
            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>

        <tr class="even_row">
            <td colspan="4">
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Admin Commission Amount<font color='red'></font></td>
            <td width="1%" valign="top">:</td>
            <td valign="top"> 
                <?php echo $this->Form->hidden('ProjectTransaction.admin_commission_amount', array('value' => $this->data['ProjectTransaction']['admin_commission_amount'])); ?>
                <span id="admin_commission_amount"><?php echo $this->data['ProjectTransaction']['admin_commission_amount']; ?></span>

            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>

        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>   

        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Paypal Commission</td>
            <td width="1%" valign="top">:</td>
            <td valign="top">
                <?php
                if ($this->data['ProjectTransaction']['is_paid'] == 0) {
                    echo $this->Form->text('ProjectTransaction.paypal_commission', array('class' => 'ui-widget-content ui-corner-all numeric')) . ' %';
                } else {
                    if(empty ($this->data['ProjectTransaction']['paypal_commission'])){
                    echo '0%';
                    }else{
                        echo $this->data['ProjectTransaction']['paypal_commission'] . '%';
                    }
                }
                ?>
            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>	
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

        <tr class="even_row">
            <td colspan="4">
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Paypal Commission Amount <font color='red'></font></td>
            <td width="1%" valign="top">:</td>
            <td valign="top"> 
                <?php echo $this->Form->hidden('ProjectTransaction.paypal_commission_amount', array('value' => $this->data['ProjectTransaction']['paypal_commission_amount'])); ?>
                <span id="paypal_commission_amount"><?php echo $this->data['ProjectTransaction']['paypal_commission_amount']; ?></span>
            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>


        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>   

        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Amount to send to project Owner</td>
            <td width="1%" valign="top">:</td>
            <td valign="top">
                <span id="amount_to_project_owner">
                    <?php
                    echo $this->Form->text('ProjectTransaction.amount_for_project_owner', array('class' => 'ui-widget-content ui-corner-all numeric', 'readonly' => true));
                    ?>
                </span>
            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>	
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

        <tr class="even_row">
            <td colspan="4">
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Check if Payment sent to project owner<font color='red'></font></td>
            <td width="1%" valign="top">:</td>
            <td valign="top"> 
                <input type="checkbox" name="data[ProjectTransaction][is_paid]" id="is_paid" value="1" <?php if($this->data['ProjectTransaction']['is_paid']==1){echo 'checked'; } ?> />
                <span id="payment_date" style="display: none;"><?php echo $this->Form->text('ProjectTransaction.payment_date', array('class' => 'ui-widget-content ui-corner-all')); ?></span>
            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>
        <tr class="odd_row">
            <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Payment Date <font color='red'></font></td>
            <td width="1%" valign="top">:</td>
            <td valign="top"> 
                <?php if($this->data['ProjectTransaction']['is_paid']==1){echo date(Configure::read('date_format'),$this->data['ProjectTransaction']['payment_date']); } ?> 
            </td>
            <td width="30%" valign="middle">
                &nbsp;
            </td>
        </tr>
         <tr class="odd_row">
            <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="even_row">
            <td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="odd_row">
            <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                <table>
                    <tr>
                        <td>
                            <?php 
                            echo $this->Form->hidden('id',array('value'=>$project_transaction['ProjectTransaction']['id']));
                            echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                        </td>
                        <td>
                            <?php echo $html->link('Cancel', array('action' => 'successful_projects'), array('escape' => false, 'class' => 'cancel_lnk')); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php echo $form->end(); ?>