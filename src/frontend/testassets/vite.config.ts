import { defineConfig } from 'vite'
import glob from "fast-glob"
import path from "path"
import { log } from 'console'
import { fileURLToPath } from 'node:url';

const getInputs = (): Record<string, string> => {
  const target = Object.fromEntries(
    glob.sync('src/**/*.ts').map(file => [
      // This remove `src/` as well as the file extension from each
      // file, so e.g. src/nested/foo.js becomes nested/foo
      path.relative(
        'src',
        file.slice(0, file.length - path.extname(file).length)
      ),
      // This expands the relative paths to absolute paths, so e.g.
      // src/nested/foo becomes /project/src/nested/foo.js
      fileURLToPath(new URL(file, import.meta.url))
    ])
  )
  log(target)
  return target
}

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    emptyOutDir: true,
    minify: false,
    rollupOptions: {
      input: getInputs(),
      output: {
        entryFileNames: '[name].js'
      }
    }
  },
})
