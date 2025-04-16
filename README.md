# Installation guide
<code>
composer install
</code>
<code>
cp .env.example .env
</code>
<code>
php artisan key:generate
</code>
<code>
php artisan migrate
</code>
<p>
after that ,add the smtp and database credentials at .env file
</p>
<code>
php artisan serve
</code>
<p>
and you are ready on <a href="http://127.0.0.1:8000/">http://127.0.0.1:8000/</a>
</p>