import { defineConfig, splitVendorChunkPlugin } from 'vite'
import glob from "fast-glob"
import path from "path"
import { fileURLToPath } from 'node:url';

const getInputs = (): Record<string, string> => {
  const target = Object.fromEntries(
    glob.sync(['ts/**/*.ts'], { ignore: 'ts/base' }).map(file => [
      path.relative(
        'ts',
        file.slice(0, file.length - path.extname(file).length)
      ),
      fileURLToPath(new URL(file, import.meta.url))
    ])
  )
  target.base = fileURLToPath(new URL("ts/base/base.ts", import.meta.url))
  return target
}

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [splitVendorChunkPlugin()],
  build: {
    emptyOutDir: true,
    minify: false,
    copyPublicDir: false,
    rollupOptions: {
      input: getInputs(),
      output: {
        entryFileNames: 'js/[name].js',
        assetFileNames: 'css/[name].[ext]',
        chunkFileNames: 'vendor/vendor.js'
      }
    }
  },
  resolve: {
      alias: {
          vue: 'vue/dist/vue.esm-bundler.js',
          '@ts/': __dirname+'/ts/',
          '@sass/': __dirname+'/sass/'
      }
  },
})
