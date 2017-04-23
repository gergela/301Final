SELECT *
FROM Customers
WHERE
	username = :username AND
	password = :password