--
-- Table structure for table `invoice-settings`
--

CREATE TABLE `invoice-settings`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `key`            varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `template_name`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `template_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice-settings`
--

INSERT INTO `invoice-settings` (`id`, `key`, `template_name`, `template_color`, `created_at`, `updated_at`)
VALUES (1, 'defaultTemplate', 'Default', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (2, 'newYorkTemplate', 'New York', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (3, 'torontoTemplate', 'Toronto', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (4, 'rioTemplate', 'Rio', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (5, 'londonTemplate', 'London', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (6, 'istanbulTemplate', 'Istanbul', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (7, 'mumbaiTemplate', 'Mumbai', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (8, 'hongKongTemplate', 'Hong Kong', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (9, 'tokyoTemplate', 'Tokyo', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50'),
       (10, 'parisTemplate', 'Paris', '#000000', '2022-01-24 10:51:50', '2022-01-24 10:51:50');

--
-- Indexes for table `invoice-settings`
--
ALTER TABLE `invoice-settings`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice-settings`
--
ALTER TABLE `invoice-settings`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;


ALTER TABLE `clients` CHANGE `note` `note` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;


ALTER TABLE `invoices` CHANGE `note` `note` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, CHANGE `term` `term` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `payments` CHANGE `notes` `notes` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `invoices`
    ADD `template_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `term`;

ALTER TABLE `invoices`
    ADD CONSTRAINT `invoices_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `invoice-settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

UPDATE `invoices`
SET `template_id`= 1
WHERE template_id is NULL;

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`)
VALUES (NULL, 'mail_notification', '1', '2022-01-14 17:23:07', '2022-01-12 17:23:07');

ALTER TABLE `currencies`
    ADD `code` VARCHAR(255) NULL DEFAULT NULL AFTER `icon`;

UPDATE `currencies`
SET `code`='USD'
WHERE code IS NULL;

ALTER TABLE `taxes` CHANGE `value` `value` FLOAT NOT NULL;

ALTER TABLE `products` CHANGE `unit_price` `unit_price` FLOAT NOT NULL;
