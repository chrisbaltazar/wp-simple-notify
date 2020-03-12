new Vue({
    el: '#wp-simple-notify-container',
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: {
        config: {},
        customSmtp: false,
        security: ['ssl', 'tls'],
        options: wsnOptions
    },
    computed: {},
    methods: {},
    watch: {
        customSmtp: function () {
            this.config.smtp_user = '';
            this.config.smtp_pwd = '';
        }
    },
    created() {

    }
})