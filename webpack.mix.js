/*
 * AWPS uses Laravel Mix
 *
 * Check the documentation at
 * https://laravel-mix.com/
 */

let mix = require( 'laravel-mix' );
require( '@tinypixelco/laravel-mix-wp-blocks' );

// Autloading jQuery to make it accessible to all the packages, because, you know, reasons
// You can comment this line if you don't need jQuery.
mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery'],
});

mix.setPublicPath( './dist' );

// crea un vendor.js para importar todas las liberrias de node_modules
mix.extract();
mix.browserSync({
    proxy: 'http://rueba.test:86/',
});
//Combinar todos los Estilos y scripts para una sola pagina (en un directorio)
mix.combine('src/register/*.js', 'dist/register/app.js');
mix.combine('src/register/*.css', 'dist/register/app.css');


// Compile common assets.
mix.js( 'src/common/scripts/app.js', 'dist/common/js' )
	.js( 'src/common/scripts/admin.js', 'dist/common/js' )
	.block( 'src/common/scripts/gutenberg.js', 'dist/common/js' )
	.sass( 'src/common/sass/style.scss', 'dist/common/css' )
	.sass( 'src/common/sass/admin.scss', 'dist/common/css' )
	.sass( 'src/common/sass/gutenberg.scss', 'dist/common/css' );

// Add source map and versioning to assets in production environment.
if ( mix.inProduction() ) {
	mix.sourceMaps().version();
}
