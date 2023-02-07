<b>installation steps</b><br>
<b>clone this repostitory</b><br>
<code>git clone https://github.com/suadikhasen/subscriptionplatform</code><br>
go to your directory : <code>cd subscriptionplatform</code><br>
<b>install vendor packages</b><br>
 <code>composer:install </code><br>
copy environmental configration
<code> cp .env.example  .env </code><br>
create database on .env to you database in my case it is php my admin<br>
migrate the database tables : <code> php artisan migrate </code><br>

