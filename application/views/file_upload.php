<title>Welcome to CodeIgniter</title>
<style scoped="scoped" type="text/css">
body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }
            #body{
                margin: 0 15px 0 15px;
            }
            #container{
                margin: 10px;
                border: 1px solid #D0D0D0;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
            }
            .error {
                color: #E13300;
            }
            .info {
                color: gold;
            }
            .success {
                color: darkgreen;
            }
</style>
<div id="container">
<h1>File Upload Example</h1>
<div id="body">
<p>Select a file to upload</p>
<?php
                if (isset($success) && strlen($success)) {
                    echo '<div class="success">';
                    echo '<p>' . $success . '</p>';
                    echo '</div>';
                }
                if (isset($errors) && strlen($errors)) {
                    echo '<div class="error">';
                    echo '<p>' . $errors . '</p>';
                    echo '</div>';
                }
                if (validation_errors()) {
                    echo validation_errors('<div class="error">', '</div>');
                }
                ?>
<div><?php
                    $attributes = array('name' => 'file_upload_form', 'id' => 'file_upload_form');
                    echo form_open_multipart($this->uri->uri_string(), $attributes);
                    ?>
<p><input name="file_name" id="file_name" readonly="readonly" type="file" /></p>
<p><input name="file_upload" value="Upload" type="submit" /></p>
<?php
                    echo form_close();
                    ?></div>
</div>
</div>