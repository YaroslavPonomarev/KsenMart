<?php defined('_JEXEC') or die; ?>
<div class="mod_ksm_filter well noTransition <?php echo $class_sfx; ?>">
	<?php if($module->showtitle){ ?>
	<h3><?php echo $module->title; ?></h3>
	<?php } ?>
	<form action="<?php echo $form_action; ?>" method="get">
		<div class="prices">
			<fieldset>
				<div class="inputs">
					<span><?php echo JText::_('MOD_KM_FILTER_PRICE')?></span>
					<span><?php echo JText::_('MOD_KM_FILTER_PRICE_LESS')?></span><?php echo KSMPrice::showPriceWithoutTransform('<input type="text" name="price_less" value="'. (int)$price_less .'" />')?>
					<span><?php echo JText::_('MOD_KM_FILTER_PRICE_MORE')?></span><?php echo KSMPrice::showPriceWithoutTransform('<input type="text" name="price_more" value="'. (int)$price_more .'" />')?>
				</div>
				<div class="tracker"></div>				
			</fieldset>
		</div>	
		<?php if (count($manufacturers) > 0){ ?>
		<div class="manufacturers">
			<ul class="nav nav-list">
				<li class="nav-header"><?php echo JText::_('MOD_KM_FILTER_MANUFACTURERS'); ?></li>
				<?php foreach($manufacturers as $manufacturer){ ?>
				<li class="manufacturer_<?php echo $manufacturer->id; ?> manufacturer<?php echo $manufacturer->selected?' active':''; ?>">
					<a href="javascript:void(0);" title="">
						<label class="item <?php if ($manufacturer->selected) echo 'active'; ?>">
							<input type="checkbox" onclick="KMChangeFilter(this,'manufacturers');" name="manufacturers[]" value="<?php echo $manufacturer->id; ?>" <?php if ($manufacturer->selected) echo 'checked'; ?> />
							<?php echo $manufacturer->title; ?>
						</label>
					</a>
				</li>
				<?php } ?>	
			</ul>
		</div>
		<?php } ?>		
		<div class="properties">
		<?php foreach($properties as $property){ ?>
		<?php if(!empty($property->values)){ ?>
		<div class="property_<?php echo $property->id?> property">
			<ul class="nav nav-list clearfix">
				<li class="nav-header clearfix"><?php echo $property->title; ?></li>
				<?php foreach($property->values as $value){ ?>
				<li class="property_value_<?php echo $value->id; ?> property_value<?php echo $value->selected?' active':''; ?><?php echo !empty($value->image)?' item_img':''; ?>">
					<a href="javascript:void(0);" title="<?php echo $value->title; ?>">
					<?php if($value->image!=''){ ?>					
					<label class="item image_item <?php if ($value->selected) echo 'active';?>">
						<input onclick="KMChangeFilter(this,'property_<?php echo $property->id; ?>');" type="checkbox" name="properties[]" value="<?php echo $value->id; ?>" <?php if ($value->selected) echo 'checked'; ?> />
						<div><img src="<?php echo JURI::root().$value->image; ?>" alt="<?php echo $value->title; ?>" /></div>
						<span class="delta">&#x25C6;</span>
					</label>
					<?php }else{ ?>
					<label class="item <?php if ($value->selected) echo 'active'; ?>">
						<input onclick="KMChangeFilter(this,'property_<?php echo $property->id; ?>');" type="checkbox" name="properties[]" value="<?php echo $value->id; ?>" <?php if ($value->selected) echo 'checked'; ?> />
						<span><?php echo $value->title; ?></span>
					</label>						
					<?php } ?>
					</a>
				</li>
				<?php } ?>	
			</ul>
		</div>		
		<?php } ?>
		<?php } ?>	
		</div>
		<?php if(count($countries) > 0){ ?>
		<div class="countries" >
			<ul class="nav nav-list">
				<li class="nav-header"><?php echo JText::_('MOD_KM_FILTER_COUNTRIES'); ?></li>
				<?php foreach($countries as $country) { ?>
				<li class="country_<?php echo $country->id; ?> country<?php echo $country->selected?' active':''; ?>">
					<a href="javascript:void(0);" title="<?php echo $country->title; ?>">
						<label class="item">
							<input type="checkbox" onclick="KMChangeFilter(this,'countries');" name="countries[]" value="<?php echo $country->id; ?>" <?php if ($country->selected) echo 'checked'; ?> />
							<?php echo $country->title; ?>
						</label>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php } ?>		
		<?php foreach($categories as $category){ ?>
		<input type="hidden" name="categories[]" value="<?php echo $category;?>" />
		<?php } ?>	
		<input type="hidden" name="order_type" value="<?php echo $order_type;?>" />
		<input type="hidden" name="order_dir" value="<?php echo $order_dir;?>" />
	</form>
</div>
<script>
	var clicked='<?php echo JRequest::getVar('clicked',''); ?>';
	var view='<?php echo JRequest::getVar('view',''); ?>';
	var price_min=<?php echo (int)$price_min; ?>;
	var price_max=<?php echo (int)$price_max; ?>;	
	var price_less=<?php echo (int)$price_less; ?>;
	var price_more=<?php echo (int)$price_more; ?>;	
</script>