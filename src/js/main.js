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
        successMsg: '',
        saving: false,
        isReady: wsnIsReady,
        sending: false
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
        },
        defined_pwd() {
            return this.config.DEFINED_PWD;
        }
    },
    methods: {
        save() {
            this.successMsg = '';
            this.errorMsg = '';
            this.saving = true;
            this.$http.post(this.endpoint.save, this.config).then(
                response => {
                    this.saving = false;
                    this.successMsg = 'Settings saved successfully';
                },
                error => {
                    this.saving = false;
                    this.errorMsg = 'There was an error saving the settings, please try again. ' + error.body || error;
                }
            )
        },
        set(index, action) {
            this.actions[index].saving = true;
            this.$http.post(this.endpoint.action, action).then(
                response => {
                    this.update(index, action);
                },
                error => {
                    alert(error.body);
                }
            )
        },
        update(index, current_action) {
            let finder = this.actions.filter(a => {
                return a.key === current_action.key;
            }).shift();

            finder.active = !current_action.active;
            finder.saving = false;
            this.actions.splice(index, 1, finder);
        }
    },
    watch: {
        customSmtp: function () {
            delete this.config.smtp_user;
            delete this.config.smtp_pwd;
        }
    },
    created() {
        this.customSmtp = this.config.smtp_user != '' && (this.config.smtp_pwd != '' || this.config.DEFINED_PWD != '');
    }
})