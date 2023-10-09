CREATE TABLE account (
    uid SERIAL PRIMARY KEY,
    password character varying(256) NOT NULL check(length(password) >= 8),
    email character varying(256) NOT NULL check(email ~* '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+[.][A-Za-z]+$'),
    username character varying(16) NOT NULL UNIQUE check(length(username) >= 3 AND username ~* '^[A-Za-z0-9][A-Za-z0-9._]*$'),
    joined_date date NOT NULL,
    is_admin boolean NOT NULL,
    profile_pic_directory text
);

CREATE TABLE author (
    aid SERIAL PRIMARY KEY,
    name character varying(256) NOT NULL,
    description text
);

CREATE TABLE category (
    cid SERIAL PRIMARY KEY,
    name character varying(256) NOT NULL UNIQUE
);

CREATE TABLE book (
    bid SERIAL PRIMARY KEY,
    title text NOT NULL,
    description text,
    rating real CHECK (rating >= 0.0 AND rating <= 5.0) NOT NULL,
    aid integer NOT NULL,
    cid integer NOT NULL,
    duration time without time zone NOT NULL,
    cover_image_directory text,
    audio_directory text NOT NULL,
    FOREIGN KEY (aid) REFERENCES author(aid) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (cid) REFERENCES category(cid) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE history (
    hid serial PRIMARY KEY,
    uid integer NOT NULL,
    bid integer NOT NULL,
    curr_duration time without time zone NOT NULL,
    FOREIGN KEY (bid) REFERENCES book(bid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (uid) REFERENCES account(uid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE FUNCTION hash_password(password text) 
RETURNS text
LANGUAGE plpgsql
AS $$
BEGIN 
    RETURN MD5(password);
END;
$$;

CREATE FUNCTION hash_password_trigger_function() 
RETURNS trigger 
LANGUAGE plpgsql
AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.password = hash_password(NEW.password);
    ELSIF TG_OP = 'UPDATE' THEN
        IF NEW.password = OLD.password THEN
            RETURN NEW;
        END IF;
        NEW.password = hash_password(NEW.password);
    END IF;
    RETURN NEW;
END;
$$;

CREATE TRIGGER hash_password_trigger
BEFORE INSERT OR UPDATE ON account 
FOR EACH ROW EXECUTE
FUNCTION hash_password_trigger_function();

INSERT INTO account(password, email, username, joined_date, is_admin)
	VALUES 
    ('admin', 'admin@email.com', 'admin', '2022-10-10', true), -- Admin acc
    ('user', 'user@email.com', 'user', '2022-11-11', false); -- User acc

INSERT INTO author (name, description)
SELECT 
    'Author ' || generate_series,
    'Description for Author ' || generate_series
FROM generate_series(1, 7);

INSERT INTO category (name)
SELECT 
    'Category ' || generate_series
FROM generate_series(1, 5);

INSERT INTO book (title, description, rating, aid, cid, duration, cover_image_directory, audio_directory)
SELECT 
    'Book ' || generate_series,
    'Description for Book ' || generate_series,
    random() * 5,  -- Random rating between 0 and 5
    floor(random() * 7) + 1,  -- Random author ID between 1 and 5
    floor(random() * 5) + 1,  -- Random category ID between 1 and 5
    (LPAD(floor(random() * 2)::text, 2, '0') || ':' || LPAD(floor(random() * 60)::text, 2, '0') || ':' || LPAD(floor(random() * 60)::text, 2, '0'))::time,  -- Random duration
    '',  -- Cover image directory
    '/storage/audio/' || generate_series || '.mp3'   -- Audio directory
FROM generate_series(1, 50);

INSERT INTO history (uid, bid, curr_duration)
SELECT 
    floor(random() * 2) + 1,  -- Random uid between 1 and 2
    floor(random() * 50) + 1,  -- Random bid between 1 and 50
    (LPAD(floor(random() * 2)::text, 2, '0') || ':' || LPAD(floor(random() * 60)::text, 2, '0') || ':' || LPAD(floor(random() * 60)::text, 2, '0'))::time  -- Random duration
FROM generate_series(1, 20);