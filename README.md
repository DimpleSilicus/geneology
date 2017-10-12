# Silicus Laravel PHP Framework

#How to use this framework for new project?
    Just download zip folder and extract it to your project directory.

    After that run “composer update” command which will generate “vendor” folder.

    Create .env file as mentioned below.

#This framework come with below features
-	In built AUTH

	--	**Login**

	--	**Registration**

	--	**Forgot Password**

	--	**Logout**

-	**Query Log:**	You can enable query log through .env settings.  Just put QUERY_LOG=true in .env file

-	**Theme:** You can set them through .env settings.  Just put THEME=default in .env file. By default it will consider theme name as “default”

-	**Cache Css**: You can enable CSS cache through .env settings.  Just put CASH_CSS=true in .env file

-	**Cache JS:**	You can enable CSS cache through .env settings.  Just put CASH_CSS=true in .env file

-	**Load your CSS | JS files dynamically:** You can load your module’s JS through your controller class. Please refer below code.

	$jsFiles[]   = $this->url. 'theme/' . $this->theme . '/assets/js/view.js';

	$cssFiles[]  = $this->url. 'theme/' . $this->theme . '/assets/css/view.css';

	$this->loadJsCSS( $jsFiles, $cssFiles );

-	**Modular :**
	You can design your project as modular. Put your new module/package/plugin inside “modules” folder

-	**ToolKit :**
	ToolKit is a part of your “modules”. This hold libraries which are common (like SEO) or require for your project.

-	**SEO :**
        Here is an example to set meta data

```
    public function showLoginForm()
    {
        $metadata = ['title' => 'site title', 'description' => 'site description', 'keywords' => 'PHP, Mysql, Apache'];
        $this->addMetadata($metadata);
        return view($this->theme . '.auth.login');
    }
```

# CRUD-Generator:

    This framework help your to create Add | Edit | Delete | View | Pagination
    and Search functionality by using below command.

```
        php artisan crud:generate <class name>  <table name>
    e.g.
        php artisan crud:generate contact contact
```

This will generate code into "storage/crud-generator" folder. After that copy that folder
and past into "modules" folder and run php artisan command and follow steps which will make code live.

# Add Log:

    This framework help your to put log so that you can debug an error. This will help you to find issue using ELK.

```
        @param string $message Log message
        @param string $module  Module name
        @param string $type    Type of error log emergency | alert | critical | error | warning | notice | info | debug
        @param array  $details Message details

        Workshop::addLog($message, $module, $type, $details);
    e.g.
        php artisan crud:generate contact contact
```

# Backup Script

	This script will help you in creating your folder and database backup

```
        php artisan create:backup

```

#Content in .env file
```
    APP_ENV=development
    APP_DEBUG=true
    APP_KEY=base64:FFv1pwedA9r57xRlE2mNi3JemSU0nL2x8KZ4xLiTtfM=

    DB_HOST=localhost
    DB_DATABASE=sil_project
    DB_USERNAME=root
    DB_PASSWORD=
    DB_PORT=3306

    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=testmili@gmail.com
    MAIL_PASSWORD=kembtbgueyxbpobs
    MAIL_ENCRYPTION=tls

    SITE_URL = http://sil.ajay.com/
    SITE_NAME= 'Your Site Name'

    QUERY_LOG=true
    THEME=default
    CASH_CSS=true
    CASH_JS=true
```
