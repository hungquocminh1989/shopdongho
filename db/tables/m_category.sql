-- Table: public.m_category

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