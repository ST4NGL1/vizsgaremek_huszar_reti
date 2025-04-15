CREATE TABLE kategoriak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nev VARCHAR(50) NOT NULL
);

CREATE TABLE ingatlanok (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategoria_id INT,
    leiras TEXT NOT NULL,
    hirdetesDatuma DATE DEFAULT CURRENT_DATE,
    tehermentes TINYINT NOT NULL,
    ar INT NOT NULL,
    kepUrl VARCHAR(255) NOT NULL,
    FOREIGN KEY (kategoria_id) REFERENCES kategoriak(id)
);




INSERT INTO kategoriak (id, nev) VALUES
(1, 'Ház'),
(2, 'Lakás'),
(3, 'Építési telek'),
(4, 'Garázs'),
(5, 'Mezőgazdasági terület'),
(6, 'Ipari ingatlan');

INSERT INTO ingatlanok (id, kategoria_id, leiras, hirdetesDatuma, tehermentes, ar, kepUrl) VALUES
(1, 1, 'Kertvárosi részén, egyszintes házat kínálunk nyugodt környezetben, nagy telken.', '2022-03-09', 1, 26990000, 'https://cdn.jhmrad.com/wp-content/uploads/three-single-storey-houses-elegance-amazing_704000.jpg'),
(2, 1, 'Belvárosi környezetben, árnyékos helyen kis méretú családi ház eladó. Tömegközlekedéssel könnyen megközelíthető.', '2022-03-16', 1, 28990000, 'https://www.westsideseattle.com/sites/default/files/styles/news_teaser/public/images/archive/ballardnewstribune.com/content/articles/2008/11/21/features/columnists/column07.jpg?itok=wMrlOwFU'),
(3, 2, 'Kétszintes berendezett lakás a belvárosban kiadó.', '2022-03-12', 1, 32000000, 'https://images.unsplash.com/photo-1606074280798-2dabb75ce10c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80'),
(4, 4, 'Nagy garázs kertvárosi környezetben kiadó.', '2022-03-14', 1, 5990000, 'https://www.afritechmedia.com/wp-content/uploads/2021/11/How-Can-You-Protect-Your-Garage-Floor-612x340.jpg'),
(5, 5, '10 hektáros mezőgazdasági terület eladó.', '2022-03-18', 1, 79000000, 'https://i2-prod.manchestereveningnews.co.uk/incoming/article18411144.ece/ALTERNATES/s810/0_gettyimages-1151774950-170667a.jpg'),
(6, 6, 'Felújításra szoruló üzemcsarnok zöld környezetben áron alul eladó.', '2022-03-11', 0, 25000000, 'https://cdn.pixabay.com/photo/2019/01/31/09/24/urban-3966306_960_720.jpg');

