UPDATE 
	`#__modules` 
SET 
	`title` = 'Группы настроек KsenMart', 
	`position` = 'km-list-left', 
	`published` = '1',
	`params` = '{"views":["settings"]}'
WHERE 
	`module` = 'mod_ks_settings_groups'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `#__modules` WHERE `module` = 'mod_ks_settings_groups'), 
	'0'
);