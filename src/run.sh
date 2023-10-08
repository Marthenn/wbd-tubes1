cmd="$@"
chown root /var/www/html/storage/
chown www-data:www-data /var/www/html/storage/
chmod 755 -R /var/www/html/storage/
chmod 777 -R /var/www/html/storage/
echo "permission success"
exec $cmd