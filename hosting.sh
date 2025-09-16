# install certbot untuk ssl, nginx sebagai webserver
sudo apt install certbot python3-certbot-nginx nginx -y

# buat file nginx sehatmate dan arahkan ke alamat port sehatmate di local dalam hal ini localhost:8000
echo 'server {
    listen 80;
    server_name sehatmate.my.id;

    location / {
        proxy_pass http://localhost:8000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
}' | sudo tee /etc/nginx/sites-available/sehatmate.my.id

sudo ln -s /etc/nginx/sites-available/sehatmate.my.id /etc/nginx/sites-enabled/

# reload nginx untuk memperbarui configurasi agar sehatmate.my.id aktif
sudo systemctl reload nginx

# aktifkan ssl
sudo certbot --nginx -d sehatmate.my.id
