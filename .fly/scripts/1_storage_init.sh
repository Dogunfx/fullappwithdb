FOLDER=/var/www/html/storage/app
if [ ! -d "$FOLDER" ]; then
    echo "$FOLDER is not a directory, copying storage_ content to storage"
    cp -r /var/www/html/storage_/. /var/www/html/storage
    echo "deleting storage_..."
    rm -rf /var/www/html/storage_
fi

# .fly/scripts/1_storage_init.sh

# Add this below the storage folder initialization snippet
FOLDER_DB=/var/www/html/storage/database
if [ ! -d "$FOLDER_DB" ]; then
    echo "$FOLDER_DB is not a directory, initializing database" 
    mkdir /var/www/html/storage/database
    touch /var/www/html/storage/database/database.sqlite
fi
