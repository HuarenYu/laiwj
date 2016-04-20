var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
});

elixir(function(mix) {
    mix.scripts(['lib/jquery-2.2.3.js', 'lib/jquery.lazyload.js'], 'public/js/lib.js')
    .scripts(['common/settings.js',
        'common/form.js',
        'common/api.js',
        'common/global-error.js'
        ],
        'public/js/common.js'
    );
});

elixir(function(mix) {
    mix.version(['css/app.css', 'js/lib.js', 'js/common.js']);
});
