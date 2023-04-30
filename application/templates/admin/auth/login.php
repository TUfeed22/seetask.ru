
  <div class="col-lg-5 col-12" style="position: relative;">
    <div id="auth-left">
      <div class="auth-logo">
        <a href="/"><img src="../../assets/images/logo/logo.svg" alt="Logo" /></a>
      </div>
      <h1 class="auth-title">Авторизация</h1>
      <p class="auth-subtitle mb-4">
        Войдите в систему, используя свои учетные данные.
      </p>
      <form id="formAuthorization" method="post">
        <div class="form-group position-relative has-icon-left mb-4">
          <input type="text" id="login" name="login" class="form-control form-control-xl" placeholder="Логин" required/>
          <div class="form-control-icon">
            <i class="bi bi-person"></i>
          </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
          <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Пароль" required/>
          <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
          </div>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg">
          Авторизоваться
        </button>
      </form>
      <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600">
          У вас нет учетной записи?
          <a href="/admin/register/" class="font-bold">Зарегистрироваться</a>.
        </p>
        <p>
          <a class="font-bold" href="auth-forgot-password.html">Забыли пароль?</a>
        </p>
      </div>
    </div>
  </div>
  <div class="col-lg-7 d-none d-lg-block">
    <div id="auth-right"></div>
  </div>