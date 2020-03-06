new Vue({
    el: '#wp-simple-notify-container',
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: {
        config: {},
        customSmtp: 0,
        security: ['ssl', 'tls']
    },
    computed: {},
    methods: {},
    created() {

    }
})