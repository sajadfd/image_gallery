## Создать скрипт генерации jpg картинки и галерею для демонстрации его работы.
### - Генератор изображений - generator.php
-	Исходники картинок хранятся в папке gallery.
-	Get-параметры: name(название картинки без расширения) и size(код размера).
-	Список размеров для генерации хранится в MySql:
-		"big" - 800 * 600,  "med" - 640 * 480,  "min" - 320 * 240,  "mic" - 150 * 150
-	Указаны максимальные размеры сторон, при масштабировании пропорции сохраняются.
-	Результат работы скрипта – jpg-картинка заданного размера.
-	Сгенерированное изображение сохраняется в папке cache. Если есть кеш, повторно не генерируем.
### - Галерея – demo.php
-	SRC картинок указывает на generator.php(с нужными параметрами).
-	Для демонстрации работы генератора, плиткой выводим 10 превью-картинок.
-	Превью – картинка в минимальном размере, в зависимости типа от устройства.
-	При клике на превью, на той же странице открывается любая jquery галерея. В ней можно увидеть картинку во всех допустимых для устройства размерах.
-	Ограничения для устройств:
   Мобильные устройства – не выводятся big картинки
   Desktop – не выводятся mic картинки
### - Общие требования
-	Максимальная оптимизация.
-	Все возможные ошибки должны обрабатываться.
-	Любая инициатива улучшить работу скрипта, при соблюдении требований, приветствуется и учитывается при проверке.
 
