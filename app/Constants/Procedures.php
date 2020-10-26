<?php


namespace App\Constants;


class Procedures
{
    public const ORDER_PROCEDURE = <<<'EOT'
CREATE PROCEDURE `orders_metrics_generate` (p_from date, p_until date, p_type varchar(255), p_field varchar(255))
BEGIN
    START TRANSACTION;
    DELETE FROM `metrics` WHERE `metric` = p_type COLLATE utf8_unicode_ci;
    INSERT INTO `metrics` (`date`, `measurable_id`, `status`, `total`, `metric`)
        SELECT DATE(`created_at`) AS date,
        CASE
        	WHEN p_field = 'none' THEN NULL
        	WHEN p_field = 'admin_id' THEN admin_id
    	END
    	as measurable_id,
        `status`,
        COUNT(*) as total,
        p_type as metric
        FROM orders
    WHERE `created_at` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY)
    GROUP BY `date`, `measurable_id`, `status`, `metric`;
    COMMIT;
END
EOT;
}
