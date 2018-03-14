-- Table: public.m_image

-- DROP SEQUENCE m_image_m_image_id_seq;

CREATE SEQUENCE m_image_m_image_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE m_image_m_image_id_seq
  OWNER TO postgres;

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