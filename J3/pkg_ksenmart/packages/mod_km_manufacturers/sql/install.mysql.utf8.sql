UPDATE 
	`#__modules` 
SET 
	`title` = 'Производители KsenMart', 
	`position` = 'km-list-left', 
	`published` = '1',
	`params` = '{"views":["catalog"]}'
WHERE 
	`module` = 'mod_km_manufacturers'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `hm31q_modules` WHERE `module` = 'mod_km_manufacturers'), 
	'0'
);