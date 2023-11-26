CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    author VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    tag VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    date_creation DATE NOT NULL,
    is_admin BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    news_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS movies (
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_image VARCHAR(255),
    movie_trailer VARCHAR(255),
    title VARCHAR(255) NOT NULL,
    release_date DATE,
    genre VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS producers (
    producer_id INT AUTO_INCREMENT PRIMARY KEY,
    producer_name VARCHAR(100) NOT NULL,
    producer_date_of_birth DATE,
    producer_date_of_death DATE,
    producer_nationality VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS directors (
    director_id INT AUTO_INCREMENT PRIMARY KEY,
    director_name VARCHAR(100) NOT NULL,
    director_date_of_birth DATE,
    director_date_of_death DATE,
    director_nationality VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS actors (
    actor_id INT AUTO_INCREMENT PRIMARY KEY,
    actor_name VARCHAR(100) NOT NULL,
    actor_date_of_birth DATE,
    actor_date_of_death DATE,
    actor_nationality VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- tablica za uspostavu veze između movies i producers
CREATE TABLE IF NOT EXISTS movie_producer (
    movie_id INT,
    producer_id INT,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
    FOREIGN KEY (producer_id) REFERENCES producers(producer_id),
    PRIMARY KEY (movie_id, producer_id)
);

-- tablica za uspostavu veze između movies i directors
CREATE TABLE IF NOT EXISTS movie_director (
    movie_id INT,
    director_id INT,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
    FOREIGN KEY (director_id) REFERENCES directors(director_id),
    PRIMARY KEY (movie_id, director_id)
);

-- tablica za uspostavu veze između movies i actors
CREATE TABLE IF NOT EXISTS movie_actor (
    movie_id INT,
    actor_id INT,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
    FOREIGN KEY (actor_id) REFERENCES actors(actor_id),
    PRIMARY KEY (movie_id, actor_id)
);


INSERT INTO producers (producer_name, producer_date_of_birth, producer_date_of_death, producer_nationality)
VALUES
    ('Gary Kurtz', '1940-07-27', '2018-09-23', 'USA'),
    ('Howard Kazanjian', '1942-07-26', NULL, 'USA'),
    ('Peter Jackson', '1961-10-31', NULL, 'New Zealand');


INSERT INTO directors (director_name, director_date_of_birth, director_date_of_death, director_nationality)
VALUES
    ('George Lucas', '1985-03-10', NULL, 'USA'),
    ('Irvin Kershner', '1923-04-29', '2010-11-27', 'USA'),
    ('Richard Marquand', '1937-09-22', '1987-09-04', 'UK'),
    ('Peter Jackson', '1961-10-31', NULL, 'New Zealand');

INSERT INTO actors (actor_name, actor_date_of_birth, actor_date_of_death, actor_nationality)
VALUES
    ('Mark Hamill', '1951-09-25', NULL, 'USA'),
    ('Harrison Ford', '1942-07-13', NULL, 'USA'),
    ('Carrie Fisher', '1956-10-21', '2016-12-27', 'USA'),
    ('Elijah Wood', '1981-28-01', NULL, 'USA'),
    ('Viggo Mortensen', '1958-20-10', NULL, 'USA'),
    ('Liv Tyler', '1977-07-01', NULL, 'USA');


INSERT INTO movies (movie_image, movie_trailer, title, release_date, genre)
VALUES
    ('/home/iznaor/Downloads/movies/swhope.jpg', 'https://www.youtube.com/watch?v=7L8p7_SLzvU&feature=youtu.be', 'Star Wars: Episode IV – A New Hope', '1977-05-25', 'science fiction'),
    ('/home/iznaor/Downloads/movies/swempire.jpg', 'https://youtu.be/JNwNXF9Y6kY', 'Star Wars: Episode V – The Empire Strikes Back', '1980-05-21', 'science fiction'),
    ('/home/iznaor/Downloads/movies/swjedi.jpg', 'https://youtu.be/7L8p7_SLzvU', 'Star Wars: Episode VI – Return of the Jedi', '1983-05-25', 'science fiction'),
    ('/home/iznaor/Downloads/movies/lordf.jpg', 'https://youtu.be/_nZdmwHrcnw', 'The Lord of the Rings: The Fellowship of the Ring', '2001-12-10', 'fantasy'),
    ('/home/iznaor/Downloads/movies/lordt.jpg', 'https://youtu.be/nuTU5XcZTLA', 'The Lord of the Rings: The Two Towers', '2002-12-05', 'fantasy'),
    ('/home/iznaor/Downloads/movies/lotrr.jpg', 'https://youtu.be/zckJCxYxn1g', 'The Lord of the Rings: The Return of the King', '2003-12-01', 'fantasy');



-- Movie Star Wars: Episode IV – A New Hope producent Gary Kurtz direktor George Lucas
INSERT INTO movie_producer (movie_id, producer_id)
VALUES (1, 1);

INSERT INTO movie_director (movie_id, director_id)
VALUES (1, 1);

-- Movie Star Wars: Episode IV – A New Hope glumci  Mark Hamill, Harrison Ford, Carrie Fisher
INSERT INTO movie_actor (movie_id, actor_id)
VALUES (1, 1), (1, 2), (1, 3);

-- -------------------------------------------------------------------------------------------------------
INSERT INTO movie_producer (movie_id, producer_id)
VALUES (2, 1);

INSERT INTO movie_director (movie_id, director_id)
VALUES (2, 2);

INSERT INTO movie_actor (movie_id, actor_id)
VALUES (2, 1), (2, 2), (2, 3);
-- -----------------------------------------------------------------
INSERT INTO movie_producer (movie_id, producer_id)
VALUES (3, 2);

INSERT INTO movie_director (movie_id, director_id)
VALUES (3, 3);

INSERT INTO movie_actor (movie_id, actor_id)
VALUES (3, 1), (3, 2), (3, 3);

-- -----------------------------------------------------------------

INSERT INTO movie_director (movie_id, director_id)
VALUES (4, 4), (5,4), (6,4);

INSERT INTO movie_producer (movie_id, producer_id)
VALUES (4, 3), (5,3), (6,3);

INSERT INTO movie_actor (movie_id, actor_id)
VALUES (4, 4), (4, 5), (4, 6), (5, 4), (5, 5), (5, 6), (6, 4), (6, 5), (6, 6);

INSERT INTO news (title, image, author, date, content, tag)
VALUES
    ('Ridley Scotts Napoleon is projected to open between $32 and $33 million at the domestic box office', '/home/iznaor/Downloads/movies/napoleon.jpg', 'BRENNAN KLEIN', '2023-11-25', 'Napoleon has broken a box office curse for director Ridley Scott. The movie, which follows the rise and fall of the titular French leader, stars Joaquin Phoenix in the lead role. The story also focuses on Napoleons relationship with his first wife, Empress Joséphine (Vanessa Kirby). After its Thanksgiving weekend premiere, it is set to stream on Apple TV+ at an as-yet undisclosed date.', 'NEW');

INSERT INTO news (title, image, author, date, content, tag)
VALUES
    ('Deadpool 3 Resumes Filming After Strike Delay', '/home/iznaor/Downloads/movies/deadpool3.jpg','JEREMY DICK', '2023-11-25', 'Deadpool 3 has resumed production, now on track to make its Summer 2024 release date. On Instagram, Marvel Studios executive Wendy Jacobson shared a post to address what she was thankful for in honor of the Thanksgiving holiday. She spoke about getting back to work and hyping the returns of the stars of Deadpool 3 in 2024, confirming that production has resumed on the sequel.', 'NEW');







