<?php


namespace App\Constants;

class Procedures
{
    public const ORDER_PROCEDURE = <<<'EOT'
CREATE PROCEDURE `orders_metrics_generate` (p_from date, p_until date, p_type varchar(255), p_field varchar(255))
BEGIN
    START TRANSACTION;
    DELETE FROM `metrics` WHERE `metric` = p_type COLLATE utf8_unicode_ci AND `date` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY);
    INSERT INTO `metrics` (`date`, `measurable_id`, `status`, `total`, `metric`, `amount`)
        SELECT DATE(`created_at`) AS date,
        CASE
        	WHEN p_field = 'none' THEN NULL
        	WHEN p_field = 'admin_id' THEN admin_id
    	END
    	as measurable_id,
        CASE
        	WHEN `status` = 'canceled' THEN 'canceled'
        	WHEN `status` = 'rejected' THEN 'canceled'
        	WHEN `status` = 'sent' 	   THEN 'sent'
    	END
    	as status,
        COUNT(*) as total,
        p_type as metric,
        SUM(`amount`) as amount
        FROM orders
    WHERE `created_at` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY)
    AND (`status` = 'sent' OR `status` = 'canceled' OR `status` = 'rejected')
    GROUP BY `date`, `measurable_id`, `status`, `metric`;
    COMMIT;
END
EOT;

    public const CATEGORIES_PROCEDURE = <<<'EOT'
CREATE PROCEDURE categories_metrics_generate(p_from date, p_until date)
BEGIN
    START TRANSACTION;
    DELETE FROM `metrics` WHERE `metric` = "categories" COLLATE utf8_unicode_ci AND `date` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY);
    INSERT INTO `metrics` (`date`, `measurable_id`, `status`, `total`, `metric`)
        SELECT DATE(orders.created_at) AS date,
      	products.id_category as measurable_id,
        orders.status as status,
        COUNT(*) as total,
        "categories" as metric
        FROM orders
        LEFT OUTER JOIN order_details ON orders.id = order_details.order_id
        LEFT OUTER JOIN stocks ON order_details.stock_id = stocks.id
        LEFT OUTER JOIN products ON stocks.product_id = products.id
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY) AND `status` = 'sent'
    AND `status` = 'sent'
    GROUP BY `date`, `measurable_id`, `status`, `metric`;
    COMMIT;
END
EOT;

    public const GENERATE_CATEGORIES_REPORT = <<<'EOT'
CREATE PROCEDURE generate_categories_report(p_from date, p_until date)
BEGIN
    START TRANSACTION;
	SELECT DATE(orders.created_at) as date,
  		categories.name as category_name,
  		products.name as product_name,
  		SUM(order_details.quantity) as total,
  		products.price * SUM(order_details.quantity) as amount
	FROM orders
  		LEFT OUTER JOIN order_details ON order_details.order_id = orders.id
  		LEFT OUTER JOIN stocks ON order_details.stock_id = stocks.id
        LEFT OUTER JOIN products ON stocks.product_id = products.id
        LEFT OUTER JOIN categories ON products.id_category = categories.id
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY) AND `status` = 'sent'
    GROUP BY MONTH(`date`), `product_name`
    ORDER BY `date`;
END
EOT;

    public const GENERATE_GENERAL_REPORT = <<<'EOT'
CREATE PROCEDURE generate_general_report(p_from date, p_until date)
BEGIN
    START TRANSACTION;
        SELECT DATE(orders.created_at) as date,
      	tags.name as gender,
        orders.status,
        SUM(orders.amount) as amount,
        COUNT(*) as total
        FROM orders
        LEFT OUTER JOIN order_details ON orders.id = order_details.order_id
        LEFT OUTER JOIN stocks ON order_details.stock_id = stocks.id
        LEFT OUTER JOIN products ON stocks.product_id = products.id
        LEFT OUTER JOIN product_tag ON product_tag.product_id = products.id
        LEFT OUTER JOIN tags ON product_tag.tag_id = tags.id
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY) AND `status` = 'sent'
    GROUP BY MONTH(`date`), `gender`
    ORDER BY `date` ASC;
END
EOT;
}
