new Vue({
    el: '#wp-simple-notify-container',
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: {
        config: wsnConfig,
        customSmtp: false,
        security: ['ssl', 'tls'],
        actions: wsnActions,
        endpoint: wsnEndpoint,
        errorMsg: '',
        successMsg: ''
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
    computed: {
        messageClass() {
            if (this.successMsg)
                return 'alert-success';

            if (this.errorMsg)
                return 'alert-danger';

            return '';
        }
    },
    methods: {
        save() {
            this.successMsg = '';
            this.errorMsg = '';
            this.$http.post(this.endpoint.save, this.config).then(
                response => {
                    this.successMsg = 'Settings saved successfully';
                },
                error => {
                    this.errorMsg = 'There was an error saving the settings, please try again. ' + error;
                }
            )
        }
    },
    watch: {
        customSmtp: function () {
            this.config.smtp_user = '';
            this.config.smtp_pwd = '';
        }
    },
    created() {

    }
})