import { defineConfig } from 'vite'
import multiEntry from "rollup-plugin-multi-entry";

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    emptyOutDir: true,
    minify: true,
    copyPublicDir: false,
    outDir: 'dist/js/base',
    rollupOptions: {
      plugins: [multiEntry()],
      input: 'src/base/*.ts',
      output: {
        entryFileNames: 'base.js'
      }
    },
  },
})
