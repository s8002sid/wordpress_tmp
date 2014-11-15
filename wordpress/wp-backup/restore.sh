mysql -u root -p wordpress < wordpress_bak.sql
tar -zxvf wordpress_sqldb.tgz
cp -r ./wordpress /var/lib/mysql/wordpress
rm -rf ./wordpress
