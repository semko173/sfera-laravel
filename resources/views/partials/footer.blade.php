<footer>
    <div id="footer_container">
        <div id="footer_menu">
            <!-- Блок контактов -->
            <div id="footer_icons">
                <a id="logo_footer" name="logo_footer" href="{{ url('/') }}"></a>
                <span class="footer__contacts__phone">
                    <a href="tel:+78003011169">+7 800 301-11-69</a>
                    <span class="footer__contacts__phone2">звонок бесплатный</span>
                </span>
                <span class="footer__contacts__phone">
                    <a href="tel:+74951850985">+7 495 185-09-85</a>
                    <span class="footer__contacts__phone2">9:00 - 23:00<br>без&nbsp;выходных</span>
                </span>
                <span class="footer__contacts__phone">
                    <span class="footer__contacts__phone2">e-mail:</span>
                    <a href="mailto:info@masterglasses.ru">info@masterglasses.ru</a>
                </span>
            </div>

            <!-- Колонки меню -->
            <ul class="footer_links">
                <li><b>Каталог</b></li>
                <li><a href="/catalog/?category[]=1">Солнцезащитные очки</a></li>
                <li><a href="/catalog/?category[]=2">Оправы</a></li>
                <li><a href="/catalog/?brands[]=2">Ray-Ban</a></li>
            </ul>

            <ul class="footer_links">
                <li><b>Покупателю</b></li>
                <li><a href="/basket/">Корзина</a></li>
                <li><a href="/profile/">Личный кабинет</a></li>
                <li><a href="/delivery/">Доставка и оплата</a></li>
            </ul>

            <ul class="footer_links" style="width:290px;">
                <li><b>Информация</b></li>
                <li><a href="/about/">О компании</a></li>
                <li><a href="/guarantee/">Гарантии</a></li>
            </ul>
        </div>

        <div id="copy">
            © 2013—{{ date('Y') }} оптика «МастерГлассес»
        </div>
    </div>
</footer>

<!-- Кнопка для чата поддержки -->
@includeIf('partials.support_chat')