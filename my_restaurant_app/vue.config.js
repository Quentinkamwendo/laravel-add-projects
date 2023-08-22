const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
    // devServer: {
    //     proxy: {
    //         '^/api': {
    //             target: 'http://localhost:8000',
    //             changeOrigin: true,
    //             secure: false,
    //             pathRewrite: {'^/api': ""},
    //         }
    //     }
    // },
  transpileDependencies: true
})
