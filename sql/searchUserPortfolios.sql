SELECT *
FROM portfolio
WHERE portfolio_name LIKE :term AND user_id = :user_id;