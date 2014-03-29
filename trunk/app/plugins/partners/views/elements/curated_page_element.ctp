<?php if ($curatedpages) { ?>
<?php foreach ($curatedpages as $curated_pages) { ?>
	<div class="fl mr25 mb15">
		<div>
			<div class="sprite listingbxtl"></div>
			<div class="listingbxt"></div>
			<div class="sprite listingbxtr"></div>
			<div class="clr"></div>
		</div>
		<div class="listingbxmid height_200" >
			<div class="pb14 ">
				<?php 
			
				echo $this->Html->link($this->Html->image(WEBSITE_IMG_URL.'image.php?image='.$curated_pages['Partner']['partner_image'].'&height=150px&width=200px',array('alt'=>ucwords($curated_pages['Partner']['partner_name']),'title'=>ucwords($curated_pages['Partner']['partner_name']))),$curated_pages['Partner']['partner_site_link'],array('target'=>'_blank','escape'=>false));
				?>
			</div>
			<div class="grey13 height155 mb8 overflow"> 
				<span class="block pb17 blue13">
					<?php 
						echo $this->Html->link(ucwords($curated_pages['Partner']['partner_name']),$curated_pages['Partner']['partner_site_link'],array('escape'=>false,'target'=>'_blank'));
					?>
				 </span>
				
			</div>
			<div class="clr"></div>
		</div>
		<div>
			<div class="sprite listingbxbl"></div>
			<div class="listingbxb"></div>
			<div class="sprite listingbxbr"></div>
			<div class="clr"></div>
		</div>
	</div>
        <?php
    }
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => 'partners', 'controller' => 'partners', 'action' => $load_more_action, 'page:' . $page));
        } else {
            echo "=================";
        }
    }
}?>
