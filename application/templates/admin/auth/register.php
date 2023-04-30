
  <div class="col-lg-5 col-12">
    <div id="auth-left">
      <div class="auth-logo">
        <a href="index.html"><img src="../../assets/images/logo/logo.svg" alt="Logo" /></a>
      </div>
      <h1 class="auth-title">Регистрация</h1>
      <p class="auth-subtitle">
        Введите свои данные для регистрации на нашем веб-сайте.
      </p>
      <form id="formRegistration" method="post" action="/admin/register-form/">
        <div class="form-group position-relative has-icon-left mb-4">
          <input type="email" name="email" id="email" class="form-control form-control-xl" placeholder="E-mail" required/>
          <div class="form-control-icon">
            <i class="bi bi-envelope"></i>
          </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
          <input type="text" name="login" id="login" class="form-control form-control-xl" placeholder="Логин" required/>
          <div class="form-control-icon">
            <i class="bi bi-person"></i>
          </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
          <input type="password" name="password" id="password" class="form-control form-control-xl" placeholder="Пароль" required/>
          <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
          </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
          <input type="password" name="confirm-password" id="confirm-password" class="form-control form-control-xl" placeholder="Подтвердите пароль" required/>
          <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
          </div>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <button class="btn btn-primary btn-block btn-lg shadow-lg">
          Зарегистрироваться
        </button>
      </form>
      <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600">
          У вас уже есть учетная запись?
          <a href="/admin/login/" class="font-bold">Авторизоваться</a>
        </p>
      </div>
    </div>
  </div>
  <div class="col-lg-7 d-none d-lg-block">
    <div id="auth-right"></div>
  </div>
