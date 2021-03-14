#!/bin/bash

# credentials from local .env file

# Database
# - DB_USER
# - DB_PASSWORD
# - DB_HOST
# - DB_NAME

# FTP
# - FTP_USER
# - FTP_PASSWORD
# - FTP_HOST
# - FTP_PORT

REMOTE_DIR="/backups/db/"
ENV_FILE="../../.env.local"

#Transfer type
#1=FTP
#2=SFTP
TYPE=1

# shellcheck disable=SC2046
export $(egrep -v '^#' $ENV_FILE | xargs)

backup_path="$(cd "$(dirname "${BASH_SOURCE[0]}")" &>/dev/null && pwd)"

create_backup() {
  umask 177

  FILE="$DB_NAME-$d.sql.gz"
  mysqldump --single-transaction --user=$DB_USER --password=$DB_PASSWORD --host=$DB_HOST $DB_NAME | gzip --best >$FILE

  echo "Backup Complete: ${backup_path}/${FILE}"
}

clean_backup() {
  rm -f $backup_path/$FILE
  echo "Local Backup Removed: ${backup_path}/${FILE}"
}

##############################
# Don't Edit Below This Line #
##############################

d=$(date --iso)
# shellcheck disable=SC2164
cd $backup_path
create_backup

if [ $TYPE -eq 1 ]; then
  ftp -n -i $FTP_HOST <<EOF
user $FTP_USER $FTP_PASSWORD
binary
cd $REMOTE_DIR
mput $FILE
quit
EOF
elif [ $TYPE -eq 2 ]; then
  rsync --rsh="sshpass -p $FTP_PASSWORD ssh -p $FTP_PORT -o StrictHostKeyChecking=no -l $FTP_USER" $backup_path/$FILE $FTP_HOST:$REMOTE_DIR
else
  echo 'Please select a valid type'
fi

echo 'Remote Backup Complete'
clean_backup
#END
