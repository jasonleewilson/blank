import { defineConfig } from "vite";
import fullReload from "vite-plugin-full-reload";

export default defineConfig({
  plugins: [fullReload(["**/*.php", "parts/**/*.html", "templates/**/*.html"])],
  server: {
    cors: true,
    strictPort: true,
  },
  build: {
    outDir: "dist",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: "src/js/main.js",
    },
  },
});
