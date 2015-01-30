-- jitendra alter table tags
ALTER TABLE `tags` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT;


-- tags dummy data
INSERT INTO `tags` (`id`, `original_tag`, `type`, `comment`, `created`, `createdBy`, `modified`, `modifiedBy`, `status`) VALUES
(266, 'love', 'ghtui', 'hghgh', '2014-01-18 22:29:43', NULL, '2014-01-19 16:58:59', NULL, 1),
(262, 'vikas', 'test', 'test', '2014-01-15 22:11:04', NULL, '2014-01-16 01:57:22', NULL, 1),
(263, 'fdfdsfdsds', 'dfdfdfdfdf', 'dfdssdfsdfds', '2014-01-15 22:26:53', NULL, '2014-01-16 01:54:58', NULL, 1),
(264, 'fddfd', 'dfdfdd', 'dfdfdfdfdf', '2014-01-16 01:46:49', NULL, '2014-01-16 01:46:49', NULL, 1),
(265, 'gfhgfhf', 'cghghgf', 'dfgfdg dfgfdgf', '2014-01-18 22:07:15', NULL, '2014-01-18 22:08:29', NULL, 1),
(267, 'shubhi', 'gfhgfgh', 'ytfgfghf', '2014-01-19 18:02:27', NULL, '2014-01-19 18:03:01', NULL, 1);


-- transentries dummy data
INSERT INTO `transentries` (`id`, `tag_id`, `language`, `translation`, `created`, `createdBy`, `modified`, `modifiedBy`, `status`) VALUES
(260, 'tag1', 'en', 'tag1_translated', '2014-01-08 11:27:52', 'CBM', '2014-01-08 11:27:52', 'CBM', 1),
(267, '260', 'en', 'dfdfd', '2014-01-17 00:09:21', NULL, '2014-01-17 00:09:21', NULL, 1),
(268, '264', 'en', 'rrtrtrtr', '2014-01-17 01:03:58', NULL, '2014-01-17 01:03:58', NULL, 1),
(269, '264', 'en', 'erere', '2014-01-17 01:04:22', NULL, '2014-01-17 01:04:22', NULL, 1),
(272, '262', 'en', 'fgdfdf', '2014-01-18 21:56:04', NULL, '2014-01-18 21:56:04', NULL, 0),
(271, '263', 'en', 'dfdfdd', '2014-01-18 21:53:33', NULL, '2014-01-18 21:53:33', NULL, 1),
(273, '265', 'en', 'dgdfgfd', '2014-01-18 22:07:56', NULL, '2014-01-18 22:07:56', NULL, 1),
(274, '265', 'de', 'fdgfgf', '2014-01-18 22:08:22', NULL, '2014-01-18 22:08:22', NULL, 0),
(275, '266', 'en', 'love', '2014-01-18 22:30:49', NULL, '2014-01-18 22:30:49', NULL, 1),
(276, '266', 'fr', 'jkhjh', '2014-01-18 22:31:22', NULL, '2014-01-18 22:31:22', NULL, 1);


--21/01/2014

ALTER TABLE `transentries` ADD `comment` VARCHAR( 255 ) NULL AFTER `translation`;
