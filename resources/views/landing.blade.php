<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кварта — свежая обжарка кофе в Минске</title>
    <meta name="description"
          content="Маленькая мастерская обжарки в Минске. Обжариваем по четвергам, доставляем в пятницу.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <div class="grid">
        <div class="block header">
            <div class="logo">Кварта</div>
            <div class="nav">
                <a href="#products">Ассортимент</a>
                <a href="#form">Заявка</a>
                <a href="#contacts">Контакты</a>
            </div>
            <div class="header-address">Минск, ул. Короля, 9</div>
        </div>
    </div>

    <div class="grid">
        <div class="block hero">
            <h1>Свежая<br>обжарка.<br>Четверг.</h1>
            <p>Маленькая мастерская в Минске. Обжариваем партиями по 5 кг. Доставляем в пятницу — вы получаете зерно на
                1–3 день после обжарки.</p>
        </div>
    </div>

    <div class="grid">
        <div class="block info-block">
            <h3>Обжарка</h3>
            <p>Каждый четверг</p>
        </div>
        <div class="block info-block">
            <h3>Доставка</h3>
            <p>Пятница, по Минску</p>
        </div>
        <div class="block info-block">
            <h3>Самовывоз</h3>
            <p>Пн–Пт 8:00–20:00</p>
        </div>
    </div>

    <div class="grid" id="products">
        <div class="block product">
            <div class="product-img">
                <img src="{{ asset('images/ethiopia.png') }}" alt="Эфиопия"
                     onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'font-size:12px;color:#999\'>Фото</span>'">
            </div>
            <div>
                <div class="product-title">Эфиопия<br>Иргачеффе</div>
                <div class="product-desc">цветочный, бергамот, светлая обжарка · 250 г</div>
                <div class="product-price">32 BYN</div>
            </div>
        </div>
        <div class="block product">
            <div class="product-img">
                <img src="{{ asset('images/colombia.png') }}" alt="Колумбия"
                     onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'font-size:12px;color:#999\'>Фото</span>'">
            </div>
            <div>
                <div class="product-title">Колумбия<br>Уила</div>
                <div class="product-desc">карамель, красное яблоко · 250 г</div>
                <div class="product-price">29 BYN</div>
            </div>
        </div>
        <div class="block product">
            <div class="product-img">
                <img src="{{ asset('images/brazil.png') }}" alt="Бразилия"
                     onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'font-size:12px;color:#999\'>Фото</span>'">
            </div>
            <div>
                <div class="product-title">Бразилия<br>Серрадо</div>
                <div class="product-desc">орех, шоколад, под эспрессо · 250 г</div>
                <div class="product-price">26 BYN</div>
            </div>
        </div>
        <div class="block product">
            <div class="product-img">
                <img src="{{ asset('images/drip.png') }}" alt="Дрип-пакеты"
                     onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'font-size:12px;color:#999\'>Фото</span>'">
            </div>
            <div>
                <div class="product-title">Дрип-пакеты<br>Ассорти</div>
                <div class="product-desc">10 штук в коробке</div>
                <div class="product-price">18 BYN</div>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="block subscription">
            <div>
                <h2>Подписка на кофе</h2>
                <p>2 пачки по 250 г раз в месяц. Доставка бесплатно.</p>
            </div>
            <div class="sub-price">54 BYN / мес</div>
        </div>
    </div>

    <div class="grid" id="form">
        <div class="block form-block">
            <div>
                <h2 style="font-size: 40px; font-weight: 700; line-height: 1; letter-spacing: -0.03em; margin-bottom: 20px;">
                    Оставить<br>заявку</h2>
                <p style="font-size: 16px; max-width: 300px;">Менеджер перезвонит, уточнит детали и оформит заказ.
                    Оплата при получении.</p>
                <div id="contacts" style="margin-top: 40px;">
                    <p style="font-size: 14px; color: #666; margin-bottom: 5px;">Связаться напрямую:</p>
                    <p style="font-size: 20px; font-weight: 700;">+375 (29) 123-45-67</p>
                </div>
            </div>

            <form id="leadForm">
                <div class="form-group">
                    <label>Ваше имя</label>
                    <input type="text" name="name" required placeholder="Иван">
                    <div class="error-text" data-error="name"></div>
                </div>
                <div class="form-group">
                    <label>Телефон</label>
                    <input type="tel" name="phone" required placeholder="+375 29 123-45-67">
                    <div class="error-text" data-error="phone"></div>
                </div>
                <div class="form-group">
                    <label>Что интересует</label>
                    <select name="interest">
                        <option value="order">Разовый заказ</option>
                        <option value="subscription">Подписка</option>
                        <option value="question">Вопрос</option>
                    </select>
                    <div class="error-text" data-error="interest"></div>
                </div>
                <div class="form-group">
                    <label>Комментарий (необязательно)</label>
                    <textarea name="comment" rows="3" placeholder="Например, нужен помол под воронку"></textarea>
                    <div class="error-text" data-error="comment"></div>
                </div>
                <button type="submit" class="btn" id="submitBtn">Отправить заявку</button>

                <div id="formSuccess" class="success-message">Спасибо! Заявка принята. Мы свяжемся с вами в ближайшее
                    время.
                </div>
                <div id="formError" class="error-message">Произошла ошибка при отправке. Попробуйте позже или позвоните
                    нам.
                </div>
            </form>
        </div>
    </div>

    <div class="grid">
        <div class="block footer">
            <div>© 2026 Обжарка «Кварта»</div>
            <div>Минск, ул. Короля, 9</div>
        </div>
    </div>
</div>
</body>
</html>