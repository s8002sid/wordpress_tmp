tar -zxf wordpress_sqldb.tgz
cp -r ./wordpress /var/lib/mysql
rm -rf ./wordpress
mysql -u root -p wordpress < wordpress_bak.sql
