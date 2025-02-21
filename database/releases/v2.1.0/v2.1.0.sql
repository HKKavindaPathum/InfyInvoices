--
-- Table structure for table `invoice_item_taxes`
--

CREATE TABLE `invoice_item_taxes`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `invoice_item_id` bigint(20) UNSIGNED NOT NULL,
    `tax_id`          bigint(20) UNSIGNED NOT NULL,
    `tax`             double(8, 2
) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `invoice_item_taxes`
--
ALTER TABLE `invoice_item_taxes`
    ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_item_taxes_invoice_item_id_foreign` (`invoice_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice_item_taxes`
--
ALTER TABLE `invoice_item_taxes`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_item_taxes`
--
ALTER TABLE `invoice_item_taxes`
    ADD CONSTRAINT `invoice_item_taxes_invoice_item_id_foreign` FOREIGN KEY (`invoice_item_id`) REFERENCES `invoice_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;



ALTER TABLE `invoice_items`
DROP
`tax_id`,
DROP
`tax`;


ALTER TABLE `clients` CHANGE `address` `address` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `products` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
