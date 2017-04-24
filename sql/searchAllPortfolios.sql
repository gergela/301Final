SELECT *
FROM portfolio
JOIN users on users.user_id = portfolio.user_id
WHERE portfolio_name LIKE :term;