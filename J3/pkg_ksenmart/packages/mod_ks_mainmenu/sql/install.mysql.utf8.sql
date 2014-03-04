UPDATE 
	`#__modules` 
SET 
	`title` = 'Категории KsenMart', 
	`position` = 'km-list-left', 
	`published` = '1'
WHERE 
	`module` = 'mod_ks_mainmenu'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `hm31q_modules` WHERE `module` = 'mod_ks_mainmenu'), 
	'0'
);