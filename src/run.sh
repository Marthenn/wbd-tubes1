cmd="$@"
chown root /var/www/html/storage/
chown www-data:www-data /var/www/html/storage/
chmod 755 /var/www/html/storage/
chmod 777 /var/www/html/storage/

exec $cmd