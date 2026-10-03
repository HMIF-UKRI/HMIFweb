#!/usr/bin/env bash
# Bangun ulang database HMIF dari migration Laravel, lalu salin datanya.
# Database lama TIDAK diubah sama sekali. Jalankan sebagai root dari folder project.
set -uo pipefail

APP_DIR="${APP_DIR:-/var/www/hmif}"
cd "$APP_DIR" || { echo "Folder $APP_DIR tidak ada"; exit 1; }

envval() { grep -E "^$1=" .env | tail -n1 | cut -d= -f2- | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//"; }
OLD="$(envval DB_DATABASE)"
NEW="${NEW_DB:-${OLD}_new}"
DBUSER="$(envval DB_USERNAME)"
SQL="mysql --default-character-set=utf8mb4"
WORK="/root/pindah-db-$(date +%F_%H%M%S)"
mkdir -p "$WORK"

echo "Database lama : $OLD"
echo "Database baru : $NEW"
echo "User aplikasi : $DBUSER"
echo "Log           : $WORK"
echo

$SQL -e "SELECT 1" >/dev/null 2>&1 || { echo "Tidak bisa masuk MySQL sebagai root (coba jalankan dengan sudo)."; exit 1; }
if $SQL -N -e "SHOW DATABASES LIKE '$NEW'" | grep -q .; then
  echo "Database $NEW sudah ada. Hapus dulu kalau memang mau mengulang:"
  echo "  mysql -e 'DROP DATABASE \`$NEW\`;'"
  exit 1
fi

read -r -p "Lanjut? Website akan masuk mode maintenance selama penyalinan. (y/N) " ok
[ "$ok" = "y" ] || exit 0

CONFIG_CACHED=0
[ -f bootstrap/cache/config.php ] && CONFIG_CACHED=1

echo "== 1/6 Backup database lama"
mysqldump --single-transaction "$OLD" > "$WORK/backup_$OLD.sql" || { echo "Backup gagal"; exit 1; }
ls -lh "$WORK/backup_$OLD.sql"

echo "== 2/6 Buat database baru + hak akses user aplikasi"
$SQL -e "CREATE DATABASE \`$NEW\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" || exit 1
for host in $($SQL -N -e "SELECT Host FROM mysql.user WHERE User='$DBUSER'"); do
  $SQL -e "GRANT ALL PRIVILEGES ON \`$NEW\`.* TO '$DBUSER'@'$host';" || exit 1
done
$SQL -e "FLUSH PRIVILEGES;"

echo "== 3/6 Jalankan migration ke database baru"
php artisan config:clear >/dev/null
DB_DATABASE="$NEW" php artisan migrate --force 2>&1 | tee "$WORK/migrate.log"
if ! $SQL -N -e "SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA='$NEW' AND TABLE_NAME='migrations'" | grep -q 1; then
  echo "Migration gagal, lihat $WORK/migrate.log. Database lama tidak tersentuh."; exit 1
fi

echo "== 4/6 Mode maintenance + salin data"
php artisan down >/dev/null
$SQL -N -e "
SET SESSION group_concat_max_len = 1000000;
SELECT CONCAT(
  'INSERT INTO \`$NEW\`.\`', n.TABLE_NAME, '\` (',
  GROUP_CONCAT(CONCAT('\`', n.COLUMN_NAME, '\`') ORDER BY n.ORDINAL_POSITION),
  ') SELECT ',
  GROUP_CONCAT(IF(n.DATA_TYPE IN ('timestamp','datetime','date'),
                  CONCAT('NULLIF(\`', n.COLUMN_NAME, '\`, '''')'),
                  CONCAT('\`', n.COLUMN_NAME, '\`')) ORDER BY n.ORDINAL_POSITION),
  ' FROM \`$OLD\`.\`', n.TABLE_NAME, '\`;')
FROM information_schema.COLUMNS n
JOIN information_schema.COLUMNS o
  ON o.TABLE_SCHEMA = '$OLD' AND o.TABLE_NAME = n.TABLE_NAME AND o.COLUMN_NAME = n.COLUMN_NAME
WHERE n.TABLE_SCHEMA = '$NEW' AND n.TABLE_NAME <> 'migrations'
GROUP BY n.TABLE_NAME;" > "$WORK/copy.sql"
{ echo "SET FOREIGN_KEY_CHECKS = 0;"; cat "$WORK/copy.sql"; echo "SET FOREIGN_KEY_CHECKS = 1;"; } > "$WORK/copy_run.sql"
$SQL --force "$NEW" < "$WORK/copy_run.sql" 2> "$WORK/copy_errors.log"

echo "== 5/6 Bandingkan jumlah baris"
$SQL -N -e "
SET SESSION group_concat_max_len = 1000000;
SELECT GROUP_CONCAT(CONCAT(
  'SELECT ''', t.TABLE_NAME, ''' AS tabel, (SELECT COUNT(*) FROM \`$OLD\`.\`', t.TABLE_NAME,
  '\`) AS lama, (SELECT COUNT(*) FROM \`$NEW\`.\`', t.TABLE_NAME, '\`) AS baru') SEPARATOR ' UNION ALL ')
FROM information_schema.TABLES t
JOIN information_schema.TABLES o ON o.TABLE_SCHEMA = '$OLD' AND o.TABLE_NAME = t.TABLE_NAME
WHERE t.TABLE_SCHEMA = '$NEW' AND t.TABLE_NAME <> 'migrations';" > "$WORK/count.sql"
$SQL -t < "$WORK/count.sql" | tee "$WORK/count.txt"
MISMATCH=$($SQL -N < "$WORK/count.sql" | awk '$2 != $3' | wc -l)

echo
echo "Tabel/kolom lama yang TIDAK ikut disalin (tidak dipakai kode lagi, tetap aman di $OLD):"
$SQL -N -e "
SELECT CONCAT('  tabel ', TABLE_NAME) FROM information_schema.TABLES
WHERE TABLE_SCHEMA = '$OLD' AND TABLE_NAME NOT IN (SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$NEW')
UNION ALL
SELECT CONCAT('  kolom ', o.TABLE_NAME, '.', o.COLUMN_NAME) FROM information_schema.COLUMNS o
JOIN information_schema.TABLES nt ON nt.TABLE_SCHEMA = '$NEW' AND nt.TABLE_NAME = o.TABLE_NAME
LEFT JOIN information_schema.COLUMNS n ON n.TABLE_SCHEMA = '$NEW' AND n.TABLE_NAME = o.TABLE_NAME AND n.COLUMN_NAME = o.COLUMN_NAME
WHERE o.TABLE_SCHEMA = '$OLD' AND n.COLUMN_NAME IS NULL;" | tee "$WORK/dropped.txt"

echo
if [ -s "$WORK/copy_errors.log" ] || [ "$MISMATCH" -ne 0 ]; then
  echo "!! Ada tabel yang gagal disalin. Website tetap memakai database LAMA ($OLD)."
  echo "   Error : $WORK/copy_errors.log"
  cat "$WORK/copy_errors.log"
  [ "$CONFIG_CACHED" = 1 ] && php artisan config:cache >/dev/null
  php artisan up >/dev/null
  exit 1
fi

echo "== 6/6 Semua data tersalin dengan jumlah baris sama."
read -r -p "Pindahkan website ke database baru ($NEW) sekarang? (y/N) " sw
if [ "$sw" = "y" ]; then
  cp .env "$WORK/.env.before"
  sed -i -E "s/^DB_DATABASE=.*/DB_DATABASE=$NEW/" .env
  php artisan config:clear >/dev/null
  [ "$CONFIG_CACHED" = 1 ] && php artisan config:cache >/dev/null
  echo "Website sekarang memakai $NEW."
  echo "Kalau ada masalah, kembalikan dengan:"
  echo "  cp $WORK/.env.before $APP_DIR/.env && cd $APP_DIR && php artisan config:clear"
else
  [ "$CONFIG_CACHED" = 1 ] && php artisan config:cache >/dev/null
  echo "Website tetap memakai $OLD. Database $NEW sudah siap kalau nanti mau dipakai."
fi
php artisan up >/dev/null
echo "Selesai."
