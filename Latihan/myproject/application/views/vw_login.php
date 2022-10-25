<html>

<head>
    <title>Form Login</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <div class="page-header">
                <center>
                    <h1>Form-Login</h1>
                </center>
            </div>
            <div class="card-body">
                <?php
                if ($this->session->flashdata('error') != '') {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo $this->session->flashdata('error');
                    echo '</div>';
                }
                ?>

                <?php
                if ($this->session->flashdata('success_register') != '') {
                    echo '<div class="alert alert-info" role="alert">';
                    echo $this->session->flashdata('success_register');
                    echo '</div>';
                }
                ?>
                <form method="post" action="<?php echo base_url(); ?>index.php/login/proses">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <a href="register"><button type="submit" class="btn btn-primary">Halaman Register</button></a>
            </div>
        </div>
    </div>
</body>

</html>