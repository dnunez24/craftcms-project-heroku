const { mix } = require('laravel-mix');
const dotenv = require('dotenv');

dotenv.config();

mix.setPublicPath('public')
  .options({
    purifyCss: true,
  })
  .sass('src/assets/styles/main.scss', 'public/styles')
  .js('src/assets/scripts/main.js', 'public/scripts')
  .sourceMaps()
  .copy('src/assets/fonts', 'public/fonts')
  .copy('src/assets/images', 'public/images');

if (!mix.inProduction()) {
  mix.browserSync(process.env.CRAFT_SITEURL);
}

if (mix.inProduction()) {
  mix.version();
}
