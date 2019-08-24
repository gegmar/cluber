SELECT
	users.name AS "Vendor",
    price_categories.name AS "Category",
    price_categories.price AS "Price",
    COUNT(CASE purchases.state when 'paid' then 1 else null end) AS "Tickets Paid",
    COUNT(CASE purchases.state when 'reserved' then 1 else null end) AS "Tickets Reserved",
    COUNT(CASE purchases.state when 'free' then 1 else null end) AS "Tickets Free",
    COUNT(purchases.state) AS "Category Sum"
from tickets
INNER JOIN purchases ON tickets.purchase_id=purchases.id
INNER JOIN users ON purchases.vendor_id=users.id
INNER JOIN price_categories ON tickets.price_category_id=price_categories.id
WHERE tickets.event_id = 4
GROUP By users.name, price_categories.name, price_categories.price
UNION SELECT
	"" AS "Vendor",
    "" AS "Category",
    "" AS "Price",
    SUM(CASE purchases.state when 'paid' then 1 else null end) AS "Tickets Paid",
    SUM(CASE purchases.state when 'reserved' then 1 else null end) AS "Tickets Reserved",
    SUM(CASE purchases.state when 'free' then 1 else null end) AS "Tickets Free",
    COUNT(purchases.state) AS "Category Sum"
from tickets
INNER JOIN purchases ON tickets.purchase_id=purchases.id
WHERE tickets.event_id = 4