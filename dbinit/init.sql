CREATE TABLE account (
    uid SERIAL PRIMARY KEY,
    password character varying(256) NOT NULL check(length(password) >= 8),
    email character varying(256) NOT NULL check(email ~* '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+[.][A-Za-z]+$'),
    username character varying(256) NOT NULL UNIQUE check(length(username) >= 3 AND length(username) <= 16 && username ~* '^[A-Za-z0-9][A-Za-z0-9._]*$'),
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
    rating real CHECK (rating >= 0.0 AND rating <= 5.0),
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
        NEW.password = hash_password(NEW.password);
    END IF;
    RETURN NEW;
END;
$$;

CREATE TRIGGER hash_password_trigger
BEFORE INSERT OR UPDATE ON account 
FOR EACH ROW EXECUTE
FUNCTION hash_password_trigger_function();