CREATE TABLE account (
    uid SERIAL PRIMARY KEY,
    password character varying(256) NOT NULL,
    email character varying(256) NOT NULL UNIQUE,
    username character varying(256) NOT NULL UNIQUE,
    joined_date date NOT NULL
);

CREATE TABLE author (
    author_id SERIAL PRIMARY KEY,
    name character varying(256) NOT NULL,
    description text
);

CREATE TABLE category (
    category_id SERIAL PRIMARY KEY,
    category_name character varying(256) NOT NULL UNIQUE
);

CREATE TABLE book (
    book_id SERIAL PRIMARY KEY,
    title text NOT NULL,
    description text,
    rating real CHECK (rating >= 0.0 AND rating <= 5.0),
    author_id integer NOT NULL,
    category_id integer NOT NULL,
    duration time without time zone NOT NULL,
    cover_image_directory text,
    audio_directory text NOT NULL,
    FOREIGN KEY (author_id) REFERENCES author(author_id) ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category(category_id) ON UPDATE CASCADE
);