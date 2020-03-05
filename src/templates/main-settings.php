<?php

?>
    <div id="wp-simple-notify-container" class="container">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron jumbotron-fluid p-m">
                    <div class="container-fluid">
                        <h1 class="display-6">WP Simple Notify Settings</h1>
                        <p class="lead">Here you can configure all the options available for this plugin.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4><span class="badge badge-primary">Email options</span></h4>
                <form>
                    <div class="form-group">
                        <label>Email address from:</label>
                        <input type="email" class="form-control" placeholder="@" v-model="config.from"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Email password:</label>
                        <input type="password" class="form-control" placeholder="***" v-model="config.pwd"
                               required>
                    </div>
                </form>
            </div>
        </div>

<?php do_action( 'wp-simple-notify-settings-end' ); ?>