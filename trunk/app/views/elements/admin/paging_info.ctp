<?php
$default = Configure::read('defaultPaginationLimit');
if (!isset($limitValue)) {
    $limitValue = Configure::read('defaultPaginationLimit');
}
$pagingViews = Configure::read('pagingViews');
?>
<div >
    <form method="post" >
        <div>
            <div  class="pagging float_left"  ><b>
                    <?php echo $paginator->counter(array('format' => 'Page %page% of&nbsp;&nbsp;%pages%, Total records %count% | ')); ?>
	 Views &nbsp;&nbsp;</b>

            </div >
            <div class="float_right" style="padding-top:10px;" > 
                <select  onchange="this.form.submit();" style="width:90px;" class="span2 ui_dropdown" name="data[recordsPerPage]">
                    <option value="<?php echo $default; ?>">Default</option>
                    <?php foreach ($pagingViews as $views) { ?>
                        <option <?php if ($limitValue == $views) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo $views; ?>"><?php echo $views; ?></option>
<?php } ?>
                </select>
            </div>
        </div>


    </form>
</div>
