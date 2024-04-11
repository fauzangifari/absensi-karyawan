<div class="container">

    <?php if (isset($model['error'])) { ?>
    <div class="alert alert-danger mt-4" role="alert">
        <?=$model['error']?>
    </div>
    <?php } ?>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" method="post" action="/register">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="name"
                                       placeholder="Employee Name" name="name" value="<?= $POST['name'] ?? ''?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="address"
                                       placeholder="Address" name="address" value="<?= $POST['address'] ?? ''?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="phone_number"
                                       placeholder="Phone Number" name="phone_number" value="<?= $POST['phone_number'] ?? ''?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="username"
                                       placeholder="Username" name="username">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           id="password" placeholder="Password" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                           id="repeat_password" placeholder="Repeat Password">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-user btn-block" type="submit">
                                Register Account
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="/login">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
