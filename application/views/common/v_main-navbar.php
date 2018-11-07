<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu custom-nav" style="">
        <nav>
            <div class="nav toggle" style="width:10%">
                <a id="menu_toggle"><i class="fa fa-bars" style="color:white; top:5px"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right" style="width:90%">
                <li class="" style="width:30%;color:white">
                    <span href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="cursor:pointer"><i class="fa fa-3x fa-user simbol2"></i> Halo, <strong>
                            <?= $this->session->userdata('ldap_name')?></strong> <i class="fa fa-angle-down"></i></span>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <?php if($this->session->userdata('ldap_password') != NULL){?>
                        <li><a data-toggle="modal" data-target="#passModal"> Change Password</a></li>
                        <?php }?>
                        <li><a href="<?=base_url('login/logout')?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>

                <li class="nav-center" style="width:60%">
                    <?php if($this->session->userdata('ldap_level') == 0 || $this->session->userdata('ldap_level') == 1) {?>
                    <form action="<?= base_url()?>dashboard/search">
                        <div class="nav form-group has-feedback" style="width:80%;float:left">
                            <input name="search-bar" id="search-bar" class="form-control has-feedback-left cari-input" type="search" placeholder="Cari.." required />
                            <span class="fa fa-search form-control-feedback left" aria-hidden="true" style="margin-top: 6px;height: 23px;border: 0px;color: #777;line-height: 22px;font-size: 25px;"></span>
                        </div>
                        <div class="nav form-group" style="width:20%;float:right">
                            <button type="submit" class="btn-search">Cari</button>
                        </div>
                    </form>
                    <?php } ?>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
<div class="right_col" role="main">
    <div class="">
