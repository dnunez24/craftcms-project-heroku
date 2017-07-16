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
  .extract([
    // 'vue',
  ])
  .copy('src/assets/fonts', 'public/fonts')
  .copy('src/assets/images', 'public/images')
  .browserSync(process.env.CRAFT_SITE_URL);

if (mix.inProduction()) {
  mix.version();
}
