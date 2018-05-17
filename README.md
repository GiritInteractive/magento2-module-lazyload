# Magento 2 LazyLoad Module by [Girit Interactive](https://www.girit-tech.com/)

This Magento 2 module adds LazyLoad for catalog images & CMS blocks.

---

## ✓ Install via composer (recommended)
Run the following command under your Magento 2 root dir:

```
composer require girit/magento2-module-lazyload
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

## Install manually under app/code

First, you need to add this repository at the root of your `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Youpie/simple-html-dom"
    }
]
```

Then, require this package in the same way as any other package:

```json
"require": {
    "simple-html-dom/simple-html-dom": "*"
}
```

Then, since Simple HTML DOM isn’t PSR-0 compliant, you need to add the following if you want to autoload it via Composer:

```json
"autoload": {
    "classmap": [
        "vendor/simple-html-dom/simple-html-dom/"
    ]
}
```

Then, download & place the contents of this repository under {YOUR-MAGENTO2-ROOT-DIR}/app/code/Girit/LazyLoad

Finally, run the following commands under your Magento 2 root dir:
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

---

http://www.girit-tech.com  
+972-3-9177788  
info@girit.biz  

Copyright © 2018 Girit-Interactive. All rights reserved.  

![Girit Interactive Logo](https://www.girit-tech.com/templates/images/logos/girit-flat.png)
