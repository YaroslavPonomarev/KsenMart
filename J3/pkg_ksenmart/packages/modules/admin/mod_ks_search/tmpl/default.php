<?php defined('_JEXEC') or die; ?>
<li>
	<form class="km-list-left-module km-search mod_km_search" ng-submit="search()">
		<input type="text" class="inputbox" id="searchword" ng-model="filterByTitle" ng-change="search()" name="searchword" value="<?php echo $searchword; ?>"/>
		<input type="submit" class="button" id="searchbutton" value="" />
	</form>
</li>