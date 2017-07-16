# HTML5 Boilerplate from - https://github.com/h5bp/server-configs-nginx

# Compression

# Enable Gzip compressed.
gzip on;

# Compression level (1-9).
# 5 is a perfect compromise between size and cpu usage, offering about
# 75% reduction for most ascii files (almost identical to level 9).
gzip_comp_level    5;

# Don't compress anything that's already small and unlikely to shrink much
# if at all (the default is 20 bytes, which is bad as that usually leads to
# larger files after gzipping).
gzip_min_length    256;

# Compress data even for clients that are connecting to us via proxies,
# identified by the "Via" header (required for CloudFront).
gzip_proxied       any;

# Tell proxies to cache both the gzipped and regular version of a resource
# whenever the client's Accept-Encoding capabilities header varies;
# Avoids the issue where a non-gzip capable client (which is extremely rare
# today) would display gibberish if their proxy gave them the gzipped version.
gzip_vary          on;

# Compress all output labeled with one of the following MIME-types.
gzip_types
    application/atom+xml
    application/javascript
    application/json
    application/ld+json
    application/manifest+json
    application/rss+xml
    application/vnd.geo+json
    application/vnd.ms-fontobject
    application/x-font-ttf
    application/x-web-app-manifest+json
    application/xhtml+xml
    application/xml
    font/opentype
    image/bmp
    image/svg+xml
    image/x-icon
    text/cache-manifest
    text/css
    text/plain
    text/vcard
    text/vnd.rim.location.xloc
    text/vtt
    text/x-component
    text/x-cross-domain-policy;
    # text/html is always compressed by HttpGzipModule

# This should be turned on if you are going to have pre-compressed copies (.gz) of
# static files available. If not it should be left off as it will cause extra I/O
# for the check. It is best if you enable this in a location{} block for
# a specific directory, or on an individual server{} level.
# gzip_static on;

# HTML5 Boilerplate from - https://github.com/h5bp/server-configs-nginx

# Expire rules for static content

# No default expire rule. This config mirrors that of apache as outlined in the
# html5-boilerplate .htaccess file. However, nginx applies rules by location,
# the apache rules are defined by type. A consequence of this difference is that
# if you use no file extension in the url and serve html, with apache you get an
# expire time of 0s, with nginx you'd get an expire header of one month in the
# future (if the default expire rule is 1 month). Therefore, do not use a
# default expire rule with nginx unless your site is completely static

# Feed
location ~* \.(?:rss|atom)$ {
    expires 1h;
    add_header Cache-Control "public";
}

# Media: images, icons, video, audio, HTC
location ~* \.(?:jpg|jpeg|gif|png|ico|cur|gz|svg|svgz|mp4|ogg|ogv|webm|htc|webp)$ {
    etag off;
    expires 1M;
    access_log off;
    add_header Cache-Control "public";
}

# CSS and Javascript
location ~* \.(?:css|js)$ {
    etag off;
    expires 1y;
    access_log off;
    add_header Cache-Control "public";
}

# WebFonts
location ~* \.(?:ttf|ttc|otf|eot|woff|woff2)$ {
    etag off;
    add_header "Access-Control-Allow-Origin" "*";
    expires 1M;
    access_log off;
    add_header Cache-Control "public";
}

# HTML5 Boilerplate from - https://github.com/h5bp/server-configs-nginx

# Built-in filename-based cache busting

# This will route all requests for /css/style.20120716.css to /css/style.css
# Read also this: github.com/h5bp/html5-boilerplate/wiki/cachebusting
# This is not included by default, because it'd be better if you use the build
# script to manage the file names.
location ~* (.+)\.(?:\d+)\.(js|css|png|jpg|jpeg|gif|webp)$ {
	  etag off;
    expires 1M;
    access_log off;
    add_header Cache-Control "public";
    try_files $uri $1.$2;
}

# Security headers via https://securityheaders.io
add_header Strict-Transport-Security "max-age=15768000; includeSubDomains; preload";
add_header X-Frame-Options "SAMEORIGIN";
add_header X-XSS-Protection "1; mode=block";
add_header X-Content-Type-Options "nosniff";

# Add Content-Security-Policy HTTP response header. Helps reduce XSS risks on
# modern browsers by declaring what dynamic resources are allowed to load via a
# HTTP Header.  See https://content-security-policy.com/
# Uncomment this only if you know what you're doing; it will need tweaking
#add_header Content-Security-Policy "default-src https: data: 'unsafe-inline' 'unsafe-eval'" always;

# General virtual host settings
index index.html index.htm index.php;
charset utf-8;

# 404 error handler
error_page 404 /index.php?$query_string;

# 301 Redirect URLs with trailing /'s as per https://webmasters.googleblog.com/2010/04/to-slash-or-not-to-slash.html
rewrite ^/(.*)/$ /$1 permanent;

# Change // -> / for all URLs, so it works for our php location block, too
merge_slashes off;
rewrite (.*)//+(.*) $1/$2 permanent;

# For WordPress bots/users
location ~ ^/(wp-login|wp-admin|wp-config|wp-content|wp-includes|(.*)\.exe) {
    return 301 https://wordpress.com/wp-login.php;
}

# Handle Do Not Track as per https://www.eff.org/dnt-policy
location /.well-known/dnt-policy.txt {
    try_files /dnt-policy.txt /index.php?p=/dnt-policy.txt;
}

# Don't send the nginx version number in error pages and Server header
server_tokens off;

# Root directory location handler
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

# Localized sites, hat tip to Johannes -- https://gist.github.com/johanneslamers/f6d2bc0d7435dca130fc

# If you are creating a localized site as per: https://craftcms.com/docs/localization-guide
# the directives here will help you handle the locale redirection so that requests will
# be routed through the appropriate index.php wherein you set the `CRAFT_LOCALE`

# Enable this by un-commenting it, and changing the language codes as appropriate
# Add a new location @XXrewrites and location /XX/ block for each language that
# you need to support

<?php if ($locales = getenv('CRAFT_LOCALES')) : ?>
location @locales {
    rewrite ^/(<?= implode('|', explode(',', $locales)); ?>)/(.*)$ /$1/index.php?p=$2? last;
}

location /(<?= implode('|', explode(',', $locales)) ?>)/ {
    try_files $uri $uri/ @locales;
}
<?php endif; ?>

# Craft-specific location handlers to ensure AdminCP requests route through index.php
# If you change your `cpTrigger`, change it here as well
location ^~ /admin {
    try_files $uri $uri/ /index.php?$query_string;
}
location ^~ /cpresources {
    try_files $uri $uri/ /index.php?$query_string;
}
