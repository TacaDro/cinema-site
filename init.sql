CREATE DATABASE IF NOT EXISTS movies_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE movies_db;
CREATE TABLE IF NOT EXISTS movies (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  year SMALLINT UNSIGNED NOT NULL,
  genre VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  poster_url VARCHAR(500) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (year), INDEX (genre)
) ENGINE=InnoDB;

INSERT INTO movies (title, year, genre, description, poster_url) VALUES
('Брат 2', 2000, 'боевик', 'Продолжение истории Данилы Багрова.', 'https://m.media-amazon.com/images/I/81Jxk3nK6oL._AC_SY679_.jpg'),
('Интерстеллар', 2014, 'фантастика', 'Путешествие сквозь червоточину ради спасения человечества.', 'https://m.media-amazon.com/images/I/71n58h0cB9L._AC_SY679_.jpg'),
('Большой куш', 2000, 'криминал', 'История о подпольном боксе и бриллиантах.', 'https://m.media-amazon.com/images/I/91mKq3b8l+L._AC_SY679_.jpg'),
('Матрица', 1999, 'фантастика', 'Нео узнаёт правду о мире и вступает в борьбу с машинами.', 'https://m.media-amazon.com/images/I/51EG732BV3L.jpg'),
('Властелин колец: Братство кольца', 2001, 'фэнтези', 'Хоббит Фродо получает Кольцо Всевластья и отправляется в опасное путешествие.', 'https://m.media-amazon.com/images/I/51Qvs9i5a%2BL.jpg'),
('Темный рыцарь', 2008, 'боевик', 'Бэтмен сталкивается с Джокером, который терроризирует Готэм.', 'https://m.media-amazon.com/images/I/51zUbui%2BgbL.jpg'),
('Форрест Гамп', 1994, 'драма', 'История простого парня, ставшего свидетелем важных событий XX века.', 'https://m.media-amazon.com/images/I/61KcZybGgfL._AC_SY679_.jpg'),
('Начало', 2010, 'фантастика', 'Команда воров внедряется в сны, чтобы украсть идеи.', 'https://m.media-amazon.com/images/I/51nbVEuw1HL.jpg'),
('Гладиатор', 2000, 'исторический', 'Римский генерал Максимус становится гладиатором, чтобы отомстить.', 'https://m.media-amazon.com/images/I/51A1rQ7ZQ2L.jpg'),
('Побег из Шоушенка', 1994, 'драма', 'История побега Энди Дюфрейна из тюрьмы Шоушенк.', 'https://m.media-amazon.com/images/I/519NBNHX5BL.jpg'),
('Криминальное чтиво', 1994, 'криминал', 'Переплетающиеся истории бандитов.', 'https://m.media-amazon.com/images/I/71c05lTE03L._AC_SY679_.jpg'),
('Терминатор 2: Судный день', 1991, 'боевик', 'Терминатор защищает Джона Коннора.', 'https://m.media-amazon.com/images/I/51eg55uWmdL.jpg'),
('Крестный отец', 1972, 'криминал', 'История семьи Корлеоне.', 'https://m.media-amazon.com/images/I/41%2B5hGUc6-L.jpg'),
('Зеленая миля', 1999, 'драма', 'Надзиратель сталкивается с необычным заключённым.', 'https://m.media-amazon.com/images/I/51MyxwQJpDL.jpg'),
('Титаник', 1997, 'драма', 'История любви на фоне катастрофы «Титаника».', 'https://m.media-amazon.com/images/I/51rOnIjLqzL.jpg'),
('Шрек', 2001, 'мультфильм', 'Огр Шрек отправляется спасать принцессу.', 'https://m.media-amazon.com/images/I/51FQ4drmTfL.jpg'),
('Леон', 1994, 'боевик', 'Наемный убийца Леон и девочка Матильда.', 'https://m.media-amazon.com/images/I/51IiQ0WwsmL.jpg');
