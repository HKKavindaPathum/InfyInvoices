ALTER TABLE `invoices` CHANGE `amount` `amount` DOUBLE(15,2) NULL DEFAULT NULL, CHANGE `final_amount` `final_amount` DOUBLE(15,2) NULL DEFAULT NULL;

ALTER TABLE `invoice_items` CHANGE `price` `price` DOUBLE(15,2) NOT NULL, CHANGE `total` `total` DOUBLE(15,2) NOT NULL;
