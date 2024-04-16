-- a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur 

SELECT movie.title AS 'titre', DATE_FORMAT(movie.releaseDate, '%Y') AS 'année de sortie',movie.timeMovie AS 'durée', CONCAT(person.firstName, ' ', person.lastName) AS 'director'
FROM movie m
INNER JOIN director d
ON m.id_director = d.id_director
INNER JOIN person p
ON d.id_person = p.id_person
GROUP BY m.id_movie;

-- b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)

SELECT m.title, m.timeMovie
FROM movie m
WHERE m.timeMovie >= 135
ORDER BY m.timeMovie DESC; 

-- c. Liste des films d’un réalisateur (en précisant l’année de sortie) 

SELECT m.title,CONCAT(person.firstName, ' ', person.lastName) AS 'director',DATE_FORMAT(movie.releaseDate, '%Y') AS 'Year'
FROM movie m
INNER JOIN director d
ON m.id_director = director.id_director
INNER JOIN person p
ON d.id_person = p.id_person
WHERE d.id_director = 2


-- d. Nombre de films par genre (classés dans l’ordre décroissant)

SELECT g.nameGenre AS 'genre',COUNT(gm.id_movie) AS 'nbMovie'
FROM genre g
INNER JOIN  genre_movie gm
ON g.id_genre = gm.id_genre
GROUP BY g.nameGenre;

-- e. Nombre de films par réalisateur (classés dans l’ordre décroissant)

SELECT movie.title, COUNT(movie.id_director) AS nbmovie
FROM movie
INNER JOIN director 
ON movie.id_director = director.id_director
INNER JOIN person 
ON director.id_person = person.id_person
GROUP BY movie.id_director
ORDER BY nbMovie DESC;

-- f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs

SELECT CONCAT(p.firstName, ' ',p.lastName) AS actor, r.nameRole
FROM role r
INNER JOIN casting c
ON c.id_role = r.id_role
INNER JOIN actor a
ON a.id_actor = c.id_actor
INNER JOIN person p
ON p.id_person = a.id_person
WHERE c.id_movie = 3;

-- g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien)

SELECT m.title
FROM movie m
INNER JOIN casting c
ON m.id_movie = c.id_movie
WHERE c.id_actor = 5;

-- h. Liste des personnes qui sont à la fois acteurs et réalisateurs

SELECT *
FROM person p
LEFT JOIN director d
ON d.id_person = p.id_person
LEFT JOIN actor a
ON a.id_person = p.id_person
WHERE a.id_actor != ''
AND d.id_director != ''


-- i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)

SELECT m.title, m.releaseDate
FROM movie m
WHERE TIMESTAMPDIFF(YEAR, m.releaseDate, NOW() ) < 5
ORDER BY m.releaseDate DESC;


-- j. Nombre d’hommes et de femmes parmi les acteurs

SELECT COUNT(*) AS nbActor, p.sex
FROM actor a
inner join person p
on p.id_person = a.id_person
group by p.sex

-- k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)

SELECT CONCAT(p.firstName, ' ', p.lastName) AS nameActor , TIMESTAMPDIFF(YEAR, p.birthday, NOW() ) AS age
FROM actor a
INNER JOIN person p
ON a.id_person=p.id_person
WHERE TIMESTAMPDIFF(YEAR, p.birthday, NOW() ) > 50


-- l. Acteurs ayant joué dans 3 films ou plus

SELECT CONCAT(p.firstName, ' ', p.lastName) AS nameActor, 
COUNT(c.id_actor)
FROM person p
INNER JOIN actor a
ON p.id_person = a.id_person
INNER JOIN casting c
ON c.id_actor = a.id_actor
GROUP BY c.id_actor
HAVING COUNT(c.id_actor) >= 3
