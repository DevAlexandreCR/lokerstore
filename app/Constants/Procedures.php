<?php


namespace App\Constants;


class Procedures
{
    public const ORDER_PROCEDURE = <<<'EOT'
CREATE PROCEDURE `orders_metrics_generate` (p_from date, p_until date, p_type varchar(255), p_field varchar(255))
BEGIN
    START TRANSACTION;
    DELETE FROM `metrics` WHERE `metric` = p_type COLLATE utf8_unicode_ci;
    INSERT INTO `metrics` (`date`, `measurable_id`, `status`, `total`, `metric`, `amount`)
        SELECT DATE(`created_at`) AS date,
        CASE
        	WHEN p_field = 'none' THEN NULL
        	WHEN p_field = 'admin_id' THEN admin_id
    	END
    	as measurable_id,
        `status`,
        COUNT(*) as total,
        p_type as metric,
        SUM(`amount`) as amount
        FROM orders
    WHERE `created_at` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY)
    GROUP BY `date`, `measurable_id`, `status`, `metric`;
    COMMIT;
END
EOT;

    public const CATEGORIES_PROCEDURE = <<<'EOT'
CREATE PROCEDURE categories_metrics_generate(p_from date, p_until date)
BEGIN
    START TRANSACTION;
    DELETE FROM `metrics` WHERE `metric` = "categories" COLLATE utf8_unicode_ci;
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
    GROUP BY `date`, `measurable_id`, `status`, `metric`;
    COMMIT;
END
EOT;
}
