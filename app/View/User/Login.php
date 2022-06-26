<div class="container">
        <section class="login">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-6 login-card shadow" style="padding: 80px 50px; background-color: #fff; border-radius: 20px;">
                    <h1 class="text-center mb-5">LOGIN</h1>
                    <?php if(isset($model['error'])) { ?>
                        <div class="row">
                            <div class="alert alert-danger" role="alert">
                                <?= $model['error'] ?>
                            </div>
                        </div>
                    <?php } ?>
                    <form action="/users/login" method="POST">
                        <div class="col mb-3">
                            <input type="text" class="form-control" name="username" id="username"required>
                            <label for="username">Username</label>
                        </div>
                        <div class="col mb-4">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="col text-center mt-4">
                            <button type="submit" class="btn btn-dark" name="login" style="width: 100%;">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>