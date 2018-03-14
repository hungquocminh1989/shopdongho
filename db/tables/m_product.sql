-- Table: public.m_product

-- DROP SEQUENCE m_product_m_product_id_seq;

CREATE SEQUENCE m_product_m_product_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE m_product_m_product_id_seq
  OWNER TO postgres;
  
-- DROP TABLE public.m_product;

CREATE TABLE public.m_product
(
    m_product_id integer NOT NULL DEFAULT nextval('m_product_m_product_id_seq'::regclass),
    m_category_id integer NOT NULL,
    product_name text COLLATE pg_catalog."default",
    product_no text COLLATE pg_catalog."default",
    product_price text COLLATE pg_catalog."default",
    product_info text COLLATE pg_catalog."default",
    product_link text COLLATE pg_catalog."default",
    del_flg integer DEFAULT 0,
    CONSTRAINT m_product_pkey PRIMARY KEY (m_product_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.m_product
    OWNER to postgres;