# YoWindow Widget Plugin

# Описание плагина

Плагин предоставляет виджет для удобной вставки погоды от YoWindow в свой блог на движке WordPress.

Настройки такие же, как на странице виджета с сайта YoWindow.com.

Плагин не умеет автоматически определять текущее местоположение пользователя, поэтому специальный идентификатор вам надо будет получить на странице определения местоположения.

## Установка и активация

Скачать плагин по ссылке: yowindow-widget.0.0.4.zip
Распаковать плагин в папку wp-content/plugins
Активировать плагин в админке на странице Плагины → Установленные
Вставить и настроить виджет на странице Внешний вид → Виджеты
Некоторые пояснения

Как уже говорилось выше — определение местоположения не работает, идентификатор надо раздобыть на специальной странице (в настройках плагина есть ссылка)
Добавлен тип пейзажа «Любой». Этой настройкой включается выбор пейзажа в зависимости от текущего дня
Есть возможность загружать информер с собственного сервера. Для этого необходимо создать папку yowindow в каталоге с плагином и распаковать туда yowidget_standalone.zip
История версий

0.0.1 — первая публичная версия плагина
0.0.2 — исправлено действие по клику, добавлен флажок для автоматического вычисления ширины, добавлена поддержка standalone версии информера
0.0.3 — добавлен пользовательский системы измерения
0.0.4 — исправлен режим пейзажа «Любой», добавлен выбор фонового цвета, добавлена возможность скрывать виджет в мобильной теме Jetpack

## Plugin description

Plugin provides a widget which allows you to easily add weather from YoWindow into your blog on WordPress engine.

It has the same settings as widget’s web-page on YoWindow.com web-site.

Plugin cannot automatically determine current user location. That’s why you have to go to a page and get location Id.

## Installation guide

Download plugin: yowindow-widget.0.0.4.zip
Unzip the file to your plugins folder (wp-content/plugins)
Go to Plugins → Installed Plugins in the admin dashboard and activate it
Drag-and-drop YoWindow widget title bar into an open widget area on page Appearance → Widgets
Other notes

As it’s said — detection of user’s location doesn’t work, you need to get location ID on a specific page (there is a link in plugin’s settings)
«Random» type of landscape has been added. This setting enables possibility to choose a landscape depending on a current day
There is an opportunity to host yowindow widget on your server. To do this you need to create yowindow folder in a directory with a plugin and unzip yowidget_standalone.zip into that folder
Revisions history

0.0.1 — first public release
0.0.2 — fixed action by mouse click, added «Stretch to widget area width» option, added support standalone weather widget
0.0.3 — added «Custom» unit system
0.0.4 — fixed «Random» landscape, added choice background color, added possibility hide widget if Jetpack mobile theme is shown
