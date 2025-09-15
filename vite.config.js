import { defineConfig } from 'vite';
import path from 'path'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  resolve: {
      alias: {
          '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
          '~tabler': path.resolve(__dirname, 'node_modules/@tabler/core')
      }
  },
  plugins: [
      laravel({
          input: ['resources/front/js/app.js', 'resources/admin/js/app.js'],
          refresh: true,
      })
  ]
});