import { defineConfig } from "vite";

export default defineConfig({
  server: {
    cors: true,
    strictPort: true,
  },
  build: {
    outDir: "dist",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: "src/js/main.js",
        styles: "src/css/tailwind.css",
      },
    },
  },
});
