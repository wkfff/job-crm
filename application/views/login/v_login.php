<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/login.css">

<!-- NOTE : Notifikasi - umum -->
<?php if(!empty($this->session->flashdata('Failed'))) {?>
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?= $this->session->flashdata('Failed') ?>
</div>
<?php } else if(!empty($this->session->flashdata('Success'))) {?>
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?= $this->session->flashdata('Success') ?>
</div>
<?php }else if(!empty($this->session->flashdata('Info'))) {?>
<div class="alert alert-info alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?= $this->session->flashdata('Info') ?>
</div>
<?php }?>

<div class="container">
    <div class="login-page">

        <div class="form" name="myForm">
            <form method="post" action="<?= base_url('auth')?>">

                <div style="text-align: center; margin-bottom: 10px">
                    <center><img class="img-responsive" src="<?= base_url() ?>assets/img/logo.png"></center>
                    <font style="font-family: verdana;font-weight: 900;font-size: 2em;color: #F07D00">ASDP</font>
                    <font style="font-family: 'Trebuchet MS';font-weight: bolder;font-size: 2em; color: #005DAA">Indonesia Ferry</font>
                    <br>
                    <font style=" font-size : 15px; font-weight: 400">Customer Relationship Management</font>
                </div>

                <div class="form-group has-feedback">
                    <input name="username" class="form-control has-feedback-left" id="username" type="email" placeholder="username" required />
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" class="form-control has-feedback-left" id="password" type="password" placeholder="password" required />
                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                </div>
                <input type="submit" class="button" value="Login">
            </form>
        </div>
    </div>
</div>
