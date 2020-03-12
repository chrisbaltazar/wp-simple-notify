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
    filters: {
        status_label: function (value) {
            return value ? 'Deactivate' : 'Activate';
        },
        status_button: function (value) {
            return value ? 'btn-danger' : 'btn-primary';
        },
        status_badge: function (value) {
            return value ? 'badge-info' : 'badge-light';
        },
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