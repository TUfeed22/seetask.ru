/**
 * Элемент формы "Основная информация" на странице профиля пользователя
 * @type {HTMLElement}
 */
const formBasicInformation = document.getElementById('formBasicInformation');

/**
 * Текущий год в footer
 * @type {Element}
 */
let yearTag = document.querySelector('#currentYear');
if (yearTag) {
    yearTag.innerHTML = '<p>' + currentYear() + ' &copy; TDash</p>';
}

/**
 * Текущий год
 * @returns {number}
 */
function currentYear()
{
    let toDay = new Date();
    return toDay.getFullYear();
}

let test = document.getElementById('test');
if (test != null) {
    test.addEventListener('click', function (){
        notification("linear-gradient(to right, #ff5f6d, #ffc371)", "Очень умный текст для уведомления");
    })
}

/**
 * Всплывающее уведомление
 * @param styleBackground Цвет фона уведомления
 * @param message Сообщение
 */
function notification(styleBackground, message)
{
    Toastify({
        text: message, // текст сообщения
        duration: 3000, // видимость
        newWindow: false,
        close: false, // кнопка закрытия
        gravity: "top", // позиция `top` или `bottom`
        position: "center", // позиция `left`, `center` или `right`
        stopOnFocus: true,
        style: {
            background: styleBackground, // цвет фон
        },
    }).showToast();
}

async function sendingBasicInformationUserData()
{
    let url = '/admin/user/basic-information/';
    let formData = new FormData(formBasicInformation);

    let response = await requestFetch(url, formData, 'POST');

    if (response.ok) {
        let res = await response.json();

        if (!res['status']) {
            notification("#f3616d", res['message']);
        } else if (res['status']) {
            notification("#198754", res['message']);
        }
    } else {
        notification("#f3616d", `Произошла ошибка запроса на сервер: ${response.statusText}`);
    }
}

/**
 * Удаляем сообщения об ошибках
 */
function messageErrorClear()
{
    let error = document.querySelector('.error');
    if (error) {
        error.remove();
    }
}

/**
 * Выводим блок с сообщением для формы.
 *
 * @param elementForm элемент формы
 * @param message сообщение об ошибке
 */
function messageForForm(elementForm, message)
{

    let div = document.createElement('div');
    let text = document.createElement('p');

    div.classList.add('error');
    text.classList.add('error-msg');

    text.innerHTML = message;

    div.append(text);

    elementForm.prepend(div);

}

/**
 * Отправка данных на сервер
 * @param url
 * @param formData
 * @param method
 * @returns {Promise<Response>}
 */
async function requestFetch(url, formData, method)
{
    return await fetch(url, {
        method: method,
        body: formData,
    });
}

/**
 * Удаление пустых данных формы
 * @param formData
 * @returns {FormData}
 */
function removeEmptyFormData(formData)
{
    let notEmptyFormData = new FormData();

    for (let [key, value] of formData) {
        if (value !== '' || typeof value !== 'string') {
            notEmptyFormData.append(key, value);
        }
    }
    return notEmptyFormData;
}

if (formBasicInformation != null) {
    formBasicInformation.addEventListener('submit', (event) => {
        event.preventDefault();
        messageErrorClear();
        sendingBasicInformationUserData();
    });
}