UPDATE 
	`#__modules` 
SET 
	`title` = 'Категории KsenMart', 
	`position` = 'km-list-left', 
	`published` = '1',
	`params` = '{"views":["catalog"]}'
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
	(SELECT `id` FROM `hm31q_modules` WHERE `module` = 'mod_km_categories'), 
	'0'
);