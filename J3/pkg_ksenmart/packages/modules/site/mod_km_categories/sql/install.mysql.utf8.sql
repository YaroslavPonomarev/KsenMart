UPDATE 
	`#__modules` 
SET 
	`title` = 'Категории KsenMart', 
	`position` = 'left', 
	`published` = '1'
WHERE 
	`module` = 'mod_km_categories'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `#__modules` WHERE `module` = 'mod_km_categories'), 
	'0'
);