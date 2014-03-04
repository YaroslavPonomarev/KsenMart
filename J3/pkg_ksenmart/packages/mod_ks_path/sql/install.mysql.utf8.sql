UPDATE 
	`#__modules` 
SET 
	`title` = 'Хлебные крошки Ksenmart', 
	`position` = 'km-top-left', 
	`published` = '1',
	`params` = '{"views":["*"]}'
WHERE 
	`module` = 'mod_ks_path'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `hm31q_modules` WHERE `module` = 'mod_ks_path'), 
	'0'
);