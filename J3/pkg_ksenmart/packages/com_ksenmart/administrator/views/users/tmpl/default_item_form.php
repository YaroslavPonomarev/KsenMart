<?php
defined( '_JEXEC' ) or die;
?>
<tr class="list_item">
	<td class="name stretch"> 
		<div class="img">
			<img class="medium_img" src="<?php echo $this->item->medium_img; ?>" style="display: none;" >
			<a href="<?php echo $this->item->medium_img; ?>" class="show_product_photo">
				<img class="min_img" rel="<?php echo $this->item->id?>" src="<?php echo $this->item->small_img; ?>" title="<?php echo $this->item->name?>">
			</a>
		</div>
		<div class="descr">
			<a class="km-modal" rel='{"x":"90%","y":"90%"}' href="<?php echo JRoute::_('index.php?option=com_ksenmart&view=users&layout=user&id='.$this->item->id.'&tmpl=component'); ?>" ><?php echo $this->item->name?></a>
			<p>
				<a rel='{"x":"90%","y":"90%"}' href="<?php echo JRoute::_('index.php?option=com_ksenmart&view=users&layout=user&id='.$this->item->id.'&tmpl=component'); ?>" class="edit km-modal"><?php echo JText::_('ksm_edit')?></a>
			</p>
		</div>
	</td>
	<td class="user_login"><?php echo $this->item->username?></td>
	<td class="user_email"><?php echo $this->item->email?></td>
	<td class="user_subsriber"><input type="checkbox" value="1" <?php echo (in_array(KSUsers::getSubscribersGroupID(),$this->item->groups)?'checked':'')?>></td>
	<td class="del"><a href="#"></a></td>
	<input type="hidden" class="id" name="items[<?php echo $this->item->id; ?>][id]" value="<?php echo $this->item->id ?>">
</tr>