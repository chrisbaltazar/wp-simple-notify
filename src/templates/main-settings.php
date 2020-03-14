<?php

?>
    <div id="wp-simple-notify-container" class="container">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron jumbotron-fluid p-m">
                    <div class="container-fluid text-center">
                        <h1 class="display-4">WP Simple Notify Settings</h1>
                        <p class="lead">Here you can configure all the options available for this plugin.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class=""><span class="badge badge-primary">Email config</span></h3>
                <form @submit.prevent="save">
                    <div class="form-group">
                        <label>Email address from:</label>
                        <input type="email" class="form-control" placeholder="@" v-model="config.email_from"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Email password:</label>
                        <input type="password" class="form-control" placeholder="*" v-model="config.email_pwd"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Sender name:</label>
                        <input type="text" class="form-control" placeholder="name" v-model="config.sender"
                               required>
                    </div>
                    <div class="form-group">
                        <label>SMTP Host:</label>
                        <input type="text" class="form-control" placeholder="smtp.yourdomain.com" v-model="config.host"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Port Number:</label>
                        <input type="number" class="form-control" plpasswordaceholder="port" v-model="config.port"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Connection security:</label>
                        <select class="form-control text-uppercase" v-model="config.secure" required>
                            <option v-for="s in security" :selected="s==config.secure">{{s}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Use custom SMTP credentials
                            <input type="checkbox" v-model="customSmtp" value="1">
                        </label>
                    </div>
                    <div class="form-group" v-if="customSmtp">
                        <label>SMTP User:</label>
                        <input type="text" class="form-control" placeholder="user" v-model="config.smtp_user"
                               required>
                    </div>
                    <div class="form-group" v-if="customSmtp">
                        <label>SMTP password:</label>
                        <input type="password" class="form-control" placeholder="password" v-model="config.smtp_pwd"
                               required>
                    </div>

                    <button type="submit" class="float-right btn btn-success btn-lg mb-x">Save configuration</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-dismissible my-3 fade show" :class="messageClass" v-if="messageClass"
                     role="alert">
                    <strong>{{successMsg || errorMsg}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class=""><span class="badge badge-warning">Plugin actions</span></h3>
                <div class="list-group mt-5">
                    <span href="" class="list-group-item list-group-item-action" v-for="(action, index) in actions">
                        <label>{{action.text}}</label>
                        <button class="btn float-right my-m mx-m" :class="action.active | status_button"
                                @click="set(index, action)">{{ action.active | status_label }}</button>
                        <span class="badge badge-pill float-right my-2 mx-4" :class="action.active | status_badge">{{ action.active ? 'ON' : 'OFF' }}</span>
                    </span>
                </div>
            </div>
        </div>

<?php do_action( 'wp-simple-notify-settings-end' ); ?>