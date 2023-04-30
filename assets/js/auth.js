/**
 * Элемент формы регистрации
 * @type {HTMLElement}
 */
const formRegistration = document.getElementById('formRegistration');

/**
 * Элемент формы авторизации
 * @type {HTMLElement}
 */
const formAuthorization = document.getElementById('formAuthorization');

/**
 * Отправка формы регистрации
 *
 * @returns {Promise<void>}
 */
async function sendingRegistrationData()
{
  let url = '/admin/register-form/';
  let formData = new FormData(formRegistration);

  // проверка валидности введенного e-mail
  if (!validateEmail(formData.get('email'))) {
    messageForForm(formRegistration, 'Введите корректный E-mail.');
    return;
  }

  // подтверждение пароля
  if (formData.get('password') === formData.get('confirm-password')) {
    // поле подтверждения пароля отправлять не нужно
    formData.delete('confirm-password');

    let response = await requestFetch(url, formData, 'POST');

    if (response.ok) {
      let res = await response.json();

      if (res['email']) {
        messageForForm(formRegistration,'Электронный адрес занят');
      } else if (res['login']) {
        messageForForm(formRegistration,'Логин занят');
      } else {
        window.location.href = '/admin/login/';
      }

    } else {
      console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
    }

  } else {
    messageForForm(formRegistration,'Пароли не совпадают');
  }

}

/**
 * Авторизация пользователя
 *
 */
async function sendingAuthorizationData()
{
  let url = '/admin/login-form/'; // адрес авторизации пользователя
  let formData = new FormData(formAuthorization); // данные с формы
  // отправляем запрос на сервер
  let response = await requestFetch(url, formData, 'POST');

  if (response.ok){
    let res = await response.json();
    if (res['status']) {
      window.location.href = '/admin/';
    } else {
      messageForForm(formAuthorization,'Неверный логин или пароль.');
    }
  } else {
    console.log('Произошла ошибка запроса на сервер: ' + response.statusText);
  }
}

/**
 * Валидация e-mail
 * @param email
 */
function validateEmail(email)
{
  let pattern = /^[\w%.\-+]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/i;
  return pattern.test(String(email));
}

if (formRegistration != null) {
  formRegistration.addEventListener('submit', (event) => {
    event.preventDefault();
    messageErrorClear();
    sendingRegistrationData();
  });
}

if (formAuthorization != null) {
  formAuthorization.addEventListener('submit', (event) => {
    event.preventDefault();
    messageErrorClear();
    sendingAuthorizationData();
  });
}

