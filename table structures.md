CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `purchase_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `gst_no` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `cash` double(20,2) NOT NULL,
  `ref_num` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ifsc` varchar(255) NOT NULL,
  `total` double(20,2) NOT NULL,
  `delete_status` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `purchase_sublist` (
  `sub_id` int(11) NOT NULL,
  `purchase_no` varchar(255) NOT NULL,
  `entry_date` date NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` double(20,2) NOT NULL,
  `rate` double(20,2) NOT NULL,
  `tax` double(20,2) NOT NULL,
  `discount` double(20,2) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `delete_status` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `purchase_sublist`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT;
