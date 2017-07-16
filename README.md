# Craft CMS Project Starter

[![Deploy to Heroku](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

## Requirements

* MacOS Yosemite or higher
* Docker for Mac
* git

## Getting Started

```bash
git clone https://github.com/dnunez24/craftcms-project.git my-project
cd my-project
cp .env.example .env
sed -i '' 's/craftcms/myproject/' .env
docker-compose up -d
docker-compose exec app composer install --prefer-dist --no-interaction
```
