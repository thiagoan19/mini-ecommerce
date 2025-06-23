import { defineNuxtConfig } from 'nuxt/config'

export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiBase: 'http://127.0.0.1:8000/api'
    }
  }
,
  modules: ['@pinia/nuxt'],
  css: ['@/assets/style.css'],
  postcss: {
  plugins: {
    '@tailwindcss/postcss': {},
    autoprefixer: {},
  },
}
})
