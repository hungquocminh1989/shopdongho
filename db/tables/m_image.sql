-- Table: public.m_image

-- DROP TABLE public.m_image;

CREATE TABLE public.m_image
(
    m_image_id integer NOT NULL DEFAULT nextval('m_image_m_image_id_seq'::regclass),
    m_product_id integer NOT NULL,
    image_path text COLLATE pg_catalog."default",
    default_flg integer DEFAULT 0,
    del_flg integer DEFAULT 0,
    CONSTRAINT m_image_pkey PRIMARY KEY (m_image_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.m_image
    OWNER to postgres;