# Requirements

- PHP >= 8.0
- PostgreSQL: >= 12

# Hướng dẫn deploy

1. Copy 2 file ssh vào thư mục .ssh trên máy của mình

```
cp deploy/plats ~/.ssh/
cp deploy/plats.pub ~/.ssh/
```

Phân quyền cho 2 file ssh trên

```
sudo chmod 400 ~/.ssh/plats
sudo chmod 400 ~/.ssh/plats.pub
```

2. Copy file deployer.phar vào thư mục bin trong vendor

```
cp deploy/deployer.phar vendor/bin/
```

Phân quyền cho file trên

```
sudo chmod -R 777 vendor/bin/deployer.phar
```

3. Chạy lênh deploy lên server dev

```
vendor/bin/deployer.phar deploy dev
```
- Chờ kết quả done thì deploy thành công

## Note:
- Nếu ở bước 3 báo lỗi thì vui lòng chạy các lệnh sau rồi chạy lại bước 3

```
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/plats
```
