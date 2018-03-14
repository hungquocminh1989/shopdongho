-- Table: public.m_category

-- DROP SEQUENCE m_category_m_category_id_seq;

CREATE SEQUENCE m_category_m_category_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE m_category_m_category_id_seq
  OWNER TO postgres;

-- DROP TABLE public.m_category;

CREATE TABLE public.m_category
(
    m_category_id integer NOT NULL DEFAULT nextval('m_category_m_category_id_seq'::regclass),
    category_name text COLLATE pg_catalog."default",
    del_flg integer DEFAULT 0,
    CONSTRAINT m_category_pkey PRIMARY KEY (m_category_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.m_category
    OWNER to postgres;