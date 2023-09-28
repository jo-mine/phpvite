import { defineConfig } from 'vite'
import glob from "fast-glob"
import path from "path"
import { log } from 'console'
import { fileURLToPath } from 'node:url';

const getInputs = (): Record<string, string> => {
  const target = Object.fromEntries(
    glob.sync(['src/**/*.ts'], { ignore: 'src/base' }).map(file => [
      path.relative(
        'src',
        file.slice(0, file.length - path.extname(file).length)
      ),
      fileURLToPath(new URL(file, import.meta.url))
    ])
  )
  const sasstarget = Object.fromEntries(
    glob.sync(['sass/**/*.scss']).map(file => [
      path.relative(
        'sass',
        file.slice(0, file.length - path.extname(file).length)
      ),
      fileURLToPath(new URL(file, import.meta.url))
    ])
  )
  const result = { ...target, ...sasstarget }
  log(result)
  return result
}

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    emptyOutDir: true,
    minify: false,
    copyPublicDir: false,
    rollupOptions: {
      input: getInputs(),
      output: {
        entryFileNames: 'js/[name].js',
        assetFileNames: 'css/[name].[ext]',
      }
    }
  },
})
