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
  .copy('src/assets/images', 'public/images')
  .version();

if (!mix.inProduction()) {
  mix.browserSync({
    open: false,
    proxy: 'http',
    files: [
      'public/images/**/*',
      'public/fonts/**/*',
      'public/scripts/**/*.js',
      'public/styles/**/*.css',
    ],
    watchEvents: [
      'change',
      'add',
      'unlink',
    ],
  });
}
