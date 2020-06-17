#### Ash
starter of Laravel & Vue & ElementUI & Rium

##### Modified Laravel Files:
 
* app/Console/Commands/test.php
* app/Helpers/helper.php
* app/Http/Controller.php
* app/Kernel.php
> remove csrf token verify
* app/Models/Model.php
* app/Models/Builder.php
* app/Models/User.php
* config/app.php
> set timezone PRC
* config/auth.php
> set providers.user.model App\Models\User
* config/session.php
> set lifetime 60 * 24 * 30
* database/create_posts_table.php
* database/seeds/DatabaseSeeder.php 
> add user and post seeds
* views/*
* routes/web.php
* .env.example
> set APP_URL http://localhost:8000

##### Removed Laravel Files

* resources/js
* resources/sass/app.scss
* tests
* package.json
* phpunit.xml
* webpack.mix.js
* .styleci.yml
* .gitattributes
* .editorconfig