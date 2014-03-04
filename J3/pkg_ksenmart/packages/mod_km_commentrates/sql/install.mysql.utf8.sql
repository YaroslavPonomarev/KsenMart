UPDATE 
	`#__modules` 
SET 
	`title` = 'Рейтинги комментариев KsenMart', 
	`position` = 'km-list-left', 
	`published` = '1',
	`params` = '{"views":["users"]}'
WHERE 
	`module` = 'mod_km_commentrates'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `hm31q_modules` WHERE `module` = 'mod_km_commentrates'), 
	'0'
);