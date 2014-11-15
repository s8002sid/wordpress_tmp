echo 'creating database backup...'
mysqldump -u root -p wordpress > wordpress_bak.sql

echo 'copying wordpress mysql file...'
cp -r /var/lib/mysql/wordpress .

echo 'creating tar and removing tmp folder...'
tar -zcvf wordpress_sqldb.tgz ./wordpress
rm -rf ./wordpress
