import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')

  return {
    plugins: [
      laravel([
        'resources/css/app.css',
        'resources/js/app.js',
      ]),
    ],
    server: {
      host: '0.0.0.0',
      port: Number(env.VITE_DEV_PORT || 5173),
      strictPort: true,
      hmr: env.VITE_HMR_HOST
        ? {
            protocol: env.VITE_HMR_PROTOCOL || 'wss',
            host: env.VITE_HMR_HOST,
            clientPort: Number(env.VITE_HMR_CLIENT_PORT || 443),
          }
        : undefined,
    },
  }
})
