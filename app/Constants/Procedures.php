<?php

namespace App\Constants;

class Procedures
{
    public const ORDER_PROCEDURE = <<<'EOT'
CREATE PROCEDURE orders_metrics_generate(p_from date, p_until date, p_type varchar(255), p_field varchar(255))
BEGIN
    START TRANSACTION;
    DELETE FROM metrics WHERE metric = p_type COLLATE utf8_unicode_ci
    AND date BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY);
    INSERT INTO metrics (date, measurable_id, status, total, metric, amount)
        SELECT DATE(created_at) AS date,
        CASE
        	WHEN p_field = "none" THEN NULL
        	WHEN p_field = "admin_id" THEN admin_id
    	END
    	as measurable_id,
        CASE
        	WHEN status = "canceled" THEN "canceled"
        	WHEN status = "rejected" THEN "canceled"
        	WHEN status = "completed" THEN "completed"
    	END
    	as status,
        COUNT(*) as total,
        p_type as metric,
        SUM(amount) as amount
        FROM orders
    WHERE created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY)
    AND
		CASE
			WHEN p_type = "admins" THEN status = "completed"
			ELSE (status = "completed" OR status = "canceled" OR status = "rejected")
		END
    GROUP BY date, measurable_id, status, metric;
    COMMIT;
END
EOT;

    public const CATEGORIES_PROCEDURE = <<<'EOT'
CREATE PROCEDURE categories_metrics_generate(p_from date, p_until date)
BEGIN
    START TRANSACTION;
    DELETE FROM metrics WHERE metric = "categories" COLLATE utf8_unicode_ci
    AND date BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY);
    INSERT INTO metrics (date, measurable_id, status, total, metric)
        SELECT DATE(orders.created_at) AS date,
      	products.id_category as measurable_id,
        orders.status as status,
        COUNT(*) as total,
        "categories" as metric
        FROM orders
        LEFT OUTER JOIN order_details ON orders.id = order_details.order_id
        LEFT OUTER JOIN stocks ON order_details.stock_id = stocks.id
        LEFT OUTER JOIN products ON stocks.product_id = products.id
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY)
    AND status = "completed"
    GROUP BY date, measurable_id, status, metric;
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
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY) AND status = "completed"
    GROUP BY MONTH(date), product_name
    ORDER BY date;
END
EOT;

    public const GENERATE_GENERAL_REPORT = <<<'EOT'
CREATE PROCEDURE generate_general_report(p_from date, p_until date)
BEGIN
    START TRANSACTION;
        SELECT DATE(orders.created_at) as date,
      	tags.name as gender,
        status,
        SUM(order_details.total_price) as amount,
        SUM(order_details.quantity) as total_products_sold
        FROM orders
        LEFT OUTER JOIN order_details ON orders.id = order_details.order_id
        LEFT OUTER JOIN stocks ON order_details.stock_id = stocks.id
        LEFT OUTER JOIN products ON stocks.product_id = products.id
        LEFT OUTER JOIN product_tag ON product_tag.product_id = products.id
        LEFT OUTER JOIN tags ON product_tag.tag_id = tags.id
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY) AND status = "completed"
    GROUP BY MONTH(date), gender
    ORDER BY date ASC;
END
EOT;

    public const GENERATE_GENERAL_REPORT_UNCOMPLETED = <<<'EOT'
CREATE PROCEDURE generate_general_report_uncompleted(p_from date, p_until date)
BEGIN
    START TRANSACTION;
        SELECT DATE(orders.created_at) as date,
        status,
        SUM(orders.amount) as amount,
        COUNT(*) as orders_total
        FROM orders
    WHERE orders.created_at BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY) AND status != "completed"
    GROUP BY MONTH(date), status
    ORDER BY date ASC;
END
EOT;

    public const GENERATE_MONTHLY_REPORT = <<<'EOT'
CREATE PROCEDURE generate_monthly_report(p_year_month date, p_status varchar(20))
BEGIN
	START TRANSACTION;
	SELECT DATE(orders.created_at) as date,
		DAYNAME(orders.created_at) as day_sale,
		orders.id as num_order,
		orders.status as status,
		admins.name as seller,
		payers.name as payer,
		payers.email as email_payer,
		payers.phone as phone_payer,
  		categories.name as category_name,
  		products.reference as reference,
  		products.name as product_name,
  		products.cost as cost,
  		products.price as price,
  		order_details.quantity as quantity,
  		products.price * order_details.quantity as price_sale,
  		orders.amount as paid,
  		payments.method as method
	FROM orders
	    LEFT OUTER JOIN payments ON payments.order_id = orders.id
	    LEFT OUTER JOIN payers ON payments.order_id = payers.id
  		LEFT OUTER JOIN order_details ON order_details.order_id = orders.id
  		LEFT OUTER JOIN admins ON orders.admin_id = admins.id
  		LEFT OUTER JOIN stocks ON order_details.stock_id = stocks.id
        LEFT OUTER JOIN products ON stocks.product_id = products.id
        LEFT OUTER JOIN categories ON products.id_category = categories.id
		WHERE YEAR(orders.created_at) = YEAR(p_year_month) AND MONTH(orders.created_at) = MONTH(p_year_month)
		AND
		CASE
			WHEN p_status = "" THEN orders.status != "completed"
			ELSE orders.status = p_status COLLATE utf8_unicode_ci
		END
    ORDER BY date;
END
EOT;

    public const STOCK_REPORT = <<<'EOT'
CREATE PROCEDURE stock_report()
BEGIN
    START TRANSACTION;
        SELECT
        categories.name,
        SUM(products.cost * stocks.quantity) as cost,
        SUM(products.price * stocks.quantity) as amount,
        SUM(products.price * stocks.quantity) - SUM(products.cost * stocks.quantity) as  dif,
        SUM(stocks.quantity) as quantity
        FROM stocks
        LEFT OUTER JOIN products ON stocks.product_id = products.id
        LEFT OUTER JOIN categories ON products.id_category = categories.id
    GROUP BY categories.name;
END
EOT;
}
