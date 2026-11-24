import path from "path";
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/landing.css",
                "resources/js/app.js",
                "resources/js/landing.js",
                "resources/js/demo.tsx",
                `resources/css/filament/admin/theme.css`,
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },

    // build: {
    //     chunkSizeWarningLimit: 500,
    //     cssCodeSplit: true,
    //     reportCompressedSize: false,
    //     rollupOptions: {
    //         output: {
    //             manualChunks(id) {
    //                 if (id.includes("node_modules")) {
    //                     return id
    //                         .toString()
    //                         .split("node_modules/")[1]
    //                         .split("/")[0]
    //                         .toString();
    //                 }
    //             },
    //         },
    //     },
    // },
});
