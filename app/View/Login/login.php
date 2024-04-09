<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <?php if (isset($model['error'])) { ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?=$model['error']?>
            </div>
        <?php } ?>

        <div class="col-xl-12 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                               id="username" aria-describedby="emailHelp"
                                               placeholder="Enter Username" name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                               id="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="role" id="role">
                                            <option value="selectrole">Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="manajer">Manajer</option>
                                            <option value="karyawan">Karyawan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit">
                                        Login
                                    </button>
                                    <hr>
                                </form>
                                <div class="text-center">
                                    <a class="small" href="/register">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('remember') === 'true') {
            document.getElementById('username').value = localStorage.getItem('username') || '';
            document.getElementById('role').value = localStorage.getItem('role') || 'selectrole';
            document.getElementById('customCheck').checked = true;
        }
    });

    document.getElementById('customCheck').addEventListener('change', function() {
        var isChecked = this.checked;
        var username = document.getElementById('username').value;
        var role = document.getElementById('role').value;

        if (isChecked) {
            localStorage.setItem('remember', 'true');
            localStorage.setItem('username', username);
            localStorage.setItem('role', role);
        } else {
            localStorage.removeItem('remember');
            localStorage.removeItem('username');
            localStorage.removeItem('role');
        }
    });

    document.getElementById('role').addEventListener('change', function() {
        if (document.getElementById('customCheck').checked) {
            localStorage.setItem('role', this.value);
        }
    });

    document.getElementById('username').addEventListener('input', function() {
        if (document.getElementById('customCheck').checked) {
            localStorage.setItem('username', this.value);
        }
    });
</script>


