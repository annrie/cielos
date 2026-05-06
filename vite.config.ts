import path from 'node:path'
import vue from '@vitejs/plugin-vue'
import externalGlobals from 'rollup-plugin-external-globals'
import UnoCSS from 'unocss/vite'
import { defineConfig } from 'vite'
import VueDevTools from 'vite-plugin-vue-devtools'

// WordPress パッケージの外部依存マッピング
const wpExternals: Record<string, string> = {
  '@wordpress/blocks': 'wp.blocks',
  '@wordpress/element': 'wp.element',
  '@wordpress/block-editor': 'wp.blockEditor',
  '@wordpress/components': 'wp.components',
  '@wordpress/i18n': 'wp.i18n',
  '@wordpress/data': 'wp.data',
}

// https://vitejs.dev/config/
export default defineConfig(({ mode }) => {
  const isProd = mode === 'production'

  return {
    // WordPressテーマのパスに合わせて修正
    base: isProd ? '/wp-content/themes/cielos/dist/' : '/',
    publicDir: 'public',

    resolve: {
      alias: {
        '~/': `${path.resolve(__dirname, 'src')}/`,
        '@/': `${path.resolve(__dirname, 'src')}/`,
      },
    },

    server: {
      host: true,
      strictPort: true,
      port: 5173,
      cors: true,
      // HMRのためにオリジンを設定
      origin: 'http://localhost:5173',
    },

    plugins: [
      vue(),
      UnoCSS(), // Automatically reads uno.config.ts
      VueDevTools(),
    ],

    build: {
      // 出力先を 'dist' に設定
      outDir: 'dist',
      manifest: true,
      target: 'es2018',
      sourcemap: !isProd,
      minify: 'esbuild',
      cssMinify: 'esbuild',
      reportCompressedSize: false,
      brotliSize: false,
      assetsInlineMaxSize: 4 * 1024,
      rollupOptions: {
        checks: {
          pluginTimings: false,
        },
        input: {
          main: 'src/main.ts',
          block: 'src/blocks/my-block-editor.ts',
          watcher: 'src/assets/js/theme-watcher.cielos.js',
        },
        // WordPress パッケージを外部依存として扱う
        external: Object.keys(wpExternals),
        // externalGlobals プラグインで WordPress 依存を変換
        plugins: [externalGlobals(wpExternals)],
        output: {
          // functions.phpがmanifest.jsonを読むのでハッシュは維持
          entryFileNames: `assets/[name]-[hash].js`,
          chunkFileNames: `assets/[name]-[hash]-chunk.js`,
          assetFileNames: `assets/[name]-[hash].[ext]`,
        },
      },
    },

    esbuild: {
      treeShaking: true,
      legalComments: 'none',
    },

    optimizeDeps: {
      include: ['vue', 'vue-router'],
    },

    // UnoCSSをメインで使うため、SCSSの設定は削除
    // css: {
    //   preprocessorOptions: {
    //     scss: {
    //       // ...
    //     },
    //   },
    // },
  }
})
