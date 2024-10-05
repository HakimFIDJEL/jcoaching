import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/bootstrap.css',
                'resources/css/line-awesome.css',
                'resources/css/line-awesome.min.css',
                'resources/css/magnific-popup.css',
                'resources/css/style.css',
                'resources/css/swiper.css',
                'resources/css/swiper.min.css',

                'resources/js/app.js',
                'resources/js/bootstrap.bundle.js',
                'resources/js/bootstrap.bundle.min.js',
                'resources/js/bootstrap.js',
                'resources/js/echo.js',
                'resources/js/jquery.filterizr.js',
                'resources/js/jquery.filterizr.min.js',
                'resources/js/jquery.js',
                'resources/js/jquery.magnific-popup.js',
                'resources/js/jquery.min.js',
                'resources/js/magnific-popup.min.js',
                'resources/js/main.js',
                'resources/js/swiper.js',
                'resources/js/swiper.min.js',

                'resources/js/pages/admin/dashboard.js',
                'resources/js/pages/admin/pricings.js',
                'resources/js/pages/admin/reductions.js',
                'resources/js/pages/jerhome/contact.js',
                'resources/js/pages/member/dashboard.js',
                'resources/js/pages/member/plan_index.js',
                'resources/js/pages/member/workout_index.js',
                'resources/js/pages/calendar.js',

                'resources/js/plugins/chatbox.js',
                'resources/js/plugins/ckeditor.js',
                'resources/js/plugins/filepond.js',
                'resources/js/plugins/fullcalendar.js',
                'resources/js/plugins/notyf.js',
                'resources/js/plugins/smartwizard.js',
                'resources/js/plugins/swal.js',
            ],
            refresh: true,
        }),
    ],
    define : {
        'process.env': process.env,
    }
});
