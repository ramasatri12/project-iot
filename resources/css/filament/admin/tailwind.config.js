import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/css/filament/**/*.css', // <- tambahkan ini!
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
          colors: {
            primary: '#34d399', // Misalnya ganti warna utama
            danger: '#f87171',  // Ganti warna merah
          },
        },
    },
}
