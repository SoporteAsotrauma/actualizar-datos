module.exports = {
    content: [
        "./**/*.php",
        "./*.html",        // Si tus archivos HTML están en la raíz del proyecto
        "./**/*.html",     // Si tus archivos HTML están en subdirectorios
        "./css/**/*.css",  // Si estás usando clases de Tailwind en tus archivos CSS
        // Agrega otros archivos como JS o JSX si los estás usando con Tailwind
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
