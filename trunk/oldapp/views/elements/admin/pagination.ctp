<?php
$this->Paginator->options(array('url' => $this->passedArgs));
$options = array('class' => 'p_numbers', 'separator' => '');
?>
<script>
    $(function() {	
        $( "#p_first" ).button({
            text: false,
            icons: {
                primary: "ui-icon-seek-start"
            }
        }).click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        });		
        $( "#p_prev, .prev_disabled" ).button({
            text: false,
            icons: {
                primary: "ui-icon-seek-prev"
            }
        }).click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        });		
        $( "#p_next, .next_disabled" ).button({
            text: false,
            icons: {
                primary: "ui-icon-seek-next"
            }
        }).click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        });		
        $( "#p_last" ).button({
            text: false,
            icons: {
                primary: "ui-icon-seek-end"
            }
        }).click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        });		
        $(".p_numbers").button().click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        });	
        $("span.current").button().click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        });
        $("span.current").addClass("ui-state-active").click(function(){
            if(typeof(this.href) !='undefined'){
                return loadContent(this.href);
            }
        }); 
    });		
</script>
<style>
    #toolbar {
        padding: 10px 4px;
    }
</style> 
<?php
$pages = $paginator->counter(array('format' => '%pages%'));
if ($pages > 1) {
    ?>
    <div class="demo" id="paginator_div">
        <span class="ui-widget-header ui-corner-all" id="toolbar">
            <?php echo $paginator->first(__('First Page', true), array('id' => 'p_first'), null, array('class' => 'disabled')); ?>
            <?php echo $paginator->prev(__('Previous Page', true), array('id' => 'p_prev'), null, array('class' => 'prev_disabled')); ?>
            <?php echo $paginator->numbers($options); ?>
            <?php echo $paginator->next(__('Next Page', true), array('id' => 'p_next'), null, array('class' => 'next_disabled')); ?> 
            <?php echo $paginator->last(__('Last Page', true), array('id' => 'p_last'), null, array('class' => 'disabled')); ?>
        </span>	
    </div>
    <?php
}
?>