set APPLICATION_ENV=test&& php doctrine.php build-all-reload --no-confirmation
mysqldump auctions_test -uroot --compact --no-create-db --no-create-info > ../application/data/doctrine/sql/fixtures.sql
set APPLICATION_ENV=