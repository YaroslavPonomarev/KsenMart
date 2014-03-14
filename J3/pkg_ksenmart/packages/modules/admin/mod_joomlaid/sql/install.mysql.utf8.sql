UPDATE 
	`#__modules` 
SET 
	`title` = 'JoomlaID', 
	`position` = 'ks-top-right', 
	`published` = '1',
	`params` = '{"views":["*"]}'
WHERE 
	`module` = 'mod_joomlaid'
;
INSERT INTO 
	`#__modules_menu` 
	(
		`moduleid`, 
		`menuid`
	) 
VALUES (
	(SELECT `id` FROM `#__modules` WHERE `module` = 'mod_joomlaid'), 
	'0'
);